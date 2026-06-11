<?php

namespace App\Http\Controllers;

use App\Models\Movimentacao;
use App\Models\Motorista;
use App\Models\Veiculo;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RelatorioComissaoController extends Controller
{
    public function index(Request $request)
    {
        $empresaId = empresaAtualId();

        $dataInicial = $request->data_inicial;
        $dataFinal = $request->data_final;
        $motoristaId = $request->motorista_id;
        $veiculoId = $request->veiculo_id;

        $query = Movimentacao::with(['motorista', 'veiculo'])
            ->whereNotNull('veiculo_id')
            ->where('valor_comissao', '>', 0);

        if ($empresaId) {
            $query->where('empresa_id', $empresaId);
        }

        if ($dataInicial) {
            $query->whereDate('data_coleta', '>=', $dataInicial);
        }

        if ($dataFinal) {
            $query->whereDate('data_coleta', '<=', $dataFinal);
        }

        if ($motoristaId) {
            $query->where('motorista_id', $motoristaId);
        }

        if ($veiculoId) {
            $query->where('veiculo_id', $veiculoId);
        }

        $movimentacoes = $query
            ->orderBy('data_coleta', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $totalPedidos = $movimentacoes->count();

        $totalVendas = $movimentacoes->sum(function ($movimentacao) {
            return $movimentacao->valor_total ?? 0;
        });

        $totalComissao = $movimentacoes->sum(function ($movimentacao) {
            return $movimentacao->valor_comissao ?? 0;
        });

        $motoristas = Motorista::query()
            ->when($empresaId, function ($query) use ($empresaId) {
                $query->where('empresa_id', $empresaId);
            })
            ->where('ativo', 1)
            ->orderBy('nome')
            ->get();

        $veiculos = Veiculo::query()
            ->when($empresaId, function ($query) use ($empresaId) {
                $query->where('empresa_id', $empresaId);
            })
            ->where('ativo', 1)
            ->orderBy('descricao')
            ->get();

        return view('relatorios.comissoes.index', compact(
            'movimentacoes',
            'motoristas',
            'veiculos',
            'totalPedidos',
            'totalVendas',
            'totalComissao',
            'dataInicial',
            'dataFinal',
            'motoristaId',
            'veiculoId'
        ));
    }

    public function pdf(Request $request)
    {
        $empresaId = empresaAtualId();

        $dataInicial = $request->data_inicial;
        $dataFinal = $request->data_final;
        $motoristaId = $request->motorista_id;
        $veiculoId = $request->veiculo_id;

        $query = Movimentacao::with(['motorista', 'veiculo'])
            ->whereNotNull('veiculo_id')
            ->where('valor_comissao', '>', 0);

        if ($empresaId) {
            $query->where('empresa_id', $empresaId);
        }

        if ($dataInicial) {
            $query->whereDate('data_coleta', '>=', $dataInicial);
        }

        if ($dataFinal) {
            $query->whereDate('data_coleta', '<=', $dataFinal);
        }

        if ($motoristaId) {
            $query->where('motorista_id', $motoristaId);
        }

        if ($veiculoId) {
            $query->where('veiculo_id', $veiculoId);
        }

        $movimentacoes = $query
            ->orderBy('data_coleta', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $totalPedidos = $movimentacoes->count();

        $totalVendas = $movimentacoes->sum(function ($movimentacao) {
            return $movimentacao->valor_total ?? 0;
        });

        $totalComissao = $movimentacoes->sum(function ($movimentacao) {
            return $movimentacao->valor_comissao ?? 0;
        });

        $pdf = Pdf::loadView('relatorios.comissoes.pdf', compact(
            'movimentacoes',
            'totalPedidos',
            'totalVendas',
            'totalComissao',
            'dataInicial',
            'dataFinal',
            'motoristaId',
            'veiculoId'
        ))->setPaper('a4', 'landscape');

        return $pdf->stream('relatorio-comissoes.pdf');
    }
}