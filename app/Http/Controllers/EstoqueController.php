<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EstoqueController extends Controller
{
    /**
     * Lista as movimentações de estoque somente da empresa logada.
     */
    public function index(Request $request)
    {
        $empresaId = auth()->user()->empresa_id;

        $query = Estoque::with('produto')
            ->where('empresa_id', $empresaId);

        // Filtro por nome do produto
        if ($request->filled('nome')) {
            $nomeProduto = $request->nome;

            $query->whereHas('produto', function ($q) use ($nomeProduto, $empresaId) {
                $q->where('empresa_id', $empresaId)
                  ->where('nome', 'like', '%' . $nomeProduto . '%');
            });
        }

        // Filtro por data inicial
        if ($request->filled('data_inicial')) {
            $query->whereDate('data_movimentacao', '>=', $request->data_inicial);
        }

        // Filtro por data final
        if ($request->filled('data_final')) {
            $query->whereDate('data_movimentacao', '<=', $request->data_final);
        }

        $movimentacoes = $query
            ->orderByDesc('data_movimentacao')
            ->get();

        Log::info('Movimentações de estoque da empresa logada:', [
            'empresa_id' => $empresaId,
            'total' => $movimentacoes->count(),
        ]);

        return view('estoques.index', compact('movimentacoes'));
    }

    /**
     * Armazena uma nova movimentação manual de estoque.
     */
    public function store(Request $request)
    {
        $empresaId = auth()->user()->empresa_id;

        $validatedData = $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|numeric',
            'tipo_movimentacao' => 'required|in:entrada,saida',
            'origem' => 'nullable|string|max:255',
            'data_movimentacao' => 'nullable|date',
        ]);

        // Garante que o produto pertence à empresa logada
        $produto = Produto::where('empresa_id', $empresaId)
            ->findOrFail($request->produto_id);

        $validatedData['empresa_id'] = $empresaId;
        $validatedData['origem'] = $validatedData['origem'] ?? 'manual';
        $validatedData['data_movimentacao'] = $validatedData['data_movimentacao'] ?? now();

        Estoque::create($validatedData);

        Log::info('Produto encontrado para movimentação manual:', [
            'empresa_id' => $empresaId,
            'produto' => $produto->nome,
            'quantidade_atual' => $produto->quantidade_estoque,
        ]);

        if ($request->tipo_movimentacao === 'entrada') {
            $produto->quantidade_estoque += $request->quantidade;
        }

        if ($request->tipo_movimentacao === 'saida') {
            $produto->quantidade_estoque -= $request->quantidade;
        }

        $produto->save();

        return response()->json([
            'message' => 'Movimentação de estoque salva e produto atualizado com sucesso!'
        ]);
    }

    /**
     * Exibe uma movimentação de estoque somente se pertencer à empresa logada.
     */
    public function show($id)
    {
        $empresaId = auth()->user()->empresa_id;

        $estoque = Estoque::where('empresa_id', $empresaId)
            ->findOrFail($id);

        return view('estoques.show', compact('estoque'));
    }

    public function totalEstoque()
    {
        return view('estoques.test');
    }

    /**
     * Consulta estoque de produtos somente da empresa logada.
     */
    public function consultaEstoque(Request $request)
    {
        $empresaId = auth()->user()->empresa_id;

        $search = $request->input('search');

        $query = Produto::where('empresa_id', $empresaId);

        if ($search) {
            $query->where('nome', 'like', '%' . $search . '%');
        }

        $produtos = $query
            ->select('nome', 'quantidade_estoque', 'updated_at')
            ->orderBy('quantidade_estoque', 'desc')
            ->get();

        return view('estoques.consulta-estoque', compact('produtos'));
    }

    /**
     * Consulta produtos somente da empresa logada.
     */
    public function consulta(Request $request)
    {
        $empresaId = auth()->user()->empresa_id;

        $search = $request->input('search');
        $sort = $request->input('sort', 'nome');
        $direction = $request->input('direction', 'asc');

        $produtos = Produto::where('empresa_id', $empresaId);

        if ($search) {
            $produtos->where('nome', 'like', '%' . $search . '%');
        }

        $produtos->orderBy($sort, $direction);

        $produtos = $produtos->get();

        return view('produtos.consulta', compact('produtos'));
    }
}