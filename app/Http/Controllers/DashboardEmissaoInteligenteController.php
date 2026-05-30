<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class DashboardEmissaoInteligenteController extends Controller
{
    private function empresaId()
    {
        return auth()->user()->empresa_id;
    }

    public function gas()
    {
        return $this->montarDashboard(
            filtroProduto: function (Builder $query) {
                $query->where('p.nome', 'like', '%GAS%')
                    ->orWhere('p.nome', 'like', '%GÁS%')
                    ->orWhere('p.nome', 'like', '%P13%')
                    ->orWhere('p.nome', 'like', '%P-13%')
                    ->orWhere('p.nome', 'like', '%P45%')
                    ->orWhere('p.nome', 'like', '%P-45%');
            },
            metaMensal: 270,
            subtipo: 'GÁS',
            viewPath: 'dashboard.emissao.gas.index'
        );
    }

    public function agua()
    {
        return $this->montarDashboard(
            filtroProduto: function (Builder $query) {
                $query->where('p.nome', 'like', '%AGUA%')
                    ->orWhere('p.nome', 'like', '%ÁGUA%')
                    ->orWhere('p.nome', 'like', '%GALAO%')
                    ->orWhere('p.nome', 'like', '%GALÃO%')
                    ->orWhere('p.nome', 'like', '%20L%')
                    ->orWhere('p.nome', 'like', '%20 L%');
            },
            metaMensal: 300,
            subtipo: 'ÁGUA',
            viewPath: 'dashboard.emissao.agua.index'
        );
    }

    private function montarDashboard(
        callable $filtroProduto,
        int $metaMensal,
        string $subtipo,
        string $viewPath
    ) {
        $empresaId = $this->empresaId();

        $hoje = Carbon::today();
        $ontem = Carbon::yesterday();
        $inicioMes = Carbon::now()->startOfMonth();
        $fimMes = Carbon::now()->endOfMonth();

        $base = DB::table('movimentacao as m')
            ->join('movimentacao_itens as mi', 'mi.movimentacao_id', '=', 'm.id')
            ->join('produtos as p', 'p.id', '=', 'mi.produto_id')
            ->where('m.empresa_id', $empresaId)
            ->where('mi.empresa_id', $empresaId)
            ->where('p.empresa_id', $empresaId)
            ->where(function (Builder $query) use ($filtroProduto) {
                $filtroProduto($query);
            });

        $emissoesHoje = (clone $base)
            ->whereDate('m.data_coleta', $hoje->toDateString())
            ->sum('mi.quantidade');

        $emissoesOntem = (clone $base)
            ->whereDate('m.data_coleta', $ontem->toDateString())
            ->sum('mi.quantidade');

        $acumuladoAteOntem = 0;
        $diasFechados = 0;
        $mediaDia = 0;
        $mediaDiariaFechada = 0;
        $projecaoMes = 0;

        if ($ontem->greaterThanOrEqualTo($inicioMes)) {
            $acumuladoAteOntem = (clone $base)
                ->whereBetween('m.data_coleta', [
                    $inicioMes->toDateString(),
                    $ontem->toDateString(),
                ])
                ->sum('mi.quantidade');

            $diasFechados = $ontem->day;

            if ($diasFechados > 0) {
                $mediaDiariaFechada = $acumuladoAteOntem / $diasFechados;
                $mediaDia = round($mediaDiariaFechada, 1);
                $projecaoMes = round($mediaDiariaFechada * $hoje->daysInMonth);
            }
        }

        $percentualMeta = $metaMensal > 0
            ? ($acumuladoAteOntem / $metaMensal) * 100
            : 0;

        $percentualProjecao = $metaMensal > 0
            ? ($projecaoMes / $metaMensal) * 100
            : 0;

        $faltamMeta = max(0, $metaMensal - $acumuladoAteOntem);

        $graficoDiario = (clone $base)
            ->selectRaw('DAY(m.data_coleta) as dia, SUM(mi.quantidade) as total')
            ->whereBetween('m.data_coleta', [
                $inicioMes->toDateString(),
                $fimMes->toDateString(),
            ])
            ->groupBy(DB::raw('DAY(m.data_coleta)'))
            ->orderBy('dia')
            ->get()
            ->keyBy('dia');

        $diasNoMes = $hoje->daysInMonth;
        $dias = [];
        $totais = [];
        $metaLinha = [];
        $projecaoLinha = [];

        for ($dia = 1; $dia <= $diasNoMes; $dia++) {
            $dias[] = $dia;
            $totais[] = isset($graficoDiario[$dia]) ? (int) $graficoDiario[$dia]->total : 0;
            $metaLinha[] = round(($metaMensal / $diasNoMes) * $dia);
            $projecaoLinha[] = round($mediaDiariaFechada * $dia);
        }

        return view($viewPath, [
            'titulo' => 'DASHBOARD GERENCIAL DE EMISSÃO',
            'subtipo' => $subtipo,

            'emissoesHoje' => $emissoesHoje,
            'emissoesOntem' => $emissoesOntem,
            'mediaDia' => $mediaDia,

            'acumuladoAteOntem' => $acumuladoAteOntem,
            'projecaoMes' => $projecaoMes,
            'metaMensal' => $metaMensal,
            'percentualMeta' => round($percentualMeta, 1),
            'percentualProjecao' => round($percentualProjecao, 1),
            'faltamMeta' => $faltamMeta,

            'dias' => $dias,
            'totais' => $totais,
            'metaLinha' => $metaLinha,
            'projecaoLinha' => $projecaoLinha,
        ]);
    }
}