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
            'caixa' => $caixa,
            'caixaBanco' => $caixaBanco,
            'saldoGeral' => $dados['saldoGeral'],
            'caixaAbertoHoje' => $caixaAberto, // 🔒 SEMPRE DEFINIDO
        ]);
    }

    /* =====================================================
       ABRIR CAIXA (OFICIAL)
    ===================================================== */
   public function abrir()
{
    // Já existe caixa aberto?
    if (CaixaAberto::where('status', 'aberto')->exists()) {
        return redirect()->route('caixa.index');
    }

    // Último fechamento é obrigatório
    $ultimoFechamento = FechamentoCaixa::orderByDesc('data')->first();

    if (!$ultimoFechamento) {
        return redirect()->route('caixa.consultas')
            ->withErrors('Não existe fechamento anterior.');
    }

    CaixaAberto::create([
        'data_caixa'           => Carbon::today()->toDateString(),
        'data_abertura'        => now(),
        'usuario_id'           => auth()->id(),

        // 🔥 IMPORTANTE: inicia zerado operacionalmente
        'saldo_inicial_caixa'  => 0,
        'saldo_inicial_banco'  => 0,

        'status'               => 'aberto',
    ]);

    return redirect()->route('caixa.index')
        ->with('success', 'Caixa aberto com sucesso.');
}


    /* =====================================================
       FECHAR CAIXA (ÚNICA FONTE OFICIAL)
    ===================================================== */
    public function fecharCaixa(Request $request)
    {
        $caixaAberto = CaixaAberto::where('status', 'aberto')->first();

        if (!$caixaAberto) {
            return back()->withErrors('Nenhum caixa aberto.');
        }

        $data = $caixaAberto->data_caixa;
        $dados = $this->dadosBaseCaixa($data);

        FechamentoCaixa::updateOrCreate(
            ['data' => $data],
            [
                'saldo_inicial' => $caixaAberto->saldo_inicial_caixa,
                'total_entradas' =>
                    $dados['entradasCaixaHoje'] + $dados['entradasBancoHoje'],
                'total_saidas' =>
                    $dados['saidasCaixaHoje'] + $dados['saidasBancoHoje'],
                'saldo_final' => $dados['saldoGeral'],
                'observacao' => $request->observacao ?? 'CAIXA',
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
                'data' => $f->data,
                'status' => 'Fechado',
                'saldo_final' => $f->saldo_final,
            ]);

        return view('caixa.consultas', compact('historico'));
    }

    /* =====================================================
       BASE DE CÁLCULO (NUNCA ZERA CARD)
    ===================================================== */
   private function dadosBaseCaixa($data)
{
    $data = Carbon::parse($data)->toDateString();

    $fechamento = FechamentoCaixa::whereDate('data', $data)->first();

    // 🔒 SE JÁ ESTIVER FECHADO → MOSTRA APENAS O FECHAMENTO
    if ($fechamento) {
        return [
            'saldoCaixa' => 0,
            'saldoBanco' => 0,
            'entradasCaixaHoje' => 0,
            'saidasCaixaHoje' => 0,
            'entradasBancoHoje' => 0,
            'saidasBancoHoje' => 0,
            'saldoGeral' => $fechamento->saldo_final,
            'caixaAberto' => null,
        ];
    }

    // 🔓 CAIXA ABERTO
    $caixaAberto = CaixaAberto::where('status', 'aberto')->first();

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

    // 🔵 Caixa e Banco mostram SOMENTE o movimento do dia
    $saldoCaixa = $entradasCaixa - $saidasCaixa;
    $saldoBanco = $entradasBanco - $saidasBanco;

    // 🟣 Saldo Geral traz saldo anterior + movimento do dia
    $ultimoFechamento = FechamentoCaixa::orderByDesc('data')->first();
    $saldoAnterior = $ultimoFechamento->saldo_final ?? 0;

    return [
        'saldoCaixa' => $saldoCaixa,
        'saldoBanco' => $saldoBanco,
        'entradasCaixaHoje' => $entradasCaixa,
        'saidasCaixaHoje' => $saidasCaixa,
        'entradasBancoHoje' => $entradasBanco,
        'saidasBancoHoje' => $saidasBanco,
        'saldoGeral' => $saldoAnterior + $saldoCaixa + $saldoBanco,
        'caixaAberto' => $caixaAberto,
    ];
}


    public function ajuste(Request $request)
{
    // validação simples
    $request->validate([
        'forma' => 'required|in:dinheiro,pix',
        'tipo'  => 'required|in:entrada,saida',
        'valor' => 'required|numeric|min:0.01',
        'descricao' => 'nullable|string',
    ]);

    // DEBUG TEMPORÁRIO
    // dd('ANTES DO INSERT');

    if ($request->forma === 'dinheiro') {

        DB::table('caixa')->insert([
            'data_movimentacao' => now()->toDateString(),
            'tipo'              => $request->tipo, // saida
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

    return redirect()
        ->route('caixa.index')
        ->with('success', 'Ajuste lançado com sucesso.');
}

// estornar caixa


public function estornarCaixaBanco($id)
{
    $movimento = DB::table('caixa_banco')->where('id', $id)->first();

    if (!$movimento) {
        return redirect()->back()
            ->with('error', 'Movimentação não encontrada.');
    }

    // Cria o estorno (inverte o tipo)
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
        'caixa' => $caixa,
        'caixaBanco' => $caixaBanco,
        'saldoGeral' => $dados['saldoGeral'],
        'caixaAbertoHoje' => null,
    ]);
}






    
}
