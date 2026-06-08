<?php

namespace App\Services\Financeiro;

use App\Models\ContasAPagar;
use App\Models\Fornecedor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class ImportacaoDespesaExcelService
{
    public function importar(string $caminhoArquivo, int $empresaId): array
    {
        $spreadsheet = IOFactory::load($caminhoArquivo);
        $sheet = $spreadsheet->getActiveSheet();
        $linhas = $sheet->toArray();

        if (empty($linhas)) {
            throw new \RuntimeException('O arquivo está vazio ou não pôde ser lido.');
        }

        $cabecalhoOriginal = array_shift($linhas);
        $cabecalho = $this->normalizarCabecalho($cabecalhoOriginal);

        $this->validarCabecalho($cabecalho);

        $resultado = [
            'lidas'      => 0,
            'validas'    => 0,
            'importadas' => 0,
            'duplicadas' => 0,
            'ignoradas'  => 0,
            'erros'      => [],
        ];

        DB::beginTransaction();

        try {
            foreach ($linhas as $indice => $linha) {
                $resultado['lidas']++;

                if ($this->linhaVazia($linha)) {
                    $resultado['ignoradas']++;
                    continue;
                }

                $item = $this->mapearLinha($cabecalho, $linha);

                if (!$this->deveImportar($item)) {
                    $resultado['ignoradas']++;
                    continue;
                }

                $resultado['validas']++;

                try {
                    $dataBase = $this->converterData($item['data']);
                    $dataVencimento = $dataBase->copy()->addMonth();

                    $descricao = $this->normalizarTexto($item['descricao'] ?? '');
                    $valor = $this->converterValor($item['valor']);

                    if ($descricao === '') {
                        $descricao = 'SEM DESCRICAO';
                    }

                    // Limpa aspas, espaços extras e caracteres estranhos antes de buscar o fornecedor.
                    $nomeFornecedor = $this->limparTextoImportado($item['fornecedor'] ?? '');
                    $fornecedorId = $this->buscarFornecedorId($nomeFornecedor, $empresaId);

                    $hash = $this->gerarHash(
                        $empresaId,
                        $dataVencimento->format('Y-m-d'),
                        (string) $fornecedorId,
                        $descricao,
                        $valor
                    );

                    $existe = ContasAPagar::where('empresa_id', $empresaId)
                        ->where('hash_importacao', $hash)
                        ->exists();

                    if ($existe) {
                        $resultado['duplicadas']++;
                        continue;
                    }

                    ContasAPagar::create([
                        'empresa_id'          => $empresaId,
                        'fornecedor_id'       => $fornecedorId,
                        'descricao'           => $descricao,
                        'valor'               => $valor,
                        'data_compra'         => $dataBase->format('Y-m-d'),
                        'data_vencimento'     => $dataVencimento->format('Y-m-d'),
                        'data_pagamento'      => null,
                        'status'              => 'pendente',
                        'forma_pagamento_id'  => 5,
                        'observacao'          => 'Importado do relatório financeiro',
                        'prazo'               => 30,
                        'compra_id'           => null,
                        'parcela'             => 1,
                        'total_parcelas'      => 1,
                        'origem_importacao'   => 'IMPORTACAO_EXCEL_DESPESAS',
                        'data_importacao'     => now(),
                        'usuario_importacao'  => Auth::id(),
                        'hash_importacao'     => $hash,
                    ]);

                    $resultado['importadas']++;

                } catch (\Throwable $e) {
                    $resultado['ignoradas']++;
                    $resultado['erros'][] = 'Linha ' . ($indice + 2) . ': ' . $e->getMessage();
                }
            }

            DB::commit();
            return $resultado;

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function normalizarCabecalho(array $cabecalho): array
    {
        return array_map(function ($coluna) {
            $coluna = trim((string) $coluna);
            $coluna = mb_strtolower($coluna);
            $coluna = $this->removerAcentos($coluna);
            return $coluna;
        }, $cabecalho);
    }

    private function validarCabecalho(array $cabecalho): void
    {
        $obrigatorias = ['data', 'tipo', 'fornecedor', 'descricao', 'valor'];

        foreach ($obrigatorias as $coluna) {
            if (!in_array($coluna, $cabecalho, true)) {
                throw new \RuntimeException("Coluna obrigatória não encontrada: {$coluna}");
            }
        }
    }

    private function mapearLinha(array $cabecalho, array $linha): array
    {
        $dados = [];

        foreach ($cabecalho as $indice => $coluna) {
            $dados[$coluna] = $linha[$indice] ?? null;
        }

        return $dados;
    }

    private function linhaVazia(array $linha): bool
    {
        foreach ($linha as $valor) {
            if (trim((string) $valor) !== '') {
                return false;
            }
        }

        return true;
    }

    private function deveImportar(array $item): bool
    {
        $tipo = $this->normalizarTexto($item['tipo'] ?? '');

        if (!in_array($tipo, ['SAIDA', 'SAÍDA'], true)) {
            return false;
        }

        if (empty($item['data'])) {
            return false;
        }

        if (!isset($item['valor']) || trim((string) $item['valor']) === '') {
            return false;
        }

        $descricao = $this->limparTextoImportado($item['descricao'] ?? '');

        if ($descricao === '') {
            return false;
        }

        $valor = $this->converterValor($item['valor']);

        return $valor > 0;
    }

    private function buscarFornecedorId(string $nomeFornecedor, int $empresaId): ?int
    {
        $nomeFornecedor = $this->limparTextoImportado($nomeFornecedor);

        if ($nomeFornecedor === '') {
            return $this->buscarFornecedorDiversos($empresaId);
        }

        $fornecedor = Fornecedor::query()
            ->where('empresa_id', $empresaId)
            ->whereRaw('UPPER(nome) = ?', [mb_strtoupper($nomeFornecedor)])
            ->first();

        if (!$fornecedor) {
            return $this->buscarFornecedorDiversos($empresaId);
        }

        return $fornecedor->id;
    }

    private function buscarFornecedorDiversos(int $empresaId): ?int
    {
        $fornecedor = Fornecedor::query()
            ->where('empresa_id', $empresaId)
            ->whereRaw('UPPER(nome) = ?', ['FORNECEDOR DIVERSOS'])
            ->first();

        if ($fornecedor) {
            return $fornecedor->id;
        }

        return null;
    }

    private function converterData($valor): Carbon
    {
        if ($valor instanceof \DateTimeInterface) {
            return Carbon::instance($valor);
        }

        if (is_numeric($valor)) {
            return Carbon::instance(ExcelDate::excelToDateTimeObject($valor));
        }

        $texto = $this->limparTextoImportado($valor);

        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $texto)) {
            return Carbon::createFromFormat('d/m/Y', $texto);
        }

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $texto)) {
            return Carbon::createFromFormat('Y-m-d', $texto);
        }

        throw new \RuntimeException('Data inválida.');
    }

    private function converterValor($valor): float
    {
        $texto = $this->limparTextoImportado($valor);

        if ($texto === '') {
            throw new \RuntimeException('Valor inválido.');
        }

        if (str_contains($texto, ',') && str_contains($texto, '.')) {
            $texto = str_replace('.', '', $texto);
            $texto = str_replace(',', '.', $texto);
        } elseif (str_contains($texto, ',')) {
            $texto = str_replace(',', '.', $texto);
        }

        if (!is_numeric($texto)) {
            throw new \RuntimeException('Valor inválido.');
        }

        return (float) $texto;
    }

    private function normalizarTexto(string $texto): string
    {
        $texto = $this->limparTextoImportado($texto);
        return mb_strtoupper($texto);
    }

    private function limparTextoImportado($texto): string
    {
        $texto = trim((string) $texto);

        // Remove aspas simples, aspas duplas e aspas curvas que podem vir do Excel/CSV.
        $texto = str_replace(['"', "'", '“', '”', '‘', '’'], '', $texto);

        // Remove espaços duplicados, tabulações e quebras de linha.
        $texto = preg_replace('/\s+/', ' ', $texto);

        return trim($texto);
    }

    private function removerAcentos(string $texto): string
    {
        return strtr($texto, [
            'á' => 'a', 'à' => 'a', 'ã' => 'a', 'â' => 'a',
            'é' => 'e', 'ê' => 'e',
            'í' => 'i',
            'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
            'ú' => 'u',
            'ç' => 'c',
            'Á' => 'A', 'À' => 'A', 'Ã' => 'A', 'Â' => 'A',
            'É' => 'E', 'Ê' => 'E',
            'Í' => 'I',
            'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O',
            'Ú' => 'U',
            'Ç' => 'C',
        ]);
    }

    private function gerarHash(int $empresaId, string $dataVencimento, string $fornecedorId, string $descricao, float $valor): string
    {
        return hash('sha256', implode('|', [
            $empresaId,
            $dataVencimento,
            $fornecedorId,
            $descricao,
            number_format($valor, 2, '.', ''),
        ]));
    }
}
