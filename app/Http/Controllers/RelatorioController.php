<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimentacao;
use App\Models\Produto;
use App\Models\Modulo;
use Illuminate\Support\Facades\DB;
use App\Helpers\FinanceiroHelper;

class RelatorioController extends Controller
{
    private function empresaId()
    {
        return empresaAtualId();
    }

    public function vendas(Request $request)
    {
        $empresaId = $this->empresaId();

        $query = Movimentacao::where('empresa_id', $empresaId);

        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }

        if ($request->filled('data_inicial') && $request->filled('data_final')) {
            $query->whereBetween('created_at', [
                date('Y-m-d 00:00:00', strtotime($request->data_inicial)),
                date('Y-m-d 23:59:59', strtotime($request->data_final))
            ]);
        }

        $vendas = $query
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRegistros = $vendas->count();
        $valorTotal = $vendas->sum('valor_total');

        return view('relatorios.vendas', compact('vendas', 'totalRegistros', 'valorTotal'));
    }

    public function vendasPorProduto(Request $request)
    {
        $empresaId = $this->empresaId();

        $query = Movimentacao::query()
            ->join('movimentacao_itens', 'movimentacao.id', '=', 'movimentacao_itens.movimentacao_id')
            ->join('produtos', 'movimentacao_itens.produto_id', '=', 'produtos.id')
            ->where('movimentacao.empresa_id', $empresaId)
            ->where('movimentacao_itens.empresa_id', $empresaId)
            ->where('produtos.empresa_id', $empresaId)
            ->select(
                'movimentacao.nome as nome_cliente',
                'produtos.nome as nome_produto',
                'movimentacao.bairro as nome_bairro',
                'movimentacao_itens.quantidade',
                'movimentacao_itens.valor_unitario',
                'movimentacao_itens.valor_total',
                'movimentacao.data_coleta'
            );

        if ($request->filled('nome_cliente')) {
            $query->where('movimentacao.nome', 'like', '%' . $request->nome_cliente . '%');
        }

        if ($request->filled('nome_produto')) {
            $query->where('produtos.nome', 'like', '%' . $request->nome_produto . '%');
        }

        if ($request->filled('nome_bairro')) {
            $query->where('movimentacao.bairro', 'like', '%' . $request->nome_bairro . '%');
        }

        if ($request->filled('data_inicial') && $request->filled('data_final')) {
            $query->whereBetween('movimentacao.data_coleta', [
                date('Y-m-d 00:00:00', strtotime($request->data_inicial)),
                date('Y-m-d 23:59:59', strtotime($request->data_final))
            ]);
        }

        $vendas = $query
            ->orderBy('movimentacao.data_coleta', 'desc')
            ->get();

        $quantidadeTotal = $vendas->sum('quantidade');
        $valorTotal = $vendas->sum('valor_total');

        return view('relatorios.vendas_por_produto', compact('vendas', 'quantidadeTotal', 'valorTotal'));
    }

    public function saldoEstoque(Request $request)
    {
        $empresaId = $this->empresaId();

        $nome = $request->input('nome');

        $produtos = Produto::where('empresa_id', $empresaId)
            ->when($nome, function ($query, $nome) {
                return $query->where('nome', 'like', "%$nome%");
            })
            ->orderBy('quantidade_estoque', 'asc')
            ->get();

        return view('relatorios.saldo_estoque', compact('produtos'));
    }

    // =========================================================================
    // RELATÓRIO GERENCIAL — EMISSÕES DO DIA x MARGEM x CUSTOS
    // =========================================================================
    public function gerencialMargem(Request $request)
    {
        $empresaId = $this->empresaId();

        $dataInicio = $request->input('data_inicio', now()->startOfMonth()->toDateString());
        $dataFim    = $request->input('data_fim', now()->toDateString());
        $moduloSelecionado = $request->input('modulo_id', '');

        // ==========================================================
        // RECEITA
        // ==========================================================

        $totalEmitido = DB::table('movimentacao')
            ->join('movimentacao_itens', 'movimentacao.id', '=', 'movimentacao_itens.movimentacao_id')
            ->where('movimentacao.empresa_id', $empresaId)
            ->where('movimentacao_itens.empresa_id', $empresaId)
            ->whereBetween('movimentacao.data_coleta', [$dataInicio, $dataFim])
            ->sum('movimentacao_itens.valor_total');

        $totalQuantidade = DB::table('movimentacao')
            ->join('movimentacao_itens', 'movimentacao.id', '=', 'movimentacao_itens.movimentacao_id')
            ->where('movimentacao.empresa_id', $empresaId)
            ->where('movimentacao_itens.empresa_id', $empresaId)
            ->whereBetween('movimentacao.data_coleta', [$dataInicio, $dataFim])
            ->sum('movimentacao_itens.quantidade');

        // ==========================================================
        // CMV (CUSTO DA MERCADORIA VENDIDA)
        // ==========================================================

        $totalCustosProd = DB::table('movimentacao')
            ->join('movimentacao_itens', 'movimentacao.id', '=', 'movimentacao_itens.movimentacao_id')
            ->join('produtos', 'movimentacao_itens.produto_id', '=', 'produtos.id')
            ->where('movimentacao.empresa_id', $empresaId)
            ->where('movimentacao_itens.empresa_id', $empresaId)
            ->where('produtos.empresa_id', $empresaId)
            ->whereBetween('movimentacao.data_coleta', [$dataInicio, $dataFim])
            ->sum(DB::raw('movimentacao_itens.quantidade * produtos.preco_compra'));

        // ==========================================================
        // DESPESAS POR NATUREZA
        // ==========================================================

        $despesaOperacional = DB::table('compras')
            ->join('fornecedores', 'compras.fornecedor_id', '=', 'fornecedores.id')
            ->where('compras.empresa_id', $empresaId)
            ->where('fornecedores.empresa_id', $empresaId)
            ->where('fornecedores.natureza_financeira', 'operacional')
            ->whereBetween('compras.data_compra', [$dataInicio, $dataFim])
            ->sum('compras.total');

        $despesaAdministrativa = DB::table('compras')
            ->join('fornecedores', 'compras.fornecedor_id', '=', 'fornecedores.id')
            ->where('compras.empresa_id', $empresaId)
            ->where('fornecedores.empresa_id', $empresaId)
            ->where('fornecedores.natureza_financeira', 'administrativa')
            ->whereBetween('compras.data_compra', [$dataInicio, $dataFim])
            ->sum('compras.total');

        $despesaFinanceira = DB::table('compras')
            ->join('fornecedores', 'compras.fornecedor_id', '=', 'fornecedores.id')
            ->where('compras.empresa_id', $empresaId)
            ->where('fornecedores.empresa_id', $empresaId)
            ->where('fornecedores.natureza_financeira', 'financeiro')
            ->whereBetween('compras.data_compra', [$dataInicio, $dataFim])
            ->sum('compras.total');

        $despesaPessoal = DB::table('compras')
            ->join('fornecedores', 'compras.fornecedor_id', '=', 'fornecedores.id')
            ->where('compras.empresa_id', $empresaId)
            ->where('fornecedores.empresa_id', $empresaId)
            ->where('fornecedores.natureza_financeira', 'pessoal')
            ->whereBetween('compras.data_compra', [$dataInicio, $dataFim])
            ->sum('compras.total');

        // ==========================================================
        // RESULTADO EMPRESA (DRE)
        // ==========================================================

        $lucroEmpresa =
            $totalEmitido
            - $totalCustosProd
            - $despesaOperacional
            - $despesaAdministrativa;

        // ==========================================================
        // FLUXO REAL (CAIXA + BANCO)
        // ==========================================================

        $entradaCaixa = DB::table('caixa')
            ->where('empresa_id', $empresaId)
            ->where('tipo', 'entrada')
            ->whereBetween('data_movimentacao', [$dataInicio, $dataFim])
            ->sum('valor');

        $saidaCaixa = DB::table('caixa')
            ->where('empresa_id', $empresaId)
            ->where('tipo', 'saida')
            ->whereBetween('data_movimentacao', [$dataInicio, $dataFim])
            ->sum('valor');

        $entradaBanco = DB::table('caixa_banco')
            ->where('empresa_id', $empresaId)
            ->where('tipo', 'entrada')
            ->whereBetween('data_movimentacao', [$dataInicio, $dataFim])
            ->sum('valor');

        $saidaBanco = DB::table('caixa_banco')
            ->where('empresa_id', $empresaId)
            ->where('tipo', 'saida')
            ->whereBetween('data_movimentacao', [$dataInicio, $dataFim])
            ->sum('valor');

        $entradasReais = $entradaCaixa + $entradaBanco;
        $saidasReais   = $saidaCaixa + $saidaBanco;

        $resultadoGeral = $entradasReais - $saidasReais;

        // ==========================================================
        // PREVISÃO (CONTAS A PAGAR)
        // ==========================================================

        $previsao = DB::table('contas_a_pagar')
            ->where('empresa_id', $empresaId)
            ->whereIn('status', ['pendente','atrasado'])
            ->whereBetween('data_vencimento', [$dataInicio, $dataFim])
            ->sum('valor');

        // ==========================================================
        // PREVISÃO (CONTAS A RECEBER)
        // ==========================================================

        $receberPrevisto = DB::table('contas_a_receber')
            ->where('empresa_id', $empresaId)
            ->whereIn('status', ['pendente','atrasado'])
            ->whereBetween('data_vencimento', [$dataInicio, $dataFim])
            ->sum('valor');

        $saldoFuturo = $receberPrevisto - $previsao;

        // ==========================================================
        // INDICADORES
        // ==========================================================

        $ticketMedio = $totalQuantidade > 0
            ? $totalEmitido / $totalQuantidade
            : 0;

        $margemBruta = $totalEmitido - $totalCustosProd;

        $margemLiquidaPercent = $totalEmitido > 0
            ? round(($lucroEmpresa / $totalEmitido) * 100, 2)
            : 0;

        // ==========================================================
        // ESTOQUE - SOMENTE GÁS
        // ==========================================================

        $vendaPotencialEstoque = DB::table('produtos')
            ->where('empresa_id', $empresaId)
            ->where(function ($q) {
                $q->where('nome', 'like', '%GAS%')
                  ->orWhere('nome', 'like', '%GÁS%');
            })
            ->where('quantidade_estoque', '>', 0)
            ->selectRaw('SUM(quantidade_estoque * preco_venda) as total')
            ->value('total');

        $lucroPotencialEstoque = DB::table('produtos')
            ->where('empresa_id', $empresaId)
            ->where(function ($q) {
                $q->where('nome', 'like', '%GAS%')
                  ->orWhere('nome', 'like', '%GÁS%');
            })
            ->where('quantidade_estoque', '>', 0)
            ->selectRaw('SUM(quantidade_estoque * (preco_venda - preco_compra)) as total')
            ->value('total');

        // ==========================================================
        // PRODUTOS
        // ==========================================================

        $queryProdutos = Produto::with('modulo')
            ->where('empresa_id', $empresaId)
            ->where('preco_compra', '>', 0);

        if ($moduloSelecionado) {
            $queryProdutos->where('modulo_id', $moduloSelecionado);
        }

        $produtos = $queryProdutos
            ->orderByDesc('margem_percentual')
            ->get();

        $modulos = Modulo::orderBy('descricao')->get();

        // SALDO TOTAL DO CAIXA (INFORMATIVO)
        // Atenção: o helper também precisa ser revisado para empresa_id.
        $caixaAtual = FinanceiroHelper::saldoCaixaAtual();

        return view('relatorios.relatorio_gerencial_margem', compact(
            'totalEmitido',
            'totalQuantidade',
            'totalCustosProd',
            'despesaOperacional',
            'despesaAdministrativa',
            'despesaFinanceira',
            'despesaPessoal',
            'lucroEmpresa',
            'entradasReais',
            'saidasReais',
            'resultadoGeral',
            'previsao',
            'ticketMedio',
            'margemBruta',
            'margemLiquidaPercent',
            'produtos',
            'modulos',
            'dataInicio',
            'dataFim',
            'moduloSelecionado',
            'receberPrevisto',
            'saldoFuturo',
            'vendaPotencialEstoque',
            'lucroPotencialEstoque',
            'caixaAtual',
        ));
    }
}