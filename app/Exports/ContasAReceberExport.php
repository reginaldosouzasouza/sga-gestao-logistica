<?php

namespace App\Exports;

use App\Models\ContasAReceber;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContasAReceberExport
{
    protected array $filtros;

    public function __construct(array $filtros)
    {
        $this->filtros = $filtros;
    }

    public function download(): StreamedResponse
    {
        $fileName = 'contas_a_receber_' . now()->format('Ymd_His') . '.xlsx';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Contas a Receber');

        // === CABEÇALHO ===
        $cabecalho = [
            'Cliente', 'Forma de Pagamento', 'Descrição',
            'Valor (R$)', 'Data da Venda', 'Data de Vencimento',
            'Data de Recebimento', 'Status',
        ];

        foreach ($cabecalho as $col => $titulo) {
            $sheet->setCellValue(chr(65 + $col) . '1', $titulo);
        }

        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF16A34A']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // === DADOS ===
        $empresaId = $this->filtros['empresa_id'] ?? empresaAtualId();
        $linha = 2;

        ContasAReceber::with(['cliente', 'formaPagamento'])
            ->where('empresa_id', $empresaId)

            ->when($this->filtros['cliente'] ?? null, function ($q, $v) use ($empresaId) {
                $q->whereHas('cliente', function ($q2) use ($v, $empresaId) {
                    $q2->where('empresa_id', $empresaId)
                       ->where('nome', 'like', "%{$v}%");
                });
            })
            ->when($this->filtros['status'] ?? null, fn($q, $v) => $q->where('status', $v))
            ->when($this->filtros['forma_pagamento_id'] ?? null, fn($q, $v) => $q->where('forma_pagamento_id', $v))
            ->when(
                ($this->filtros['data_venda_inicial'] ?? null) && ($this->filtros['data_venda_final'] ?? null),
                function ($q) {
                    $q->whereBetween('data_venda', [
                        $this->filtros['data_venda_inicial'],
                        $this->filtros['data_venda_final'],
                    ]);
                }
            )
            ->when(
                ($this->filtros['data_vencimento_inicial'] ?? null) && ($this->filtros['data_vencimento_final'] ?? null),
                function ($q) {
                    $q->whereBetween('data_vencimento', [
                        $this->filtros['data_vencimento_inicial'],
                        $this->filtros['data_vencimento_final'],
                    ]);
                }
            )
            ->when(
                ($this->filtros['data_recebimento_inicial'] ?? null) && ($this->filtros['data_recebimento_final'] ?? null),
                function ($q) {
                    $q->whereBetween('data_recebimento', [
                        $this->filtros['data_recebimento_inicial'],
                        $this->filtros['data_recebimento_final'],
                    ]);
                }
            )
            ->orderBy('data_vencimento', 'asc')
            ->chunk(500, function ($contas) use ($sheet, &$linha) {
                foreach ($contas as $conta) {

                    $sheet->setCellValue('A' . $linha, $conta->cliente->nome ?? '-');
                    $sheet->setCellValue('B' . $linha, $conta->formaPagamento->nome ?? '-');
                    $sheet->setCellValue('C' . $linha, $conta->descricao ?? '-');
                    $sheet->setCellValue('D' . $linha, (float) $conta->valor);
                    $sheet->setCellValue('E' . $linha, $conta->data_venda ? Carbon::parse($conta->data_venda)->format('d/m/Y') : '-');
                    $sheet->setCellValue('F' . $linha, $conta->data_vencimento ? Carbon::parse($conta->data_vencimento)->format('d/m/Y') : '-');
                    $sheet->setCellValue('G' . $linha, $conta->data_recebimento ? Carbon::parse($conta->data_recebimento)->format('d/m/Y') : '-');
                    $sheet->setCellValue('H' . $linha, ucfirst($conta->status ?? '-'));

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
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD1FAE5']],
        ]);
        $sheet->getStyle('D' . $linha)->getNumberFormat()->setFormatCode('#.##0,00');

        // Auto largura
        foreach (range('A', 'H') as $col) {
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