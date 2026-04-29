<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\FinanceiroHelper;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function resumo(Request $request)
{

$dataInicio = $request->input('data_inicio', now()->startOfMonth());
$dataFim = $request->input('data_fim', now());

$receita = DB::table('movimentacao')
    ->whereBetween('data_coleta', [$dataInicio, $dataFim])
    ->sum('valor_total');

$clientes = DB::table('clientes')->count();

return response()->json([
    'receita'=>$receita,
    'lucro'=>0,
    'margem'=>0,
    'clientes'=>$clientes
]);

}
    public function financeiro(Request $request)
{

$dataInicio = $request->input('data_inicio', now()->startOfMonth());
$dataFim = $request->input('data_fim', now());

$dados = DB::table('movimentacao')
->selectRaw('MONTH(data_coleta) mes, SUM(valor_total) total')
->whereBetween('data_coleta', [$dataInicio,$dataFim])
->groupBy('mes')
->orderBy('mes')
->get();

return response()->json($dados);

}

 public function previsaoFinanceira(Request $request)
{

$dataInicio = $request->input('data_inicio') ?? now()->startOfMonth()->toDateString();
$dataFim = $request->input('data_fim') ?? now()->toDateString();

$caixaAtual = FinanceiroHelper::saldoCaixaAtual();

$receberPrevisto = DB::table('contas_a_receber')
->whereIn('status',['pendente','atrasado'])
->whereDate('data_vencimento','>=',$dataInicio)
->whereDate('data_vencimento','<=',$dataFim)
->sum('valor');

$contasPagar = DB::table('contas_a_pagar')
->whereIn('status',['pendente','atrasado'])
->whereDate('data_vencimento','>=',$dataInicio)
->whereDate('data_vencimento','<=',$dataFim)
->sum('valor');

$vendaPotencialEstoque = DB::table('produtos')
->where('nome','like','%GAS%')
->where('quantidade_estoque','>',0)
->selectRaw('SUM(quantidade_estoque * preco_venda) as total')
->value('total') ?? 0;

$resultadoReceber =
$caixaAtual + $receberPrevisto + $vendaPotencialEstoque;

$saldoFuturo =
$resultadoReceber - $contasPagar;

return response()->json([
'caixaAtual'=>$caixaAtual,
'receberPrevisto'=>$receberPrevisto,
'vendaPotencialEstoque'=>$vendaPotencialEstoque,
'resultadoReceber'=>$resultadoReceber,
'contasPagar'=>$contasPagar,
'saldoFuturo'=>$saldoFuturo
]);

}


