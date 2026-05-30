<?php

namespace App\Http\Controllers;

use App\Models\Caixa;
use App\Models\CaixaBanco;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RelCaixaController extends Controller
{
    private function empresaId()
    {
        return auth()->user()->empresa_id;
    }

    public function index(Request $request)
    {
        $empresaId = $this->empresaId();

        $dataInicio = $request->get('data_inicio', Carbon::today()->toDateString());
        $dataFim    = $request->get('data_fim', Carbon::today()->toDateString());

        $movCaixa = collect(
            Caixa::where('empresa_id', $empresaId)
                ->whereBetween('data_movimentacao', [
                    $dataInicio . ' 00:00:00',
                    $dataFim . ' 23:59:59'
                ])
                ->orderBy('data_movimentacao')
                ->get()
                ->map(fn ($m) => [
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
            CaixaBanco::where('empresa_id', $empresaId)
                ->whereBetween('data_movimentacao', [
                    $dataInicio . ' 00:00:00',
                    $dataFim . ' 23:59:59'
                ])
                ->orderBy('data_movimentacao')
                ->get()
                ->map(fn ($m) => [
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
            ->sortBy(fn ($m) => $m['data'] . ' ' . $m['hora'])
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
            'periodo'     => [
                'data_inicio' => $dataInicio,
                'data_fim'    => $dataFim
            ],
        ]);
    }

    public function exportar(Request $request)
    {
        $empresaId = $this->empresaId();

        $dataInicio = $request->get('data_inicio', Carbon::today()->toDateString());
        $dataFim    = $request->get('data_fim', Carbon::today()->toDateString());

        $lancamentos = collect();

        // ── CAIXA (Dinheiro) ────────────────────────────────────────────────
        Caixa::where('empresa_id', $empresaId)
            ->whereBetween('data_movimentacao', [
                $dataInicio . ' 00:00:00',
                $dataFim . ' 23:59:59',
            ])
            ->orderBy('data_movimentacao')
            ->get()
            ->each(function ($m) use (&$lancamentos) {
                $tipo = $m->tipo;

                // Saída = negativo | entrada e estorno = positivo
                $valor = in_array($tipo, ['saida'])
                    ? -abs((float) $m->valor)
                    : abs((float) $m->valor);

                $lancamentos->push([
                    'data_sort' => Carbon::parse($m->data_movimentacao)->format('Y-m-d H:i:s'),
                    'data'      => Carbon::parse($m->data_movimentacao)->format('d/m/Y'),
                    'hora'      => Carbon::parse($m->data_movimentacao)->format('H:i'),
                    'tipo'      => $tipo,
                    'meio'      => 'Dinheiro',
                    'valor'     => $valor,
                    'origem'    => $m->origem ?? '',
                    'descricao' => $m->descricao ?? '',
                ]);
            });

        // ── BANCO / PIX ─────────────────────────────────────────────────────
        CaixaBanco::where('empresa_id', $empresaId)
            ->whereBetween('data_movimentacao', [
                $dataInicio . ' 00:00:00',
                $dataFim . ' 23:59:59',
            ])
            ->orderBy('data_movimentacao')
            ->get()
            ->each(function ($m) use (&$lancamentos) {
                $tipo = $m->tipo;

                $valor = in_array($tipo, ['saida'])
                    ? -abs((float) $m->valor)
                    : abs((float) $m->valor);

                $lancamentos->push([
                    'data_sort' => Carbon::parse($m->data_movimentacao)->format('Y-m-d H:i:s'),
                    'data'      => Carbon::parse($m->data_movimentacao)->format('d/m/Y'),
                    'hora'      => Carbon::parse($m->data_movimentacao)->format('H:i'),
                    'tipo'      => $tipo,
                    'meio'      => 'PIX/Banco',
                    'valor'     => $valor,
                    'origem'    => $m->origem ?? '',
                    'descricao' => $m->descricao ?? '',
                ]);
            });

        $lancamentos = $lancamentos->sortBy('data_sort')->values();

        $totalEntradas = $lancamentos->whereNotIn('tipo', ['saida'])->sum('valor');
        $totalSaidas   = $lancamentos->where('tipo', 'saida')->sum('valor');
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
            fputs($file, "\xEF\xBB\xBF");
            fputs($file, "sep=;\n");

            fputcsv($file, ['Relatório de Movimentação do Caixa'], ';');
            fputcsv($file, [
                'Período:',
                Carbon::parse($dataInicio)->format('d/m/Y') . ' até ' . Carbon::parse($dataFim)->format('d/m/Y'),
            ], ';');
            fputcsv($file, [], ';');

            fputcsv($file, ['Total Entradas (R$):', number_format($totalEntradas, 2, ',', '')], ';');
            fputcsv($file, ['Total Saídas (R$):', number_format($totalSaidas, 2, ',', '')], ';');
            fputcsv($file, ['Saldo do Período (R$):', number_format($saldo, 2, ',', '')], ';');
            fputcsv($file, [], ';');

            fputcsv($file, ['Data', 'Hora', 'Tipo', 'Meio', 'Valor (R$)', 'Origem', 'Descrição'], ';');

            foreach ($lancamentos as $m) {
                fputcsv($file, [
                    $m['data'],
                    $m['hora'],
                    ucfirst($m['tipo']),
                    $m['meio'],
                    number_format($m['valor'], 2, ',', ''),
                    $m['origem'],
                    $m['descricao'],
                ], ';');
            }

            fputcsv($file, [], ';');
            fputcsv($file, [
                'TOTAL (' . $lancamentos->count() . ' registros)',
                '', '', '',
                number_format($saldo, 2, ',', ''),
                '', '',
            ], ';');

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}