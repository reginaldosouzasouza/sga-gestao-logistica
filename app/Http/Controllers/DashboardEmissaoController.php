<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardEmissaoController extends Controller
{
    public function index(Request $request)
    {
        // Filtro de data (Padrão: últimos 30 dias)
        $inicio = $request->get('data_inicio', now()->subDays(30)->format('Y-m-d'));
        $fim = $request->get('data_fim', now()->format('Y-m-d'));

        // 1. FATURAMENTO E MARGEM (Vendas de Água/Gás)
        $vendas = DB::table('movimentacao_itens as mi')
            ->join('movimentacao as m', 'm.id', '=', 'mi.movimentacao_id')
            ->join('produtos as p', 'p.id', '=', 'mi.produto_id')
            ->whereBetween('m.data_coleta', [$inicio, $fim])
            ->select(
                DB::raw('SUM(mi.valor_total) as faturamento'),
                DB::raw('SUM(mi.valor_total - (mi.quantidade * p.preco_compra)) as lucro_bruto')
            )->first();

        // 2. DESPESAS OPERACIONAIS (Filtrando para ignorar o que é carga/estoque)
        $despCaixa = DB::table('caixa')
            ->where('tipo', 'saida')
            ->whereBetween('data_movimentacao', [$inicio, $fim])
            ->where('descricao', 'NOT LIKE', '%GAS%')
            ->where('descricao', 'NOT LIKE', '%SAFIRA%')
            ->sum('valor');

        $despBanco = DB::table('caixa_banco')
            ->where('tipo', 'saida')
            ->whereBetween('data_movimentacao', [$inicio, $fim])
            ->where('descricao', 'NOT LIKE', '%GAS%')
            ->where('descricao', 'NOT LIKE', '%SAFIRA%')
            ->sum('valor');

        $totalDespesas = $despCaixa + $despBanco;
        $rendimentoLiquido = ($vendas->lucro_bruto ?? 0) - $totalDespesas;

        return view('dashboard_emissao.index', [
            'faturamento' => $vendas->faturamento ?? 0,
            'margemBruta' => $vendas->lucro_bruto ?? 0,
            'despesas'    => $totalDespesas,
            'rendimento'  => $rendimentoLiquido,
            'inicio'      => $inicio,
            'fim'         => $fim
        ]);
    }
}
