<?php

namespace App\Exports;

use App\Models\ContasAReceber;
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
        $fileName = 'contas_a_receber_' . now()->format('Ymd_His') . '.csv';

        $response = new StreamedResponse(function () {

            $handle = fopen('php://output', 'w');

            // BOM para Excel/LibreOffice abrir UTF-8 corretamente
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Cabeçalho das colunas
            fputcsv($handle, [
                'Cliente',
                'Forma de Pagamento',
                'Descrição',
                'Valor (R$)',
                'Data da Venda',
                'Data de Vencimento',
                'Data de Recebimento',
                'Status',
            ], ';');

            $empresaId = $this->filtros['empresa_id'] ?? empresaAtualId();

            ContasAReceber::with(['cliente', 'formaPagamento'])
                ->where('empresa_id', $empresaId)

                ->when($this->filtros['cliente'] ?? null, function ($q, $v) use ($empresaId) {
                    $q->whereHas('cliente', function ($q2) use ($v, $empresaId) {
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
                ->chunk(500, function ($contas) use ($handle) {
                    foreach ($contas as $conta) {
                        fputcsv($handle, [
                            $conta->cliente->nome ?? '-',
                            $conta->formaPagamento->nome ?? '-',
                            $conta->descricao ?? '-',

                            number_format((float) $conta->valor, 2, ',', '.'),

                            $conta->data_venda
                                ? \Carbon\Carbon::parse($conta->data_venda)->format('d/m/Y')
                                : '-',

                            $conta->data_vencimento
                                ? \Carbon\Carbon::parse($conta->data_vencimento)->format('d/m/Y')
                                : '-',

                            $conta->data_recebimento
                                ? \Carbon\Carbon::parse($conta->data_recebimento)->format('d/m/Y')
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