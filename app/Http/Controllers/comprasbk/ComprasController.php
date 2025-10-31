<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\Compra;
use Illuminate\Http\Request;
use App\Models\FormaDePagamento;
use App\Models\Prazo;
use App\Moldes\ContasAPagar;





class ComprasController extends Controller
{
  
    public function create()
    {
        $fornecedores = Fornecedor::all();
        $produtos = Produto::orderBy('nome', 'asc')->get();
        $formas_pagamento = FormaDePagamento::all();
        $prazos = Prazo::orderByRaw("FIELD(prazo, 'À vista', '1 dia', '5 dias', '15 dias', '20 dias', '30 dias')")->get();

       
    
        return view('compras.create', compact('fornecedores', 'produtos', 'formas_pagamento', 'prazos'));
    }  
    





    public function store(Request $request)
{
   // Exibir todos os dados recebidos para análise
 //  dd($request->all());


    // Validação dos dados
    $validatedData = $request->validate([
        'fornecedor_id' => 'required|exists:fornecedores,id',
        'produto_id' => 'required|exists:produtos,id',
        'quantidade' => 'required|integer',
        'preco_unitario' => 'required|numeric',
        'total' => 'required|numeric',
        'nota_fiscal' => 'nullable|string',
        'prazo_id' => 'required|exists:prazos,id',
        'data_compra' => 'required|date',
        'forma_pagamento_id' => 'required|exists:formas_de_pagamento,id', // Validação correta
    ]);

    // Garantindo que o forma_pagamento_id seja adicionado corretamente ao array validatedData
    $validatedData['forma_pagamento_id'] = $request->input('forma_pagamento_id');

    // Salvando a compra no banco de dados
    $compra = Compra::create($validatedData);

    // Continuando com o resto do código...
    \DB::table('estoques')->insert([
        'produto_id' => $request->produto_id,
        'quantidade' => $request->quantidade,
        'tipo_movimentacao' => 'entrada',
        'origem' => 'compra',
        'data_movimentacao' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Atualizando a quantidade de estoque do produto na tabela de produtos
    $produto = Produto::find($request->produto_id);

    if ($produto) {
        $produto->quantidade_estoque += $request->quantidade;
        $produto->save();
    }


         // Obter a data de compra 
    $dataCompra = \Carbon\Carbon::parse($compra->data_compra);
    
       // Calcular a data de vencimento com base no prazo
       $prazo = Prazo::find($request->prazo_id);
       $diasPrazo = (int) filter_var($prazo->prazo, FILTER_SANITIZE_NUMBER_INT);
       $dataVencimento = $dataCompra->copy()->addDays($diasPrazo);
   
       // Verificar se a data de vencimento é menor que a data atual
       $status = $dataVencimento->lessThan(now()) ? 'atrasado' : 'pendente';
    

    // Criando uma conta a pagar se a compra for a prazo
    $prazo = Prazo::find($request->prazo_id);
    if ($prazo && $prazo->prazo !== 'À vista') {

        $dataVencimento = now()->addDays((int) filter_var($prazo->prazo, FILTER_SANITIZE_NUMBER_INT));

        \App\Models\ContasAPagar::create([
            'fornecedor_id' => $request->fornecedor_id,
            'descricao' => 'Compra de ' . $produto->nome,
            'valor' => $request->total,
            'data_vencimento' => $dataVencimento,
            'data_compra' => $compra->data_compra, // Adicionando a data_compra
            'forma_pagamento_id' => $request->forma_pagamento_id, // Utilizando o valor corretamente
            'status' => $status,
        ]);
    }

    return redirect()->route('compras.index')->with('success', 'Compra salva com sucesso, estoque atualizado e conta a pagar criada!');
}

    public function index()
    {
        
      $compras = Compra::with(['fornecedor', 'produto'])
                ->orderBy('data_compra', 'desc')
                ->get();
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

public function update(Request $request, $id)
{
    // Validação dos dados recebidos
    $validatedData = $request->validate([
        'fornecedor_id' => 'required|exists:fornecedores,id',
        'produto_id' => 'required|exists:produtos,id',
        'quantidade' => 'required|integer',
        'preco_unitario' => 'required|numeric',
        'total' => 'required|numeric',
        'nota_fiscal' => 'nullable|string',
        'prazo_id' => 'required|exists:prazos,id',
        'data_compra' => 'required|date',
        'forma_pagamento_id' => 'required|exists:formas_de_pagamento,id',
    ]);

    // Encontrar a compra pelo ID
    $compra = Compra::findOrFail($id);

    // Atualizar os dados da compra
    $compra->update($validatedData);

    // Redirecionar para a lista de compras com uma mensagem de sucesso
    return redirect()->route('compras.index')->with('success', 'Compra atualizada com sucesso!');
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
