<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\Compra;
use Illuminate\Http\Request;
use App\Models\FormaDePagamento;
use App\Models\Prazo;





class ComprasController extends Controller
{
    public function create()
    {
        $fornecedores = Fornecedor::all();
        $produtos = Produto::orderBy('nome', 'asc')->get();
        $formas_pagamento = FormaDePagamento::all();
        $prazos = Prazo::orderByRaw("FIELD(prazo, 'À vista', '1 dia', '5 dias', '15 dias', '20 dias', '30 dias')")->get();

       // $prazos = Prazo::all(); // Buscar prazos de pagamento
       //dd($prazos);
    
        return view('compras.create', compact('fornecedores', 'produtos', 'formas_pagamento', 'prazos'));
    }
    


    public function store(Request $request)
    {
        $validated = $request->validate([
            'fornecedor_id' => 'required',
            'produto_id' => 'required',
            'quantidade' => 'required|numeric',
            'preco_unitario' => 'required|numeric',
            'nota_fiscal' => 'nullable|string',
            'data_compra' => 'required|date',
            'observacao' => 'nullable|string',
            'forma_pagamento' => 'required',
            'prazo_id' => 'required',
        ]);
    
        // Calculando o valor total
        $validated['total'] = $request->quantidade * $request->preco_unitario;
    
        // Inserindo a compra no banco de dados
        Compra::create($validated);
    
        return redirect()->route('compras.index')->with('success', 'Compra cadastrada com sucesso!');
    }

    public function index()
    {
    $compras = Compra::with(['fornecedor', 'produto'])->get();
  //  dd($compras);  Verifica se os dados dos fornecedores e produtos estão sendo carregados corretamente
    return view('compras.index', compact('compras'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        // Buscar por Fornecedor ou Produto
        $compras = Compra::whereHas('fornecedor', function($q) use ($query) {
            $q->where('nome', 'like', '%' . $query . '%');
        })
        ->orWhereHas('produto', function($q) use ($query) {
            $q->where('nome', 'like', '%' . $query . '%');
        })
        ->get();

        return view('compras.index', compact('compras'));
    }

    public function edit($id)
{
    // Encontra a compra pelo ID e carrega os relacionamentos
    $compra = Compra::with('fornecedor', 'produto')->findOrFail($id);

    // Busca todos os fornecedores e produtos para exibir no select
    $fornecedores = Fornecedor::all();
    $produtos = Produto::all();

    // Retorna a view de edição, passando os dados da compra, fornecedores e produtos
    return view('compras.edit', compact('compra', 'fornecedores', 'produtos'));
}

public function destroy($id)
{
    // Encontre a compra pelo ID
    $compra = Compra::findOrFail($id);

    // Exclua a compra
    $compra->delete();

    // Redirecione para a lista de compras com uma mensagem de sucesso
    return redirect()->route('compras.index')->with('success', 'Compra excluída com sucesso.');
}





    

}
