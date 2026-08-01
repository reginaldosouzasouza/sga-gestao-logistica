<?php

namespace App\Http\Controllers;

use App\Models\Caixa;
use App\Models\CaixaBanco;
use App\Models\CaixaAberto;
use App\Models\FechamentoCaixa;
use App\Models\ContasAPagar;
use App\Models\ContasAReceber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\FormaDePagamento;

class CaixaController extends Controller
{
    private function empresaId()
    {
        return empresaAtualId();

    }

    /* =====================================================
       TELA PRINCIPAL DO CAIXA
    ===================================================== */
    public function index(Request $request)
    {
        $empresaId = $this->empresaId();

        $caixaAberto = CaixaAberto::where('empresa_id', $empresaId)
            ->where('status', 'aberto')
            ->first();

        if (!$caixaAberto) {
            return redirect()->route('caixa.consultas');
        }

        $data  = $caixaAberto->data_caixa;
        $dados = $this->dadosBaseCaixa($data);

        $caixa = Caixa::where('empresa_id', $empresaId)
            ->whereDate('data_movimentacao', $data)
            ->orderByDesc('data_movimentacao')
            ->get();

        $caixaBanco = CaixaBanco::where('empresa_id', $empresaId)
            ->whereDate('data_movimentacao', $data)
            ->orderByDesc('data_movimentacao')
            ->get();

        $dataInicio = $request->input('prev_inicio', now()->toDateString());
        $dataFim    = $request->input('prev_fim', now()->addDays(7)->toDateString());

        $previsao = $this->previsaoCaixa($dados['saldoGeral'], $dataInicio, $dataFim);

        return view('caixa.index', [
            ...$dados,
            'caixa'           => $caixa,
            'caixaBanco'      => $caixaBanco,
            'saldoGeral'      => $dados['saldoGeral'],
            'caixaAbertoHoje' => $caixaAberto,
            'previsao'        => $previsao,
        ]);
    }

    /* =====================================================
       ABRIR CAIXA
    ===================================================== */
    public function abrir()
    {
        $empresaId = $this->empresaId();

        if (CaixaAberto::where('empresa_id', $empresaId)->where('status', 'aberto')->exists()) {
            return redirect()->route('caixa.index');
        }

        $ultimoFechamento = FechamentoCaixa::where('empresa_id', $empresaId)
            ->orderByDesc('data')
            ->first();

        $saldoInicialCaixa = $ultimoFechamento->saldo_final_caixa ?? 0;
        $saldoInicialBanco = $ultimoFechamento->saldo_final_banco ?? 0;

        CaixaAberto::create([
            'empresa_id'           => $empresaId,
            'data_caixa'           => Carbon::today()->toDateString(),
            'data_abertura'        => now(),
            'usuario_id'           => auth()->id(),
            'saldo_inicial_caixa'  => $saldoInicialCaixa,
            'saldo_inicial_banco'  => $saldoInicialBanco,
            'status'               => 'aberto',
        ]);

        return redirect()
            ->route('caixa.index')
            ->with('success', 'Caixa aberto com sucesso.');
    }

    /* =====================================================
       FECHAR CAIXA
    ===================================================== */
    public function fecharCaixa(Request $request)
    {
        $empresaId = $this->empresaId();

        $caixaAberto = CaixaAberto::where('empresa_id', $empresaId)
            ->where('status', 'aberto')
            ->first();

        if (!$caixaAberto) {
            return back()->withErrors('Nenhum caixa aberto.');
        }

        $data  = $caixaAberto->data_caixa;
        $dados = $this->dadosBaseCaixa($data);

        FechamentoCaixa::updateOrCreate(
            [
                'empresa_id' => $empresaId,
                'data'       => $data,
            ],
            [
                'saldo_inicial'      => $caixaAberto->saldo_inicial_caixa,
                'total_entradas'     => $dados['entradasCaixaHoje'] + $dados['entradasBancoHoje'],
                'total_saidas'       => $dados['saidasCaixaHoje'] + $dados['saidasBancoHoje'],
                'saldo_final'        => $dados['saldoGeral'],
                'saldo_final_caixa'  => $dados['saldoCaixa'],
                'saldo_final_banco'  => $dados['saldoBanco'],
                'observacao'         => $request->observacao ?? 'CAIXA',
            ]
        );

        $caixaAberto->update(['status' => 'fechado']);

        return redirect()
            ->route('caixa.consultas')
            ->with('success', 'Caixa fechado com sucesso.');
    }

