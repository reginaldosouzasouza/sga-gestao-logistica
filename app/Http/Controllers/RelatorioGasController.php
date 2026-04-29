<?php

namespace App\Http\Controllers;

use App\Models\ClienteProdutoDuracao;
use App\Models\Movimentacao;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RelatorioGasController extends Controller
{
    public function index()
    {
        $duracoes = ClienteProdutoDuracao::with(['cliente', 'produto'])
            ->where('produto_id', 2) // GAS P-13
            ->get();

        $relatorio = $duracoes->map(function ($item) {
            // Busca a última movimentação de saída que contenha o produto gás
            $ultimaMovimentacao = Movimentacao::whereHas('itens', function ($q) use ($item) {
                    $q->where('produto_id', $item->produto_id);
                })
                ->where('cliente_id', $item->cliente_id)
                ->orderBy('data_coleta', 'desc')
                ->first();

            $ultimaVenda  = $ultimaMovimentacao ? $ultimaMovimentacao->data_coleta : null;
            $dataAtual    = Carbon::today();
            $qtdeDias     = $ultimaVenda ? Carbon::parse($ultimaVenda)->diffInDays($dataAtual) : null;
            $previsao     = $qtdeDias !== null ? $item->duracao - $qtdeDias : null;

            return [
                'cliente'      => $item->cliente->nome,
                'ult_venda'    => $ultimaVenda,
                'data_atual'   => $dataAtual->format('d/m/Y'),
                'qtde_dias'    => $qtdeDias,
                'duracao'      => $item->duracao,
                'p_troca'      => $previsao,
            ];
        })->sortBy('p_troca'); // ordena do mais urgente ao menos urgente

        return view('relatorios.duracaogas', compact('relatorio'));
    }

     public function exportarExcel()
{
    $duracoes = \App\Models\ClienteProdutoDuracao::with(['cliente', 'produto'])
        ->where('produto_id', 2)
        ->get();

    $relatorio = $duracoes->map(function ($item) {
        $ultimaMovimentacao = \App\Models\Movimentacao::whereHas('itens', function ($q) use ($item) {
                $q->where('produto_id', $item->produto_id);
            })
            ->where('cliente_id', $item->cliente_id)
            ->orderBy('data_coleta', 'desc')
            ->first();

        $ultimaVenda = $ultimaMovimentacao ? $ultimaMovimentacao->data_coleta : null;
        $dataAtual   = \Carbon\Carbon::today();
        $qtdeDias    = $ultimaVenda ? \Carbon\Carbon::parse($ultimaVenda)->diffInDays($dataAtual) : null;
        $previsao    = $qtdeDias !== null ? $item->duracao - $qtdeDias : null;

        return [
            'cliente'    => $item->cliente->nome,
            'ult_venda'  => $ultimaVenda ? \Carbon\Carbon::parse($ultimaVenda)->format('d/m/Y') : 'Sem registro',
            'data_atual' => $dataAtual->format('d/m/Y'),
            'qtde_dias'  => $qtdeDias ?? '-',
            'duracao'    => $item->duracao,
            'p_troca'    => $previsao !== null ? $previsao.' dias' : '-',
            'status'     => $previsao === null ? 'Sem dados' :
                           ($previsao < 0  ? 'ATRASADO' :
                           ($previsao == 0 ? 'TROCAR HOJE' :
                           ($previsao <= 5 ? 'URGENTE' :
                           ($previsao <= 10? 'ATENÇÃO' : 'EM DIA')))),
        ];
    })->sortBy('p_troca');

    $filename = 'relatorio-gas-' . now()->format('d-m-Y') . '.csv';
    $headers  = [
        'Content-Type'        => 'text/csv; charset=UTF-8',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ];

    $callback = function () use ($relatorio) {
        $file = fopen('php://output', 'w');
        fputs($file, "\xEF\xBB\xBF"); // BOM UTF-8
        fputcsv($file, ['CLIENTE', 'ULT. VENDA', 'DATA ATUAL', 'QTDE DIAS', 'D.U.GAS', 'P.TROCA', 'STATUS'], ';');

        foreach ($relatorio as $row) {
            fputcsv($file, [
                $row['cliente'],
                $row['ult_venda'],
                $row['data_atual'],
                $row['qtde_dias'],
                $row['duracao'],
                $row['p_troca'],
                $row['status'],
            ], ';');
        }
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}