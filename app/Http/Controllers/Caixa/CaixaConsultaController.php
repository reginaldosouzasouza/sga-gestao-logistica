<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caixa;
use App\Models\CaixaBanco;

class CaixaConsultaController extends Controller
{
    public function index(Request $request)
    {
        // ============================
        // FILTROS
        // ============================
        $dataInicio = $request->data_inicio;
        $dataFim    = $request->data_fim;
        $tipo       = $request->tipo; // entrada | saida
        $origem     = $request->origem; // caixa | banco
        $texto      = $request->texto;

        // ============================
        // CAIXA (DINHEIRO)
        // ============================
        $caixa = Caixa::query();

        // ============================
        // CAIXA BANCO (PIX)
        // ============================
        $banco = CaixaBanco::query();

        if ($dataInicio && $dataFim) {
            $caixa->whereBetween('data_movimentacao', [$dataInicio, $dataFim]);
            $banco->whereBetween('data_movimentacao', [$dataInicio, $dataFim]);
        }

        if ($tipo) {
            $caixa->where('tipo', $tipo);
            $banco->where('tipo', $tipo);
        }

        if ($texto) {
            $caixa->where('descricao', 'like', "%$texto%");
            $banco->where('descricao', 'like', "%$texto%");
        }

        $movimentacoes = collect();

        if (!$origem || $origem === 'caixa') {
            $movimentacoes = $movimentacoes->merge(
                $caixa->get()->map(function ($item) {
                    $item->origem_caixa = 'Caixa';
                    return $item;
                })
            );
        }

        if (!$origem || $origem === 'banco') {
            $movimentacoes = $movimentacoes->merge(
                $banco->get()->map(function ($item) {
                    $item->origem_caixa = 'Banco';
                    return $item;
                })
            );
        }

        // Ordenar por data
        $movimentacoes = $movimentacoes->sortByDesc('data_movimentacao');

        return view('caixa.consulta', compact(
            'movimentacoes',
            'dataInicio',
            'dataFim',
            'tipo',
            'origem',
            'texto'
        ));
    }
}

