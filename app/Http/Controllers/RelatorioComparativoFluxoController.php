<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatorioComparativoFluxoController extends Controller
{
    public function index(Request $request)
    {
        $usuario = auth()->user();
        $empresaId = $usuario->empresa_id ?? null;

        $mesBase = (int) $request->input('mes_base', now()->subMonth()->month);
        $anoBase = (int) $request->input('ano_base', now()->subMonth()->year);

        $mesComparacao = (int) $request->input('mes_comparacao', now()->month);
        $anoComparacao = (int) $request->input('ano_comparacao', now()->year);

        $inicioBase = Carbon::create($anoBase, $mesBase, 1)->startOfMonth()->toDateString();
        $fimBase = Carbon::create($anoBase, $mesBase, 1)->endOfMonth()->toDateString();

        $inicioComparacao = Carbon::create($anoComparacao, $mesComparacao, 1)->startOfMonth()->toDateString();
        $fimComparacao = Carbon::create($anoComparacao, $mesComparacao, 1)->endOfMonth()->toDateString();

        $base = $this->buscarFluxo($empresaId, $inicioBase, $fimBase);
        $comparacao = $this->buscarFluxo($empresaId, $inicioComparacao, $fimComparacao);

        $diferencaEntradas = $comparacao['entradas'] - $base['entradas'];
        $diferencaSaidas = $comparacao['saidas'] - $base['saidas'];
        $diferencaResultado = $comparacao['resultado'] - $base['resultado'];

        return view('relatorios.comparativo-fluxo', compact(
            'mesBase',
            'anoBase',
            'mesComparacao',
            'anoComparacao',
            'base',
            'comparacao',
            'diferencaEntradas',
            'diferencaSaidas',
            'diferencaResultado'
        ));
    }

    private function buscarFluxo($empresaId, $dataInicio, $dataFim)
    {
        $caixa = DB::table('caixa')
            ->select(
                'empresa_id',
                'data_movimentacao',
                'tipo',
                'valor'
            );

        $caixaBanco = DB::table('caixa_banco')
            ->select(
                'empresa_id',
                'data_movimentacao',
                'tipo',
                'valor'
            );

        $union = $caixa->unionAll($caixaBanco);

        $resultado = DB::query()
            ->fromSub($union, 'x')
            ->where('x.empresa_id', $empresaId)
            ->whereBetween('x.data_movimentacao', [$dataInicio, $dataFim])
            ->selectRaw("
                SUM(CASE WHEN x.tipo = 'entrada' THEN x.valor ELSE 0 END) as entradas,
                SUM(CASE WHEN x.tipo = 'saida' THEN x.valor ELSE 0 END) as saidas
            ")
            ->first();

        $entradas = (float) ($resultado->entradas ?? 0);
        $saidas = (float) ($resultado->saidas ?? 0);

        return [
            'entradas' => $entradas,
            'saidas' => $saidas,
            'resultado' => $entradas - $saidas,
        ];
    }
}