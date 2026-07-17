<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\RelatorioMargemEmissaoExport;

class RelatorioMargemEmissaoController extends Controller
{
    private function empresaId()
    {
        return empresaAtualId();
    }

    public function index(Request $request)
    {
        $empresaId = $this->empresaId();

        $dataInicio = $request->data_inicio;
        $dataFim = $request->data_fim;
        $produtoId = $request->produto_id;

        $query = DB::table('movimentacao_itens as mi')
            ->join('movimentacao as m', 'm.id', '=', 'mi.movimentacao_id')
            ->join('produtos as p', 'p.id', '=', 'mi.produto_id')
            ->leftJoin('clientes as c', 'c.id', '=', 'm.cliente_id')
            ->where('mi.empresa_id', $empresaId)
            ->where('m.empresa_id', $empresaId)
            ->where('p.empresa_id', $empresaId)
            ->where('mi.valor_unitario', '>', 1)

            ->select(
                'm.id as movimentacao_id',
                'm.data_coleta',
                'm.valor_total as valor_total_emissao',
                'c.nome as cliente',
                'p.id as produto_id',
                'p.nome as produto',
                'mi.quantidade',
                'mi.valor_unitario',
                'mi.preco_compra_momento',
                'mi.valor_total as valor_total_item',
                DB::raw('(mi.valor_unitario - mi.preco_compra_momento) as margem_unitaria'),
                DB::raw('((mi.valor_unitario - mi.preco_compra_momento) * mi.quantidade) as margem_total'),
                DB::raw('
                    CASE 
                        WHEN mi.valor_unitario > 0 
                        THEN ((mi.valor_unitario - mi.preco_compra_momento) / mi.valor_unitario) * 100
                        ELSE 0
                    END as margem_percentual
                ')
            );

        if ($dataInicio) {
            $query->whereDate('m.data_coleta', '>=', $dataInicio);
        }

        if ($dataFim) {
            $query->whereDate('m.data_coleta', '<=', $dataFim);
        }

        if ($produtoId) {
            $query->where('p.id', $produtoId);
        }

        $itens = $query
            ->orderBy('m.data_coleta', 'desc')
            ->orderBy('m.id', 'desc')
            ->get();

        $produtos = DB::table('produtos')
            ->where('empresa_id', $empresaId)
            ->orderBy('nome')
            ->get();

        $totalVendido = $itens->sum('valor_total_item');

        $totalCusto = $itens->sum(function ($item) {
            return $item->preco_compra_momento * $item->quantidade;
        });

        $totalMargem = $itens->sum('margem_total');

        $margemMediaPercentual = $totalVendido > 0
            ? ($totalMargem / $totalVendido) * 100
            : 0;

        return view('relatorios.margem-emissao', compact(
            'itens',
            'produtos',
            'totalVendido',
            'totalCusto',
            'totalMargem',
            'margemMediaPercentual',
            'dataInicio',
            'dataFim',
            'produtoId'
        ));
    }


public function exportar(Request $request)
{
    $filtros = [
        'empresa_id'   => $this->empresaId(),
        'data_inicio'  => $request->data_inicio,
        'data_fim'     => $request->data_fim,
        'produto_id'   => $request->produto_id,
    ];

    return (new RelatorioMargemEmissaoExport($filtros))->download();
}
}