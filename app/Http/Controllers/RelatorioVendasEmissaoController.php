<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RelatorioVendasEmissaoController extends Controller
{
    private function empresaId()
    {
       return empresaAtualId();
    }

    private function getQuery(Request $request)
    {
        $empresaId = $this->empresaId();

        $query = DB::table('movimentacao as m')
            ->join('movimentacao_itens as mi', 'mi.movimentacao_id', '=', 'm.id')
            ->join('produtos as p', function ($join) use ($empresaId) {
                $join->on('p.id', '=', 'mi.produto_id')
                    ->where('p.empresa_id', '=', $empresaId);
            })
            ->where('m.empresa_id', $empresaId)
            ->select(
                DB::raw('DATE(m.data_coleta) as data'),
                'p.id as produto_id',
                'p.nome as produto',
                DB::raw('SUM(mi.quantidade) as quantidade_total'),
                DB::raw('SUM(mi.valor_total) as valor_total')
            )
            ->groupBy(DB::raw('DATE(m.data_coleta)'), 'p.id', 'p.nome')
            ->orderBy('data')
            ->orderBy('p.nome');

        /*
         * Se a tabela movimentacao_itens também tiver empresa_id,
         * pode ativar esta linha abaixo. Se não tiver, deixe comentada.
         */
        // $query->where('mi.empresa_id', $empresaId);

        if ($request->filled('data_inicial')) {
            $query->whereDate('m.data_coleta', '>=', $request->data_inicial);
        }

        if ($request->filled('data_final')) {
            $query->whereDate('m.data_coleta', '<=', $request->data_final);
        }

        if ($request->filled('produto_id')) {
            $query->where('p.id', $request->produto_id);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $empresaId = $this->empresaId();

        $resultados = $this->getQuery($request)->get();

        $produtos = DB::table('produtos')
            ->where('empresa_id', $empresaId)
            ->orderBy('nome')
            ->get();

        $total_quantidade = $resultados->sum('quantidade_total');
        $total_valor = $resultados->sum('valor_total');

        return view('relatorios.vendas_emissao', compact(
            'resultados',
            'produtos',
            'total_quantidade',
            'total_valor'
        ));
    }

    public function exportar(Request $request)
    {
        $resultados = $this->getQuery($request)->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Vendas por Emissão');

        // Cabeçalho
        $sheet->fromArray([
            'Data',
            'Produto',
            'Quantidade Total',
            'Valor Total (R$)'
        ], null, 'A1');

        // Estilo cabeçalho
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '0d6efd'],
            ],
        ]);

        // Dados
        $row = 2;

        foreach ($resultados as $r) {
            $sheet->fromArray([
                date('d/m/Y', strtotime($r->data)),
                $r->produto,
                $r->quantidade_total,
                number_format($r->valor_total, 2, ',', '.'),
            ], null, "A{$row}");

            $row++;
        }

        // Linha de totais
        $sheet->setCellValue("A{$row}", 'TOTAL');
        $sheet->setCellValue("C{$row}", $resultados->sum('quantidade_total'));
        $sheet->setCellValue("D{$row}", number_format($resultados->sum('valor_total'), 2, ',', '.'));
        $sheet->getStyle("A{$row}:D{$row}")->getFont()->setBold(true);

        // Auto largura colunas
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'vendas_emissao_' . now()->format('Ymd_His') . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}