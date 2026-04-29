<?php

namespace App\Http\Controllers;

use App\Models\Caixa;
use App\Models\CaixaBanco;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RelCaixaController extends Controller
{
    public function index(Request $request)
    {
        $dataInicio = $request->get('data_inicio', Carbon::today()->toDateString());
        $dataFim    = $request->get('data_fim', Carbon::today()->toDateString());

        $movCaixa = collect(
            Caixa::whereBetween('data_movimentacao', [
                $dataInicio . ' 00:00:00',
                $dataFim . ' 23:59:59'
            ])->orderBy('data_movimentacao')->get()
            ->map(fn($m) => [
                'data'      => Carbon::parse($m->data_movimentacao)->format('d/m/Y'),
                'hora'      => Carbon::parse($m->data_movimentacao)->format('H:i'),
                'tipo'      => $m->tipo === 'estorno' ? 'entrada' : $m->tipo,
                'forma'     => 'Dinheiro',
                'valor'     => $m->valor,
                'origem'    => $m->origem,
                'descricao' => $m->descricao,
            ])
            ->all()
        );

        $movBanco = collect(
            CaixaBanco::whereBetween('data_movimentacao', [
                $dataInicio . ' 00:00:00',
                $dataFim . ' 23:59:59'
            ])->orderBy('data_movimentacao')->get()
            ->map(fn($m) => [
                'data'      => Carbon::parse($m->data_movimentacao)->format('d/m/Y'),
                'hora'      => Carbon::parse($m->data_movimentacao)->format('H:i'),
                'tipo'      => $m->tipo,
                'forma'     => 'PIX/Banco',
                'valor'     => $m->valor,
                'origem'    => $m->origem,
                'descricao' => $m->descricao,
            ])
            ->all()
        );

        $lancamentos = $movCaixa->merge($movBanco)
            ->sortBy(fn($m) => $m['data'] . ' ' . $m['hora'])
            ->values();

        $totais = [
            'entradas_caixa'  => $movCaixa->whereIn('tipo', ['entrada', 'estorno'])->sum('valor'),
            'saidas_caixa'    => $movCaixa->where('tipo', 'saida')->sum('valor'),
            'entradas_banco'  => $movBanco->whereIn('tipo', ['entrada', 'estorno'])->sum('valor'),
            'saidas_banco'    => $movBanco->where('tipo', 'saida')->sum('valor'),
        ];

        $totais['saldo_caixa']    = $totais['entradas_caixa'] - $totais['saidas_caixa'];
        $totais['saldo_banco']    = $totais['entradas_banco'] - $totais['saidas_banco'];
        $totais['saldo_geral']    = $totais['saldo_caixa'] + $totais['saldo_banco'];
        $totais['total_entradas'] = $totais['entradas_caixa'] + $totais['entradas_banco'];
        $totais['total_saidas']   = $totais['saidas_caixa'] + $totais['saidas_banco'];

        return view('relatorios.rel-caixa', [
            'lancamentos' => $lancamentos,
            'totais'      => $totais,
            'periodo'     => ['data_inicio' => $dataInicio, 'data_fim' => $dataFim],
        ]);
    }






// Substitua apenas o método exportar() no seu RelCaixaController.php

public function exportar(Request $request)
{
    $dataInicio = $request->get('data_inicio', Carbon::today()->toDateString());
    $dataFim    = $request->get('data_fim', Carbon::today()->toDateString());

    $movCaixa = Caixa::whereBetween('data_movimentacao', [
        $dataInicio . ' 00:00:00', $dataFim . ' 23:59:59'
    ])->orderBy('data_movimentacao')->get();

    $movBanco = CaixaBanco::whereBetween('data_movimentacao', [
        $dataInicio . ' 00:00:00', $dataFim . ' 23:59:59'
    ])->orderBy('data_movimentacao')->get();

    // Monta os lançamentos combinados
    $lancamentos = collect();

    foreach ($movCaixa as $m) {
        // Saída = valor negativo (número puro, sem formatação ainda)
        $valorNumerico = $m->tipo === 'saida' ? -abs($m->valor) : abs($m->valor);

        $lancamentos->push([
            'data_sort'  => $m->data_movimentacao, // data real para ordenar corretamente
            'data'       => Carbon::parse($m->data_movimentacao)->format('d/m/Y'),
            'hora'       => Carbon::parse($m->data_movimentacao)->format('H:i'),
            'tipo'       => $m->tipo,
            'meio'       => 'Dinheiro',
            'valor'      => $valorNumerico,
            'origem'     => $m->origem,
            'descricao'  => $m->descricao,
        ]);
    }

    foreach ($movBanco as $m) {
        $valorNumerico = $m->tipo === 'saida' ? -abs($m->valor) : abs($m->valor);

        $lancamentos->push([
            'data_sort'  => $m->data_movimentacao,
            'data'       => Carbon::parse($m->data_movimentacao)->format('d/m/Y'),
            'hora'       => Carbon::parse($m->data_movimentacao)->format('H:i'),
            'tipo'       => $m->tipo,
            'meio'       => 'PIX/Banco',
            'valor'      => $valorNumerico,
            'origem'     => $m->origem,
            'descricao'  => $m->descricao,
        ]);
    }

    // Ordena pela data real (Y-m-d H:i:s), não pelo formato d/m/Y
    $lancamentos = $lancamentos->sortBy('data_sort')->values();

    // Calcula totais com os valores numéricos
    $totalEntradas = $lancamentos->where('tipo', '!=', 'saida')->sum('valor');
    $totalSaidas   = $lancamentos->where('tipo', 'saida')->sum('valor'); // já negativo
    $saldo         = $totalEntradas + $totalSaidas;

    $filename = 'movimentacao_caixa_'
        . Carbon::parse($dataInicio)->format('d-m-Y')
        . '_a_'
        . Carbon::parse($dataFim)->format('d-m-Y')
        . '.csv';

    $headers = [
        'Content-Type'        => 'text/csv; charset=UTF-8',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ];

    $callback = function () use ($lancamentos, $totalEntradas, $totalSaidas, $saldo, $dataInicio, $dataFim) {

        $file = fopen('php://output', 'w');

        // BOM UTF-8 para Excel abrir corretamente
        fputs($file, "\xEF\xBB\xBF");

        // Título e período
        fputcsv($file, ['Relatório de Movimentação do Caixa'], ';');
        fputcsv($file, [
            'Período:',
            Carbon::parse($dataInicio)->format('d/m/Y') . ' até ' . Carbon::parse($dataFim)->format('d/m/Y')
        ], ';');
        fputcsv($file, [], ';');

        // Resumo de totais
        // IMPORTANTE: usar ponto como decimal para o Excel reconhecer como número
        fputcsv($file, ['Total Entradas (R$):', number_format($totalEntradas, 2, '.', '')], ';');
        fputcsv($file, ['Total Saídas (R$):',   number_format($totalSaidas,   2, '.', '')], ';');
        fputcsv($file, ['Saldo do Período (R$):', number_format($saldo,        2, '.', '')], ';');
        fputcsv($file, [], ';');

        // Cabeçalho da tabela
        fputcsv($file, ['Data', 'Hora', 'Tipo', 'Meio', 'Valor (R$)', 'Origem', 'Descrição'], ';');

        // Linhas de dados
        foreach ($lancamentos as $m) {
            fputcsv($file, [
                $m['data'],
                $m['hora'],
                ucfirst($m['tipo']),
                $m['meio'],
                // Ponto como separador decimal → Excel reconhece como número e soma corretamente
                number_format($m['valor'], 2, '.', ''),
                $m['origem'],
                $m['descricao'],
            ], ';');
        }

        // Linha de total final
        fputcsv($file, [], ';');
        fputcsv($file, [
            'TOTAL (' . $lancamentos->count() . ' registros)',
            '', '', '',
            number_format($saldo, 2, '.', ''),
            '', ''
        ], ';');

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}