    /* =====================================================
       CONSULTAS
    ===================================================== */
    public function consultas()
    {
        $empresaId = $this->empresaId();

        $historico = FechamentoCaixa::where('empresa_id', $empresaId)
            ->orderByDesc('data')
            ->get()
            ->map(fn ($f) => [
                'data'        => $f->data,
                'status'      => 'Fechado',
                'saldo_final' => $f->saldo_final,
            ]);

        return view('caixa.consultas', compact('historico'));
    }

    /* =====================================================
       BASE DE CÁLCULO DOS CARDS
    ===================================================== */
    private function dadosBaseCaixa($data)
    {
        $empresaId = $this->empresaId();
        $data = Carbon::parse($data)->toDateString();

        $fechamento = FechamentoCaixa::where('empresa_id', $empresaId)
            ->whereDate('data', $data)
            ->first();

        if ($fechamento) {
            return [
                'saldoCaixa'         => $fechamento->saldo_final_caixa ?? 0,
                'saldoBanco'         => $fechamento->saldo_final_banco ?? 0,
                'entradasCaixaHoje'  => 0,
                'saidasCaixaHoje'    => 0,
                'entradasBancoHoje'  => 0,
                'saidasBancoHoje'    => 0,
                'saldoGeral'         => $fechamento->saldo_final,
                'caixaAberto'        => null,
            ];
        }

        $caixaAberto = CaixaAberto::where('empresa_id', $empresaId)
            ->where('status', 'aberto')
            ->first();

        $saldoInicialCaixa = $caixaAberto->saldo_inicial_caixa ?? 0;
        $saldoInicialBanco = $caixaAberto->saldo_inicial_banco ?? 0;

        $entradasCaixa = Caixa::where('empresa_id', $empresaId)
            ->whereDate('data_movimentacao', $data)
            ->where('tipo', 'entrada')
            ->sum('valor');

        $saidasCaixa = Caixa::where('empresa_id', $empresaId)
            ->whereDate('data_movimentacao', $data)
            ->where('tipo', 'saida')
            ->sum('valor');

        $entradasBanco = CaixaBanco::where('empresa_id', $empresaId)
            ->whereDate('data_movimentacao', $data)
            ->where('tipo', 'entrada')
            ->sum('valor');

        $saidasBanco = CaixaBanco::where('empresa_id', $empresaId)
            ->whereDate('data_movimentacao', $data)
            ->where('tipo', 'saida')
            ->sum('valor');

        $saldoCaixa = $saldoInicialCaixa + $entradasCaixa - $saidasCaixa;
        $saldoBanco = $saldoInicialBanco + $entradasBanco - $saidasBanco;
        $saldoGeral = $saldoCaixa + $saldoBanco;

        return [
            'saldoCaixa'        => $saldoCaixa,
            'saldoBanco'        => $saldoBanco,
            'entradasCaixaHoje' => $entradasCaixa,
            'saidasCaixaHoje'   => $saidasCaixa,
            'entradasBancoHoje' => $entradasBanco,
            'saidasBancoHoje'   => $saidasBanco,
            'saldoGeral'        => $saldoGeral,
            'caixaAberto'       => $caixaAberto,
        ];
    }

