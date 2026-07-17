<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RelatorioMargemEmissaoExport
{
    protected array $filtros;

    public function __construct(array $filtros)
    {
        $this->filtros = $filtros;
    }

    public function download(): StreamedResponse
    {
        $fileName = 'relatorio_margem_emissao_' . now()->format('Ymd_His') . '.xlsx';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Margem por Emissao');

        // === CABEÇALHO ===
        $cabecalho = [
            'Data',
            'Emissão',
            'Cliente',
            'Produto',
            'Qtd',
            'Venda Unit.',
            'Custo Unit.',
            'Total Venda',
            'Total Custo',
            'Margem Unit.',
            'Margem Total',
            'Margem %',
        ];

        foreach ($cabecalho as $col => $titulo) {
            $sheet->setCellValue(chr(65 + $col) . '1', $titulo);
        }

        $sheet->getStyle('A1:L1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF2563EB'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // === FILTROS ===
        $empresaId = $this->filtros['empresa_id'] ?? empresaAtualId();
        $dataInicio = $this->filtros['data_inicio'] ?? null;
        $dataFim = $this->filtros['data_fim'] ?? null;
        $produtoId = $this->filtros['produto_id'] ?? null;

        $query = DB::table('movimentacao_itens as mi')
            ->join('movimentacao as m', 'm.id', '=', 'mi.movimentacao_id')
            ->join('produtos as p', 'p.id', '=', 'mi.produto_id')
            ->leftJoin('clientes as c', 'c.id', '=', 'm.cliente_id')
            ->where('mi.empresa_id', $empresaId)
            ->where('m.empresa_id', $empresaId)
            ->where('p.empresa_id', $empresaId)

            // Não exportar itens de R$ 1,00 ou abaixo
            ->where('mi.valor_unitario', '>', 1)

            ->select(
                'm.id as movimentacao_id',
                'm.data_coleta',
                'c.nome as cliente',
                'p.nome as produto',
                'mi.quantidade',
                'mi.valor_unitario',
                'mi.preco_compra_momento',
                'mi.valor_total as valor_total_item',
                DB::raw('(mi.preco_compra_momento * mi.quantidade) as total_custo'),
                DB::raw('
                    CASE 
                        WHEN mi.quantidade > 0
                        THEN ((mi.valor_total / mi.quantidade) - mi.preco_compra_momento)
                        ELSE 0
                    END as margem_unitaria
                '),
                DB::raw('(mi.valor_total - (mi.preco_compra_momento * mi.quantidade)) as margem_total'),
                DB::raw('
                    CASE 
                        WHEN mi.valor_total > 0 
                        THEN ((mi.valor_total - (mi.preco_compra_momento * mi.quantidade)) / mi.valor_total)
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

        // === DADOS ===
        $linha = 2;

        foreach ($itens as $item) {
            $sheet->setCellValue('A' . $linha, $item->data_coleta ? Carbon::parse($item->data_coleta)->format('d/m/Y') : '-');
            $sheet->setCellValue('B' . $linha, '#' . $item->movimentacao_id);
            $sheet->setCellValue('C' . $linha, $item->cliente ?? 'Não informado');
            $sheet->setCellValue('D' . $linha, $item->produto);
            $sheet->setCellValue('E' . $linha, (float) $item->quantidade);
            $sheet->setCellValue('F' . $linha, (float) $item->valor_unitario);
            $sheet->setCellValue('G' . $linha, (float) $item->preco_compra_momento);
            $sheet->setCellValue('H' . $linha, (float) $item->valor_total_item);
            $sheet->setCellValue('I' . $linha, (float) $item->total_custo);
            $sheet->setCellValue('J' . $linha, (float) $item->margem_unitaria);
            $sheet->setCellValue('K' . $linha, (float) $item->margem_total);
            $sheet->setCellValue('L' . $linha, (float) $item->margem_percentual);

            if ((float) $item->margem_total < 0) {
                $sheet->getStyle('J' . $linha . ':L' . $linha)->getFont()->getColor()->setARGB('FFDC2626');
            } else {
                $sheet->getStyle('J' . $linha . ':L' . $linha)->getFont()->getColor()->setARGB('FF008000');
            }

            $linha++;
        }

        $ultimaLinhaDados = $linha - 1;

        // === FORMATAÇÕES ===
        if ($ultimaLinhaDados >= 2) {
            // Quantidade
            $sheet->getStyle('E2:E' . $ultimaLinhaDados)
                ->getNumberFormat()
                ->setFormatCode('#,##0.00');

            // Moeda
            $sheet->getStyle('F2:K' . $ultimaLinhaDados)
                ->getNumberFormat()
                ->setFormatCode('"R$" #,##0.00');

            // Percentual real
            $sheet->getStyle('L2:L' . $ultimaLinhaDados)
                ->getNumberFormat()
                ->setFormatCode('0.00%');
        }

        // === LINHA DE TOTAL ===
        $linhaTotal = $linha + 1;

        $sheet->setCellValue('A' . $linhaTotal, 'TOTAIS');
        $sheet->mergeCells('A' . $linhaTotal . ':D' . $linhaTotal);

        if ($ultimaLinhaDados >= 2) {
            $sheet->setCellValue('E' . $linhaTotal, '=SUM(E2:E' . $ultimaLinhaDados . ')');
            $sheet->setCellValue('H' . $linhaTotal, '=SUM(H2:H' . $ultimaLinhaDados . ')');
            $sheet->setCellValue('I' . $linhaTotal, '=SUM(I2:I' . $ultimaLinhaDados . ')');
            $sheet->setCellValue('K' . $linhaTotal, '=SUM(K2:K' . $ultimaLinhaDados . ')');

            // Margem média = Margem Total / Total Venda
            $sheet->setCellValue('L' . $linhaTotal, '=IF(H' . $linhaTotal . '>0,K' . $linhaTotal . '/H' . $linhaTotal . ',0)');
        } else {
            $sheet->setCellValue('E' . $linhaTotal, 0);
            $sheet->setCellValue('H' . $linhaTotal, 0);
            $sheet->setCellValue('I' . $linhaTotal, 0);
            $sheet->setCellValue('K' . $linhaTotal, 0);
            $sheet->setCellValue('L' . $linhaTotal, 0);
        }

        $sheet->getStyle('A' . $linhaTotal . ':L' . $linhaTotal)->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFD1FAE5'],
            ],
        ]);

        $sheet->getStyle('E' . $linhaTotal)
            ->getNumberFormat()
            ->setFormatCode('#,##0.00');

        $sheet->getStyle('H' . $linhaTotal . ':K' . $linhaTotal)
            ->getNumberFormat()
            ->setFormatCode('"R$" #,##0.00');

        $sheet->getStyle('L' . $linhaTotal)
            ->getNumberFormat()
            ->setFormatCode('0.00%');

        // Bordas
        $sheet->getStyle('A1:L' . $linhaTotal)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FFCCCCCC'],
                ],
            ],
        ]);

        // Alinhamentos
        $sheet->getStyle('A1:L1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E2:L' . $linhaTotal)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('A2:D' . $linhaTotal)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // Auto largura
        foreach (range('A', 'L') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Congelar cabeçalho
        $sheet->freezePane('A2');

        // Filtro
        $sheet->setAutoFilter('A1:L1');

        // === DOWNLOAD ===
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