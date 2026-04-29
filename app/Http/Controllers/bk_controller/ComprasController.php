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
        $formas_pagamento = FormaDePagamento::all();
        $prazos = Prazo::orderByRaw("FIELD(prazo, 'À vista', '1 dia', '5 dias', '15 dias', '20 dias', '30 dias')")->get();

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
            else {
                ContasAPagar::create([
                    'fornecedor_id' => $request->fornecedor_id,
                    'descricao' => 'Compra de produtos - NF ' . ($request->nota_fiscal ?? ''),
                    'valor' => $valorTotalCompra,
                    'data_compra' => $request->data_compra,
                    'data_vencimento' => $dataVencimento->format('Y-m-d'),
                    'status' => 'pendente',
                    'forma_pagamento_id' => $request->forma_pagamento_id,
                    'prazo' => $prazoDias,
                    'data_pagamento' => null,
                ]);
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
        $compras = Compra::with(['fornecedor', 'itensDeCompras.produto'])
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
    // QUERY BASE (itens da compra + fornecedor + forma pagamento + contas a pagar)
    // ==========================================================
    $query = DB::table('compras as c')
        ->join('itens_de_compras as ic', 'c.id', '=', 'ic.compra_id')
        ->join('produtos as p', 'ic.produto_id', '=', 'p.id')
        ->leftJoin('fornecedores as f', 'c.fornecedor_id', '=', 'f.id')
        ->join('formas_de_pagamento as fp', 'c.forma_pagamento_id', '=', 'fp.id')
        ->leftJoin('contas_a_pagar as cap', 'cap.compra_id', '=', 'c.id')
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
    // FILTROS (os seus + novo filtro de status_pagamento)
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

    if ($request->filled('data_inicial')) {
        $query->whereDate('c.data_compra', '>=', $request->data_inicial);
    }

    if ($request->filled('data_final')) {
        $query->whereDate('c.data_compra', '<=', $request->data_final);
    }

    // ✅ NOVO: filtro por status de pagamento
    // Esperado no request: status_pagamento = todos|pago|pendente|atrasado
    if ($request->filled('status_pagamento') && $request->status_pagamento !== 'todos') {
        $status = $request->status_pagamento;

        if ($status === 'pago') {
            $query->where(function ($q) {
                $q->whereIn('fp.nome', ['Dinheiro', 'PIX'])
                  ->orWhere('cap.status', 'pago');
            });
        } elseif ($status === 'pendente') {
            $query->whereNotIn('fp.nome', ['Dinheiro', 'PIX'])
                  ->where('cap.status', 'pendente');
        } elseif ($status === 'atrasado') {
            $query->whereNotIn('fp.nome', ['Dinheiro', 'PIX'])
                  ->where('cap.status', 'atrasado');
        }
    }

    // ==========================================================
    // RESULTADOS
    // ==========================================================
    $compras = (clone $query)
        ->orderBy('c.data_compra', 'desc')
        ->get();

    // ==========================================================
    // TOTAIS (IMPORTANTE: total por COMPRA, não por ITEM)
    // Como sua listagem é por item, somar ic.valor_total duplica o total.
    // Então os totais são calculados somando compras únicas (c.id).
    // ==========================================================

    // Base de compras únicas (mesmos filtros)
    $baseComprasUnicas = DB::table('compras as c')
        ->leftJoin('fornecedores as f', 'c.fornecedor_id', '=', 'f.id')
        ->join('formas_de_pagamento as fp', 'c.forma_pagamento_id', '=', 'fp.id')
        ->leftJoin('contas_a_pagar as cap', 'cap.compra_id', '=', 'c.id');

    // Reaplicar filtros equivalentes na base de compras únicas
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

    // OBS: filtro por produto não entra aqui porque produto está nos itens.
    // Se você quiser que os totais respeitem filtro por produto, me avise que eu ajusto com join nos itens.

    // Total Geral (somando c.total uma vez por compra)
    $totalGeral = (clone $baseComprasUnicas)
        ->select('c.id', 'c.total')
        ->distinct()
        ->get()
        ->sum('total');

    // Total Pago
    $totalPago = (clone $baseComprasUnicas)
        ->where(function ($q) {
            $q->whereIn('fp.nome', ['Dinheiro', 'PIX'])
              ->orWhere('cap.status', 'pago');
        })
        ->select('c.id', 'c.total')
        ->distinct()
        ->get()
        ->sum('total');

    // Total Pendente
    $totalPendente = (clone $baseComprasUnicas)
        ->whereNotIn('fp.nome', ['Dinheiro', 'PIX'])
        ->where('cap.status', 'pendente')
        ->select('c.id', 'c.total')
        ->distinct()
        ->get()
        ->sum('total');

    // Total Atrasado
    $totalAtrasado = (clone $baseComprasUnicas)
        ->whereNotIn('fp.nome', ['Dinheiro', 'PIX'])
        ->where('cap.status', 'atrasado')
        ->select('c.id', 'c.total')
        ->distinct()
        ->get()
        ->sum('total');

    // Mantém compatibilidade com sua view antiga:
    // antes você usava $totalCompras
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
