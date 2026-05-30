<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caixa;
use App\Models\CaixaBanco;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RelatorioMovimentacaoController extends Controller
{
    private function empresaId()
    {
        return auth()->user()->empresa_id;
    }

    public function index(Request $request)
    {
        $dados = $this->buscarDados($request);

        return view('relatorios.relatorio_movimentacao_caixa', $dados);
    }

    public function exportar(Request $request)
    {
        $dados = $this->buscarDados($request);

        $filename = 'movimentacao_caixa_' .
            $dados['inicio']->format('d-m-Y') .
            '_a_' .
            $dados['fim']->format('d-m-Y') .
            '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($dados) {
            $out = fopen('php://output', 'w');

            // BOM UTF-8 para Excel
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($out, [
                'Data',
                'Tipo',
                'Meio',
                'Forma de Pagamento',
                'Origem',
                'Fornecedor',
                'Descrição',
                'Valor'
            ], ';');

            foreach ($dados['todos'] as $mov) {
                fputcsv($out, [
                    Carbon::parse($mov->data)->format('d/m/Y'),
                    $mov->tipo === 'entrada' ? 'Entrada' : 'Saída',
                    $mov->meio,
                    $mov->forma_pagamento ?? '-',
                    ucfirst($mov->origem),
                    $mov->fornecedor ?? '-',
                    $mov->descricao,
                    number_format($mov->valor, 2, ',', '.'),
                ], ';');
            }

            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function buscarDados(Request $request): array
    {
        $empresaId = $this->empresaId();

        $filtroTipo = $request->input('filtro_tipo', 'periodo');

        if ($filtroTipo === 'mes') {
            $mes    = $request->input('mes', now()->month);
            $ano    = $request->input('ano', now()->year);
            $inicio = Carbon::createFromDate($ano, $mes, 1)->startOfMonth();
            $fim    = Carbon::createFromDate($ano, $mes, 1)->endOfMonth();
        } else {
            $mes    = $request->input('mes', now()->month);
            $ano    = $request->input('ano', now()->year);
            $inicio = Carbon::parse($request->input('data_inicio', now()->startOfMonth()->toDateString()))->startOfDay();
            $fim    = Carbon::parse($request->input('data_fim', now()->toDateString()))->endOfDay();
        }

        $di = $inicio->format('Y-m-d H:i:s');
        $df = $fim->format('Y-m-d H:i:s');

        $filtroOrigem = $request->input('origem');
        $filtroForma  = $request->input('forma_pagamento');

        $formasPagamento = DB::table('formas_de_pagamento')
            ->pluck('nome', 'id');

        /*
        |--------------------------------------------------------------------------
        | Caixa dinheiro — somente empresa logada
        |--------------------------------------------------------------------------
        */
        $qCaixa = Caixa::where('empresa_id', $empresaId)
            ->whereBetween('data_movimentacao', [$di, $df]);

        if ($filtroOrigem) {
            $qCaixa->where('origem', $filtroOrigem);
        }

        $movCaixa = $qCaixa
            ->orderByDesc('data_movimentacao')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Caixa banco / PIX — somente empresa logada
        |--------------------------------------------------------------------------
        */
        $qBanco = CaixaBanco::where('empresa_id', $empresaId)
            ->whereBetween('data_movimentacao', [$di, $df]);

        if ($filtroOrigem) {
            $qBanco->where('origem', $filtroOrigem);
        }

        $movBanco = $qBanco
            ->orderByDesc('data_movimentacao')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Referências vinculadas aos lançamentos da empresa logada
        |--------------------------------------------------------------------------
        */
        $idsCompra = $movCaixa->where('origem', 'compra')->pluck('referencia_id')
            ->merge($movBanco->where('origem', 'compra')->pluck('referencia_id'))
            ->filter()
            ->unique()
            ->values();

        $idsReceber = $movCaixa->where('origem', 'recebimento')->pluck('referencia_id')
            ->merge($movBanco->where('origem', 'recebimento')->pluck('referencia_id'))
            ->filter()
            ->unique()
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Contas a pagar — somente empresa logada
        |--------------------------------------------------------------------------
        */
        $dadosPagar = DB::table('contas_a_pagar as cp')
            ->leftJoin('fornecedores as f', function ($join) use ($empresaId) {
                $join->on('f.id', '=', 'cp.fornecedor_id')
                    ->where('f.empresa_id', '=', $empresaId);
            })
            ->where('cp.empresa_id', $empresaId)
            ->whereIn('cp.id', $idsCompra)
            ->get([
                'cp.id',
                'cp.forma_pagamento_id',
                'cp.descricao',
                DB::raw('COALESCE(f.nome, "-") as fornecedor'),
            ])
            ->keyBy('id');

        /*
        |--------------------------------------------------------------------------
        | Compras — somente empresa logada
        |--------------------------------------------------------------------------
        */
        $dadosCompras = DB::table('compras as c')
            ->leftJoin('fornecedores as f', function ($join) use ($empresaId) {
                $join->on('f.id', '=', 'c.fornecedor_id')
                    ->where('f.empresa_id', '=', $empresaId);
            })
            ->where('c.empresa_id', $empresaId)
            ->whereIn('c.id', $idsCompra)
            ->get([
                'c.id',
                'c.forma_pagamento_id',
                'c.observacao',
                'c.nota_fiscal',
                DB::raw('COALESCE(f.nome, "-") as fornecedor'),
            ])
            ->keyBy('id');

        /*
        |--------------------------------------------------------------------------
        | Contas a receber — somente empresa logada
        |--------------------------------------------------------------------------
        */
        $dadosReceber = DB::table('contas_a_receber')
            ->where('empresa_id', $empresaId)
            ->whereIn('id', $idsReceber)
            ->get([
                'id',
                'forma_pagamento_id',
                'descricao',
            ])
            ->keyBy('id');

        $todos = collect();

        /*
        |--------------------------------------------------------------------------
        | Monta lançamentos do Caixa dinheiro
        |--------------------------------------------------------------------------
        */
        foreach ($movCaixa as $m) {
            [$forma, $obs] = $this->resolverFormaObs(
                $m,
                $dadosPagar,
                $dadosCompras,
                $dadosReceber,
                $formasPagamento,
                'Dinheiro'
            );

            $descricao = $obs ?: $m->descricao;

            $fornecedor = '-';

            if ($m->origem === 'compra' && !empty($m->referencia_id)) {
                if (isset($dadosPagar[$m->referencia_id])) {
                    $fornecedor = $dadosPagar[$m->referencia_id]->fornecedor ?? '-';
                } elseif (isset($dadosCompras[$m->referencia_id])) {
                    $fornecedor = $dadosCompras[$m->referencia_id]->fornecedor ?? '-';
                }
            }

            $todos->push((object) [
                'data'            => $m->data_movimentacao,
                'tipo'            => $m->tipo,
                'origem'          => $m->origem,
                'descricao'       => $descricao,
                'fornecedor'      => $fornecedor,
                'meio'            => 'Dinheiro',
                'forma_pagamento' => $forma,
                'valor'           => $m->valor,
                'referencia_id'   => $m->referencia_id,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Monta lançamentos do Caixa banco / PIX
        |--------------------------------------------------------------------------
        */
        foreach ($movBanco as $m) {
            [$forma, $obs] = $this->resolverFormaObs(
                $m,
                $dadosPagar,
                $dadosCompras,
                $dadosReceber,
                $formasPagamento,
                'PIX'
            );

            $descricao = $obs ?: $m->descricao;

            $fornecedor = '-';

            if ($m->origem === 'compra' && !empty($m->referencia_id)) {
                if (isset($dadosPagar[$m->referencia_id])) {
                    $fornecedor = $dadosPagar[$m->referencia_id]->fornecedor ?? '-';
                } elseif (isset($dadosCompras[$m->referencia_id])) {
                    $fornecedor = $dadosCompras[$m->referencia_id]->fornecedor ?? '-';
                }
            }

            $todos->push((object) [
                'data'            => $m->data_movimentacao,
                'tipo'            => $m->tipo,
                'origem'          => $m->origem,
                'descricao'       => $descricao,
                'fornecedor'      => $fornecedor,
                'meio'            => 'PIX',
                'forma_pagamento' => $forma,
                'valor'           => $m->valor,
                'referencia_id'   => $m->referencia_id,
            ]);
        }

        $todos = $todos
            ->sortByDesc('data')
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Filtro por forma de pagamento
        |--------------------------------------------------------------------------
        */
        if ($filtroForma) {
            $todos = $todos
                ->filter(fn ($m) => $m->forma_pagamento === $filtroForma)
                ->values();
        }

        $entradas = $todos->where('tipo', 'entrada')->values();
        $saidas   = $todos->where('tipo', 'saida')->values();

        $totalDinheiro = $entradas->where('meio', 'Dinheiro')->sum('valor');
        $totalPix      = $entradas->where('meio', 'PIX')->sum('valor');
        $totalEntradas = $entradas->sum('valor');
        $totalSaidas   = $saidas->sum('valor');
        $saldoGeral    = $totalEntradas - $totalSaidas;

        /*
        |--------------------------------------------------------------------------
        | Origens — somente empresa logada
        |--------------------------------------------------------------------------
        */
        $origens = Caixa::where('empresa_id', $empresaId)
            ->select('origem')
            ->distinct()
            ->pluck('origem')
            ->merge(
                CaixaBanco::where('empresa_id', $empresaId)
                    ->select('origem')
                    ->distinct()
                    ->pluck('origem')
            )
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return compact(
            'entradas',
            'saidas',
            'todos',
            'inicio',
            'fim',
            'filtroTipo',
            'filtroOrigem',
            'filtroForma',
            'totalDinheiro',
            'totalPix',
            'totalEntradas',
            'totalSaidas',
            'saldoGeral',
            'origens',
            'formasPagamento',
            'mes',
            'ano'
        );
    }

    private function resolverFormaObs(
        $mov,
        $dadosPagar,
        $dadosCompras,
        $dadosReceber,
        $formasPagamento,
        string $meioPadrao
    ): array {
        $refId = $mov->referencia_id ?? null;

        if ($mov->origem === 'compra' && $refId) {
            if (isset($dadosPagar[$refId])) {
                $conta   = $dadosPagar[$refId];
                $formaId = $conta->forma_pagamento_id ?? null;
                $forma   = $formaId ? ($formasPagamento[$formaId] ?? $meioPadrao) : $meioPadrao;
                $obs     = trim($conta->descricao ?? '');

                return [$forma, $obs];
            }

            if (isset($dadosCompras[$refId])) {
                $compra  = $dadosCompras[$refId];
                $formaId = $compra->forma_pagamento_id ?? null;
                $forma   = $formaId ? ($formasPagamento[$formaId] ?? $meioPadrao) : $meioPadrao;

                $obs = trim($compra->observacao ?? '');

                if ($obs === '' && !empty($compra->nota_fiscal)) {
                    $obs = trim($compra->nota_fiscal);
                }

                return [$forma, $obs];
            }
        }

        if ($mov->origem === 'recebimento' && $refId && isset($dadosReceber[$refId])) {
            $conta   = $dadosReceber[$refId];
            $formaId = $conta->forma_pagamento_id ?? null;
            $forma   = $formaId ? ($formasPagamento[$formaId] ?? $meioPadrao) : $meioPadrao;
            $obs     = trim($conta->descricao ?? '');

            return [$forma, $obs];
        }

        return [$meioPadrao, ''];
    }
}