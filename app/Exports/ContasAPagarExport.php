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

            $empresaId = $this->filtros['empresa_id'] ?? auth()->user()->empresa_id;

            ContasAPagar::with(['fornecedor', 'formaPagamento'])
                ->where('empresa_id', $empresaId)

                ->when($this->filtros['fornecedor'] ?? null, function ($q, $v) use ($empresaId) {
                    $q->whereHas('fornecedor', function ($q2) use ($v, $empresaId) {
                        $q2->where('empresa_id', $empresaId)
                           ->where('nome', 'like', "%{$v}%");
                    });
                })

                ->when($this->filtros['status'] ?? null, function ($q, $v) {
                    $q->where('status', $v);
                })

                ->when($this->filtros['forma_pagamento_id'] ?? null, function ($q, $v) {
                    $q->where('forma_pagamento_id', $v);
                })

                ->when($this->filtros['data_compra_inicial'] ?? null, function ($q, $v) {
                    $q->whereDate('data_compra', '>=', $v);
                })

                ->when($this->filtros['data_compra_final'] ?? null, function ($q, $v) {
                    $q->whereDate('data_compra', '<=', $v);
                })

                ->when($this->filtros['data_vencimento_inicial'] ?? null, function ($q, $v) {
                    $q->whereDate('data_vencimento', '>=', $v);
                })

                ->when($this->filtros['data_vencimento_final'] ?? null, function ($q, $v) {
                    $q->whereDate('data_vencimento', '<=', $v);
                })

                ->when($this->filtros['data_pagamento'] ?? null, function ($q, $v) {
                    $q->whereDate('data_pagamento', $v);
                })

                ->orderBy('data_vencimento')
                ->chunk(500, function ($contas) use ($handle) {
                    foreach ($contas as $conta) {
                        $parcela = '-';

                        if (!empty($conta->parcela) && !empty($conta->total_parcelas)) {
                            $parcela = $conta->parcela . '/' . $conta->total_parcelas;
                        }
            fputcsv($handle, [
                $conta->fornecedor->nome ?? '-',
                $conta->formaPagamento->nome ?? '-',
                $conta->descricao ?? '-',

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

                $parcela,
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