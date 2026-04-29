<?php

namespace App\Http\Controllers;

use App\Models\Caixa;
use App\Models\CaixaBanco;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RelatorioNaturezaFinanceiraController extends Controller
{
    public function index(Request $request)
    {
        $filtroTipo = $request->get('filtro_tipo', 'periodo');

        $mes = (int) $request->get('mes', Carbon::today()->month);
        $ano = (int) $request->get('ano', Carbon::today()->year);

        if ($filtroTipo === 'mes') {
            $inicio = Carbon::create($ano, $mes, 1)->startOfMonth();
            $fim = Carbon::create($ano, $mes, 1)->endOfMonth();
        } else {
            $inicio = Carbon::parse($request->get('data_inicio', Carbon::today()->toDateString()))->startOfDay();
            $fim = Carbon::parse($request->get('data_fim', Carbon::today()->toDateString()))->endOfDay();
        }

        $filtroNatureza = $request->get('natureza_financeira');
        $filtroFornecedor = $request->get('fornecedor_id');

        $tabelaCaixa = (new Caixa)->getTable();
        $tabelaBanco = (new CaixaBanco)->getTable();

        $saidasCaixa = $this->buscarSaidasComNaturezaFinanceira(
            $tabelaCaixa,
            $inicio,
            $fim,
            $filtroNatureza,
            $filtroFornecedor,
            'Dinheiro'
        );

        $saidasBanco = $this->buscarSaidasComNaturezaFinanceira(
            $tabelaBanco,
            $inicio,
            $fim,
            $filtroNatureza,
            $filtroFornecedor,
            'PIX/Banco'
        );

        $lancamentos = $saidasCaixa
            ->merge($saidasBanco)
            ->sortByDesc('data_sort')
            ->values();

        $totalGeral = $lancamentos->sum('valor');

        $agrupado = $lancamentos
            ->groupBy('natureza_financeira')
            ->map(function ($itensNatureza, $natureza) use ($totalGeral) {
                $totalNatureza = $itensNatureza->sum('valor');

                $fornecedores = $itensNatureza
                    ->groupBy('fornecedor')
                    ->map(function ($itensFornecedor, $fornecedor) use ($totalNatureza, $totalGeral) {
                        $totalFornecedor = $itensFornecedor->sum('valor');

                        return [
                            'fornecedor' => $fornecedor,
                            'total' => $totalFornecedor,
                            'quantidade' => $itensFornecedor->count(),

                            // Percentual do fornecedor dentro do total geral
                            'percentual_geral' => $totalGeral > 0
                                ? ($totalFornecedor / $totalGeral) * 100
                                : 0,

                            // Percentual do fornecedor dentro da própria natureza
                            'percentual_natureza' => $totalNatureza > 0
                                ? ($totalFornecedor / $totalNatureza) * 100
                                : 0,

                            'lancamentos' => $itensFornecedor
                                ->sortByDesc('data_sort')
                                ->values(),
                        ];
                    })
                    ->sortByDesc('total')
                    ->values();

                return [
                    'natureza_financeira' => $natureza,
                    'total' => $totalNatureza,
                    'percentual' => $totalGeral > 0
                        ? ($totalNatureza / $totalGeral) * 100
                        : 0,
                    'quantidade' => $itensNatureza->count(),
                    'fornecedores' => $fornecedores,
                ];
            })
            ->sortByDesc('percentual')
            ->values();

        $totalNaturezas = $lancamentos
            ->pluck('natureza_financeira')
            ->unique()
            ->count();

        $totalFornecedores = $lancamentos
            ->pluck('fornecedor')
            ->unique()
            ->count();

        $graficoNaturezas = $agrupado
            ->map(function ($item) {
                return [
                    'natureza' => ucfirst($item['natureza_financeira']),
                    'total' => round($item['total'], 2),
                    'percentual' => round($item['percentual'], 2),
                ];
            })
            ->values();

        $graficoFornecedores = $lancamentos
            ->groupBy('fornecedor')
            ->map(function ($itens, $fornecedor) {
                return [
                    'fornecedor' => $fornecedor,
                    'total' => round($itens->sum('valor'), 2),
                ];
            })
            ->sortByDesc('total')
            ->take(10)
            ->values();

        /*
         * Agora as naturezas do filtro vêm da tabela nova.
         */
        $naturezasDisponiveis = DB::table('naturezas_financeiras')
            ->where('ativo', 1)
            ->where('exibir_relatorio', 1)
            ->where('considerar_total', 1)
            ->orderBy('nome')
            ->pluck('nome');

        $fornecedoresDisponiveis = DB::table('fornecedores')
            ->select('id', 'nome')
            ->orderBy('nome')
            ->get();

        return view('relatorios.natureza-financeira', compact(
            'inicio',
            'fim',
            'filtroTipo',
            'mes',
            'ano',
            'filtroNatureza',
            'filtroFornecedor',
            'agrupado',
            'lancamentos',
            'totalGeral',
            'totalNaturezas',
            'totalFornecedores',
            'graficoNaturezas',
            'graficoFornecedores',
            'naturezasDisponiveis',
            'fornecedoresDisponiveis'
        ));
    }

    private function buscarSaidasComNaturezaFinanceira(
        string $tabela,
        Carbon $inicio,
        Carbon $fim,
        ?string $filtroNatureza,
        ?string $filtroFornecedor,
        string $meio
    ) {
        $temForma = Schema::hasColumn($tabela, 'forma');

        /*
         |--------------------------------------------------------------------------
         | Data da compra na tabela compras
         |--------------------------------------------------------------------------
         */
        $colunaDataCompraCompras = null;

        if (Schema::hasColumn('compras', 'data_compra')) {
            $colunaDataCompraCompras = 'data_compra';
        } elseif (Schema::hasColumn('compras', 'data')) {
            $colunaDataCompraCompras = 'data';
        } elseif (Schema::hasColumn('compras', 'data_movimentacao')) {
            $colunaDataCompraCompras = 'data_movimentacao';
        } elseif (Schema::hasColumn('compras', 'created_at')) {
            $colunaDataCompraCompras = 'created_at';
        }

        /*
         |--------------------------------------------------------------------------
         | Data da compra na tabela contas_a_pagar
         |--------------------------------------------------------------------------
         */
        $colunaDataCompraContas = 'data_compra';

        /*
         * Joins principais.
         * nf_compra e nf_conta buscam a natureza nova.
         */
       $query = DB::table($tabela . ' as m')
    ->leftJoin('compras as co', 'co.id', '=', 'm.referencia_id')
    ->leftJoin('fornecedores as f_compra', 'f_compra.id', '=', 'co.fornecedor_id')
    ->leftJoin('naturezas_financeiras as nf_compra', 'nf_compra.id', '=', 'f_compra.natureza_financeira_id')

    ->leftJoin('contas_a_pagar as cp', 'cp.id', '=', 'm.referencia_id')
    ->leftJoin('fornecedores as f_conta', 'f_conta.id', '=', 'cp.fornecedor_id')
    ->leftJoin('naturezas_financeiras as nf_conta', 'nf_conta.id', '=', 'f_conta.natureza_financeira_id')

    ->whereBetween('m.data_movimentacao', [$inicio, $fim])
    ->where('m.tipo', 'saida')
    ->where('m.origem', '<>', 'estorno')
    ->whereRaw('COALESCE(f_compra.id, f_conta.id) IS NOT NULL')

    /*
     * Não exibe no relatório e não calcula no total
     * naturezas marcadas como exibir_relatorio = 0
     * ou considerar_total = 0.
     */
    ->whereRaw("
        COALESCE(nf_compra.exibir_relatorio, nf_conta.exibir_relatorio, 1) = 1
    ")
    ->whereRaw("
        COALESCE(nf_compra.considerar_total, nf_conta.considerar_total, 1) = 1
    ");

        /*
         * Filtro por natureza.
         * Primeiro tenta pela natureza nova.
         * Depois mantém compatibilidade com o campo antigo.
         */
        if ($filtroNatureza) {
            $filtroNaturezaNormalizada = trim($filtroNatureza);

            $query->where(function ($q) use ($filtroNaturezaNormalizada) {
                $q->whereRaw('TRIM(nf_compra.nome) = ?', [$filtroNaturezaNormalizada])
                    ->orWhereRaw('TRIM(nf_conta.nome) = ?', [$filtroNaturezaNormalizada])
                    ->orWhereRaw('TRIM(f_compra.natureza_financeira) = ?', [$filtroNaturezaNormalizada])
                    ->orWhereRaw('TRIM(f_conta.natureza_financeira) = ?', [$filtroNaturezaNormalizada]);
            });
        }

        if ($filtroFornecedor) {
            $query->where(function ($q) use ($filtroFornecedor) {
                $q->where('f_compra.id', $filtroFornecedor)
                    ->orWhere('f_conta.id', $filtroFornecedor);
            });
        }

        $selects = [
            'm.id',
            'm.data_movimentacao',
            'm.tipo',
            'm.valor',
            'm.origem',
            'm.descricao',
            'm.referencia_id',

            DB::raw('co.id as compra_id'),
            DB::raw('cp.id as conta_pagar_id'),

            DB::raw(
                'COALESCE(' .
                ($colunaDataCompraCompras ? "co.$colunaDataCompraCompras" : 'NULL') .
                ', cp.' . $colunaDataCompraContas .
                ') as data_compra'
            ),

            DB::raw('COALESCE(f_compra.id, f_conta.id) as fornecedor_id'),
            DB::raw('COALESCE(f_compra.nome, f_conta.nome) as fornecedor_nome'),

            /*
             * Principal mudança:
             * usa primeiro a natureza nova da tabela naturezas_financeiras.
             * se não tiver, usa o campo antigo.
             */
            DB::raw("
                COALESCE(
                    nf_compra.nome,
                    nf_conta.nome,
                    f_compra.natureza_financeira,
                    f_conta.natureza_financeira
                ) as natureza_financeira
            "),
        ];

        if ($temForma) {
            $selects[] = DB::raw('m.forma as forma');
        } else {
            $selects[] = DB::raw('"' . $meio . '" as forma');
        }

        $registros = $query
            ->select($selects)
            ->orderByDesc('m.data_movimentacao')
            ->get();

        return $registros->map(function ($m) use ($meio) {
            return [
                'id' => $m->id,
                'data_sort' => Carbon::parse($m->data_movimentacao)->format('Y-m-d H:i:s'),
                'data' => Carbon::parse($m->data_movimentacao)->format('d/m/Y'),
                'meio' => $m->forma ?: $meio,
                'origem' => $m->origem ?? '',
                'descricao' => $m->descricao ?? '',
                'referencia_id' => $m->referencia_id ?? null,

                'compra_id' => $m->compra_id ?? null,
                'conta_pagar_id' => $m->conta_pagar_id ?? null,

                'data_compra' => $m->data_compra
                    ? Carbon::parse($m->data_compra)->format('d/m/Y')
                    : null,

                'fornecedor_id' => $m->fornecedor_id,
                'fornecedor' => $m->fornecedor_nome,
               'natureza_financeira' => $m->natureza_financeira
                ? mb_convert_case(trim($m->natureza_financeira), MB_CASE_TITLE, 'UTF-8')
                : 'Sem Natureza Financeira',
                'valor' => abs((float) $m->valor),
            ];
        });
    }
}