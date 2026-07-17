<?php

namespace App\Services;

use App\Models\ConfiguracaoPrevisaoVenda;
use Carbon\Carbon;

class PrevisaoGiroService
{
    /**
     * Calcula a média ajustada de venda para um produto.
     *
     * Regras consideradas:
     * - Média diária base
     * - Ajuste de fim de mês
     * - Sazonalidade manual
     * - Estoque de segurança normal
     * - Regra especial de sexta-feira para final de semana
     */
    public function calcular(array $dados): array
    {
        $empresaId = $dados['empresa_id'];
        $produtoId = $dados['produto_id'];

        $mediaDiariaBase = (float) ($dados['media_diaria_base'] ?? 0);
        $estoqueAtual = (float) ($dados['estoque_atual'] ?? 0);
        $diasRestantes = (float) ($dados['dias_restantes'] ?? 0);
        $custoUnitario = (float) ($dados['custo_unitario'] ?? 0);

        $dataReferencia = isset($dados['data_referencia'])
            ? Carbon::parse($dados['data_referencia'])
            : now();

        $config = ConfiguracaoPrevisaoVenda::where('empresa_id', $empresaId)
            ->where('produto_id', $produtoId)
            ->where('ativo', true)
            ->first();

        $mediaAjustada = $mediaDiariaBase;

        $ajustesAplicados = [];

        /*
         * Ajuste de fim de mês
         */
        if (
            $config &&
            $config->usar_ajuste_fim_mes &&
            $config->dia_inicio_fim_mes &&
            $dataReferencia->day >= (int) $config->dia_inicio_fim_mes
        ) {
            $percentual = (float) $config->percentual_ajuste_fim_mes;

            $mediaAjustada = $mediaAjustada * (1 + ($percentual / 100));

            $ajustesAplicados[] = [
                'tipo' => 'Fim de mês',
                'percentual' => $percentual,
                'descricao' => 'Ajuste aplicado a partir do dia ' . $config->dia_inicio_fim_mes,
            ];
        }

        /*
         * Sazonalidade manual.
         * Funciona tanto para períodos normais, ex: maio a agosto,
         * quanto períodos que viram o ano, ex: outubro a março.
         */
        if (
            $config &&
            $config->usar_sazonalidade_manual &&
            $config->mes_inicio_sazonalidade &&
            $config->mes_fim_sazonalidade
        ) {
            $mesAtual = (int) $dataReferencia->month;
            $mesInicio = (int) $config->mes_inicio_sazonalidade;
            $mesFim = (int) $config->mes_fim_sazonalidade;

            $estaNoPeriodoSazonal = false;

            if ($mesInicio <= $mesFim) {
                $estaNoPeriodoSazonal = $mesAtual >= $mesInicio && $mesAtual <= $mesFim;
            } else {
                // Exemplo: outubro até março
                $estaNoPeriodoSazonal = $mesAtual >= $mesInicio || $mesAtual <= $mesFim;
            }

            if ($estaNoPeriodoSazonal) {
                $percentual = (float) $config->percentual_ajuste_sazonalidade;

                $mediaAjustada = $mediaAjustada * (1 + ($percentual / 100));

                $ajustesAplicados[] = [
                    'tipo' => 'Sazonalidade',
                    'percentual' => $percentual,
                    'descricao' => 'Ajuste sazonal aplicado no mês ' . $mesAtual,
                ];
            }
        }

        /*
         * Estoque de segurança.
         * Normalmente usa o que foi configurado.
         * Porém, se for sexta-feira, usamos 3,5 dias para cobrir sexta,
         * sábado, domingo e até meio-dia de segunda.
         */
        $estoqueSegurancaDias = $config
            ? (float) $config->estoque_seguranca_dias
            : 0;

        $regraFinalSemanaAplicada = false;

        if ($dataReferencia->isFriday()) {
            $estoqueSegurancaDias = max($estoqueSegurancaDias, 3.5);
            $regraFinalSemanaAplicada = true;

            $ajustesAplicados[] = [
                'tipo' => 'Final de semana',
                'percentual' => null,
                'descricao' => 'Sexta-feira: segurança elevada para 3,5 dias',
            ];
        }

        $vendaPrevista = $mediaAjustada * $diasRestantes;

        $estoqueSegurancaUnidades = $mediaAjustada * $estoqueSegurancaDias;

        $compraMinimaCalculada = max(0, $vendaPrevista - $estoqueAtual);

        $compraRecomendadaCalculada = max(0, ($vendaPrevista + $estoqueSegurancaUnidades) - $estoqueAtual);

        /*
        * Como a compra é feita em unidades inteiras,
        * arredondamos para cima antes de calcular o custo.
        */
        $compraMinima = ceil($compraMinimaCalculada);

        $compraRecomendada = ceil($compraRecomendadaCalculada);

        $custoCompraMinima = $compraMinima * $custoUnitario;

        $custoCompraRecomendada = $compraRecomendada * $custoUnitario;

        $coberturaAtualDias = $mediaAjustada > 0
            ? $estoqueAtual / $mediaAjustada
            : 0;

        return [
            'media_diaria_base' => round($mediaDiariaBase, 2),
            'media_diaria_ajustada' => round($mediaAjustada, 2),

            'dias_restantes' => round($diasRestantes, 2),
            'venda_prevista' => round($vendaPrevista, 2),

            'estoque_atual' => round($estoqueAtual, 2),
            'cobertura_atual_dias' => round($coberturaAtualDias, 2),

            'estoque_seguranca_dias' => round($estoqueSegurancaDias, 2),
            'estoque_seguranca_unidades' => round($estoqueSegurancaUnidades, 2),

            'compra_minima' => $compraMinima,
            'compra_recomendada' => $compraRecomendada,

            'custo_unitario' => round($custoUnitario, 2),
            'custo_compra_minima' => round($custoCompraMinima, 2),
            'custo_compra_recomendada' => round($custoCompraRecomendada, 2),

            'regra_final_semana_aplicada' => $regraFinalSemanaAplicada,
            'ajustes_aplicados' => $ajustesAplicados,
        ];
    }
}