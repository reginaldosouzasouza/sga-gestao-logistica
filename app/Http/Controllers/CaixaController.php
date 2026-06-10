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

    public function destroyCaixaBanco($id)
    {
        $empresaId = $this->empresaId();

        $movimento = CaixaBanco::where('empresa_id', $empresaId)
            ->where('id', $id)
            ->firstOrFail();

        $movimento->delete();

        return redirect()
            ->back()
            ->with('success', 'Registro excluído!');
    }

    public function destroyCaixa($id)
    {
        $empresaId = $this->empresaId();

        $movimento = Caixa::where('empresa_id', $empresaId)
            ->where('id', $id)
            ->firstOrFail();

        $movimento->delete();

        return redirect()
            ->back()
            ->with('success', 'Registro do caixa excluído com sucesso!');
    }
}