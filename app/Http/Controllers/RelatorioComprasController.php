<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatorioComprasController extends Controller
{
    public function index(Request $request)
    {
        $filtros = $request->only([
            'data_compra_inicio',
            'data_compra_fim',
            'data_vencimento_inicio',
            'data_vencimento_fim',
            'data_pagamento_inicio',
            'data_pagamento_fim',
            'fornecedor',
            'status',
            'forma_pagamento',
        ]);

        $resultado = $this->buscarCompras($filtros);

        $totais = [
            'total_geral'    => $resultado->sum('valor'),
            'total_pago'     => $resultado->where('situacao', 'pago')->sum('valor'),
            'total_pendente' => $resultado->where('situacao', 'pendente')->sum('valor'),
            'qtd_registros'  => $resultado->count(),
        ];

        $fornecedores = DB::table('fornecedores')
            ->select('id', 'nome')
            ->orderBy('nome')
            ->get();

        return view('relatorios.compras', compact('resultado', 'totais', 'filtros', 'fornecedores'));
    }

    // -------------------------------------------------------------------------
    // BUSCA PRINCIPAL — 1 linha por compra
    //
    // JOIN com contas_a_pagar usa duas estratégias:
    //   1) compra_id = comp.id  (quando preenchido)
    //   2) fornecedor_id + data_compra (quando compra_id é NULL)
    // -------------------------------------------------------------------------
    private function buscarCompras(array $f): \Illuminate\Support\Collection
    {
        $params = [];

        $sql = "
            SELECT
                comp.id                                                     AS compra_id,
                comp.data_compra,
                f.nome                                                      AS nome_fornecedor,
                f.cnpj,
                comp.total                                                  AS valor,
                comp.nota_fiscal,
                comp.observacao,

                -- ── STATUS ───────────────────────────────────────────────
                -- Prioriza cap (quando encontrado), senão usa caixa/banco
                CASE
                    WHEN cap.id IS NOT NULL THEN cap.status
                    WHEN COUNT(cx.id) > 0 OR COUNT(cb.id) > 0 THEN 'pago'
                    ELSE 'pendente'
                END                                                         AS situacao,

                -- ── FORMA DE PAGAMENTO ────────────────────────────────────
                CASE
                    WHEN COUNT(cx.id) > 0 AND COUNT(cb.id) > 0 THEN 'Misto'
                    WHEN COUNT(cx.id) > 0 THEN 'Dinheiro'
                    WHEN COUNT(cb.id) > 0 THEN MAX(cb.forma)
                    WHEN cap.id IS NOT NULL THEN 'Prazo'
                    ELSE 'N/A'
                END                                                         AS forma_pagamento,

                -- ── VENCIMENTO ────────────────────────────────────────────
                CASE
                    WHEN cap.id IS NOT NULL THEN cap.data_vencimento
                    ELSE NULL
                END                                                         AS data_vencimento,

                -- ── DATA PAGAMENTO ────────────────────────────────────────
                -- Só preenche se realmente pago
                CASE
                    WHEN cap.id IS NOT NULL AND cap.status = 'pago'
                        THEN cap.data_pagamento
                    WHEN COUNT(cx.id) > 0 AND cap.id IS NULL
                        THEN MAX(cx.data_movimentacao)
                    WHEN COUNT(cb.id) > 0 AND cap.id IS NULL
                        THEN MAX(cb.data_movimentacao)
                    ELSE NULL
                END                                                         AS data_pagamento,

                -- ── FONTE ─────────────────────────────────────────────────
                CASE
                    WHEN COUNT(cx.id) > 0 AND COUNT(cb.id) > 0 THEN 'Caixa + Banco'
                    WHEN COUNT(cx.id) > 0 THEN 'Caixa'
                    WHEN COUNT(cb.id) > 0 THEN 'Banco'
                    WHEN cap.id IS NOT NULL THEN 'Contas a Pagar'
                    ELSE 'N/A'
                END                                                         AS fonte

            FROM compras comp
            INNER JOIN fornecedores f ON comp.fornecedor_id = f.id

            -- JOIN duplo: tenta compra_id primeiro, senão usa fornecedor+data
            LEFT JOIN contas_a_pagar cap
                ON (
                    -- estratégia 1: compra_id direto (quando preenchido)
                    (cap.compra_id IS NOT NULL AND cap.compra_id = comp.id)
                    OR
                    -- estratégia 2: fornecedor + data (quando compra_id é NULL)
                    (cap.compra_id IS NULL
                        AND cap.fornecedor_id = comp.fornecedor_id
                        AND cap.data_compra   = comp.data_compra)
                )

            -- Pagamento em dinheiro (caixa)
            LEFT JOIN caixa cx
                ON cx.referencia_id = comp.id
                AND cx.tipo = 'saida'

            -- Pagamento via pix/banco (caixa_banco)
            LEFT JOIN caixa_banco cb
                ON cb.referencia_id = comp.id
                AND cb.tipo = 'saida'

            WHERE 1 = 1
        ";

        // ── Filtros WHERE ─────────────────────────────────────────────────

        if (!empty($f['data_compra_inicio'])) {
            $sql .= " AND comp.data_compra >= ?";
            $params[] = $f['data_compra_inicio'];
        }
        if (!empty($f['data_compra_fim'])) {
            $sql .= " AND comp.data_compra <= ?";
            $params[] = $f['data_compra_fim'];
        }
        if (!empty($f['data_vencimento_inicio'])) {
            $sql .= " AND cap.data_vencimento >= ?";
            $params[] = $f['data_vencimento_inicio'];
        }
        if (!empty($f['data_vencimento_fim'])) {
            $sql .= " AND cap.data_vencimento <= ?";
            $params[] = $f['data_vencimento_fim'];
        }
        if (!empty($f['fornecedor'])) {
            $sql .= " AND f.nome LIKE ?";
            $params[] = '%' . $f['fornecedor'] . '%';
        }

        // ── GROUP BY: 1 linha por compra ──────────────────────────────────
        $sql .= "
            GROUP BY
                comp.id,
                comp.data_compra,
                comp.data_vencimento,
                comp.data_pagamento,
                comp.total,
                comp.status,
                comp.nota_fiscal,
                comp.observacao,
                f.nome,
                f.cnpj,
                cap.id,
                cap.status,
                cap.data_vencimento,
                cap.data_pagamento
        ";

        // ── Filtros HAVING (pós-agregação) ────────────────────────────────
        $having = [];

        if (!empty($f['status'])) {
            $having[] = "situacao = ?";
            $params[] = $f['status'];
        }
        if (!empty($f['data_pagamento_inicio'])) {
            $having[] = "data_pagamento >= ?";
            $params[] = $f['data_pagamento_inicio'];
        }
        if (!empty($f['data_pagamento_fim'])) {
            $having[] = "data_pagamento <= ?";
            $params[] = $f['data_pagamento_fim'];
        }
        if (!empty($f['forma_pagamento'])) {
            $mapa = [
                'dinheiro' => 'Dinheiro',
                'pix'      => 'PIX',
                'prazo'    => 'Prazo',
                'misto'    => 'Misto',
            ];
            $forma = strtolower($f['forma_pagamento']);
            if (isset($mapa[$forma])) {
                $having[] = "forma_pagamento = ?";
                $params[] = $mapa[$forma];
            }
        }

        if (!empty($having)) {
            $sql .= " HAVING " . implode(' AND ', $having);
        }

        $sql .= " ORDER BY comp.data_compra DESC, f.nome ASC";

        return collect(DB::select($sql, $params));
    }

    // -------------------------------------------------------------------------
    // EXPORT CSV
    // -------------------------------------------------------------------------
    public function export(Request $request)
    {
        $filtros   = $request->only([
            'data_compra_inicio', 'data_compra_fim',
            'data_vencimento_inicio', 'data_vencimento_fim',
            'data_pagamento_inicio', 'data_pagamento_fim',
            'fornecedor', 'status', 'forma_pagamento',
        ]);

        $resultado = $this->buscarCompras($filtros);
        $filename  = 'relatorio_compras_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($resultado) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($handle, [
                'Data Compra', 'Fornecedor', 'CNPJ', 'Nota Fiscal',
                'Forma Pagamento', 'Valor', 'Status',
                'Data Vencimento', 'Data Pagamento', 'Fonte',
            ], ';');
            foreach ($resultado as $row) {
                fputcsv($handle, [
                    \Carbon\Carbon::parse($row->data_compra)->format('d/m/Y'),
                    $row->nome_fornecedor,
                    $row->cnpj,
                    $row->nota_fiscal ?? 'S/N',
                    $row->forma_pagamento,
                    number_format($row->valor, 2, ',', '.'),
                    $row->situacao,
                    $row->data_vencimento ? \Carbon\Carbon::parse($row->data_vencimento)->format('d/m/Y') : '',
                    $row->data_pagamento  ? \Carbon\Carbon::parse($row->data_pagamento)->format('d/m/Y')  : '',
                    $row->fonte,
                ], ';');
            }
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
