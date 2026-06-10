<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\FinanceiroHelper;



class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function empresaId()
    {
         return empresaAtualId();
    }

    public function index()
    {
        return view('dashboard.index');
    }

    public function resumo(Request $request)
    {
        $empresaId = $this->empresaId();

        $dataInicio = $request->input('data_inicio', now()->startOfMonth()->toDateString());
        $dataFim = $request->input('data_fim', now()->toDateString());

        $receita = DB::table('movimentacao')
            ->where('empresa_id', $empresaId)
            ->whereBetween('data_coleta', [$dataInicio, $dataFim])
            ->sum('valor_total');

        $clientes = DB::table('clientes')
            ->where('empresa_id', $empresaId)
            ->count();

        return response()->json([
            'receita' => $receita,
            'lucro' => 0,
            'margem' => 0,
            'clientes' => $clientes
        ]);
    }

    public function financeiro(Request $request)
    {
        $empresaId = $this->empresaId();

        $dataInicio = $request->input('data_inicio', now()->startOfMonth()->toDateString());
        $dataFim = $request->input('data_fim', now()->toDateString());

        $dados = DB::table('movimentacao')
            ->selectRaw('MONTH(data_coleta) mes, SUM(valor_total) total')
            ->where('empresa_id', $empresaId)
            ->whereBetween('data_coleta', [$dataInicio, $dataFim])
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        return response()->json($dados);
    }

    public function previsaoFinanceira(Request $request)
    {
        $empresaId = $this->empresaId();

        $dataInicio = $request->input('data_inicio') ?? now()->startOfMonth()->toDateString();
        $dataFim = $request->input('data_fim') ?? now()->toDateString();

        $caixaAtual = FinanceiroHelper::saldoCaixaAtual();

        $receberPrevisto = DB::table('contas_a_receber')
            ->where('empresa_id', $empresaId)
            ->whereIn('status', ['pendente', 'atrasado'])
            ->whereDate('data_vencimento', '>=', $dataInicio)
            ->whereDate('data_vencimento', '<=', $dataFim)
            ->sum('valor');

        $contasPagar = DB::table('contas_a_pagar')
            ->where('empresa_id', $empresaId)
            ->whereIn('status', ['pendente', 'atrasado'])
            ->whereDate('data_vencimento', '>=', $dataInicio)
            ->whereDate('data_vencimento', '<=', $dataFim)
            ->sum('valor');

        $vendaPotencialEstoque = DB::table('produtos')
            ->where('empresa_id', $empresaId)
            ->where(function ($q) {
                $q->where('nome', 'like', '%GAS%')
                  ->orWhere('nome', 'like', '%GÁS%');
            })
            ->where('quantidade_estoque', '>', 0)
            ->selectRaw('SUM(quantidade_estoque * preco_venda) as total')
            ->value('total') ?? 0;

        $resultadoReceber = $caixaAtual + $receberPrevisto + $vendaPotencialEstoque;
        $saldoFuturo = $resultadoReceber - $contasPagar;

        return response()->json([
            'caixaAtual' => $caixaAtual,
            'receberPrevisto' => $receberPrevisto,
            'vendaPotencialEstoque' => $vendaPotencialEstoque,
            'resultadoReceber' => $resultadoReceber,
            'contasPagar' => $contasPagar,
            'saldoFuturo' => $saldoFuturo
        ]);
    }

    public function vendasPorDia(Request $request)
    {
        $empresaId = $this->empresaId();

        $dataInicio = $request->input('data_inicio') ?? now()->startOfMonth()->toDateString();
        $dataFim = $request->input('data_fim') ?? now()->toDateString();

        $dados = DB::table('movimentacao_itens as mi')
            ->join('movimentacao as m', 'm.id', '=', 'mi.movimentacao_id')
            ->join('produtos as p', 'p.id', '=', 'mi.produto_id')
            ->selectRaw("
                DATE(m.data_coleta) dia,
                SUM(CASE WHEN p.nome LIKE '%GAS%' OR p.nome LIKE '%GÁS%' THEN mi.quantidade ELSE 0 END) gas,
                SUM(CASE WHEN p.nome LIKE '%AGUA%' OR p.nome LIKE '%ÁGUA%' THEN mi.quantidade ELSE 0 END) agua
            ")
            ->where('m.empresa_id', $empresaId)
            ->where('mi.empresa_id', $empresaId)
            ->where('p.empresa_id', $empresaId)
            ->whereBetween('m.data_coleta', [$dataInicio, $dataFim])
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();

        return response()->json($dados);
    }

    public function produtosMaisVendidos(Request $request)
    {
        $empresaId = $this->empresaId();

        $dataInicio = $request->input('data_inicio') ?? now()->startOfMonth()->toDateString();
        $dataFim = $request->input('data_fim') ?? now()->toDateString();

        $dados = DB::table('movimentacao_itens as mi')
            ->join('movimentacao as m', 'm.id', '=', 'mi.movimentacao_id')
            ->join('produtos as p', 'p.id', '=', 'mi.produto_id')
            ->selectRaw('p.nome as produto, SUM(mi.quantidade) as total')
            ->where('m.empresa_id', $empresaId)
            ->where('mi.empresa_id', $empresaId)
            ->where('p.empresa_id', $empresaId)
            ->whereBetween('m.data_coleta', [$dataInicio, $dataFim])
            ->groupBy('p.nome')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return response()->json($dados);
    }

    public function vendasPorBairro(Request $request)
    {
        $empresaId = $this->empresaId();

        $dataInicio = $request->input('data_inicio') ?? now()->startOfMonth()->toDateString();
        $dataFim = $request->input('data_fim') ?? now()->toDateString();

        $dados = DB::table('movimentacao as m')
            ->join('clientes as c', 'c.id', '=', 'm.cliente_id')
            ->selectRaw('c.bairro, COUNT(m.id) as total')
            ->where('m.empresa_id', $empresaId)
            ->where('c.empresa_id', $empresaId)
            ->whereBetween('m.data_coleta', [$dataInicio, $dataFim])
            ->groupBy('c.bairro')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return response()->json($dados);
    }

    public function vendasPorCliente(Request $request)
    {
        $empresaId = $this->empresaId();

        $dataInicio = $request->input('data_inicio') ?? now()->startOfMonth()->toDateString();
        $dataFim = $request->input('data_fim') ?? now()->toDateString();

        $dados = DB::table('movimentacao_itens as mi')
            ->join('movimentacao as m', 'm.id', '=', 'mi.movimentacao_id')
            ->join('clientes as c', 'c.id', '=', 'm.cliente_id')
            ->join('produtos as p', 'p.id', '=', 'mi.produto_id')
            ->selectRaw("
                c.nome as cliente,

                SUM(
                    CASE 
                        WHEN p.nome LIKE '%GAS%' OR p.nome LIKE '%GÁS%'
                        THEN mi.quantidade 
                        ELSE 0 
                    END
                ) as gas,

                SUM(
                    CASE 
                        WHEN p.nome LIKE '%AGUA%' OR p.nome LIKE '%ÁGUA%'
                        THEN mi.quantidade 
                        ELSE 0 
                    END
                ) as agua
            ")
            ->where('m.empresa_id', $empresaId)
            ->where('mi.empresa_id', $empresaId)
            ->where('c.empresa_id', $empresaId)
            ->where('p.empresa_id', $empresaId)
            ->whereBetween('m.data_coleta', [$dataInicio, $dataFim])
            ->groupBy('c.nome')
            ->orderByRaw('(gas + agua) DESC')
            ->limit(10)
            ->get();

        return response()->json($dados);
    }

    public function ticketMedioClientes(Request $request)
    {
        $empresaId = $this->empresaId();

        $dataInicio = $request->input('data_inicio') ?? now()->startOfMonth()->toDateString();
        $dataFim = $request->input('data_fim') ?? now()->toDateString();

        $dados = DB::table('movimentacao_itens as mi')
            ->join('movimentacao as m', 'm.id', '=', 'mi.movimentacao_id')
            ->join('clientes as c', 'c.id', '=', 'm.cliente_id')
            ->join('produtos as p', 'p.id', '=', 'mi.produto_id')
            ->selectRaw("
                c.nome as cliente,

                SUM(
                    CASE 
                        WHEN p.nome LIKE '%GAS%' OR p.nome LIKE '%GÁS%'
                        THEN mi.quantidade * p.preco_venda
                        ELSE 0 
                    END
                ) as gas,

                SUM(
                    CASE 
                        WHEN p.nome LIKE '%AGUA%' OR p.nome LIKE '%ÁGUA%'
                        THEN mi.quantidade * p.preco_venda
                        ELSE 0 
                    END
                ) as agua
            ")
            ->where('m.empresa_id', $empresaId)
            ->where('mi.empresa_id', $empresaId)
            ->where('c.empresa_id', $empresaId)
            ->where('p.empresa_id', $empresaId)
            ->whereBetween('m.data_coleta', [$dataInicio, $dataFim])
            ->groupBy('c.nome')
            ->orderByRaw('(gas + agua) DESC')
            ->limit(20)
            ->get();

        return response()->json($dados);
    }

    public function previsaoRupturaEstoque(Request $request)
    {
        $empresaId = $this->empresaId();

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
            ->where('empresa_id', $empresaId)
            ->where(function ($q) {
                $q->where('nome', 'like', '%GAS%')
                  ->orWhere('nome', 'like', '%GÁS%')
                  ->orWhere('nome', 'like', '%AGUA%')
                  ->orWhere('nome', 'like', '%ÁGUA%');
            })
            ->get();

        $resultado = [];

        foreach ($produtos as $produto) {
            $totalVendido = DB::table('movimentacao_itens as mi')
                ->join('movimentacao as m', 'm.id', '=', 'mi.movimentacao_id')
                ->where('m.empresa_id', $empresaId)
                ->where('mi.empresa_id', $empresaId)
                ->where('mi.produto_id', $produto->id)
                ->whereBetween('m.data_coleta', [$dataInicio, $dataFim])
                ->sum('mi.quantidade');

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