<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardFinanceiroService
{
    private function empresaId()
    {
        return auth()->user()->empresa_id;
    }

    public function getDashboardData(?string $dataInicio = null, ?string $dataFim = null): array
    {
        $hoje = Carbon::today();
        $ontem = $hoje->copy()->subDay();

        $inicioPeriodo = $dataInicio
            ? Carbon::parse($dataInicio)->startOfDay()
            : $hoje->copy()->startOfMonth();

        $fimPeriodo = $dataFim
            ? Carbon::parse($dataFim)->startOfDay()
            : $hoje->copy()->endOfMonth()->startOfDay();

        if ($inicioPeriodo->greaterThan($fimPeriodo)) {
            [$inicioPeriodo, $fimPeriodo] = [$fimPeriodo, $inicioPeriodo];
        }

        $inicioMes = $inicioPeriodo->toDateString();
        $fimMes = $fimPeriodo->toDateString();
        $ontemString = $ontem->toDateString();

        $vendidoOntem = $this->getVendidoOntem($ontemString);
        $acumuladoMes = $this->getAcumuladoMes($inicioMes, $fimMes);

        $fimRecebido = $fimPeriodo->lessThan($ontem)
            ? $fimPeriodo->toDateString()
            : $ontemString;

        $recebidoAteOntem = $this->getRecebidoMes($inicioMes, $fimRecebido);
        $contasReceberPendentesMes = $this->getContasReceberPendentesMes($inicioMes, $fimMes);

        $comparativoSemanal = $this->getComparativoSemanal();
        $vendasDiarias = $this->getVendasDiariasMes($inicioMes, $fimMes);

        $comprasPagasMes = $this->getComprasPagasMes($inicioMes, $fimMes);
        $pagoDinheiroMes = $this->getPagoDinheiroMes($inicioMes, $fimMes);
        $pagoPixMes = $this->getPagoPixMes($inicioMes, $fimMes);
        $contasPagarAberto = $this->getContasPagarAbertoMes($inicioMes, $fimMes);

        $projecaoDespesasMes = $comprasPagasMes + $contasPagarAberto;

        $inicioPeriodo = $inicioPeriodo->copy()->startOfDay();
        $fimPeriodo = $fimPeriodo->copy()->startOfDay();
        $ontem = $ontem->copy()->startOfDay();
        $hoje = $hoje->copy()->startOfDay();

        $diasNoPeriodo = (int) max(floor($inicioPeriodo->diffInDays($fimPeriodo)) + 1, 1);

        $fimDiasCompletos = $fimPeriodo->lessThan($ontem)
            ? $fimPeriodo->copy()
            : $ontem->copy();

        $diasCompletos = $fimDiasCompletos->greaterThanOrEqualTo($inicioPeriodo)
            ? (int) floor($inicioPeriodo->diffInDays($fimDiasCompletos)) + 1
            : 0;

        $diasCompletos = min($diasCompletos, $diasNoPeriodo);

        $diasRestantes = (int) max($diasNoPeriodo - $diasCompletos, 0);

        $mediaDiariaRecebimento = $diasCompletos > 0
            ? round($recebidoAteOntem / $diasCompletos, 2)
            : 0;

        $projecaoRecebimentoMes = round($mediaDiariaRecebimento * $diasNoPeriodo, 2);

        $projecaoReposicao = $this->getProjecaoReposicaoProdutos(
            $inicioMes,
            $fimRecebido,
            $diasCompletos,
            $diasRestantes
        );

        $saldoReposicaoAComprar = $this->getSaldoReposicaoAComprar($projecaoReposicao);

        $analiseMesAnterior = $this->getAnaliseMesAnterior(
            $inicioPeriodo,
            $diasNoPeriodo,
            $contasPagarAberto,
            (float) ($saldoReposicaoAComprar['total']['custo_estimado'] ?? 0)
        );

        $custoEstimadoReposicao = (float) ($saldoReposicaoAComprar['total']['custo_estimado'] ?? 0);
        $despesasTotaisComReposicao = round($projecaoDespesasMes + $custoEstimadoReposicao, 2);

        $resultadoProjetadoMes = round($projecaoRecebimentoMes - $projecaoDespesasMes, 2);
        $resultadoProjetadoComReposicao = round($projecaoRecebimentoMes - $despesasTotaisComReposicao, 2);

        $faltaReceberParaCobrirMes = max($despesasTotaisComReposicao - $recebidoAteOntem, 0);

        $metaDiariaCobrirAberto = $diasRestantes > 0
            ? round($contasPagarAberto / $diasRestantes, 2)
            : 0;

        $metaDiariaFecharMes = $diasRestantes > 0
            ? round($faltaReceberParaCobrirMes / $diasRestantes, 2)
            : 0;

        $totalCustosFuturos = round($contasPagarAberto + $custoEstimadoReposicao, 2);

        $custoMedioDiarioFuturo = $diasRestantes > 0
            ? round($totalCustosFuturos / $diasRestantes, 2)
            : 0;

        $sobraMediaDiariaProjetada = round($mediaDiariaRecebimento - $custoMedioDiarioFuturo, 2);
        $previsaoRealFechamento = round($sobraMediaDiariaProjetada * $diasRestantes, 2);

        $saldoPotencialMes = $contasReceberPendentesMes - $contasPagarAberto;

        $statusMeta = $resultadoProjetadoComReposicao >= 0
            ? 'VAI ATINGIR'
            : 'RISCO DE NAO ATINGIR';

        return [
            'periodo' => [
                'hoje' => $hoje->toDateString(),
                'ontem' => $ontemString,
                'inicio_mes' => $inicioMes,
                'fim_mes' => $fimMes,
                'fim_recebido' => $fimRecebido,
                'dia_atual' => (int) $hoje->day,
                'dia_base_calculo' => (int) $ontem->day,
                'dias_no_mes' => (int) $diasNoPeriodo,
                'dias_restantes' => (int) $diasRestantes,
                'dias_completos' => (int) $diasCompletos,
            ],
            'cards' => [
                'vendido_ontem' => $vendidoOntem,
                'acumulado_mes' => $acumuladoMes,
                'recebido_ate_ontem' => $recebidoAteOntem,
                'contas_receber_pendentes_mes' => $contasReceberPendentesMes,

                'compras_pagas_mes' => $comprasPagasMes,
                'pago_dinheiro_mes' => $pagoDinheiroMes,
                'pago_pix_mes' => $pagoPixMes,
                'contas_pagar_aberto' => $contasPagarAberto,

                'projecao_despesas_mes' => $projecaoDespesasMes,
                'projecao_recebimento_mes' => $projecaoRecebimentoMes,
                'resultado_projetado_mes' => $resultadoProjetadoMes,

                'projecao_reposicao' => $projecaoReposicao,
                'saldo_reposicao_a_comprar' => $saldoReposicaoAComprar,
                'analise_mes_anterior' => $analiseMesAnterior,
                'custo_estimado_reposicao' => $custoEstimadoReposicao,
                'despesas_totais_com_reposicao' => $despesasTotaisComReposicao,
                'resultado_projetado_com_reposicao' => $resultadoProjetadoComReposicao,

                'falta_receber_para_cobrir_mes' => $faltaReceberParaCobrirMes,
                'media_diaria_recebimento' => $mediaDiariaRecebimento,
                'meta_diaria_cobrir_aberto' => $metaDiariaCobrirAberto,
                'meta_diaria_fechar_mes' => $metaDiariaFecharMes,

                'total_custos_futuros' => $totalCustosFuturos,
                'custo_medio_diario_futuro' => $custoMedioDiarioFuturo,
                'sobra_media_diaria_projetada' => $sobraMediaDiariaProjetada,
                'previsao_real_fechamento' => $previsaoRealFechamento,

                'saldo_potencial_mes' => $saldoPotencialMes,
                'status_meta' => $statusMeta,
            ],
            'comparativo_semanal' => $comparativoSemanal,
            'graficos' => [
                'vendas_diarias' => $vendasDiarias,
            ],
        ];
    }

    private function getVendidoOntem(string $data): array
    {
        $empresaId = $this->empresaId();

        $row = DB::table('movimentacao as m')
            ->join('movimentacao_itens as mi', 'mi.movimentacao_id', '=', 'm.id')
            ->join('produtos as p', 'p.id', '=', 'mi.produto_id')
            ->where('m.empresa_id', $empresaId)
            ->where('mi.empresa_id', $empresaId)
            ->where('p.empresa_id', $empresaId)
            ->whereDate('m.data_coleta', $data)
            ->selectRaw("
                COALESCE(SUM(CASE WHEN (UPPER(p.nome) LIKE '%GAS%' OR UPPER(p.nome) LIKE '%GÁS%') THEN mi.valor_total ELSE 0 END), 0) as gas,
                COALESCE(SUM(CASE WHEN (UPPER(p.nome) LIKE '%AGUA%' OR UPPER(p.nome) LIKE '%ÁGUA%') THEN mi.valor_total ELSE 0 END), 0) as agua,
                COALESCE(SUM(mi.valor_total), 0) as total
            ")
            ->first();

        return [
            'gas' => (float) ($row->gas ?? 0),
            'agua' => (float) ($row->agua ?? 0),
            'total' => (float) ($row->total ?? 0),
        ];
    }

    private function getAcumuladoMes(string $inicioMes, string $fimMes): array
    {
        $empresaId = $this->empresaId();

        $row = DB::table('movimentacao as m')
            ->join('movimentacao_itens as mi', 'mi.movimentacao_id', '=', 'm.id')
            ->join('produtos as p', 'p.id', '=', 'mi.produto_id')
            ->where('m.empresa_id', $empresaId)
            ->where('mi.empresa_id', $empresaId)
            ->where('p.empresa_id', $empresaId)
            ->whereBetween('m.data_coleta', [$inicioMes, $fimMes])
            ->selectRaw("
                COALESCE(SUM(CASE WHEN (UPPER(p.nome) LIKE '%GAS%' OR UPPER(p.nome) LIKE '%GÁS%') THEN mi.valor_total ELSE 0 END), 0) as gas,
                COALESCE(SUM(CASE WHEN (UPPER(p.nome) LIKE '%AGUA%' OR UPPER(p.nome) LIKE '%ÁGUA%') THEN mi.valor_total ELSE 0 END), 0) as agua,
                COALESCE(SUM(mi.valor_total), 0) as total
            ")
            ->first();

        return [
            'gas' => (float) ($row->gas ?? 0),
            'agua' => (float) ($row->agua ?? 0),
            'total' => (float) ($row->total ?? 0),
        ];
    }

    private function getRecebidoMes(string $inicioMes, string $fimMes): float
    {
        $empresaId = $this->empresaId();

        if ($inicioMes > $fimMes) {
            return 0;
        }

        $caixa = (float) DB::table('caixa')
            ->where('empresa_id', $empresaId)
            ->where('tipo', 'entrada')
            ->whereBetween('data_movimentacao', [$inicioMes, $fimMes])
            ->sum('valor');

        $caixaBanco = (float) DB::table('caixa_banco')
            ->where('empresa_id', $empresaId)
            ->where('tipo', 'entrada')
            ->whereBetween('data_movimentacao', [$inicioMes, $fimMes])
            ->sum('valor');

        return $caixa + $caixaBanco;
    }

    private function getContasReceberPendentesMes(string $inicioMes, string $fimMes): float
    {
        $empresaId = $this->empresaId();

        return (float) DB::table('contas_a_receber')
            ->where('empresa_id', $empresaId)
            ->whereIn('status', ['pendente', 'atrasado'])
            ->whereBetween('data_vencimento', [$inicioMes, $fimMes])
            ->sum('valor');
    }

    private function getComparativoSemanal(): array
    {
        $empresaId = $this->empresaId();

        $hoje = Carbon::today();
        $ontem = $hoje->copy()->subDay();

        $inicioSemanaAtual = $hoje->copy()->startOfWeek(Carbon::SUNDAY);
        $fimComparacaoAtual = $ontem->copy();

        $diasComparacao = 0;

        if ($fimComparacaoAtual->greaterThanOrEqualTo($inicioSemanaAtual)) {
            $diasComparacao = $inicioSemanaAtual->diffInDays($fimComparacaoAtual) + 1;
        }

        $inicioSemanaAnterior = $inicioSemanaAtual->copy()->subWeek();

        $fimSemanaAnteriorComparada = $diasComparacao > 0
            ? $inicioSemanaAnterior->copy()->addDays($diasComparacao - 1)
            : $inicioSemanaAnterior->copy()->subDay();

        $semanaAtual = $diasComparacao > 0
            ? (float) DB::table('movimentacao as m')
                ->join('movimentacao_itens as mi', 'mi.movimentacao_id', '=', 'm.id')
                ->where('m.empresa_id', $empresaId)
                ->where('mi.empresa_id', $empresaId)
                ->whereBetween('m.data_coleta', [
                    $inicioSemanaAtual->toDateString(),
                    $fimComparacaoAtual->toDateString(),
                ])
                ->sum('mi.valor_total')
            : 0;

        $semanaAnterior = $diasComparacao > 0
            ? (float) DB::table('movimentacao as m')
                ->join('movimentacao_itens as mi', 'mi.movimentacao_id', '=', 'm.id')
                ->where('m.empresa_id', $empresaId)
                ->where('mi.empresa_id', $empresaId)
                ->whereBetween('m.data_coleta', [
                    $inicioSemanaAnterior->toDateString(),
                    $fimSemanaAnteriorComparada->toDateString(),
                ])
                ->sum('mi.valor_total')
            : 0;

        $variacao = $semanaAnterior > 0
            ? round((($semanaAtual - $semanaAnterior) / $semanaAnterior) * 100, 2)
            : 0;

        return [
            'semana_atual' => $semanaAtual,
            'semana_anterior' => $semanaAnterior,
            'variacao_percentual' => $variacao,
            'dias_comparados' => $diasComparacao,
        ];
    }

    private function getVendasDiariasMes(string $inicioMes, string $fimMes): array
    {
        $empresaId = $this->empresaId();

        return DB::table('movimentacao as m')
            ->join('movimentacao_itens as mi', 'mi.movimentacao_id', '=', 'm.id')
            ->where('m.empresa_id', $empresaId)
            ->where('mi.empresa_id', $empresaId)
            ->whereBetween('m.data_coleta', [$inicioMes, $fimMes])
            ->groupBy('m.data_coleta')
            ->orderBy('m.data_coleta')
            ->selectRaw('m.data_coleta as data, COALESCE(SUM(mi.valor_total), 0) as total')
            ->get()
            ->map(fn ($item) => [
                'data' => $item->data,
                'total' => (float) $item->total,
            ])
            ->toArray();
    }

    private function getComprasPagasMes(string $inicioMes, string $fimMes): float
    {
        $caixa = $this->getPagoDinheiroMes($inicioMes, $fimMes);
        $caixaBanco = $this->getPagoPixMes($inicioMes, $fimMes);

        return $caixa + $caixaBanco;
    }

    private function getPagoDinheiroMes(string $inicioMes, string $fimMes): float
    {
        $empresaId = $this->empresaId();

        return (float) DB::table('caixa')
            ->where('empresa_id', $empresaId)
            ->where('tipo', 'saida')
            ->whereBetween('data_movimentacao', [$inicioMes, $fimMes])
            ->whereRaw("UPPER(TRIM(origem)) = 'COMPRA'")
            ->sum('valor');
    }

    private function getPagoPixMes(string $inicioMes, string $fimMes): float
    {
        $empresaId = $this->empresaId();

        return (float) DB::table('caixa_banco')
            ->where('empresa_id', $empresaId)
            ->where('tipo', 'saida')
            ->whereBetween('data_movimentacao', [$inicioMes, $fimMes])
            ->whereRaw("UPPER(TRIM(origem)) = 'COMPRA'")
            ->sum('valor');
    }

    private function getContasPagarAbertoMes(string $inicioMes, string $fimMes): float
    {
        $empresaId = $this->empresaId();

        return (float) DB::table('contas_a_pagar')
            ->where('empresa_id', $empresaId)
            ->whereIn('status', ['pendente', 'atrasado'])
            ->whereBetween('data_vencimento', [$inicioMes, $fimMes])
            ->sum('valor');
    }

    private function getProjecaoReposicaoProdutos(
        string $inicioMes,
        string $fimBase,
        int $diasCompletos,
        int $diasRestantes
    ): array {
        $empresaId = $this->empresaId();

        $resultadoPadrao = [
            'gas' => [
                'quantidade_emitida' => 0,
                'media_diaria_quantidade' => 0,
                'quantidade_prevista_restante' => 0,
                'preco_compra_medio' => 0,
                'custo_estimado' => 0,
            ],
            'agua' => [
                'quantidade_emitida' => 0,
                'media_diaria_quantidade' => 0,
                'quantidade_prevista_restante' => 0,
                'preco_compra_medio' => 0,
                'custo_estimado' => 0,
            ],
            'total' => [
                'quantidade_emitida' => 0,
                'quantidade_prevista_restante' => 0,
                'custo_estimado' => 0,
            ],
        ];

        if ($diasCompletos <= 0 || $diasRestantes <= 0 || $inicioMes > $fimBase) {
            return $resultadoPadrao;
        }

        $row = DB::table('movimentacao as m')
            ->join('movimentacao_itens as mi', 'mi.movimentacao_id', '=', 'm.id')
            ->join('produtos as p', 'p.id', '=', 'mi.produto_id')
            ->where('m.empresa_id', $empresaId)
            ->where('mi.empresa_id', $empresaId)
            ->where('p.empresa_id', $empresaId)
            ->whereBetween('m.data_coleta', [$inicioMes, $fimBase])
            ->selectRaw("
                COALESCE(SUM(CASE WHEN (UPPER(p.nome) LIKE '%GAS%' OR UPPER(p.nome) LIKE '%GÁS%') THEN mi.quantidade ELSE 0 END), 0) as qtd_gas,
                COALESCE(SUM(CASE WHEN (UPPER(p.nome) LIKE '%AGUA%' OR UPPER(p.nome) LIKE '%ÁGUA%') THEN mi.quantidade ELSE 0 END), 0) as qtd_agua,
                COALESCE(SUM(CASE WHEN (UPPER(p.nome) LIKE '%GAS%' OR UPPER(p.nome) LIKE '%GÁS%') THEN mi.quantidade * COALESCE(p.preco_compra, 0) ELSE 0 END), 0) as custo_base_gas,
                COALESCE(SUM(CASE WHEN (UPPER(p.nome) LIKE '%AGUA%' OR UPPER(p.nome) LIKE '%ÁGUA%') THEN mi.quantidade * COALESCE(p.preco_compra, 0) ELSE 0 END), 0) as custo_base_agua
            ")
            ->first();

        $quantidadeGas = (float) ($row->qtd_gas ?? 0);
        $quantidadeAgua = (float) ($row->qtd_agua ?? 0);

        $custoBaseGas = (float) ($row->custo_base_gas ?? 0);
        $custoBaseAgua = (float) ($row->custo_base_agua ?? 0);

        $precoMedioGas = $quantidadeGas > 0
            ? round($custoBaseGas / $quantidadeGas, 2)
            : $this->getPrecoCompraMedioProduto('gas');

        $precoMedioAgua = $quantidadeAgua > 0
            ? round($custoBaseAgua / $quantidadeAgua, 2)
            : $this->getPrecoCompraMedioProduto('agua');

        $mediaDiariaGas = $diasCompletos > 0 ? round($quantidadeGas / $diasCompletos, 4) : 0;
        $mediaDiariaAgua = $diasCompletos > 0 ? round($quantidadeAgua / $diasCompletos, 4) : 0;

        $quantidadePrevistaGas = round($mediaDiariaGas * $diasRestantes, 2);
        $quantidadePrevistaAgua = round($mediaDiariaAgua * $diasRestantes, 2);

        $custoEstimadoGas = round($quantidadePrevistaGas * $precoMedioGas, 2);
        $custoEstimadoAgua = round($quantidadePrevistaAgua * $precoMedioAgua, 2);

        return [
            'gas' => [
                'quantidade_emitida' => round($quantidadeGas, 2),
                'media_diaria_quantidade' => $mediaDiariaGas,
                'quantidade_prevista_restante' => $quantidadePrevistaGas,
                'preco_compra_medio' => $precoMedioGas,
                'custo_estimado' => $custoEstimadoGas,
            ],
            'agua' => [
                'quantidade_emitida' => round($quantidadeAgua, 2),
                'media_diaria_quantidade' => $mediaDiariaAgua,
                'quantidade_prevista_restante' => $quantidadePrevistaAgua,
                'preco_compra_medio' => $precoMedioAgua,
                'custo_estimado' => $custoEstimadoAgua,
            ],
            'total' => [
                'quantidade_emitida' => round($quantidadeGas + $quantidadeAgua, 2),
                'quantidade_prevista_restante' => round($quantidadePrevistaGas + $quantidadePrevistaAgua, 2),
                'custo_estimado' => round($custoEstimadoGas + $custoEstimadoAgua, 2),
            ],
        ];
    }

    private function getAnaliseMesAnterior(
        Carbon $inicioPeriodoAtual,
        int $diasPeriodoAtual,
        float $contasPagarAbertoAtual,
        float $saldoReposicaoAComprarAtual
    ): array {
        $inicioMesAnterior = $inicioPeriodoAtual->copy()->subMonthNoOverflow()->startOfMonth()->startOfDay();
        $fimMesAnterior = $inicioPeriodoAtual->copy()->subMonthNoOverflow()->endOfMonth()->startOfDay();

        $inicioAnterior = $inicioMesAnterior->toDateString();
        $fimAnterior = $fimMesAnterior->toDateString();

        $diasMesAnterior = (int) max(floor($inicioMesAnterior->diffInDays($fimMesAnterior)) + 1, 1);

        $entradasDinheiro = $this->getEntradasPorTabelaMes('caixa', $inicioAnterior, $fimAnterior);
        $entradasPixBanco = $this->getEntradasPorTabelaMes('caixa_banco', $inicioAnterior, $fimAnterior);
        $entradasTotal = round($entradasDinheiro + $entradasPixBanco, 2);

        $saidasDinheiro = $this->getSaidasPorTabelaMes('caixa', $inicioAnterior, $fimAnterior);
        $saidasPixBanco = $this->getSaidasPorTabelaMes('caixa_banco', $inicioAnterior, $fimAnterior);
        $saidasTotal = round($saidasDinheiro + $saidasPixBanco, 2);

        $saldoCaixa = round($entradasTotal - $saidasTotal, 2);

        $contasAbertasMesAnterior = $this->getContasPagarAbertoMes($inicioAnterior, $fimAnterior);
        $custoProdutosEmitidos = $this->getCustoProdutosEmitidosMes($inicioAnterior, $fimAnterior);

        $resultadoAposContas = round($saldoCaixa - $contasAbertasMesAnterior, 2);
        $resultadoGerencial = round($saldoCaixa - $contasAbertasMesAnterior - $custoProdutosEmitidos['total'], 2);

        $mediaDiariaEntradas = $diasMesAnterior > 0 ? round($entradasTotal / $diasMesAnterior, 2) : 0;
        $mediaDiariaSaidas = $diasMesAnterior > 0 ? round($saidasTotal / $diasMesAnterior, 2) : 0;

        $projecaoEntradasBaseAnterior = round($mediaDiariaEntradas * $diasPeriodoAtual, 2);
        $projecaoSaidasBaseAnterior = round($mediaDiariaSaidas * $diasPeriodoAtual, 2);

        $saldoCaixaProjetadoBaseAnterior = round(
            $projecaoEntradasBaseAnterior - $projecaoSaidasBaseAnterior,
            2
        );

        $resultadoGerencialProjetadoBaseAnterior = round(
            $saldoCaixaProjetadoBaseAnterior - $contasPagarAbertoAtual - $saldoReposicaoAComprarAtual,
            2
        );

        return [
            'periodo' => [
                'inicio' => $inicioAnterior,
                'fim' => $fimAnterior,
                'dias' => $diasMesAnterior,
            ],
            'real' => [
                'entradas_dinheiro' => round($entradasDinheiro, 2),
                'entradas_pix_banco' => round($entradasPixBanco, 2),
                'entradas_total' => $entradasTotal,
                'saidas_dinheiro' => round($saidasDinheiro, 2),
                'saidas_pix_banco' => round($saidasPixBanco, 2),
                'saidas_total' => $saidasTotal,
                'saldo_caixa' => $saldoCaixa,
                'contas_abertas' => round($contasAbertasMesAnterior, 2),
                'custo_produtos_emitidos' => $custoProdutosEmitidos,
                'resultado_apos_contas' => $resultadoAposContas,
                'resultado_gerencial' => $resultadoGerencial,
            ],
            'previsao_base_mes_anterior' => [
                'media_diaria_entradas' => $mediaDiariaEntradas,
                'media_diaria_saidas' => $mediaDiariaSaidas,
                'entradas_projetadas' => $projecaoEntradasBaseAnterior,
                'saidas_projetadas' => $projecaoSaidasBaseAnterior,
                'saldo_caixa_projetado' => $saldoCaixaProjetadoBaseAnterior,
                'contas_pagar_aberto_atual' => round($contasPagarAbertoAtual, 2),
                'saldo_reposicao_a_comprar_atual' => round($saldoReposicaoAComprarAtual, 2),
                'resultado_gerencial_projetado' => $resultadoGerencialProjetadoBaseAnterior,
            ],
        ];
    }

    private function getEntradasPorTabelaMes(string $tabela, string $inicioMes, string $fimMes): float
    {
        $empresaId = $this->empresaId();

        return (float) DB::table($tabela)
            ->where('empresa_id', $empresaId)
            ->where('tipo', 'entrada')
            ->whereBetween('data_movimentacao', [$inicioMes, $fimMes])
            ->where(function ($query) {
                $query->whereNull('origem')
                    ->orWhereRaw("UPPER(TRIM(origem)) <> 'ESTORNO'");
            })
            ->sum('valor');
    }

    private function getSaidasPorTabelaMes(string $tabela, string $inicioMes, string $fimMes): float
    {
        $empresaId = $this->empresaId();

        return (float) DB::table($tabela)
            ->where('empresa_id', $empresaId)
            ->where('tipo', 'saida')
            ->whereBetween('data_movimentacao', [$inicioMes, $fimMes])
            ->where(function ($query) {
                $query->whereNull('origem')
                    ->orWhereRaw("UPPER(TRIM(origem)) <> 'ESTORNO'");
            })
            ->sum('valor');
    }

    private function getCustoProdutosEmitidosMes(string $inicioMes, string $fimMes): array
    {
        $empresaId = $this->empresaId();

        $row = DB::table('movimentacao as m')
            ->join('movimentacao_itens as mi', 'mi.movimentacao_id', '=', 'm.id')
            ->join('produtos as p', 'p.id', '=', 'mi.produto_id')
            ->where('m.empresa_id', $empresaId)
            ->where('mi.empresa_id', $empresaId)
            ->where('p.empresa_id', $empresaId)
            ->whereBetween('m.data_coleta', [$inicioMes, $fimMes])
            ->selectRaw("
                COALESCE(SUM(CASE WHEN (UPPER(p.nome) LIKE '%GAS%' OR UPPER(p.nome) LIKE '%GÁS%') THEN mi.quantidade * COALESCE(p.preco_compra, 0) ELSE 0 END), 0) as gas,
                COALESCE(SUM(CASE WHEN (UPPER(p.nome) LIKE '%AGUA%' OR UPPER(p.nome) LIKE '%ÁGUA%') THEN mi.quantidade * COALESCE(p.preco_compra, 0) ELSE 0 END), 0) as agua,
                COALESCE(SUM(mi.quantidade * COALESCE(p.preco_compra, 0)), 0) as total
            ")
            ->first();

        return [
            'gas' => round((float) ($row->gas ?? 0), 2),
            'agua' => round((float) ($row->agua ?? 0), 2),
            'total' => round((float) ($row->total ?? 0), 2),
        ];
    }

    private function getSaldoReposicaoAComprar(array $projecaoReposicao): array
    {
        $estoqueGas = $this->getEstoqueAtualProduto('gas');
        $estoqueAgua = $this->getEstoqueAtualProduto('agua');

        $necessidadeGas = ceil((float) ($projecaoReposicao['gas']['quantidade_prevista_restante'] ?? 0));
        $necessidadeAgua = ceil((float) ($projecaoReposicao['agua']['quantidade_prevista_restante'] ?? 0));

        $precoMedioGas = (float) ($projecaoReposicao['gas']['preco_compra_medio'] ?? 0);
        $precoMedioAgua = (float) ($projecaoReposicao['agua']['preco_compra_medio'] ?? 0);

        $saldoComprarGas = max($necessidadeGas - $estoqueGas, 0);
        $saldoComprarAgua = max($necessidadeAgua - $estoqueAgua, 0);

        $custoComprarGas = round($saldoComprarGas * $precoMedioGas, 2);
        $custoComprarAgua = round($saldoComprarAgua * $precoMedioAgua, 2);

        return [
            'gas' => [
                'necessidade_prevista' => (int) $necessidadeGas,
                'estoque_atual' => (int) $estoqueGas,
                'quantidade_a_comprar' => (int) $saldoComprarGas,
                'preco_compra_medio' => $precoMedioGas,
                'custo_estimado' => $custoComprarGas,
            ],
            'agua' => [
                'necessidade_prevista' => (int) $necessidadeAgua,
                'estoque_atual' => (int) $estoqueAgua,
                'quantidade_a_comprar' => (int) $saldoComprarAgua,
                'preco_compra_medio' => $precoMedioAgua,
                'custo_estimado' => $custoComprarAgua,
            ],
            'total' => [
                'quantidade_a_comprar' => (int) ($saldoComprarGas + $saldoComprarAgua),
                'custo_estimado' => round($custoComprarGas + $custoComprarAgua, 2),
            ],
        ];
    }

    private function getEstoqueAtualProduto(string $tipo): int
    {
        $empresaId = $this->empresaId();

        $query = DB::table('produtos')
            ->where('empresa_id', $empresaId)
            ->whereNotNull('quantidade_estoque');

        if ($tipo === 'gas') {
            $query->where(function ($q) {
                $q->whereRaw("UPPER(nome) LIKE '%GAS%'")
                  ->orWhereRaw("UPPER(nome) LIKE '%GÁS%'");
            });
        }

        if ($tipo === 'agua') {
            $query->where(function ($q) {
                $q->whereRaw("UPPER(nome) LIKE '%AGUA%'")
                  ->orWhereRaw("UPPER(nome) LIKE '%ÁGUA%'");
            });
        }

        return (int) ceil((float) $query->sum('quantidade_estoque'));
    }

    private function getPrecoCompraMedioProduto(string $tipo): float
    {
        $empresaId = $this->empresaId();

        $query = DB::table('produtos')
            ->where('empresa_id', $empresaId)
            ->whereNotNull('preco_compra')
            ->where('preco_compra', '>', 0);

        if ($tipo === 'gas') {
            $query->where(function ($q) {
                $q->whereRaw("UPPER(nome) LIKE '%GAS%'")
                  ->orWhereRaw("UPPER(nome) LIKE '%GÁS%'");
            });
        }

        if ($tipo === 'agua') {
            $query->where(function ($q) {
                $q->whereRaw("UPPER(nome) LIKE '%AGUA%'")
                  ->orWhereRaw("UPPER(nome) LIKE '%ÁGUA%'");
            });
        }

        return round((float) $query->avg('preco_compra'), 2);
    }
}