    /* =====================================================
       AJUSTE MANUAL
    ===================================================== */
    public function ajuste(Request $request)
    {
        $empresaId = $this->empresaId();

        $request->validate([
            'forma'     => 'required|in:dinheiro,pix',
            'tipo'      => 'required|in:entrada,saida',
            'valor'     => 'required|numeric|min:0.01',
            'descricao' => 'nullable|string',
        ]);

        if ($request->forma === 'dinheiro') {
            Caixa::create([
                'empresa_id'          => $empresaId,
                'data_movimentacao'   => now()->toDateString(),
                'tipo'                => $request->tipo,
                'valor'               => $request->valor,
                'origem'              => 'ajuste_manual',
                'descricao'           => $request->descricao,
            ]);
        } else {
            CaixaBanco::create([
                'empresa_id'          => $empresaId,
                'data_movimentacao'   => now()->toDateString(),
                'tipo'                => $request->tipo,
                'valor'               => $request->valor,
                'forma'               => 'pix',
                'origem'              => 'ajuste_manual',
                'descricao'           => $request->descricao,
            ]);
        }

        return redirect()
            ->route('caixa.index')
            ->with('success', 'Ajuste lançado com sucesso.');
    }

    /* =====================================================
       ESTORNAR CAIXA
    ===================================================== */
    public function estornarCaixa($id)
    {
        $empresaId = $this->empresaId();

        $movimento = Caixa::where('empresa_id', $empresaId)
            ->where('id', $id)
            ->first();

        if (!$movimento) {
            return redirect()->back()->with('error', 'Movimentação não encontrada.');
        }

        $jaEstornado = Caixa::where('empresa_id', $empresaId)
            ->where('referencia_id', $movimento->id)
            ->where('origem', 'estorno')
            ->exists();

        if ($jaEstornado) {
            return redirect()->back()->with('error', 'Este movimento já foi estornado.');
        }

        Caixa::create([
            'empresa_id'          => $empresaId,
            'data_movimentacao'   => now()->toDateString(),
            'tipo'                => $movimento->tipo === 'entrada' ? 'saida' : 'entrada',
            'valor'               => $movimento->valor,
            'origem'              => 'estorno',
            'descricao'           => 'Estorno: ' . $movimento->descricao,
            'referencia_id'       => $movimento->id,
        ]);

        return redirect()
            ->route('caixa.index')
            ->with('success', 'Estorno do Caixa realizado com sucesso.');
    }

    /* =====================================================
       ESTORNAR CAIXA BANCO
    ===================================================== */
    public function estornarCaixaBanco($id)
    {
        $empresaId = $this->empresaId();

        $movimento = CaixaBanco::where('empresa_id', $empresaId)
            ->where('id', $id)
            ->first();

        if (!$movimento) {
            return redirect()->back()->with('error', 'Movimentação não encontrada.');
        }

        $jaEstornado = CaixaBanco::where('empresa_id', $empresaId)
            ->where('referencia_id', $movimento->id)
            ->where('origem', 'estorno')
            ->exists();

        if ($jaEstornado) {
            return redirect()->back()->with('error', 'Este movimento já foi estornado.');
        }

        CaixaBanco::create([
            'empresa_id'          => $empresaId,
            'data_movimentacao'   => now()->toDateString(),
            'tipo'                => $movimento->tipo === 'entrada' ? 'saida' : 'entrada',
            'valor'               => $movimento->valor,
            'forma'               => $movimento->forma,
            'origem'              => 'estorno',
            'descricao'           => 'Estorno: ' . $movimento->descricao,
            'referencia_id'       => $movimento->id,
        ]);

        return redirect()
            ->route('caixa.index')
            ->with('success', 'Estorno do Caixa Banco realizado com sucesso.');
    }

    /* =====================================================
       VISUALIZAR CAIXA FECHADO
    ===================================================== */
    public function visualizar($data)
    {
        $empresaId = $this->empresaId();

        $dados = $this->dadosBaseCaixa($data);

        $caixa = Caixa::where('empresa_id', $empresaId)
            ->whereDate('data_movimentacao', $data)
            ->orderByDesc('data_movimentacao')
            ->get();

        $caixaBanco = CaixaBanco::where('empresa_id', $empresaId)
            ->whereDate('data_movimentacao', $data)
            ->orderByDesc('data_movimentacao')
            ->get();

        return view('caixa.index', [
            ...$dados,
            'caixa'           => $caixa,
            'caixaBanco'      => $caixaBanco,
            'saldoGeral'      => $dados['saldoGeral'],
            'caixaAbertoHoje' => null,
        ]);
    }

