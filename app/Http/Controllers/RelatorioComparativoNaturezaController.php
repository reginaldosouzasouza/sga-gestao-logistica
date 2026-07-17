<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatorioComparativoNaturezaController extends Controller
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

        $dadosBase = $this->buscarSaidasPorNatureza($empresaId, $inicioBase, $fimBase);
        $dadosComparacao = $this->buscarSaidasPorNatureza($empresaId, $inicioComparacao, $fimComparacao);

        $naturezas = collect($dadosBase)
            ->keys()
            ->merge(collect($dadosComparacao)->keys())
            ->unique()
            ->sort()
            ->values();

        $linhas = [];

        foreach ($naturezas as $natureza) {
            $valorBase = $dadosBase[$natureza] ?? 0;
            $valorComparacao = $dadosComparacao[$natureza] ?? 0;

            $diferenca = $valorComparacao - $valorBase;

            if ($valorBase > 0) {
                $percentual = ($diferenca / $valorBase) * 100;
            } else {
                $percentual = $valorComparacao > 0 ? 100 : 0;
            }

            if ($diferenca > 0) {
                $status = 'Aumentou';
            } elseif ($diferenca < 0) {
                $status = 'Reduziu';
            } else {
                $status = 'Estável';
            }

            $linhas[] = [
                'natureza' => $natureza,
                'valor_base' => $valorBase,
                'valor_comparacao' => $valorComparacao,
                'diferenca' => $diferenca,
                'percentual' => $percentual,
                'status' => $status,
            ];
        }

        $totalBase = collect($linhas)->sum('valor_base');
        $totalComparacao = collect($linhas)->sum('valor_comparacao');
        $diferencaGeral = $totalComparacao - $totalBase;

        $maiorAumento = collect($linhas)
            ->where('diferenca', '>', 0)
            ->sortByDesc('diferenca')
            ->first();

        $maiorReducao = collect($linhas)
            ->where('diferenca', '<', 0)
            ->sortBy('diferenca')
            ->first();

        $linhas = collect($linhas)
            ->sortByDesc(function ($linha) {
                return abs($linha['diferenca']);
            })
            ->values();

        return view('relatorios.comparativo-natureza', compact(
            'mesBase',
            'anoBase',
            'mesComparacao',
            'anoComparacao',
            'linhas',
            'totalBase',
            'totalComparacao',
            'diferencaGeral',
            'maiorAumento',
            'maiorReducao'
        ));
    }

    private function buscarSaidasPorNatureza($empresaId, $dataInicio, $dataFim)
    {
        $caixa = DB::table('caixa')
            ->select(
                'empresa_id',
                'data_movimentacao',
                'tipo',
                'valor',
                'referencia_id'
            )
            ->where('tipo', 'saida');

        $caixaBanco = DB::table('caixa_banco')
            ->select(
                'empresa_id',
                'data_movimentacao',
                'tipo',
                'valor',
                'referencia_id'
            )
            ->where('tipo', 'saida');

        $union = $caixa->unionAll($caixaBanco);

        return DB::query()
            ->fromSub($union, 'x')
            ->leftJoin('contas_a_pagar as cp', function ($join) {
                $join->on('cp.id', '=', 'x.referencia_id')
                    ->on('cp.empresa_id', '=', 'x.empresa_id');
            })
            ->leftJoin('fornecedores as f', function ($join) {
                $join->on('f.id', '=', 'cp.fornecedor_id')
                    ->on('f.empresa_id', '=', 'x.empresa_id');
            })
            ->leftJoin('naturezas_financeiras as nf', 'nf.id', '=', 'f.natureza_financeira_id')
            ->where('x.empresa_id', $empresaId)
            ->whereBetween('x.data_movimentacao', [$dataInicio, $dataFim])
            ->selectRaw("
                COALESCE(nf.nome, 'Sem Natureza Financeira') as natureza,
                SUM(x.valor) as total
            ")
            ->groupByRaw("COALESCE(nf.nome, 'Sem Natureza Financeira')")
            ->pluck('total', 'natureza')
            ->map(function ($valor) {
                return (float) $valor;
            })
            ->toArray();
    }
}