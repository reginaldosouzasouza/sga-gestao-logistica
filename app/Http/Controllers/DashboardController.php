<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\FinanceiroHelper;
use App\Services\PrevisaoGiroService;



class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function empresaId()
    {
         return empresaAtualId();
    }

    public function index()
    {
        return view('dashboard.index');
    }

    public function resumo(Request $request)
    {
        $empresaId = $this->empresaId();

        $dataInicio = $request->input('data_inicio', now()->startOfMonth()->toDateString());
        $dataFim = $request->input('data_fim', now()->toDateString());

        $receita = DB::table('movimentacao')
            ->where('empresa_id', $empresaId)
            ->whereBetween('data_coleta', [$dataInicio, $dataFim])
            ->sum('valor_total');

        $clientes = DB::table('clientes')
            ->where('empresa_id', $empresaId)
            ->count();

        return response()->json([
            'receita' => $receita,
            'lucro' => 0,
            'margem' => 0,
            'clientes' => $clientes
        ]);
    }

    public function financeiro(Request $request)
    {
        $empresaId = $this->empresaId();

        $dataInicio = $request->input('data_inicio', now()->startOfMonth()->toDateString());
        $dataFim = $request->input('data_fim', now()->toDateString());

        $dados = DB::table('movimentacao')
            ->selectRaw('MONTH(data_coleta) mes, SUM(valor_total) total')
            ->where('empresa_id', $empresaId)
            ->whereBetween('data_coleta', [$dataInicio, $dataFim])
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        return response()->json($dados);
    }

    public function previsaoFinanceira(Request $request)
    {
        $empresaId = $this->empresaId();

        $dataInicio = $request->input('data_inicio') ?? now()->startOfMonth()->toDateString();
        $dataFim = $request->input('data_fim') ?? now()->toDateString();

        $caixaAtual = FinanceiroHelper::saldoCaixaAtual();

        $receberPrevisto = DB::table('contas_a_receber')
            ->where('empresa_id', $empresaId)
            ->whereIn('status', ['pendente', 'atrasado'])
            ->whereDate('data_vencimento', '>=', $dataInicio)
            ->whereDate('data_vencimento', '<=', $dataFim)
            ->sum('valor');

        $contasPagar = DB::table('contas_a_pagar')
            ->where('empresa_id', $empresaId)
            ->whereIn('status', ['pendente', 'atrasado'])
            ->whereDate('data_vencimento', '>=', $dataInicio)
            ->whereDate('data_vencimento', '<=', $dataFim)
            ->sum('valor');

        $vendaPotencialEstoque = DB::table('produtos')
            ->where('empresa_id', $empresaId)
            ->where(function ($q) {
                $q->where('nome', 'like', '%GAS%')
                  ->orWhere('nome', 'like', '%GÁS%');
            })
            ->where('quantidade_estoque', '>', 0)
            ->selectRaw('SUM(quantidade_estoque * preco_venda) as total')
            ->value('total') ?? 0;

        $resultadoReceber = $caixaAtual + $receberPrevisto + $vendaPotencialEstoque;
        $saldoFuturo = $resultadoReceber - $contasPagar;

        return response()->json([
            'caixaAtual' => $caixaAtual,
            'receberPrevisto' => $receberPrevisto,
            'vendaPotencialEstoque' => $vendaPotencialEstoque,
            'resultadoReceber' => $resultadoReceber,
            'contasPagar' => $contasPagar,
            'saldoFuturo' => $saldoFuturo
        ]);
    }

    public function vendasPorDia(Request $request)
    {
        $empresaId = $this->empresaId();

        $dataInicio = $request->input('data_inicio') ?? now()->startOfMonth()->toDateString();
        $dataFim = $request->input('data_fim') ?? now()->toDateString();

        $dados = DB::table('movimentacao_itens as mi')
            ->join('movimentacao as m', 'm.id', '=', 'mi.movimentacao_id')
            ->join('produtos as p', 'p.id', '=', 'mi.produto_id')
            ->selectRaw("
                DATE(m.data_coleta) dia,
                SUM(CASE WHEN p.nome LIKE '%GAS%' OR p.nome LIKE '%GÁS%' THEN mi.quantidade ELSE 0 END) gas,
                SUM(CASE WHEN p.nome LIKE '%AGUA%' OR p.nome LIKE '%ÁGUA%' THEN mi.quantidade ELSE 0 END) agua
            ")
            ->where('m.empresa_id', $empresaId)
            ->where('mi.empresa_id', $empresaId)
            ->where('p.empresa_id', $empresaId)
            ->whereBetween('m.data_coleta', [$dataInicio, $dataFim])
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();

        return response()->json($dados);
    }

    public function produtosMaisVendidos(Request $request)
    {
        $empresaId = $this->empresaId();

        $dataInicio = $request->input('data_inicio') ?? now()->startOfMonth()->toDateString();
        $dataFim = $request->input('data_fim') ?? now()->toDateString();

        $dados = DB::table('movimentacao_itens as mi')
            ->join('movimentacao as m', 'm.id', '=', 'mi.movimentacao_id')
            ->join('produtos as p', 'p.id', '=', 'mi.produto_id')
            ->selectRaw('p.nome as produto, SUM(mi.quantidade) as total')
            ->where('m.empresa_id', $empresaId)
            ->where('mi.empresa_id', $empresaId)
            ->where('p.empresa_id', $empresaId)
            ->whereBetween('m.data_coleta', [$dataInicio, $dataFim])
            ->groupBy('p.nome')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return response()->json($dados);
    }

    public function vendasPorBairro(Request $request)
    {
        $empresaId = $this->empresaId();

        $dataInicio = $request->input('data_inicio') ?? now()->startOfMonth()->toDateString();
        $dataFim = $request->input('data_fim') ?? now()->toDateString();

        $dados = DB::table('movimentacao as m')
            ->join('clientes as c', 'c.id', '=', 'm.cliente_id')
            ->selectRaw('c.bairro, COUNT(m.id) as total')
            ->where('m.empresa_id', $empresaId)
            ->where('c.empresa_id', $empresaId)
            ->whereBetween('m.data_coleta', [$dataInicio, $dataFim])
            ->groupBy('c.bairro')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return response()->json($dados);
    }

    public function vendasPorCliente(Request $request)
    {
        $empresaId = $this->empresaId();

        $dataInicio = $request->input('data_inicio') ?? now()->startOfMonth()->toDateString();
        $dataFim = $request->input('data_fim') ?? now()->toDateString();

        $dados = DB::table('movimentacao_itens as mi')
            ->join('movimentacao as m', 'm.id', '=', 'mi.movimentacao_id')
            ->join('clientes as c', 'c.id', '=', 'm.cliente_id')
            ->join('produtos as p', 'p.id', '=', 'mi.produto_id')
            ->selectRaw("
                c.nome as cliente,

                SUM(
                    CASE 
                        WHEN p.nome LIKE '%GAS%' OR p.nome LIKE '%GÁS%'
                        THEN mi.quantidade 
                        ELSE 0 
                    END
                ) as gas,

                SUM(
                    CASE 
                        WHEN p.nome LIKE '%AGUA%' OR p.nome LIKE '%ÁGUA%'
                        THEN mi.quantidade 
                        ELSE 0 
                    END
                ) as agua
            ")
            ->where('m.empresa_id', $empresaId)
            ->where('mi.empresa_id', $empresaId)
            ->where('c.empresa_id', $empresaId)
            ->where('p.empresa_id', $empresaId)
            ->whereBetween('m.data_coleta', [$dataInicio, $dataFim])
            ->groupBy('c.nome')
            ->orderByRaw('(gas + agua) DESC')
            ->limit(10)
            ->get();

        return response()->json($dados);
    }

    public function ticketMedioClientes(Request $request)
    {
        $empresaId = $this->empresaId();

        $dataInicio = $request->input('data_inicio') ?? now()->startOfMonth()->toDateString();
        $dataFim = $request->input('data_fim') ?? now()->toDateString();

        $dados = DB::table('movimentacao_itens as mi')
            ->join('movimentacao as m', 'm.id', '=', 'mi.movimentacao_id')
            ->join('clientes as c', 'c.id', '=', 'm.cliente_id')
            ->join('produtos as p', 'p.id', '=', 'mi.produto_id')
            ->selectRaw("
                c.nome as cliente,

                SUM(
                    CASE 
                        WHEN p.nome LIKE '%GAS%' OR p.nome LIKE '%GÁS%'
                        THEN mi.quantidade * p.preco_venda
                        ELSE 0 
                    END
                ) as gas,

                SUM(
                    CASE 
                        WHEN p.nome LIKE '%AGUA%' OR p.nome LIKE '%ÁGUA%'
                        THEN mi.quantidade * p.preco_venda
                        ELSE 0 
                    END
                ) as agua
            ")
            ->where('m.empresa_id', $empresaId)
            ->where('mi.empresa_id', $empresaId)
            ->where('c.empresa_id', $empresaId)
            ->where('p.empresa_id', $empresaId)
            ->whereBetween('m.data_coleta', [$dataInicio, $dataFim])
            ->groupBy('c.nome')
            ->orderByRaw('(gas + agua) DESC')
            ->limit(20)
            ->get();

        return response()->json($dados);
    }

    public function previsaoRupturaEstoque(Request $request, PrevisaoGiroService $previsaoGiroService)
{
    $empresaId = $this->empresaId();

    $dataInicio = $request->input('data_inicio') ?? now()->startOfMonth()->toDateString();
    $dataFim = $request->input('data_fim') ?? now()->toDateString();

    $inicio = \Carbon\Carbon::parse($dataInicio);
    $fim = \Carbon\Carbon::parse($dataFim);
    $hoje = now();

    $diasPeriodo = $inicio->diffInDays($fim) + 1;

    if ($diasPeriodo <= 0) {
        $diasPeriodo = 1;
    }

    /*
     * Dias restantes até a data final do filtro.
     * Se a data final já passou, usamos 0.
     */
    $diasRestantesAteFim = $hoje->lte($fim)
        ? $hoje->copy()->startOfDay()->diffInDays($fim->copy()->startOfDay()) + 1
        : 0;

    /*
     * Produtos válidos para previsão.
     * Por enquanto, apenas GÁS e ÁGUA.
     */
    $produtos = DB::table('produtos')
        ->select('id', 'nome', 'quantidade_estoque', 'preco_compra')
        ->where('empresa_id', $empresaId)
        ->where(function ($q) {
            $q->where('nome', 'like', '%GAS%')
              ->orWhere('nome', 'like', '%GÁS%')
              ->orWhere('nome', 'like', '%AGUA%')
              ->orWhere('nome', 'like', '%ÁGUA%');
        })
        ->whereNotIn('nome', [
            'PRODUTOS DIVERSOS',
            'COMPRAS -MERCADO',
            'COMPRAS- MERCADO',
            'COMPRAS-MERCADO',
            'COMPRAS MERCADO',
        ])
        ->get();

    $resultado = [];

    foreach ($produtos as $produto) {
        $totalVendido = DB::table('movimentacao_itens as mi')
            ->join('movimentacao as m', 'm.id', '=', 'mi.movimentacao_id')
            ->where('m.empresa_id', $empresaId)
            ->where('mi.empresa_id', $empresaId)
            ->where('mi.produto_id', $produto->id)
            ->whereBetween('m.data_coleta', [$dataInicio, $dataFim])
            ->sum('mi.quantidade');

        $mediaDia = $diasPeriodo > 0 ? ($totalVendido / $diasPeriodo) : 0;

        /*
         * Cálculo antigo: cobertura do estoque pela média simples.
         * Mantemos para compatibilidade com a tela atual.
         */
        $diasCoberturaSimples = $mediaDia > 0
            ? ($produto->quantidade_estoque / $mediaDia)
            : 0;

        /*
         * Novo cálculo inteligente:
         * usa configuração de fim de mês, sazonalidade e estoque de segurança.
         */
        $previsao = $previsaoGiroService->calcular([
            'empresa_id' => $empresaId,
            'produto_id' => $produto->id,
            'media_diaria_base' => $mediaDia,
            'estoque_atual' => (float) $produto->quantidade_estoque,
            'dias_restantes' => $diasRestantesAteFim,
            'custo_unitario' => (float) ($produto->preco_compra ?? 0),
            'data_referencia' => $hoje,
        ]);

        $resultado[] = [
            'produto' => $produto->nome,
            'estoque' => (float) $produto->quantidade_estoque,
            'vendido_periodo' => (float) $totalVendido,
            'dias_periodo' => $diasPeriodo,

            /*
             * Campos antigos mantidos
             */
            'media' => round($mediaDia, 2),
            'dias' => round($diasCoberturaSimples, 1),

            /*
             * Campos novos para a previsão inteligente
             */
            'media_ajustada' => $previsao['media_diaria_ajustada'],
            'dias_restantes_ate_fim' => $diasRestantesAteFim,
            'venda_prevista' => $previsao['venda_prevista'],
            'cobertura_atual_dias_ajustada' => $previsao['cobertura_atual_dias'],

            'estoque_seguranca_dias' => $previsao['estoque_seguranca_dias'],
            'estoque_seguranca_unidades' => $previsao['estoque_seguranca_unidades'],

            'compra_minima' => $previsao['compra_minima'],
            'compra_recomendada' => $previsao['compra_recomendada'],

            'custo_unitario' => $previsao['custo_unitario'],
            'custo_compra_minima' => $previsao['custo_compra_minima'],
            'custo_compra_recomendada' => $previsao['custo_compra_recomendada'],

            'regra_final_semana_aplicada' => $previsao['regra_final_semana_aplicada'],
            'ajustes_aplicados' => $previsao['ajustes_aplicados'],
        ];
    }

    return response()->json($resultado);
}

public function previsaoGiroCaixa(Request $request, PrevisaoGiroService $previsaoGiroService)
{
    $empresaId = $this->empresaId();

    $dataInicio = $request->input('data_inicio') ?? now()->startOfMonth()->toDateString();
    $dataFim = $request->input('data_fim') ?? now()->endOfMonth()->toDateString();

    $inicio = \Carbon\Carbon::parse($dataInicio);
    $fim = \Carbon\Carbon::parse($dataFim);
    $hoje = now();

    $diasPeriodo = $inicio->diffInDays($fim) + 1;

    if ($diasPeriodo <= 0) {
        $diasPeriodo = 1;
    }

    $diasRestantesAteFim = $hoje->lte($fim)
        ? $hoje->copy()->startOfDay()->diffInDays($fim->copy()->startOfDay()) + 1
        : 0;

/*
 * RECEBIMENTO REAL DO PERÍODO
 * Fonte oficial: caixa + caixa_banco.
 *
 * Motivo:
 * Existem entradas via dinheiro e PIX que podem não passar pelo contas_a_receber.
 * Como este relatório é de giro e caixa, a base correta é o dinheiro que entrou
 * efetivamente no caixa/banco.
 */
$entradasCaixa = DB::table('caixa')
    ->where('empresa_id', $empresaId)
    ->where('tipo', 'entrada')
    ->whereBetween('data_movimentacao', [$dataInicio, $hoje->toDateString()])
    ->sum('valor');

$entradasCaixaBanco = DB::table('caixa_banco')
    ->where('empresa_id', $empresaId)
    ->where('tipo', 'entrada')
    ->whereBetween('data_movimentacao', [$dataInicio, $hoje->toDateString()])
    ->sum('valor');

$recebidoPeriodo = $entradasCaixa + $entradasCaixaBanco;

/*
 * Média diária de recebimento até hoje.
 */
/*
 * Dias corridos até hoje, considerando dias inteiros.
 * Exemplo:
 * 01/06 até 24/06 = 24 dias.
 */
$diasAteHoje = $inicio->copy()->startOfDay()
    ->diffInDays($hoje->copy()->startOfDay()) + 1;

if ($diasAteHoje <= 0) {
    $diasAteHoje = 1;
}

$mediaRecebimentoDia = $recebidoPeriodo / $diasAteHoje;

/*
 * Projeção do que ainda pode entrar até o final do período.
 */
$recebimentoProjetadoRestante = $mediaRecebimentoDia * $diasRestantesAteFim;
    /*
     * CONTAS A PAGAR EM ABERTO ATÉ A DATA FINAL
     */
    $contasPagarAberto = DB::table('contas_a_pagar')
        ->where('empresa_id', $empresaId)
        ->whereIn('status', ['pendente', 'em aberto', 'aberto'])
        ->whereBetween('data_vencimento', [$hoje->toDateString(), $dataFim])
        ->sum('valor');

    /*
     * PRODUTOS VÁLIDOS PARA PREVISÃO
     */
    $produtos = DB::table('produtos')
        ->select('id', 'nome', 'quantidade_estoque', 'preco_compra')
        ->where('empresa_id', $empresaId)
        ->where(function ($q) {
            $q->where('nome', 'like', '%GAS%')
              ->orWhere('nome', 'like', '%GÁS%')
              ->orWhere('nome', 'like', '%AGUA%')
              ->orWhere('nome', 'like', '%ÁGUA%');
        })
        ->whereNotIn('nome', [
            'PRODUTOS DIVERSOS',
            'COMPRAS -MERCADO',
            'COMPRAS- MERCADO',
            'COMPRAS-MERCADO',
            'COMPRAS MERCADO',
        ])
        ->get();

    $previsoesProdutos = [];
    $totalCompraMinima = 0;
    $totalCompraRecomendada = 0;

    foreach ($produtos as $produto) {
        /*
        * Para previsão mensal de compra, usamos apenas dias fechados.
        *
        * Exemplo:
        * Hoje: 12/07
        * Base de cálculo: 01/07 até 11/07
        *
        * Assim evitamos distorção causada pelo dia atual parcial.
        */
        $ontem = $hoje->copy()->subDay()->startOfDay();

        $dataBaseFimVendas = $ontem->lte($fim)
            ? $ontem->copy()
            : $fim->copy();

        /*
        * Se a data inicial for maior que ontem, não há dias fechados válidos.
        * Nesse caso, usamos a própria data inicial como base para evitar erro.
        */
        if ($dataBaseFimVendas->lt($inicio)) {
            $dataBaseFimVendas = $inicio->copy();
        }

        $totalVendido = DB::table('movimentacao_itens as mi')
            ->join('movimentacao as m', 'm.id', '=', 'mi.movimentacao_id')
            ->where('m.empresa_id', $empresaId)
            ->where('mi.empresa_id', $empresaId)
            ->where('mi.produto_id', $produto->id)
            ->whereBetween('m.data_coleta', [$dataInicio, $dataBaseFimVendas->toDateString()])
            ->sum('mi.quantidade');

        $diasBaseVendas = $inicio->copy()->startOfDay()
            ->diffInDays($dataBaseFimVendas->copy()->startOfDay()) + 1;

        if ($diasBaseVendas <= 0) {
            $diasBaseVendas = 1;
        }

        $mediaDia = $totalVendido / $diasBaseVendas; 
        

        $previsao = $previsaoGiroService->calcular([
            'empresa_id' => $empresaId,
            'produto_id' => $produto->id,
            'media_diaria_base' => $mediaDia,
            'estoque_atual' => (float) $produto->quantidade_estoque,
            'dias_restantes' => $diasRestantesAteFim,
            'custo_unitario' => (float) ($produto->preco_compra ?? 0),
            'data_referencia' => $hoje,
        ]);

        $totalCompraMinima += $previsao['custo_compra_minima'];
        $totalCompraRecomendada += $previsao['custo_compra_recomendada'];

        $previsoesProdutos[] = [
            'produto' => $produto->nome,
            'estoque' => (float) $produto->quantidade_estoque,
            'vendido_periodo' => (float) $totalVendido,
            'media_base' => round($mediaDia, 2),
            'media_ajustada' => $previsao['media_diaria_ajustada'],
            'venda_prevista' => $previsao['venda_prevista'],
            'compra_minima' => $previsao['compra_minima'],
            'compra_recomendada' => $previsao['compra_recomendada'],
            'custo_compra_minima' => $previsao['custo_compra_minima'],
            'custo_compra_recomendada' => $previsao['custo_compra_recomendada'],
            'ajustes_aplicados' => $previsao['ajustes_aplicados'],
        ];
    }

    /*
     * CENÁRIOS FINANCEIROS
     */
    $resultadoSemReposicao = $recebimentoProjetadoRestante - $contasPagarAberto;

    $resultadoComCompraMinima = $resultadoSemReposicao - $totalCompraMinima;

    $resultadoComCompraRecomendada = $resultadoSemReposicao - $totalCompraRecomendada;

    return view('dashboard.previsao_giro_caixa', compact(
        'dataInicio',
        'dataFim',
        'diasRestantesAteFim',
        'recebidoPeriodo',
        'mediaRecebimentoDia',
        'recebimentoProjetadoRestante',
        'contasPagarAberto',
        'previsoesProdutos',
        'totalCompraMinima',
        'totalCompraRecomendada',
        'resultadoSemReposicao',
        'resultadoComCompraMinima',
        'resultadoComCompraRecomendada'
    ));
}

}