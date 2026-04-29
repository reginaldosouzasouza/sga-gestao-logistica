<?php

namespace App\Helpers;

use App\Models\Caixa;
use App\Models\CaixaBanco;
use App\Models\CaixaAberto;
use Illuminate\Support\Facades\DB;

class FinanceiroHelper
{
    public static function saldoCaixaAtual()
    {
        $caixaAberto = CaixaAberto::where('status', 'aberto')->first();

        if (!$caixaAberto) {
            return 0;
        }

        $data = $caixaAberto->data_caixa;

        $saldoInicialCaixa = $caixaAberto->saldo_inicial_caixa ?? 0;
        $saldoInicialBanco = $caixaAberto->saldo_inicial_banco ?? 0;

        $entradasCaixa = Caixa::whereDate('data_movimentacao', $data)
            ->where('tipo','entrada')
            ->sum('valor');

        $saidasCaixa = Caixa::whereDate('data_movimentacao', $data)
            ->where('tipo','saida')
            ->sum('valor');

        $entradasBanco = CaixaBanco::whereDate('data_movimentacao', $data)
            ->where('tipo','entrada')
            ->sum('valor');

        $saidasBanco = CaixaBanco::whereDate('data_movimentacao', $data)
            ->where('tipo','saida')
            ->sum('valor');

        $saldoCaixa = $saldoInicialCaixa + $entradasCaixa - $saidasCaixa;
        $saldoBanco = $saldoInicialBanco + $entradasBanco - $saidasBanco;

        return $saldoCaixa + $saldoBanco;
    }
}