<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardFinanceiroService
{
    public function getDashboardData(): array
    {
        $hoje = Carbon::today();
        $inicioMes = $hoje->copy()->startOfMonth()->toDateString();
        $fimMes = $hoje->copy()->endOfMonth()->toDateString();
        $ontem = $hoje->copy()->subDay()->toDateString();

        $vendidoOntem = $this->getVendidoOntem($ontem);
        $acumuladoMes = $this->getAcumuladoMes($inicioMes, $fimMes);

        // RECEBIDO FICA SOMENTE ATÉ ONTEM
        $recebidoAteOntem = $this->getRecebidoMes($inicioMes, $ontem);

        $contasReceberPendentesMes = $this->getContasReceberPendentesMes($inicioMes, $fimMes);

        $comparativoSemanal = $this->getComparativoSemanal();
        $vendasDiarias = $this->getVendasDiariasMes($inicioMes, $fimMes);

        $comprasPagasMes = $this->getComprasPagasMes($inicioMes, $fimMes);
        $pagoDinheiroMes = $this->getPagoDinheiroMes($inicioMes, $fimMes);
        $pagoPixMes = $this->getPagoPixMes($inicioMes, $fimMes);
        $contasPagarAberto = $this->getContasPagarAbertoMes($inicioMes, $fimMes);

        $projecaoDespesasMes = $comprasPagasMes + $contasPagarAberto;

        $diaAtual = (int) $hoje->day;
        $diaBaseCalculo = (int) Carbon::parse($ontem)->day;
        $diasNoMes = (int) $hoje->daysInMonth;

        // Dias completos = dias já encerrados no mês
        $diasCompletos = max($diaAtual - 1, 0);

        // Dias restantes = calculados com base em ontem,
        // pois hoje ainda não está fechado
        $diasRestantes = max($diasNoMes - $diaBaseCalculo, 0);

        $mediaDiariaRecebimento = $diasCompletos > 0
            ? round($recebidoAteOntem / $diasCompletos, 2)
            : 0;

        $projecaoRecebimentoMes = round($mediaDiariaRecebimento * $diasNoMes, 2);

        $faltaReceberParaCobrirMes = max($projecaoDespesasMes - $recebidoAteOntem, 0);

        $metaDiariaCobrirAberto = $diasRestantes > 0
            ? round($contasPagarAberto / $diasRestantes, 2)
            : 0;

        $metaDiariaFecharMes = $diasRestantes > 0
            ? round($faltaReceberParaCobrirMes / $diasRestantes, 2)
            : 0;

        $saldoPotencialMes = $contasReceberPendentesMes - $contasPagarAberto;

        $statusMeta = $projecaoRecebimentoMes >= $projecaoDespesasMes
            ? 'VAI ATINGIR'
            : 'RISCO DE NAO ATINGIR';

        return [
            'periodo' => [
                'hoje' => $hoje->toDateString(),
                'ontem' => $ontem,
                'inicio_mes' => $inicioMes,
                'fim_mes' => $fimMes,
                'dia_atual' => $diaAtual,
                'dia_base_calculo' => $diaBaseCalculo,
                'dias_no_mes' => $diasNoMes,
                'dias_restantes' => $diasRestantes,
                'dias_completos' => $diasCompletos,
            ],
            'cards' => [
                'vendido_ontem' => $vendidoOntem,
                'acumulado_mes' => $acumuladoMes,

                // AGORA SOMENTE ATÉ ONTEM
                'recebido_ate_ontem' => $recebidoAteOntem,

                'contas_receber_pendentes_mes' => $contasReceberPendentesMes,
                'compras_pagas_mes' => $comprasPagasMes,
                'pago_dinheiro_mes' => $pagoDinheiroMes,
                'pago_pix_mes' => $pagoPixMes,
                'contas_pagar_aberto' => $contasPagarAberto,

                'projecao_despesas_mes' => $projecaoDespesasMes,
                'projecao_recebimento_mes' => $projecaoRecebimentoMes,
                'falta_receber_para_cobrir_mes' => $faltaReceberParaCobrirMes,
                'media_diaria_recebimento' => $mediaDiariaRecebimento,
                'meta_diaria_cobrir_aberto' => $metaDiariaCobrirAberto,
                'meta_diaria_fechar_mes' => $metaDiariaFecharMes,
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
        $row = DB::table('movimentacao as m')
            ->join('movimentacao_itens as mi', 'mi.movimentacao_id', '=', 'm.id')
            ->join('produtos as p', 'p.id', '=', 'mi.produto_id')
            ->whereDate('m.data_coleta', $data)
            ->selectRaw("
                COALESCE(SUM(CASE WHEN UPPER(p.nome) LIKE '%GAS%' THEN mi.valor_total ELSE 0 END), 0) as gas,
                COALESCE(SUM(CASE WHEN UPPER(p.nome) LIKE '%AGUA%' THEN mi.valor_total ELSE 0 END), 0) as agua,
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
        $row = DB::table('movimentacao as m')
            ->join('movimentacao_itens as mi', 'mi.movimentacao_id', '=', 'm.id')
            ->join('produtos as p', 'p.id', '=', 'mi.produto_id')
            ->whereBetween('m.data_coleta', [$inicioMes, $fimMes])
            ->selectRaw("
                COALESCE(SUM(CASE WHEN UPPER(p.nome) LIKE '%GAS%' THEN mi.valor_total ELSE 0 END), 0) as gas,
                COALESCE(SUM(CASE WHEN UPPER(p.nome) LIKE '%AGUA%' THEN mi.valor_total ELSE 0 END), 0) as agua,
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
        if ($inicioMes > $fimMes) {
            return 0;
        }

        $caixa = (float) DB::table('caixa')
            ->where('tipo', 'entrada')
            ->whereBetween('data_movimentacao', [$inicioMes, $fimMes])
            ->sum('valor');

        $caixaBanco = (float) DB::table('caixa_banco')
            ->where('tipo', 'entrada')
            ->whereBetween('data_movimentacao', [$inicioMes, $fimMes])
            ->sum('valor');

        return $caixa + $caixaBanco;
    }

    private function getContasReceberPendentesMes(string $inicioMes, string $fimMes): float
    {
        return (float) DB::table('contas_a_receber')
            ->where('status', 'pendente')
            ->whereBetween('data_vencimento', [$inicioMes, $fimMes])
            ->sum('valor');
    }

    private function getComparativoSemanal(): array
    {
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
                ->whereBetween('m.data_coleta', [
                    $inicioSemanaAtual->toDateString(),
                    $fimComparacaoAtual->toDateString(),
                ])
                ->sum('mi.valor_total')
            : 0;

        $semanaAnterior = $diasComparacao > 0
            ? (float) DB::table('movimentacao as m')
                ->join('movimentacao_itens as mi', 'mi.movimentacao_id', '=', 'm.id')
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
        return DB::table('movimentacao as m')
            ->join('movimentacao_itens as mi', 'mi.movimentacao_id', '=', 'm.id')
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
        $caixa = (float) DB::table('caixa')
            ->where('tipo', 'saida')
            ->whereBetween('data_movimentacao', [$inicioMes, $fimMes])
            ->whereRaw("UPPER(TRIM(origem)) = 'COMPRA'")
            ->sum('valor');

        $caixaBanco = (float) DB::table('caixa_banco')
            ->where('tipo', 'saida')
            ->whereBetween('data_movimentacao', [$inicioMes, $fimMes])
            ->whereRaw("UPPER(TRIM(origem)) = 'COMPRA'")
            ->sum('valor');

        return $caixa + $caixaBanco;
    }

    private function getPagoDinheiroMes(string $inicioMes, string $fimMes): float
    {
        return (float) DB::table('caixa')
            ->where('tipo', 'saida')
            ->whereBetween('data_movimentacao', [$inicioMes, $fimMes])
            ->whereRaw("UPPER(TRIM(origem)) = 'COMPRA'")
            ->sum('valor');
    }

    private function getPagoPixMes(string $inicioMes, string $fimMes): float
    {
        return (float) DB::table('caixa_banco')
            ->where('tipo', 'saida')
            ->whereBetween('data_movimentacao', [$inicioMes, $fimMes])
            ->whereRaw("UPPER(TRIM(origem)) = 'COMPRA'")
            ->sum('valor');
    }

    private function getContasPagarAbertoMes(string $inicioMes, string $fimMes): float
    {
        return (float) DB::table('contas_a_pagar')
            ->where('status', 'pendente')
            ->whereBetween('data_vencimento', [$inicioMes, $fimMes])
            ->sum('valor');
    }
}