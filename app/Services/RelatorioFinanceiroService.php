<?php

namespace App\Services;

use App\Models\Caixa;
use App\Models\CaixaBanco;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RelatorioFinanceiroService
{
    /**
     * Buscar relatório completo unificado
     */
    public function relatorioCompleto($dataInicio = null, $dataFim = null)
    {
        $dataInicio = $dataInicio ?? Carbon::today()->toDateString();
        $dataFim = $dataFim ?? $dataInicio;

        $query = $this->queryUnificada($dataInicio, $dataFim);
        
        return DB::table(DB::raw("({$query}) as movimentacoes_unificadas"))
            ->orderBy('data_movimentacao', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Buscar relatório com totalizadores
     */
    public function relatorioComTotais($dataInicio = null, $dataFim = null)
    {
        $movimentacoes = $this->relatorioCompleto($dataInicio, $dataFim);

        $totais = [
            'total_receitas' => $movimentacoes->where('tipo', 'entrada')->sum('valor'),
            'total_despesas' => $movimentacoes->where('tipo', 'saida')->sum('valor'),
            'saldo_periodo' => 0,
            'quantidade_entradas' => $movimentacoes->where('tipo', 'entrada')->count(),
            'quantidade_saidas' => $movimentacoes->where('tipo', 'saida')->count(),
            'total_transacoes' => $movimentacoes->count(),
        ];

        $totais['saldo_periodo'] = $totais['total_receitas'] - $totais['total_despesas'];

        return [
            'movimentacoes' => $movimentacoes,
            'totais' => $totais,
            'periodo' => [
                'data_inicio' => $dataInicio,
                'data_fim' => $dataFim,
            ]
        ];
    }

    /**
     * Relatório agrupado por dia
     */
    public function relatorioPorDia($dataInicio = null, $dataFim = null)
    {
        $dataInicio = $dataInicio ?? Carbon::today()->startOfMonth()->toDateString();
        $dataFim = $dataFim ?? Carbon::today()->toDateString();

        $query = $this->queryUnificada($dataInicio, $dataFim);

        return DB::table(DB::raw("({$query}) as movimentacoes"))
            ->select(
                DB::raw('DATE(data_movimentacao) as data'),
                DB::raw('SUM(CASE WHEN tipo = "entrada" THEN valor ELSE 0 END) as receitas'),
                DB::raw('SUM(CASE WHEN tipo = "saida" THEN valor ELSE 0 END) as despesas'),
                DB::raw('SUM(CASE WHEN tipo = "entrada" THEN valor ELSE -valor END) as saldo_dia'),
                DB::raw('COUNT(*) as total_movimentacoes'),
                DB::raw('COUNT(CASE WHEN tipo = "entrada" THEN 1 END) as qtd_entradas'),
                DB::raw('COUNT(CASE WHEN tipo = "saida" THEN 1 END) as qtd_saidas')
            )
            ->groupBy(DB::raw('DATE(data_movimentacao)'))
            ->orderBy('data', 'desc')
            ->get();
    }

    /**
     * Relatório por forma de pagamento
     */
    public function relatorioPorFormaPagamento($data = null)
    {
        $data = $data ?? Carbon::today()->toDateString();

        $query = $this->queryUnificada($data, $data);

        return DB::table(DB::raw("({$query}) as movimentacoes"))
            ->select(
                'forma_pagamento',
                DB::raw('SUM(CASE WHEN tipo = "entrada" THEN valor ELSE 0 END) as total_receitas'),
                DB::raw('SUM(CASE WHEN tipo = "saida" THEN valor ELSE 0 END) as total_despesas'),
                DB::raw('SUM(CASE WHEN tipo = "entrada" THEN valor ELSE -valor END) as saldo'),
                DB::raw('COUNT(CASE WHEN tipo = "entrada" THEN 1 END) as qtd_receitas'),
                DB::raw('COUNT(CASE WHEN tipo = "saida" THEN 1 END) as qtd_despesas')
            )
            ->groupBy('forma_pagamento')
            ->get();
    }

    /**
     * Totalizadores do período
     */
    public function totalizadores($dataInicio = null, $dataFim = null)
    {
        $dataInicio = $dataInicio ?? Carbon::today()->toDateString();
        $dataFim = $dataFim ?? $dataInicio;

        // Caixa (Dinheiro)
        $caixa = Caixa::porPeriodo($dataInicio, $dataFim)
            ->selectRaw('
                COALESCE(SUM(CASE WHEN tipo = "entrada" THEN valor ELSE 0 END), 0) as receitas,
                COALESCE(SUM(CASE WHEN tipo = "saida" THEN valor ELSE 0 END), 0) as despesas
            ')
            ->first();

        // Caixa Banco (PIX)
        $banco = CaixaBanco::porPeriodo($dataInicio, $dataFim)
            ->selectRaw('
                COALESCE(SUM(CASE WHEN tipo = "entrada" THEN valor ELSE 0 END), 0) as receitas,
                COALESCE(SUM(CASE WHEN tipo = "saida" THEN valor ELSE 0 END), 0) as despesas
            ')
            ->first();

        return [
            'caixa' => [
                'receitas' => (float) $caixa->receitas,
                'despesas' => (float) $caixa->despesas,
                'saldo' => (float) ($caixa->receitas - $caixa->despesas),
            ],
            'banco' => [
                'receitas' => (float) $banco->receitas,
                'despesas' => (float) $banco->despesas,
                'saldo' => (float) ($banco->receitas - $banco->despesas),
            ],
            'geral' => [
                'receitas' => (float) ($caixa->receitas + $banco->receitas),
                'despesas' => (float) ($caixa->despesas + $banco->despesas),
                'saldo' => (float) (($caixa->receitas + $banco->receitas) - ($caixa->despesas + $banco->despesas)),
            ]
        ];
    }

    /**
     * Query unificada das duas tabelas (CORE)
     */
    private function queryUnificada($dataInicio, $dataFim)
    {
        return "
            SELECT 
                id,
                data_movimentacao,
                tipo,
                'Dinheiro' as forma_pagamento,
                valor,
                origem,
                descricao,
                referencia_id,
                created_at,
                updated_at,
                'caixa' as origem_tabela
            FROM caixa
            WHERE DATE(data_movimentacao) BETWEEN '{$dataInicio}' AND '{$dataFim}'
            
            UNION ALL
            
            SELECT 
                id,
                data_movimentacao,
                tipo,
                CASE 
                    WHEN forma = 'pix' THEN 'PIX'
                    WHEN forma = 'transferencia' THEN 'Transferência'
                    ELSE UPPER(forma)
                END as forma_pagamento,
                valor,
                origem,
                descricao,
                referencia_id,
                created_at,
                updated_at,
                'caixa_banco' as origem_tabela
            FROM caixa_banco
            WHERE DATE(data_movimentacao) BETWEEN '{$dataInicio}' AND '{$dataFim}'
        ";
    }

    /**
     * REL_CAIXA - Relatório Formatado Completo
     * Baseado no SQL fornecido pelo usuário
     */
    public function relCaixa($dataInicio = null, $dataFim = null)
    {
        $dataInicio = $dataInicio ?? Carbon::today()->toDateString();
        $dataFim = $dataFim ?? $dataInicio;

        $sql = "
            SELECT 
                DATE_FORMAT(data_movimentacao, '%d/%m/%Y') AS data,
                DATE_FORMAT(data_movimentacao, '%H:%i') AS hora,
                CASE 
                    WHEN tipo = 'entrada' THEN '💰 Entrada'
                    WHEN tipo = 'saida' THEN '💸 Saída'
                    ELSE tipo
                END AS tipo_formatado,
                tipo,
                forma_pagamento,
                CONCAT('R$ ', FORMAT(valor, 2, 'pt_BR')) AS valor_formatado,
                valor AS valor_original,
                origem,
                descricao,
                CASE 
                    WHEN tipo = 'entrada' THEN '✅'
                    WHEN tipo = 'saida' THEN '❌'
                END AS status,
                data_movimentacao
            FROM (
                SELECT 
                    data_movimentacao,
                    tipo,
                    'Dinheiro' AS forma_pagamento,
                    valor,
                    origem,
                    descricao
                FROM caixa
                WHERE DATE(data_movimentacao) BETWEEN ? AND ?
                
                UNION ALL
                
                SELECT 
                    data_movimentacao,
                    tipo,
                    forma AS forma_pagamento,
                    valor,
                    origem,
                    descricao
                FROM caixa_banco
                WHERE DATE(data_movimentacao) BETWEEN ? AND ?
            ) AS movimentacoes
            ORDER BY data_movimentacao DESC
        ";

        return DB::select($sql, [$dataInicio, $dataFim, $dataInicio, $dataFim]);
    }

    /**
     * REL_CAIXA com Totalizadores
     */
    public function relCaixaComTotais($dataInicio = null, $dataFim = null)
    {
        $movimentacoes = collect($this->relCaixa($dataInicio, $dataFim));

        $totais = [
            'total_receitas' => $movimentacoes->where('tipo', 'entrada')->sum('valor_original'),
            'total_despesas' => $movimentacoes->where('tipo', 'saida')->sum('valor_original'),
            'saldo_periodo' => 0,
            'quantidade_entradas' => $movimentacoes->where('tipo', 'entrada')->count(),
            'quantidade_saidas' => $movimentacoes->where('tipo', 'saida')->count(),
            'total_transacoes' => $movimentacoes->count(),
        ];

        $totais['saldo_periodo'] = $totais['total_receitas'] - $totais['total_despesas'];

        // Formatação dos totais
        $totais_formatados = [
            'total_receitas' => 'R$ ' . number_format($totais['total_receitas'], 2, ',', '.'),
            'total_despesas' => 'R$ ' . number_format($totais['total_despesas'], 2, ',', '.'),
            'saldo_periodo' => 'R$ ' . number_format($totais['saldo_periodo'], 2, ',', '.'),
            'quantidade_entradas' => $totais['quantidade_entradas'],
            'quantidade_saidas' => $totais['quantidade_saidas'],
            'total_transacoes' => $totais['total_transacoes'],
        ];

        return [
            'movimentacoes' => $movimentacoes,
            'totais' => $totais,
            'totais_formatados' => $totais_formatados,
            'periodo' => [
                'data_inicio' => $dataInicio ?? Carbon::today()->toDateString(),
                'data_fim' => $dataFim ?? ($dataInicio ?? Carbon::today()->toDateString()),
            ]
        ];
    }

    /**
     * Exportar para Array formatado
     */
    public function exportarArray($dataInicio = null, $dataFim = null)
    {
        return $this->relCaixaComTotais($dataInicio, $dataFim);
    }
}