public function vendasPorDia(Request $request)
{

$dataInicio = $request->input('data_inicio') ?? now()->startOfMonth()->toDateString();
$dataFim = $request->input('data_fim') ?? now()->toDateString();

$dados = DB::table('movimentacao_itens')
->join('movimentacao','movimentacao.id','=','movimentacao_itens.movimentacao_id')
->join('produtos','produtos.id','=','movimentacao_itens.produto_id')
->selectRaw("
DATE(movimentacao.data_coleta) dia,
SUM(CASE WHEN produtos.nome LIKE '%GAS%' THEN movimentacao_itens.quantidade ELSE 0 END) gas,
SUM(CASE WHEN produtos.nome LIKE '%AGUA%' THEN movimentacao_itens.quantidade ELSE 0 END) agua
")
->whereBetween('movimentacao.data_coleta',[$dataInicio,$dataFim])
->groupBy('dia')
->orderBy('dia')
->get();

return response()->json($dados);

}

   public function produtosMaisVendidos(Request $request)
{

$dataInicio = $request->input('data_inicio') ?? now()->startOfMonth()->toDateString();
$dataFim = $request->input('data_fim') ?? now()->toDateString();

$dados = DB::table('movimentacao_itens')
->join('movimentacao','movimentacao.id','=','movimentacao_itens.movimentacao_id')
->join('produtos','produtos.id','=','movimentacao_itens.produto_id')
->selectRaw('produtos.nome as produto, SUM(movimentacao_itens.quantidade) as total')
->whereBetween('movimentacao.data_coleta',[$dataInicio,$dataFim])
->groupBy('produtos.nome')
->orderByDesc('total')
->limit(10)
->get();

return response()->json($dados);

}

public function vendasPorBairro(Request $request)
{

    $dataInicio = $request->input('data_inicio') ?? now()->startOfMonth()->toDateString();
    $dataFim = $request->input('data_fim') ?? now()->toDateString();

    $dados = DB::table('movimentacao')
        ->join('clientes','clientes.id','=','movimentacao.cliente_id')
        ->selectRaw('clientes.bairro, COUNT(movimentacao.id) as total')
        ->whereBetween('movimentacao.data_coleta', [$dataInicio,$dataFim])
        ->groupBy('clientes.bairro')
        ->orderByDesc('total')
        ->limit(10)
        ->get();

    return response()->json($dados);

}

public function vendasPorCliente(Request $request)
{

$dataInicio = $request->input('data_inicio') ?? now()->startOfMonth()->toDateString();
$dataFim = $request->input('data_fim') ?? now()->toDateString();

$dados = DB::table('movimentacao_itens')
->join('movimentacao','movimentacao.id','=','movimentacao_itens.movimentacao_id')
->join('clientes','clientes.id','=','movimentacao.cliente_id')
->join('produtos','produtos.id','=','movimentacao_itens.produto_id')
->selectRaw("
clientes.nome as cliente,

SUM(
CASE 
WHEN produtos.nome LIKE '%GAS%' 
THEN movimentacao_itens.quantidade 
ELSE 0 
END
) as gas,

SUM(
CASE 
WHEN produtos.nome LIKE '%AGUA%' 
THEN movimentacao_itens.quantidade 
ELSE 0 
END
) as agua
")
->whereBetween('movimentacao.data_coleta',[$dataInicio,$dataFim])
->groupBy('clientes.nome')
->orderByRaw('(gas + agua) DESC')
->limit(10)
->get();

return response()->json($dados);

}


public function ticketMedioClientes(Request $request)
{

$dataInicio = $request->input('data_inicio') ?? now()->startOfMonth()->toDateString();
$dataFim = $request->input('data_fim') ?? now()->toDateString();

$dados = DB::table('movimentacao_itens')
->join('movimentacao','movimentacao.id','=','movimentacao_itens.movimentacao_id')
->join('clientes','clientes.id','=','movimentacao.cliente_id')
->join('produtos','produtos.id','=','movimentacao_itens.produto_id')

->selectRaw("
clientes.nome as cliente,

SUM(
CASE 
WHEN produtos.nome LIKE '%GAS%' 
THEN movimentacao_itens.quantidade * produtos.preco_venda
ELSE 0 
END
) as gas,

SUM(
CASE 
WHEN produtos.nome LIKE '%AGUA%' 
THEN movimentacao_itens.quantidade * produtos.preco_venda
ELSE 0 
END
) as agua
")

->whereBetween('movimentacao.data_coleta',[$dataInicio,$dataFim])
->groupBy('clientes.nome')
->orderByRaw('(gas + agua) DESC')
->limit(20)
->get();

return response()->json($dados);

}


public function previsaoRupturaEstoque(Request $request)
{
    $dataInicio = $request->input('data_inicio') ?? now()->startOfMonth()->toDateString();
    $dataFim = $request->input('data_fim') ?? now()->toDateString();

    $inicio = \Carbon\Carbon::parse($dataInicio);
    $fim = \Carbon\Carbon::parse($dataFim);

    $diasPeriodo = $inicio->diffInDays($fim) + 1;
    if ($diasPeriodo <= 0) {
        $diasPeriodo = 1;
    }

    $produtos = DB::table('produtos')
        ->select('id', 'nome', 'quantidade_estoque')
        ->where(function ($q) {
            $q->where('nome', 'like', '%GAS%')
              ->orWhere('nome', 'like', '%AGUA%');
        })
        ->get();

    $resultado = [];

    foreach ($produtos as $produto) {

        $totalVendido = DB::table('movimentacao_itens')
            ->join('movimentacao', 'movimentacao.id', '=', 'movimentacao_itens.movimentacao_id')
            ->where('movimentacao_itens.produto_id', $produto->id)
            ->whereBetween('movimentacao.data_coleta', [$dataInicio, $dataFim])
            ->sum('movimentacao_itens.quantidade');

        $mediaDia = $diasPeriodo > 0 ? ($totalVendido / $diasPeriodo) : 0;

        $diasRestantes = $mediaDia > 0
            ? ($produto->quantidade_estoque / $mediaDia)
            : 0;

        $resultado[] = [
            'produto' => $produto->nome,
            'estoque' => (float) $produto->quantidade_estoque,
            'vendido_periodo' => (float) $totalVendido,
            'dias_periodo' => $diasPeriodo,
            'media' => round($mediaDia, 2),
            'dias' => round($diasRestantes, 1),
        ];
    }

    return response()->json($resultado);
}
}