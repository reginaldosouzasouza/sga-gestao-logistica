<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caixa;
use App\Models\CaixaBanco;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RelatorioMovimentacaoController extends Controller
{
    public function index(Request $request)
    {
        $dados = $this->buscarDados($request);
        return view('relatorios.relatorio_movimentacao_caixa', $dados);
    }

    public function exportar(Request $request)
    {
        $dados = $this->buscarDados($request);

        $filename = 'movimentacao_caixa_' . $dados['inicio']->format('d-m-Y') . '_a_' . $dados['fim']->format('d-m-Y') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($dados) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($out, ['Data', 'Tipo', 'Meio', 'Forma de Pagamento', 'Origem', 'Descrição', 'Valor'], ';');

            foreach ($dados['todos'] as $mov) {
                fputcsv($out, [
                    Carbon::parse($mov->data)->format('d/m/Y'),
                    $mov->tipo === 'entrada' ? 'Entrada' : 'Saída',
                    $mov->meio,
                    $mov->forma_pagamento ?? '-',
                    ucfirst($mov->origem),
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
        $filtroTipo = $request->input('filtro_tipo', 'periodo');

        if ($filtroTipo === 'mes') {
            $mes    = $request->input('mes', now()->month);
            $ano    = $request->input('ano', now()->year);
            $inicio = Carbon::createFromDate($ano, $mes, 1)->startOfMonth();
            $fim    = Carbon::createFromDate($ano, $mes, 1)->endOfMonth();
        } else {
            $mes    = $request->input('mes', now()->month);
            $ano    = $request->input('ano', now()->year);
            $inicio = Carbon::parse($request->input('data_inicio', now()->startOfMonth()->toDateString()));
            $fim    = Carbon::parse($request->input('data_fim',    now()->toDateString()));
        }

        $di = $inicio->toDateString();
        $df = $fim->toDateString();

        $filtroOrigem = $request->input('origem');
        $filtroForma  = $request->input('forma_pagamento');

        $formasPagamento = DB::table('formas_de_pagamento')->pluck('nome', 'id');

        $qCaixa = Caixa::whereBetween('data_movimentacao', [$di, $df]);
        if ($filtroOrigem) $qCaixa->where('origem', $filtroOrigem);
        $movCaixa = $qCaixa->orderByDesc('data_movimentacao')->get();

        $qBanco = CaixaBanco::whereBetween('data_movimentacao', [$di, $df]);
        if ($filtroOrigem) $qBanco->where('origem', $filtroOrigem);
        $movBanco = $qBanco->orderByDesc('data_movimentacao')->get();

        $idsPagar = $movCaixa->where('origem', 'compra')->pluck('referencia_id')
            ->merge($movBanco->where('origem', 'compra')->pluck('referencia_id'))
            ->filter()->unique();

        $idsReceber = $movCaixa->where('origem', 'recebimento')->pluck('referencia_id')
            ->merge($movBanco->where('origem', 'recebimento')->pluck('referencia_id'))
            ->filter()->unique();

        $dadosPagar = DB::table('contas_a_pagar')
            ->whereIn('id', $idsPagar)
            ->get(['id', 'forma_pagamento_id', 'descricao'])
            ->keyBy('id');

        $dadosReceber = DB::table('contas_a_receber')
            ->whereIn('id', $idsReceber)
            ->get(['id', 'forma_pagamento_id', 'descricao'])
            ->keyBy('id');

        $todos = collect();

        foreach ($movCaixa as $m) {
            [$forma, $obs] = $this->resolverFormaObs($m, $dadosPagar, $dadosReceber, $formasPagamento, 'Dinheiro');
            // Se houver observação manual, mostra só ela; senão mostra a automática
            $descricao = $obs ?: $m->descricao;
            $todos->push((object)[
                'data'            => $m->data_movimentacao,
                'tipo'            => $m->tipo,
                'origem'          => $m->origem,
                'descricao'       => $descricao,
                'meio'            => 'Dinheiro',
                'forma_pagamento' => $forma,
                'valor'           => $m->valor,
                'referencia_id'   => $m->referencia_id,
            ]);
        }

        foreach ($movBanco as $m) {
            [$forma, $obs] = $this->resolverFormaObs($m, $dadosPagar, $dadosReceber, $formasPagamento, 'PIX');
            $descricao = $obs ?: $m->descricao;
            $todos->push((object)[
                'data'            => $m->data_movimentacao,
                'tipo'            => $m->tipo,
                'origem'          => $m->origem,
                'descricao'       => $descricao,
                'meio'            => 'PIX',
                'forma_pagamento' => $forma,
                'valor'           => $m->valor,
                'referencia_id'   => $m->referencia_id,
            ]);
        }

        $todos = $todos->sortByDesc('data')->values();

        if ($filtroForma) {
            $todos = $todos->filter(fn($m) => $m->forma_pagamento === $filtroForma)->values();
        }

        $entradas = $todos->where('tipo', 'entrada')->values();
        $saidas   = $todos->where('tipo', 'saida')->values();

        $totalDinheiro = $entradas->where('meio', 'Dinheiro')->sum('valor');
        $totalPix      = $entradas->where('meio', 'PIX')->sum('valor');
        $totalEntradas = $entradas->sum('valor');
        $totalSaidas   = $saidas->sum('valor');
        $saldoGeral    = $totalEntradas - $totalSaidas;

        $origens = Caixa::select('origem')->distinct()->pluck('origem')
            ->merge(CaixaBanco::select('origem')->distinct()->pluck('origem'))
            ->filter()->unique()->sort()->values();

        return compact(
            'entradas', 'saidas', 'todos',
            'inicio', 'fim', 'filtroTipo', 'filtroOrigem', 'filtroForma',
            'totalDinheiro', 'totalPix',
            'totalEntradas', 'totalSaidas', 'saldoGeral',
            'origens', 'formasPagamento', 'mes', 'ano'
        );
    }

    private function resolverFormaObs($mov, $dadosPagar, $dadosReceber, $formasPagamento, string $meioPadrao): array
    {
        $refId = $mov->referencia_id ?? null;

        if ($mov->origem === 'compra' && $refId && isset($dadosPagar[$refId])) {
            $conta   = $dadosPagar[$refId];
            $formaId = $conta->forma_pagamento_id ?? null;
            $forma   = $formaId ? ($formasPagamento[$formaId] ?? $meioPadrao) : $meioPadrao;
            $obs     = trim($conta->descricao ?? '');
            return [$forma, $obs];
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