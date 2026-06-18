<?php

namespace App\Exports;

use App\Models\ContasAPagar;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContasAPagarExport
{
    protected array $filtros;

    public function __construct(array $filtros)
    {
        $this->filtros = $filtros;
    }

    public function download(): StreamedResponse
    {
        $fileName = 'contas_a_pagar_' . now()->format('Ymd_His') . '.xlsx';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Contas a Pagar');

        // === CABEÇALHO ===
        $cabecalho = [
            'Fornecedor', 'Forma de Pagamento', 'Descrição',
            'Valor (R$)', 'Data de Compra', 'Data de Vencimento',
            'Data de Pagamento', 'Parcela', 'Status',
        ];

        foreach ($cabecalho as $col => $titulo) {
            $sheet->setCellValue(chr(65 + $col) . '1', $titulo);
        }

        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF2563EB']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // === DADOS ===
        $empresaId = $this->filtros['empresa_id'] ?? empresaAtualId();
        $linha = 2;

        ContasAPagar::with(['fornecedor', 'formaPagamento'])
            ->where('empresa_id', $empresaId)
            ->when($this->filtros['fornecedor'] ?? null, function ($q, $v) use ($empresaId) {
                $q->whereHas('fornecedor', function ($q2) use ($v, $empresaId) {
                    $q2->where('empresa_id', $empresaId)->where('nome', 'like', "%{$v}%");
                });
            })
            ->when($this->filtros['status'] ?? null, fn($q, $v) => $q->where('status', $v))
            ->when($this->filtros['forma_pagamento_id'] ?? null, fn($q, $v) => $q->where('forma_pagamento_id', $v))
            ->when($this->filtros['data_compra_inicial'] ?? null, fn($q, $v) => $q->whereDate('data_compra', '>=', $v))
            ->when($this->filtros['data_compra_final'] ?? null, fn($q, $v) => $q->whereDate('data_compra', '<=', $v))
            ->when($this->filtros['data_vencimento_inicial'] ?? null, fn($q, $v) => $q->whereDate('data_vencimento', '>=', $v))
            ->when($this->filtros['data_vencimento_final'] ?? null, fn($q, $v) => $q->whereDate('data_vencimento', '<=', $v))
            ->when($this->filtros['data_pagamento'] ?? null, fn($q, $v) => $q->whereDate('data_pagamento', $v))
            ->orderBy('data_vencimento')
            ->chunk(500, function ($contas) use ($sheet, &$linha) {
                foreach ($contas as $conta) {

                    $parcela = '-';
                    if (!empty($conta->parcela) && !empty($conta->total_parcelas)) {
                        $parcela = $conta->parcela . '/' . $conta->total_parcelas;
                    }

                    $sheet->setCellValue('A' . $linha, $conta->fornecedor->nome ?? '-');
                    $sheet->setCellValue('B' . $linha, $conta->formaPagamento->nome ?? '-');
                    $sheet->setCellValue('C' . $linha, $conta->descricao ?? '-');
                    $sheet->setCellValue('D' . $linha, (float) $conta->valor);
                    $sheet->setCellValue('E' . $linha, $conta->data_compra ? Carbon::parse($conta->data_compra)->format('d/m/Y') : '-');
                    $sheet->setCellValue('F' . $linha, $conta->data_vencimento ? Carbon::parse($conta->data_vencimento)->format('d/m/Y') : '-');
                    $sheet->setCellValue('G' . $linha, $conta->data_pagamento ? Carbon::parse($conta->data_pagamento)->format('d/m/Y') : '-');
                    $sheet->setCellValue('H' . $linha, $parcela);
                    $sheet->setCellValue('I' . $linha, ucfirst($conta->status ?? '-'));

                    $linha++;
                }
            });

        // Formato moeda BR coluna D
        $sheet->getStyle('D2:D' . ($linha - 1))
            ->getNumberFormat()->setFormatCode('#.##0,00');

        // Linha de TOTAL
        $sheet->setCellValue('C' . $linha, 'TOTAL');
        $sheet->setCellValue('D' . $linha, '=SUM(D2:D' . ($linha - 1) . ')');
        $sheet->getStyle('C' . $linha . ':D' . $linha)->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFDBEAFE']],
        ]);
        $sheet->getStyle('D' . $linha)->getNumberFormat()->setFormatCode('#.##0,00');

        // Auto largura
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $response = new StreamedResponse(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', "attachment; filename=\"{$fileName}\"");
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }
}