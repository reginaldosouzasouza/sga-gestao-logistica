<?php

namespace App\Http\Controllers;

use App\Models\Caixa;
use App\Models\CaixaBanco;
use App\Models\CaixaAberto;
use App\Models\FechamentoCaixa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CaixaController extends Controller
{
    /* =====================================================
       TELA PRINCIPAL DO CAIXA
    ===================================================== */
    public function index()
    {
        $caixaAberto = CaixaAberto::where('status', 'aberto')->first();

        // Se NÃO existe caixa aberto → consulta
        if (!$caixaAberto) {
            return redirect()->route('caixa.consultas');
        }

        $data = $caixaAberto->data_caixa;
        $dados = $this->dadosBaseCaixa($data);

        $caixa = Caixa::whereDate('data_movimentacao', $data)
            ->orderByDesc('data_movimentacao')
            ->get();

        $caixaBanco = CaixaBanco::whereDate('data_movimentacao', $data)
            ->orderByDesc('data_movimentacao')
            ->get();

        return view('caixa.index', [
            ...$dados,
            'caixa'          => $caixa,
            'caixaBanco'     => $caixaBanco,
            'saldoGeral'     => $dados['saldoGeral'],
            'caixaAbertoHoje' => $caixaAberto,
        ]);
    }

    /* =====================================================
       ABRIR CAIXA
       🔥 CORRIGIDO: saldo_inicial_caixa e saldo_inicial_banco
          vêm do fechamento do dia anterior
    ===================================================== */
    public function abrir()
    {
        // Já existe caixa aberto?
        if (CaixaAberto::where('status', 'aberto')->exists()) {
            return redirect()->route('caixa.index');
        }

        // Busca o último fechamento (pode não existir na primeira abertura)
        $ultimoFechamento = FechamentoCaixa::orderByDesc('data')->first();

        // 🔥 Se não existe fechamento anterior, abre zerado (primeira vez em produção)
        $saldoInicialCaixa = $ultimoFechamento->saldo_final_caixa ?? 0;
        $saldoInicialBanco = $ultimoFechamento->saldo_final_banco ?? 0;

        CaixaAberto::create([
            'data_caixa'          => Carbon::today()->toDateString(),
            'data_abertura'       => now(),
            'usuario_id'          => auth()->id(),
            'saldo_inicial_caixa' => $saldoInicialCaixa, // 🔥 Saldo real do dia anterior
            'saldo_inicial_banco' => $saldoInicialBanco, // 🔥 Saldo real do dia anterior
            'status'              => 'aberto',
        ]);

        return redirect()->route('caixa.index')
            ->with('success', 'Caixa aberto com sucesso.');
    }

    /* =====================================================
       FECHAR CAIXA
       🔥 CORRIGIDO: salva saldo_final_caixa e saldo_final_banco
          separadamente para o próximo dia usar na abertura
    ===================================================== */
    public function fecharCaixa(Request $request)
    {
        $caixaAberto = CaixaAberto::where('status', 'aberto')->first();

        if (!$caixaAberto) {
            return back()->withErrors('Nenhum caixa aberto.');
        }

        $data  = $caixaAberto->data_caixa;
        $dados = $this->dadosBaseCaixa($data);

        // 🔥 SALVA OS SALDOS FINAIS SEPARADOS (caixa e banco)
        // Estes valores serão usados na próxima abertura
        FechamentoCaixa::updateOrCreate(
            ['data' => $data],
            [
                'saldo_inicial'      => $caixaAberto->saldo_inicial_caixa,
                'total_entradas'     => $dados['entradasCaixaHoje'] + $dados['entradasBancoHoje'],
                'total_saidas'       => $dados['saidasCaixaHoje']   + $dados['saidasBancoHoje'],
                'saldo_final'        => $dados['saldoGeral'],      // Saldo geral (caixa + banco)
                'saldo_final_caixa'  => $dados['saldoCaixa'],      // 🔥 Saldo só do caixa (dinheiro)
                'saldo_final_banco'  => $dados['saldoBanco'],      // 🔥 Saldo só do banco (PIX)
                'observacao'         => $request->observacao ?? 'CAIXA',
            ]
        );

        $caixaAberto->update(['status' => 'fechado']);

        return redirect()->route('caixa.consultas')
            ->with('success', 'Caixa fechado com sucesso.');
    }

    /* =====================================================
       CONSULTAS (HISTÓRICO)
    ===================================================== */
    public function consultas()
    {
        $historico = FechamentoCaixa::orderByDesc('data')
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
       🔥 CORRIGIDO: saldoCaixa e saldoBanco somam o saldo
          inicial vindo do fechamento anterior
    ===================================================== */
    private function dadosBaseCaixa($data)
    {
        $data = Carbon::parse($data)->toDateString();

        $fechamento = FechamentoCaixa::whereDate('data', $data)->first();

        // 🔒 SE JÁ ESTIVER FECHADO → mostra os saldos finais do fechamento
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

        // 🔓 CAIXA ABERTO
        $caixaAberto = CaixaAberto::where('status', 'aberto')->first();

        // 🔥 Saldo inicial vindo do fechamento anterior (gravado na abertura)
        $saldoInicialCaixa = $caixaAberto->saldo_inicial_caixa ?? 0;
        $saldoInicialBanco = $caixaAberto->saldo_inicial_banco ?? 0;

        // Movimentações do dia
        $entradasCaixa = Caixa::whereDate('data_movimentacao', $data)
            ->where('tipo', 'entrada')
            ->sum('valor');

        $saidasCaixa = Caixa::whereDate('data_movimentacao', $data)
            ->where('tipo', 'saida')
            ->sum('valor');

        $entradasBanco = CaixaBanco::whereDate('data_movimentacao', $data)
            ->where('tipo', 'entrada')
            ->sum('valor');

        $saidasBanco = CaixaBanco::whereDate('data_movimentacao', $data)
            ->where('tipo', 'saida')
            ->sum('valor');

        // 🔥 Card Caixa (Dinheiro) = saldo anterior + movimentos do dia
        $saldoCaixa = $saldoInicialCaixa + $entradasCaixa - $saidasCaixa;

        // 🔥 Card Banco (PIX) = saldo anterior + movimentos do dia
        $saldoBanco = $saldoInicialBanco + $entradasBanco - $saidasBanco;

        // 🟣 Saldo Geral = caixa + banco (já incluem os saldos anteriores)
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
        $request->validate([
            'forma'     => 'required|in:dinheiro,pix',
            'tipo'      => 'required|in:entrada,saida',
            'valor'     => 'required|numeric|min:0.01',
            'descricao' => 'nullable|string',
        ]);

        if ($request->forma === 'dinheiro') {
            DB::table('caixa')->insert([
                'data_movimentacao' => now()->toDateString(),
                'tipo'              => $request->tipo,
                'valor'             => $request->valor,
                'origem'            => 'ajuste_manual',
                'descricao'         => $request->descricao,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        } else {
            DB::table('caixa_banco')->insert([
                'data_movimentacao' => now()->toDateString(),
                'tipo'              => $request->tipo,
                'valor'             => $request->valor,
                'origem'            => 'ajuste_manual',
                'descricao'         => $request->descricao,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        return redirect()->route('caixa.index')
            ->with('success', 'Ajuste lançado com sucesso.');
    }

    /* =====================================================
       ESTORNAR CAIXA BANCO
    ===================================================== */
    public function estornarCaixaBanco($id)
    {
        $movimento = DB::table('caixa_banco')->where('id', $id)->first();

        if (!$movimento) {
            return redirect()->back()->with('error', 'Movimentação não encontrada.');
        }

        DB::table('caixa_banco')->insert([
            'data_movimentacao' => now()->toDateString(),
            'tipo'              => $movimento->tipo === 'entrada' ? 'saida' : 'entrada',
            'valor'             => $movimento->valor,
            'origem'            => 'estorno',
            'descricao'         => 'Estorno: ' . $movimento->descricao,
            'referencia_id'     => $movimento->id,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        return redirect()->route('caixa.index')
            ->with('success', 'Estorno do Caixa Banco realizado com sucesso.');
    }

    /* =====================================================
       VISUALIZAR CAIXA FECHADO
    ===================================================== */
    public function visualizar($data)
    {
        $dados = $this->dadosBaseCaixa($data);

        $caixa = Caixa::whereDate('data_movimentacao', $data)
            ->orderByDesc('data_movimentacao')
            ->get();

        $caixaBanco = CaixaBanco::whereDate('data_movimentacao', $data)
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
}
