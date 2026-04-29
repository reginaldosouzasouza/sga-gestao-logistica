<?php

namespace App\Exports;

use App\Models\ContasAPagar;
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
        $fileName = 'contas_a_pagar_' . now()->format('Ymd_His') . '.csv';

        $response = new StreamedResponse(function () {

            $handle = fopen('php://output', 'w');

            // BOM para Excel abrir UTF-8 corretamente
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Cabeçalho das colunas
            fputcsv($handle, [
                'Fornecedor',
                'Forma de Pagamento',
                'Descrição',
                'Valor (R$)',
                'Data de Compra',
                'Data de Vencimento',
                'Data de Pagamento',
                'Parcela',
                'Status',
            ], ';');

            // Busca os dados com os filtros
            ContasAPagar::with(['fornecedor', 'formaPagamento'])
                ->when($this->filtros['fornecedor'] ?? null, fn($q, $v) =>
                    $q->whereHas('fornecedor', fn($q2) =>
                        $q2->where('nome', 'like', "%$v%")
                    )
                )
                ->when($this->filtros['status'] ?? null, fn($q, $v) =>
                    $q->where('status', $v)
                )
                ->when($this->filtros['forma_pagamento_id'] ?? null, fn($q, $v) =>
                    $q->where('forma_pagamento_id', $v)
                )
                ->when($this->filtros['data_compra_inicial'] ?? null, fn($q, $v) =>
                    $q->whereDate('data_compra', '>=', $v)
                )
                ->when($this->filtros['data_compra_final'] ?? null, fn($q, $v) =>
                    $q->whereDate('data_compra', '<=', $v)
                )
                ->when($this->filtros['data_vencimento_inicial'] ?? null, fn($q, $v) =>
                    $q->whereDate('data_vencimento', '>=', $v)
                )
                ->when($this->filtros['data_vencimento_final'] ?? null, fn($q, $v) =>
                    $q->whereDate('data_vencimento', '<=', $v)
                )
                ->when($this->filtros['data_pagamento'] ?? null, fn($q, $v) =>
                    $q->whereDate('data_pagamento', $v)
                )
                ->orderBy('data_vencimento')
                ->chunk(500, function ($contas) use ($handle) {
                    foreach ($contas as $conta) {
                        fputcsv($handle, [
                            $conta->fornecedor->nome                ?? '-',
                            $conta->formaPagamento->nome            ?? '-',
                            $conta->descricao                       ?? '-',
                            number_format((float) $conta->valor, 2, ',', '.'),
                            $conta->data_compra
                                ? \Carbon\Carbon::parse($conta->data_compra)->format('d/m/Y')
                                : '-',
                            $conta->data_vencimento
                                ? \Carbon\Carbon::parse($conta->data_vencimento)->format('d/m/Y')
                                : '-',
                            $conta->data_pagamento
                                ? \Carbon\Carbon::parse($conta->data_pagamento)->format('d/m/Y')
                                : '-',
                            $conta->parcela && $conta->{'total-parcelas'}
                                ? $conta->parcela . '/' . $conta->{'total-parcelas'}
                                : '-',
                            ucfirst($conta->status ?? '-'),
                        ], ';');
                    }
                });

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', "attachment; filename=\"{$fileName}\"");

        return $response;
    }
}