    private function previsaoCaixa(float $saldoAtual, string $dataInicio = null, string $dataFim = null): array
    {
        $empresaId = $this->empresaId();

        $hoje   = Carbon::today();
        $inicio = $dataInicio ? Carbon::parse($dataInicio) : $hoje->copy();
        $fim    = $dataFim ? Carbon::parse($dataFim) : $hoje->copy()->addDays(7);

        if ($fim->lt($inicio)) {
            $fim = $inicio->copy()->addDays(7);
        }

        $pagar = ContasAPagar::where('empresa_id', $empresaId)
            ->whereBetween('data_vencimento', [$inicio, $fim])
            ->whereNotIn('status', ['pago', 'cancelado'])
            ->orderBy('data_vencimento')
            ->get(['id', 'descricao', 'valor', 'data_vencimento', 'status']);

        $receber = ContasAReceber::where('empresa_id', $empresaId)
            ->whereBetween('data_vencimento', [$inicio, $fim])
            ->whereNotIn('status', ['recebido', 'cancelado'])
            ->orderBy('data_vencimento')
            ->get(['id', 'descricao', 'valor', 'data_vencimento', 'status']);

        $dias = [];
        $current = $inicio->copy();

        while ($current->lte($fim)) {
            $data = $current->toDateString();

            $dias[$data] = [
                'data'          => $data,
                'pagar'         => [],
                'receber'       => [],
                'total_pagar'   => 0,
                'total_receber' => 0,
            ];

            $current->addDay();
        }

        foreach ($pagar as $c) {
            $d = Carbon::parse($c->data_vencimento)->toDateString();

            if (isset($dias[$d])) {
                $dias[$d]['pagar'][] = $c;
                $dias[$d]['total_pagar'] += $c->valor;
            }
        }

        foreach ($receber as $c) {
            $d = Carbon::parse($c->data_vencimento)->toDateString();

            if (isset($dias[$d])) {
                $dias[$d]['receber'][] = $c;
                $dias[$d]['total_receber'] += $c->valor;
            }
        }

        $saldoProjetado = $saldoAtual;

        foreach ($dias as $data => &$dia) {
            $saldoProjetado += $dia['total_receber'] - $dia['total_pagar'];
            $dia['saldo_projetado'] = $saldoProjetado;
        }

        return [
            'dias'                  => array_values($dias),
            'total_pagar'           => $pagar->sum('valor'),
            'total_receber'         => $receber->sum('valor'),
            'saldo_projetado_final' => $saldoProjetado,
            'data_inicio'           => $inicio->format('Y-m-d'),
            'data_fim'              => $fim->format('Y-m-d'),
        ];
    }


    /**
     * Confirma se a movimentação pertence ao dia atual.
     */
    private function movimentoEhDeHoje($movimento): bool
    {
        return Carbon::parse($movimento->data_movimentacao)->isToday();
    }

    /**
     * Identifica pagamentos antigos de Contas a Pagar que foram gravados
     * incorretamente com origem "compra".
     */
    private function ehPagamentoLegadoContaPagar($movimento): bool
    {
        return $movimento->origem === 'compra'
            && str_starts_with(
                (string) $movimento->descricao,
                'Pagamento conta a pagar #'
            );
    }

    /**
     * Devolve a Conta a Pagar ao status correto após a exclusão do pagamento.
     */
    private function reabrirContaPagar($movimento, int $empresaId): void
    {
        $contaAPagar = ContasAPagar::where('empresa_id', $empresaId)
            ->where('id', $movimento->referencia_id)
            ->lockForUpdate()
            ->first();

        if (!$contaAPagar) {
            throw new \RuntimeException(
                'A Conta a Pagar vinculada a esta movimentação não foi encontrada.'
            );
        }

        $status = Carbon::parse($contaAPagar->data_vencimento)
            ->lt(Carbon::today())
                ? 'atrasado'
                : 'pendente';

        $formaNotaAssinada = \App\Models\FormaDePagamento::whereRaw(
            'LOWER(TRIM(nome)) = ?',
            ['nota assinada']
        )->first();

        $contaAPagar->update([
            'status' => $status,
            'data_pagamento' => null,
            'forma_pagamento_id' => $formaNotaAssinada?->id
                ?? $contaAPagar->forma_pagamento_id,
        ]);
    }

