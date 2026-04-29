<?php

namespace App\Http\Controllers;

use App\Services\RelatorioFinanceiroService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class RelCaixaController extends Controller
{
    protected $relatorioService;

    public function __construct(RelatorioFinanceiroService $relatorioService)
    {
        $this->relatorioService = $relatorioService;
    }

    /**
     * Exibir o relatório REL_CAIXA
     * GET /relatorios/rel-caixa
     */
    public function index(Request $request)
    {
        // Validação
        $validator = Validator::make($request->all(), [
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Parâmetros
        $dataInicio = $request->input('data_inicio', Carbon::today()->toDateString());
        $dataFim = $request->input('data_fim', $dataInicio);

        // Buscar dados
        $dados = $this->relatorioService->relCaixaComTotais($dataInicio, $dataFim);

        return view('relatorios.rel-caixa', $dados);
    }

    /**
     * API: Retornar JSON
     * GET /api/relatorios/rel-caixa
     */
    public function api(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $dataInicio = $request->input('data_inicio', Carbon::today()->toDateString());
        $dataFim = $request->input('data_fim', $dataInicio);

        $dados = $this->relatorioService->relCaixaComTotais($dataInicio, $dataFim);

        return response()->json([
            'success' => true,
            'data' => $dados
        ]);
    }

    /**
     * Exportar para Excel/CSV
     * GET /relatorios/rel-caixa/exportar
     */
    public function exportar(Request $request)
    {
        $dataInicio = $request->input('data_inicio', Carbon::today()->toDateString());
        $dataFim = $request->input('data_fim', $dataInicio);

        $dados = $this->relatorioService->relCaixaComTotais($dataInicio, $dataFim);

        // Headers para download CSV
        $filename = "rel_caixa_{$dataInicio}_a_{$dataFim}.csv";
        
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($dados) {
            $file = fopen('php://output', 'w');
            
            // BOM para UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Cabeçalho
            fputcsv($file, [
                'Data',
                'Hora',
                'Tipo',
                'Forma Pagamento',
                'Valor',
                'Origem',
                'Descrição',
                'Status'
            ], ';');

            // Dados
            foreach ($dados['movimentacoes'] as $mov) {
                fputcsv($file, [
                    $mov->data,
                    $mov->hora,
                    $mov->tipo_formatado,
                    $mov->forma_pagamento,
                    $mov->valor_formatado,
                    $mov->origem,
                    $mov->descricao,
                    $mov->status
                ], ';');
            }

            // Linha em branco
            fputcsv($file, [], ';');

            // Totalizadores
            fputcsv($file, ['TOTALIZADORES'], ';');
            fputcsv($file, ['Total Receitas', $dados['totais_formatados']['total_receitas']], ';');
            fputcsv($file, ['Total Despesas', $dados['totais_formatados']['total_despesas']], ';');
            fputcsv($file, ['Saldo Período', $dados['totais_formatados']['saldo_periodo']], ';');
            fputcsv($file, ['Quantidade Entradas', $dados['totais_formatados']['quantidade_entradas']], ';');
            fputcsv($file, ['Quantidade Saídas', $dados['totais_formatados']['quantidade_saidas']], ';');

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Imprimir relatório
     * GET /relatorios/rel-caixa/imprimir
     */
    public function imprimir(Request $request)
    {
        $dataInicio = $request->input('data_inicio', Carbon::today()->toDateString());
        $dataFim = $request->input('data_fim', $dataInicio);

        $dados = $this->relatorioService->relCaixaComTotais($dataInicio, $dataFim);

        return view('relatorios.rel-caixa-print', $dados);
    }
}
