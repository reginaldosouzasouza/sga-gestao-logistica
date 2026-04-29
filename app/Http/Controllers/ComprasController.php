<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\Compra;
use App\Models\FormaDePagamento;
use App\Models\Prazo;
use App\Models\ContasAPagar;
use App\Models\Estoque;
use App\Models\ItemDeCompra;
use App\Models\Caixa;
use App\Models\CaixaBanco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;




class ComprasController extends Controller
{
    public function create()
    {
        $fornecedores = Fornecedor::orderby('nome', 'asc')->get();
        $produtos = Produto::orderBy('nome', 'asc')->get();
        $formas_pagamento = FormaDePagamento::orderby('nome', 'asc')->get();
        $prazos = Prazo::orderBy('prazo', 'asc')->get();

        return view('compras.create', compact('fornecedores', 'produtos', 'formas_pagamento', 'prazos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fornecedor_id' => 'required|exists:fornecedores,id',
            'nota_fiscal' => 'nullable|string',
            'data_compra' => 'required|date',
            'forma_pagamento_id' => 'required|exists:formas_de_pagamento,id',
            'prazo_id' => 'required|exists:prazos,id',
            'itens' => 'required|array',
            'itens.*.produto_id' => 'required|exists:produtos,id',
            'itens.*.quantidade' => 'required|integer|min:1',
            'itens.*.valor_unitario' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $valorTotalCompra = array_sum(array_column($request->itens, 'valor_total'));

            $prazo = Prazo::findOrFail($request->prazo_id);
            $prazoDias = intval($prazo->prazo);

            $formaPagamento = FormaDePagamento::findOrFail($request->forma_pagamento_id);
            $formaNome = strtolower(trim($formaPagamento->nome));

            $dataCompra = Carbon::parse($request->data_compra);
            $dataVencimento = $dataCompra->copy()->addDays($prazoDias);

            // Criar compra
            $compra = Compra::create([
                'fornecedor_id' => $request->fornecedor_id,
                'nota_fiscal' => $request->nota_fiscal,
                'data_compra' => $request->data_compra,
                'data_vencimento' => $dataVencimento,
                'data_pagamento' => null,
                'status' => 'pendente',
                'forma_pagamento_id' => $request->forma_pagamento_id,
                'prazo_id' => $request->prazo_id,
                'total' => $valorTotalCompra,
            ]);

            /* ===============================
               ITENS + ESTOQUE
            =============================== */
            foreach ($request->itens as $item) {
                $produto = Produto::findOrFail($item['produto_id']);

                $itemCompra = $compra->itensDeCompras()->create([
                    'produto_id' => $item['produto_id'],
                    'quantidade' => $item['quantidade'],
                    'valor_unitario' => $item['valor_unitario'],
                    'valor_total' => $item['quantidade'] * $item['valor_unitario'],
                ]);

                Estoque::create([
                    'produto_id' => $itemCompra->produto_id,
                    'quantidade' => $itemCompra->quantidade,
                    'tipo_movimentacao' => 'entrada',
                    'origem' => 'compra',
                    'data_movimentacao' => now(),
                ]);

                $produto->quantidade_estoque += $itemCompra->quantidade;
                $produto->save();
            }

            /* ===============================
               FINANCEIRO (REGRA NOVA)
            =============================== */

            // 💵 DINHEIRO → CAIXA
            if ($formaNome === 'dinheiro') {
                Caixa::create([
                    'data_movimentacao' => $request->data_compra,
                    'tipo' => 'saida',
                    'valor' => $valorTotalCompra,
                    'origem' => 'compra',
                    'descricao' => 'Compra à vista - NF ' . ($request->nota_fiscal ?? ''),
                    'referencia_id' => $compra->id,
                ]);
            }

            // 💸 PIX → CAIXA_BANCO
            elseif ($formaNome === 'pix') {
                CaixaBanco::create([
                    'data_movimentacao' => $request->data_compra,
                    'tipo' => 'saida',
                    'valor' => $valorTotalCompra,
                    'forma' => 'pix',
                    'origem' => 'compra',
                    'descricao' => 'Compra via PIX - NF ' . ($request->nota_fiscal ?? ''),
                    'referencia_id' => $compra->id,
                ]);
            }

            // 💳 PRAZO / BOLETO → CONTAS A PAGAR
           // 💳 PRAZO / BOLETO → CONTAS A PAGAR
else {

    $parcelas = $request->parcelas ?? 1;

    $valorParcela = $valorTotalCompra / $parcelas;

    for ($i = 1; $i <= $parcelas; $i++) {

        $dataVencimentoParcela = $dataCompra->copy()->addDays($prazoDias * $i);

        ContasAPagar::create([
            'compra_id' => $compra->id,
            'fornecedor_id' => $request->fornecedor_id,
            'descricao' => 'Compra de produtos - Parcela ' . $i . '/' . $parcelas . ' - NF ' . ($request->nota_fiscal ?? ''),
            'valor' => $valorParcela,
            'data_compra' => $request->data_compra,
            'data_vencimento' => $dataVencimentoParcela->format('Y-m-d'),
            'status' => 'pendente',
            'forma_pagamento_id' => $request->forma_pagamento_id,
            'prazo' => $prazoDias,
            'parcela' => $i,
            'total_parcelas' => $parcelas,
            'data_pagamento' => null,
        ]);

    }
}

            DB::commit();

            return redirect()
                ->route('compras.index')
                ->with('success', 'Compra salva com sucesso.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erro ao salvar compra', [
                'erro' => $e->getMessage()
            ]);

            return redirect()
                ->back()
                ->withErrors('Erro ao salvar a compra: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $compras = Compra::with(['fornecedor', 'itensDeCompras.produto', 'contasAPagar'])
            ->orderBy('id', 'desc')
            ->get();

        return view('compras.index', compact('compras'));
    }

    public function destroy($id)
    {
        Compra::findOrFail($id)->delete();

        return redirect()
            ->route('compras.index')
            ->with('success', 'Compra excluída com sucesso.');
    }


    public function edit($id)
{
    $compra = Compra::findOrFail($id);

    return view('compras.edit', compact('compra'));
}



public function relatorioCompras(Request $request)
{
    // ==========================================================
    // QUERY BASE (itens da compra + fornecedor + forma pagamento)
    // ==========================================================
    $query = DB::table('compras as c')
        ->join('itens_de_compras as ic', 'c.id', '=', 'ic.compra_id')
        ->join('produtos as p', 'ic.produto_id', '=', 'p.id')
        ->leftJoin('fornecedores as f', 'c.fornecedor_id', '=', 'f.id')
        ->join('formas_de_pagamento as fp', 'c.forma_pagamento_id', '=', 'fp.id')

        // pega apenas UMA parcela para evitar duplicação
        ->leftJoin(DB::raw('(
            SELECT compra_id, MAX(data_pagamento) as data_pagamento, MAX(status) as status
            FROM contas_a_pagar
            GROUP BY compra_id
        ) as cap'), 'cap.compra_id', '=', 'c.id')

        ->select(
            'c.id as compra_id',
            'p.nome as produto',
            'ic.quantidade',
            'ic.valor_unitario',
            'ic.valor_total',
            'c.nota_fiscal',
            'f.nome as fornecedor',
            'f.natureza_financeira',
            'fp.nome as forma_pagamento',
            'c.data_compra',
            'c.data_vencimento',
            'cap.data_pagamento',

            DB::raw("
                CASE
                    WHEN fp.nome IN ('Dinheiro','PIX') THEN 'pago'
                    ELSE COALESCE(cap.status,'pendente')
                END AS status_pagamento
            ")
        );

    // ==========================================================
    // FILTROS
    // ==========================================================

    if ($request->filled('id')) {
        $query->where('c.id', $request->id);
    }

    if ($request->filled('produto')) {
        $query->where('p.nome', 'like', '%' . $request->produto . '%');
    }

    if ($request->filled('fornecedor')) {
        $query->where('f.nome', 'like', '%' . $request->fornecedor . '%');
    }

    if ($request->filled('natureza_financeira') && $request->natureza_financeira !== 'todas') {
        $query->where('f.natureza_financeira', $request->natureza_financeira);
    }

    // FILTRO por data da  COMPRA(DATA INCIAL E FINAL)
    if ($request->filled('data_inicial')) {
        $query->whereDate('c.data_compra', '>=', $request->data_inicial);
    }

    if ($request->filled('data_final')) {
        $query->whereDate('c.data_compra', '<=', $request->data_final);
    }

    if ($request->filled('status_pagamento') && $request->status_pagamento !== 'todos') {

        if ($request->status_pagamento === 'pago') {
            $query->where(function ($q) {
                $q->whereIn('fp.nome', ['Dinheiro','PIX'])
                  ->orWhere('cap.status','pago');
            });
        }

        if ($request->status_pagamento === 'pendente') {
            $query->whereNotIn('fp.nome', ['Dinheiro','PIX'])
                  ->where('cap.status','pendente');
        }

        if ($request->status_pagamento === 'atrasado') {
            $query->whereNotIn('fp.nome', ['Dinheiro','PIX'])
                  ->where('cap.status','atrasado');
        }


        // Filtro por Data de Vencimento
            if ($request->filled('data_vencimento_inicial')) {
                $query->whereDate('c.data_vencimento', '>=', $request->data_vencimento_inicial);
            }

            if ($request->filled('data_vencimento_final')) {
                $query->whereDate('c.data_vencimento', '<=', $request->data_vencimento_final);
            }
    }

    // ==========================================================
    // RESULTADOS
    // ==========================================================

    $compras = $query
        ->orderBy('c.data_compra', 'desc')
        ->get();

    // ==========================================================
    // TOTAIS
    // ==========================================================

    $baseComprasUnicas = DB::table('compras as c')
        ->leftJoin('fornecedores as f', 'c.fornecedor_id', '=', 'f.id')
        ->join('formas_de_pagamento as fp', 'c.forma_pagamento_id', '=', 'fp.id')
        ->leftJoin('contas_a_pagar as cap', 'cap.compra_id', '=', 'c.id');

    if ($request->filled('id')) {
        $baseComprasUnicas->where('c.id', $request->id);
    }

    if ($request->filled('fornecedor')) {
        $baseComprasUnicas->where('f.nome', 'like', '%' . $request->fornecedor . '%');
    }

    if ($request->filled('natureza_financeira') && $request->natureza_financeira !== 'todas') {
        $baseComprasUnicas->where('f.natureza_financeira', $request->natureza_financeira);
    }

    if ($request->filled('data_inicial')) {
        $baseComprasUnicas->whereDate('c.data_compra', '>=', $request->data_inicial);
    }

    if ($request->filled('data_final')) {
        $baseComprasUnicas->whereDate('c.data_compra', '<=', $request->data_final);
    }

    $totalGeral = (clone $baseComprasUnicas)
        ->select('c.id','c.total')
        ->distinct()
        ->get()
        ->sum('total');

    $totalPago = (clone $baseComprasUnicas)
        ->where(function ($q) {
            $q->whereIn('fp.nome',['Dinheiro','PIX'])
              ->orWhere('cap.status','pago');
        })
        ->select('c.id','c.total')
        ->distinct()
        ->get()
        ->sum('total');

    $totalPendente = (clone $baseComprasUnicas)
        ->whereNotIn('fp.nome',['Dinheiro','PIX'])
        ->where('cap.status','pendente')
        ->select('c.id','c.total')
        ->distinct()
        ->get()
        ->sum('total');

    $totalAtrasado = (clone $baseComprasUnicas)
        ->whereNotIn('fp.nome',['Dinheiro','PIX'])
        ->where('cap.status','atrasado')
        ->select('c.id','c.total')
        ->distinct()
        ->get()
        ->sum('total');

    $totalCompras = $totalGeral;

    return view('relatorios.compras', compact(
        'compras',
        'totalCompras',
        'totalGeral',
        'totalPago',
        'totalPendente',
        'totalAtrasado'
    ));
}


public function search(Request $request)
{
    $query = $request->get('query');

    $compras = Compra::with('fornecedor')
        ->whereHas('fornecedor', function ($q) use ($query) {
            $q->where('nome', 'like', "%{$query}%");
        })
        ->orderBy('created_at', 'desc')
        ->get();

    return view('compras.index', compact('compras'));
}








}
