<?php

namespace App\Helpers;

use App\Models\Caixa;
use App\Models\CaixaBanco;
use App\Models\CaixaAberto;

class FinanceiroHelper
{
    private static function empresaId()
    {
       $empresaId = empresaAtualId();
    }

    public static function saldoCaixaAtual()
    {
        $empresaId = self::empresaId();

        if (!$empresaId) {
            return 0;
        }

        $caixaAberto = CaixaAberto::where('empresa_id', $empresaId)
            ->where('status', 'aberto')
            ->first();

        if (!$caixaAberto) {
            return 0;
        }

        $data = $caixaAberto->data_caixa;

        $saldoInicialCaixa = $caixaAberto->saldo_inicial_caixa ?? 0;
        $saldoInicialBanco = $caixaAberto->saldo_inicial_banco ?? 0;

        $entradasCaixa = Caixa::where('empresa_id', $empresaId)
            ->whereDate('data_movimentacao', $data)
            ->where('tipo', 'entrada')
            ->sum('valor');

        $saidasCaixa = Caixa::where('empresa_id', $empresaId)
            ->whereDate('data_movimentacao', $data)
            ->where('tipo', 'saida')
            ->sum('valor');

        $entradasBanco = CaixaBanco::where('empresa_id', $empresaId)
            ->whereDate('data_movimentacao', $data)
            ->where('tipo', 'entrada')
            ->sum('valor');

        $saidasBanco = CaixaBanco::where('empresa_id', $empresaId)
            ->whereDate('data_movimentacao', $data)
            ->where('tipo', 'saida')
            ->sum('valor');

        $saldoCaixa = $saldoInicialCaixa + $entradasCaixa - $saidasCaixa;
        $saldoBanco = $saldoInicialBanco + $entradasBanco - $saidasBanco;

        return $saldoCaixa + $saldoBanco;
    }
}