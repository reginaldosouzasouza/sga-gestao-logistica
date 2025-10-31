<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class EstoqueController extends Controller
{
    
    

   // Método para listar as movimentações de estoque

    public function index(Request $request)
{
      // Verifica se os filtros estão chegando corretamente
      //Log::info('Filtros recebidos:', $request->all());

    $query = Estoque::with('produto');

    // Filtro por nome do produto
    if ($request->filled('nome')) {
        $query->whereHas('produto', function ($q) use ($request) {
            $q->where('nome', 'like', '%' . $request->nome . '%');
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

    // Ordena do mais recente para o mais antigo
    $movimentacoes = $query->orderByDesc('data_movimentacao')->get();

     // Verifica os resultados
     Log::info('Resultados da consulta:', $movimentacoes->toArray());

    return view('estoques.index', compact('movimentacoes'));
}



   /* **************************************************************
        public function index()
        {
            // Carregar todas as movimentações de estoque, ordenadas pela data de forma decrescente
            $movimentacoes = Estoque::with('produto')
                                    ->orderBy('data_movimentacao', 'desc')
                                    ->get();

            // Retornar a view de estoques com as movimentações
            return view('estoques.index', compact('movimentacoes'));
        }

   /*******************************************************************************************************/
    // Método para armazenar uma nova movimentação de estoque (por exemplo, uma entrada de compra)

    public function store(Request $request)
    {
        // Validação dos dados
        $validatedData = $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|numeric',
            'tipo_movimentacao' => 'required|in:entrada,saida',
            // Outros campos...
        ]);

        // Salvar a movimentação no estoque
        Estoque::create($validatedData);

        // Atualizar o campo 'quantidade_estoque' no produto
        $produto = Produto::find($request->produto_id);

        \Log::info('Produto encontrado: ' . $produto->nome);
        \Log::info('Quantidade atual no estoque: ' . $produto->quantidade_estoque);

        if ($request->tipo_movimentacao === 'entrada') {
            // Aumentar a quantidade no estoque do produto
            $produto->quantidade_estoque += $request->quantidade;
            \Log::info('Nova quantidade após entrada: ' . $produto->quantidade_estoque);
        } elseif ($request->tipo_movimentacao === 'saida') {
            // Diminuir a quantidade no estoque do produto
            $produto->quantidade_estoque -= $request->quantidade;
            \Log::info('Nova quantidade após saída: ' . $produto->quantidade_estoque);
        }

        // Salvar a nova quantidade de estoque no banco de dados
        $produto->save();

        // Temporariamente, em vez de redirecionar, retorne uma resposta simples
        return response()->json(['message' => 'Compra salva e estoque atualizado com sucesso!']);



        
    }


    public function show($id)
    {
        $estoque = Estoque::findOrFail($id);
        return view('estoques.show', compact('estoque'));
    }

   
    public function totalEstoque()
    {
    return view('estoques.test');
    }

    public function consultaEstoque(Request $request)
{
    // Se houver uma busca, filtrar os resultados
    $search = $request->input('search');
    
    $query = Produto::query();

    if ($search) {
        $query->where('nome', 'like', '%' . $search . '%');
    }

    // Executa a query
    $produtos = $query->select('nome', 'quantidade_estoque', 'updated_at')
                      ->orderBy('quantidade_estoque', 'desc')
                      ->get();

    return view('estoques.consulta-estoque', compact('produtos'));
}


public function consulta(Request $request)
{
    $search = $request->input('search');
    $sort = $request->input('sort', 'nome'); // Ordenar por nome por padrão
    $direction = $request->input('direction', 'asc'); // Ordenar em ordem ascendente por padrão

    $produtos = Produto::query();

    // Filtro de busca por nome
    if ($search) {
        $produtos->where('nome', 'like', '%' . $search . '%');
    }

    // Adiciona ordenação
    $produtos->orderBy($sort, $direction);

    $produtos = $produtos->get();

    return view('produtos.consulta', compact('produtos'));
}


    

    
    

    
}
