<?php

namespace App\Http\Controllers;

use App\Models\ContasAReceber;
use App\Models\ContasAPagar;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request) 
    {
        // Captura as datas do formulário (se não forem passadas, usa o mês atual como padrão)
        $dataInicio = $request->input('data_inicio', date('Y-m-01')); // Primeiro dia do mês
        $dataFim = $request->input('data_fim', date('Y-m-t')); // Último dia do mês

        // Total de receitas previstas dentro do período selecionado
        $previsaoReceitas = ContasAReceber::whereBetween('data_venda', [$dataInicio, $dataFim])
            ->sum('valor');

        // Total de receitas dentro do período selecionado (Receitas a Receber pendentes e atrasadas)
        $totalEntrada = ContasAReceber::whereIn('status', ['pendente', 'atrasado'])
            ->whereBetween('data_venda', [$dataInicio, $dataFim])
            ->sum('valor');

        // Total de pagamentos recebidos dentro do período selecionado
        $totalRecebido = ContasAReceber::whereNotNull('data_recebimento')
            ->whereBetween('data_recebimento', [$dataInicio, $dataFim])
            ->sum('valor');

        // Total de saídas/despesas dentro do período selecionado
        $totalSaidas = ContasAPagar::whereBetween('data_vencimento', [$dataInicio, $dataFim])
            ->sum('valor');

        // Total de pagamentos efetuados dentro do período selecionado (Contas JÁ PAGAS)
        $totalPago = ContasAPagar::whereNotNull('data_pagamento')
            ->whereBetween('data_pagamento', [$dataInicio, $dataFim])
            ->sum('valor');

        // Previsão de despesas dentro do período selecionado
        $previsaoDespesas = $totalSaidas - $totalPago;

        // Saldo Atual = Total Recebido MENOS o Total Pago
        $saldoAtual = $totalRecebido - $totalPago;

        // Previsão de Saldo Mensal
        $previsaoSaldoMensal = $previsaoReceitas - $totalSaidas;

        // Dados para gráfico de evolução do saldo (Recebimentos e Pagamentos) por mês
        $evolucaoSaldo = ContasAReceber::selectRaw('MONTH(data_venda) as mes, SUM(valor) as total')
            ->whereBetween('data_venda', [$dataInicio, $dataFim])
            ->groupBy('mes')
            ->pluck('total', 'mes');

        return view('dashboard.painel', compact(
            'dataInicio', 'dataFim', // Enviar as datas para manter no formulário
            'previsaoReceitas',
            'totalEntrada',
            'totalRecebido',
            'totalSaidas',
            'totalPago',
            'previsaoDespesas',
            'saldoAtual',
            'previsaoSaldoMensal',
            'evolucaoSaldo'
        ));
    }

}
