<?php



namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
            ->join(
                'movimentacao_itens as mi',
                'mi.movimentacao_id',
                '=',
                'm.id'
            )
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
            ->groupBy(
                DB::raw('DATE(m.data_coleta)'),
                'p.id',
                'p.nome'
            )
            ->orderBy('data')
            ->orderBy('p.nome');

        /*
         * Caso movimentacao_itens possua empresa_id,
         * esta condição também poderá ser utilizada:
         */
        // $query->where('mi.empresa_id', $empresaId);

        if ($request->filled('data_inicial')) {
            $query->whereDate(
                'm.data_coleta',
                '>=',
                $request->data_inicial
            );
        }

        if ($request->filled('data_final')) {
            $query->whereDate(
                'm.data_coleta',
                '<=',
                $request->data_final
            );
        }

        if ($request->filled('produto_id')) {
            $query->where(
                'p.id',
                $request->produto_id
            );
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

        return view(
            'relatorios.vendas_emissao',
            compact(
                'resultados',
                'produtos',
                'total_quantidade',
                'total_valor'
            )
        );
    }

    public function exportar(Request $request): StreamedResponse
{
    $resultados = $this->getQuery($request)->get();

    $fileName = 'vendas_emissao_'
        . now()->format('Ymd_His')
        . '.xlsx';

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setTitle('Vendas por Emissão');

    /*
    |--------------------------------------------------------------------------
    | Cabeçalho
    |--------------------------------------------------------------------------
    */

    $sheet->fromArray([
        'Data',
        'Produto',
        'Quantidade Total',
        'Valor Total (R$)',
    ], null, 'A1');

    $sheet->getStyle('A1:D1')->applyFromArray([
        'font' => [
            'bold' => true,
            'color' => [
                'argb' => 'FFFFFFFF',
            ],
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => [
                'argb' => 'FF0D6EFD',
            ],
        ],
        'alignment' => [
            'horizontal' =>
                \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' =>
                \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Dados
    |--------------------------------------------------------------------------
    */

    $linha = 2;

    foreach ($resultados as $resultado) {
        $data = $resultado->data
            ? \Carbon\Carbon::parse($resultado->data)->format('d/m/Y')
            : '-';

        $sheet->setCellValue(
            'A' . $linha,
            $data
        );

        $sheet->setCellValue(
            'B' . $linha,
            $resultado->produto ?? '-'
        );

        $sheet->setCellValue(
            'C' . $linha,
            (float) $resultado->quantidade_total
        );

        /*
         * O valor precisa ser enviado como número.
         * Não utilize number_format() ao gravar a célula.
         */
        $sheet->setCellValue(
            'D' . $linha,
            (float) $resultado->valor_total
        );

        $linha++;
    }

    /*
    |--------------------------------------------------------------------------
    | Linha de total
    |--------------------------------------------------------------------------
    */

    $sheet->setCellValue(
        'B' . $linha,
        'TOTAL'
    );

    $sheet->setCellValue(
        'C' . $linha,
        (float) $resultados->sum('quantidade_total')
    );

    $sheet->setCellValue(
        'D' . $linha,
        (float) $resultados->sum('valor_total')
    );

    $sheet->getStyle(
        'B' . $linha . ':D' . $linha
    )->applyFromArray([
        'font' => [
            'bold' => true,
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => [
                'argb' => 'FFDBEAFE',
            ],
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Formatação numérica
    |--------------------------------------------------------------------------
    */

    if ($linha > 2) {
        $sheet->getStyle(
            'C2:C' . $linha
        )->getNumberFormat()->setFormatCode('0');

        $sheet->getStyle(
            'D2:D' . $linha
        )->getNumberFormat()->setFormatCode('#.##0,00');
    }

    /*
    |--------------------------------------------------------------------------
    | Bordas e alinhamento
    |--------------------------------------------------------------------------
    */

    $sheet->getStyle(
        'A1:D' . $linha
    )->getBorders()->getAllBorders()->setBorderStyle(
        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
    );

    $sheet->getStyle(
        'C2:D' . $linha
    )->getAlignment()->setHorizontal(
        \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT
    );

    /*
    |--------------------------------------------------------------------------
    | Largura das colunas
    |--------------------------------------------------------------------------
    */

    foreach (range('A', 'D') as $coluna) {
        $sheet
            ->getColumnDimension($coluna)
            ->setAutoSize(true);
    }

    $sheet->freezePane('A2');

    /*
    |--------------------------------------------------------------------------
    | Limpa qualquer saída anterior
    |--------------------------------------------------------------------------
    |
    | Esta parte é importante. Qualquer espaço, aviso, caractere ou buffer
    | anterior pode fazer o conteúdo do XLSX aparecer como texto no navegador.
    |
    */

    while (ob_get_level() > 0) {
        ob_end_clean();
    }

    /*
    |--------------------------------------------------------------------------
    | Resposta do arquivo
    |--------------------------------------------------------------------------
    */

    $response = new StreamedResponse(
        function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);

            /*
             * Evita processamento desnecessário durante a exportação.
             */
            $writer->setPreCalculateFormulas(false);

            $writer->save('php://output');

            $spreadsheet->disconnectWorksheets();

            if (ob_get_level() > 0) {
                ob_flush();
            }

            flush();
        }
    );

    $response->headers->set(
        'Content-Type',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    );

    $response->headers->set(
        'Content-Disposition',
        'attachment; filename="' . $fileName . '"'
    );

    $response->headers->set(
        'Cache-Control',
        'no-store, no-cache, must-revalidate, max-age=0'
    );

    $response->headers->set(
        'Pragma',
        'no-cache'
    );

    $response->headers->set(
        'Expires',
        '0'
    );

    $response->headers->set(
        'X-Content-Type-Options',
        'nosniff'
    );

    return $response;
}
}