    public function destroyCaixaBanco($id)
    {
        $empresaId = $this->empresaId();

        $movimento = CaixaBanco::where('empresa_id', $empresaId)
            ->where('id', $id)
            ->firstOrFail();

        /*
        * Somente movimentações do dia atual podem ser excluídas.
        */
        if (!Carbon::parse($movimento->data_movimentacao)->isToday()) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Não é permitido excluir movimentações de dias anteriores.'
                );
        }

        /*
        * Somente o usuário MASTER pode utilizar a exclusão.
        * Os demais usuários deverão utilizar o estorno.
        */
        $isMaster = auth()->check()
            && auth()->user()->tipo === 'MASTER';

        if (!$isMaster) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Somente o usuário MASTER pode excluir uma movimentação. Para desfazer o pagamento, utilize a opção Estornar.'
                );
        }

        /*
        * Compra paga diretamente por PIX deve ser cancelada
        * pela tela de Compras, pois também envolve estoque.
        *
        * A exceção abaixo reconhece pagamentos antigos de Contas a Pagar
        * que foram gravados incorretamente com origem "compra".
        */
        $pagamentoLegadoContaPagar =
            $movimento->origem === 'compra'
            && str_starts_with(
                (string) $movimento->descricao,
                'Pagamento conta a pagar #'
            );

        if (
            $movimento->origem === 'compra'
            && !$pagamentoLegadoContaPagar
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Este lançamento foi gerado diretamente por uma compra. Faça o cancelamento pela tela de Compras.'
                );
        }

        /*
        * Recebimentos ainda não devem ser excluídos até aplicarmos
        * a mesma amarração em Contas a Receber.
        */
        if ($movimento->origem === 'contas_a_receber') {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Este lançamento pertence a uma Conta a Receber e ainda não pode ser excluído diretamente.'
                );
        }

        /*
        * Impede exclusão de um lançamento que já representa estorno.
        */
        if ($movimento->origem === 'estorno') {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Um lançamento de estorno não pode ser excluído diretamente.'
                );
        }

        DB::beginTransaction();

        try {
            /*
            * Quando o lançamento pertence a Contas a Pagar,
            * a conta volta para pendente ou atrasada.
            */
            if (
                $movimento->origem === 'contas_a_pagar'
                || $pagamentoLegadoContaPagar
            ) {
                $contaAPagar = ContasAPagar::where(
                    'empresa_id',
                    $empresaId
                )
                    ->where('id', $movimento->referencia_id)
                    ->first();

                if (!$contaAPagar) {
                    DB::rollBack();

                    return redirect()
                        ->back()
                        ->with(
                            'error',
                            'A Conta a Pagar vinculada não foi encontrada. O lançamento não foi excluído.'
                        );
                }

                $statusRetorno = Carbon::parse(
                    $contaAPagar->data_vencimento
                )->lt(Carbon::today())
                    ? 'atrasado'
                    : 'pendente';

                $notaAssinada = FormaDePagamento::whereRaw(
                    'LOWER(TRIM(nome)) = ?',
                    ['nota assinada']
                )->first();

                $dadosConta = [
                    'status' => $statusRetorno,
                    'data_pagamento' => null,
                ];

                if ($notaAssinada) {
                    $dadosConta['forma_pagamento_id'] = $notaAssinada->id;
                }

                $contaAPagar->update($dadosConta);
            }

            $movimento->delete();

            DB::commit();

            return redirect()
                ->back()
                ->with(
                    'success',
                    'Movimentação do Caixa Banco excluída com sucesso.'
                );

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Erro ao excluir movimentação do Caixa Banco', [
                'movimento_id' => $id,
                'empresa_id' => $empresaId,
                'usuario_id' => auth()->id(),
                'erro' => $e->getMessage(),
                'linha' => $e->getLine(),
                'arquivo' => $e->getFile(),
            ]);

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Não foi possível excluir a movimentação. Nenhuma alteração foi realizada.'
                );
        }
    }

    public function destroyCaixa($id)
    {
        $empresaId = $this->empresaId();

        $movimento = Caixa::where('empresa_id', $empresaId)
            ->where('id', $id)
            ->firstOrFail();

        /*
        * Somente movimentações do dia atual podem ser excluídas.
        */
        if (!Carbon::parse($movimento->data_movimentacao)->isToday()) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Não é permitido excluir movimentações de dias anteriores.'
                );
        }

        /*
        * Somente o usuário MASTER pode utilizar a exclusão.
        * Os demais usuários deverão utilizar o estorno.
        */
        $isMaster = auth()->check()
            && auth()->user()->tipo === 'MASTER';

        if (!$isMaster) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Somente o usuário MASTER pode excluir uma movimentação. Para desfazer o pagamento, utilize a opção Estornar.'
                );
        }

        /*
        * Compra paga diretamente em dinheiro deve ser cancelada
        * pela tela de Compras, pois também envolve estoque.
        *
        * A exceção reconhece pagamentos antigos de Contas a Pagar
        * gravados incorretamente com origem "compra".
        */
        $pagamentoLegadoContaPagar =
            $movimento->origem === 'compra'
            && str_starts_with(
                (string) $movimento->descricao,
                'Pagamento conta a pagar #'
            );

        if (
            $movimento->origem === 'compra'
            && !$pagamentoLegadoContaPagar
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Este lançamento foi gerado diretamente por uma compra. Faça o cancelamento pela tela de Compras.'
                );
        }

        /*
        * Recebimentos ainda ficam protegidos até ajustarmos
        * o módulo de Contas a Receber.
        */
        if ($movimento->origem === 'contas_a_receber') {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Este lançamento pertence a uma Conta a Receber e ainda não pode ser excluído diretamente.'
                );
        }

        /*
        * Impede exclusão de um lançamento de estorno.
        */
        if ($movimento->origem === 'estorno') {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Um lançamento de estorno não pode ser excluído diretamente.'
                );
        }

        DB::beginTransaction();

        try {
            /*
            * Quando pertence a Contas a Pagar,
            * restaura a situação da conta.
            */
            if (
                $movimento->origem === 'contas_a_pagar'
                || $pagamentoLegadoContaPagar
            ) {
                $contaAPagar = ContasAPagar::where(
                    'empresa_id',
                    $empresaId
                )
                    ->where('id', $movimento->referencia_id)
                    ->first();

                if (!$contaAPagar) {
                    DB::rollBack();

                    return redirect()
                        ->back()
                        ->with(
                            'error',
                            'A Conta a Pagar vinculada não foi encontrada. O lançamento não foi excluído.'
                        );
                }

                $statusRetorno = Carbon::parse(
                    $contaAPagar->data_vencimento
                )->lt(Carbon::today())
                    ? 'atrasado'
                    : 'pendente';

                $notaAssinada = FormaDePagamento::whereRaw(
                    'LOWER(TRIM(nome)) = ?',
                    ['nota assinada']
                )->first();

                $dadosConta = [
                    'status' => $statusRetorno,
                    'data_pagamento' => null,
                ];

                if ($notaAssinada) {
                    $dadosConta['forma_pagamento_id'] = $notaAssinada->id;
                }

                $contaAPagar->update($dadosConta);
            }

            $movimento->delete();

            DB::commit();

            return redirect()
                ->back()
                ->with(
                    'success',
                    'Movimentação do Caixa excluída com sucesso.'
                );

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Erro ao excluir movimentação do Caixa', [
                'movimento_id' => $id,
                'empresa_id' => $empresaId,
                'usuario_id' => auth()->id(),
                'erro' => $e->getMessage(),
                'linha' => $e->getLine(),
                'arquivo' => $e->getFile(),
            ]);

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Não foi possível excluir a movimentação. Nenhuma alteração foi realizada.'
                );
        }
    }
}