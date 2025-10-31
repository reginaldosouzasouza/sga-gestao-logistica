<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\Compra;
use Illuminate\Http\Request;
use App\Models\FormaDePagamento;
use App\Models\Prazo;
use App\Models\ContasAPagar;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; // Importação correta do DB
use Carbon\Carbon;
use App\Models\Estoque; // Importa o modelo Estoque
use App\Models\ItemDeCompra;






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
        Log::info('Teste de Log - Início do método store');
        
        // Validação dos dados da compra
        $validatedData = $request->validate([
            'fornecedor_id' => 'required|exists:fornecedores,id',
            'nota_fiscal' => 'nullable|string',
            'data_compra' => 'required|date',
            'forma_pagamento_id' => 'required|exists:formas_de_pagamento,id',
            'prazo_id' => 'required|exists:prazos,id',
            'itens' => 'required|array',
            'itens.*.produto_id' => 'required|exists:produtos,id',
            'itens.*.quantidade' => 'required|integer|min:1',
            'itens.*.valor_unitario' => 'required|numeric|min:0',
            'itens.*.valor_total' => 'required|numeric|min:0',
        ]);
    
        $valorTotalCompra = array_sum(array_column($request->itens, 'valor_total'));
    
        // Obter o prazo em dias
        $prazo = Prazo::find($request->prazo_id);
        $prazoDias = intval($prazo->prazo);
    
        // Criar a compra principal
        $dataCompra = \Carbon\Carbon::parse($request->data_compra);
        $dataVencimento = $dataCompra->copy()->addDays($prazoDias);
    
        // Verificar a forma de pagamento para definir o status e a data de pagamento
        $formaPagamento = FormaDePagamento::find($request->forma_pagamento_id);
        $status = 'pendente';
        $dataPagamento = null;
    
        if (in_array(strtolower($formaPagamento->nome), ['dinheiro', 'pix'])) {
            $status = 'pago';
            $dataPagamento = $dataCompra; // Define a data de pagamento igual à data da compra
        }
    
        // Criar a compra
        $compra = Compra::create([
            'fornecedor_id' => $request->fornecedor_id,
            'nota_fiscal' => $request->nota_fiscal,
            'data_compra' => $request->data_compra,
            'data_vencimento' => $dataVencimento, 
            'data_pagamento' => $dataPagamento, 
            'status' => $status, 
            'forma_pagamento_id' => $request->forma_pagamento_id,
            'prazo_id' => $request->prazo_id,
            'total' => $valorTotalCompra,
        ]);

          
    

    
        // Processar cada item da compra e atualizar o estoque
        foreach ($request->itens as $itemData) {
            $produto = Produto::find($itemData['produto_id']);
            
            if ($produto) {
                $precoUnitario = $itemData['valor_unitario'];
                $valorTotal = $itemData['quantidade'] * $precoUnitario;
    
                /* Salvar o item da compra
                $compra->itensDeCompras()->create([
                    'produto_id' => $itemData['produto_id'],
                    'quantidade' => $itemData['quantidade'],
                    'valor_unitario' => $precoUnitario,
                    'valor_total' => $valorTotal,
                ]);*/

                  // Criar item de compra
            $itemCompra = $compra->itensDeCompras()->create([
                'produto_id' => $itemData['produto_id'],
                'quantidade' => $itemData['quantidade'],
                'valor_unitario' => $precoUnitario,
                'valor_total' => $valorTotal,
            ]);

            // Atualizar o estoque com base na compra
            Estoque::create([
                'produto_id' => $itemCompra->produto_id, // ✅ Agora existe a variável correta
                'quantidade' => $itemCompra->quantidade,
                'tipo_movimentacao' => 'entrada',
                'origem' => 'compra',
                'data_movimentacao' => now(),
            ]);
    
                // Atualizar o estoque do produto
                $produto->quantidade_estoque += $itemData['quantidade'];
                $produto->save();
            }
        }
    
        // Criar automaticamente um registro em contas a pagar
        ContasAPagar::create([
            'fornecedor_id' => $request->fornecedor_id,
            'descricao' => 'Compra de produtos',
            'valor' => $valorTotalCompra,
            'data_compra' => $request->data_compra,
            'data_vencimento' => $dataVencimento->format('Y-m-d'),
            'status' => $status,
            'forma_pagamento_id' => $request->forma_pagamento_id,
            'prazo' => $prazoDias,
            'data_pagamento' => $dataPagamento,
        ]);
    
        Log::info('Conta a pagar gerada automaticamente.');
    
        return redirect()->route('compras.index')->with('success', 'Compra salva com sucesso!');
    }
    







public function index()
    {
        
      $compras = Compra::with(['fornecedor', 'itensDeCompras.produto'])
                ->orderBy('id', 'desc')
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
        ->orWhereHas('itensDeCompras.produto', function($q) use ($query) {
            $q->where('nome', 'like', '%' . $query . '%');
        })
        ->get();

        return view('compras.index', compact('compras'));
    }

    public function edit($id)
{
    // Encontra a compra pelo ID e carrega os relacionamentos
    $compra = Compra::with('fornecedor', 'itensDeCompras.produto')->findOrFail($id);

    // Busca todos os fornecedores e produtos para exibir no select
    $fornecedores = Fornecedor::all();
    $produtos = Produto::all();

    // Retorna a view de edição, passando os dados da compra, fornecedores e produtos
    return view('compras.edit', compact('compra', 'fornecedores', 'produtos'));
}



public function update(Request $request, $id)
{
    // Validação dos dados da compra
    $validatedData = $request->validate([
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

    // Atualizar a compra principal
    $compra = Compra::findOrFail($id);

     // Atualizar a Data de Vencimento conforme o prazo
     $dataCompra = Carbon::parse($request->data_compra);
     $prazo = Prazo::find($request->prazo_id);
     $dataVencimento = $prazo ? $dataCompra->addDays((int) $prazo->prazo) : $dataCompra;


    $compra->update([
        'fornecedor_id' => $request->fornecedor_id,
        'nota_fiscal' => $request->nota_fiscal,
        'data_compra' => $request->data_compra,
        'data_vencimento' => $dataVencimento, 
        'forma_pagamento_id' => $request->forma_pagamento_id,
        'total' => array_sum(array_column($request->itens, 'valor_total')),
    ]);

    // Atualizar os itens da compra
    $compra->itensDeCompras()->delete(); // Remove itens antigos
    
    foreach ($request->itens as $itemData) {
        $compra->itensDeCompras()->create([
            'produto_id' => $itemData['produto_id'],
            'quantidade' => $itemData['quantidade'],
            'valor_unitario' => $itemData['valor_unitario'], // Agora pega o valor digitado
            'valor_total' => $itemData['quantidade'] * $itemData['valor_unitario'],
        ]);
    }

    return redirect()->route('compras.index')->with('success', 'Compra atualizada com sucesso!');
}



public function relatorioCompras(Request $request)
{
    $query = DB::table('itens_de_compras as ic')
        ->join('produtos as p', 'ic.produto_id', '=', 'p.id')
        ->join('compras as c', 'ic.compra_id', '=', 'c.id')
        ->join('fornecedores as f', 'c.fornecedor_id', '=', 'f.id')
        ->select(
            'ic.compra_id',
            'p.nome as produto',
            'ic.quantidade',
            'ic.valor_unitario',
            'ic.valor_total',
            'c.nota_fiscal',
            'f.nome as fornecedor',
            'c.data_compra'
        );

    // ** Filtro pelo Nome do Produto **
    if ($request->filled('id')) {
        $query->where('ic.compra_id', 'LIKE', '%' . $request->id . '%');
    }

    if ($request->filled('produto')) {
        $query->where('p.nome', 'LIKE', '%' . $request->produto . '%');
    }

    // ** Filtro pelo Nome do Fornecedor **
    if ($request->filled('fornecedor')) {
        $query->where('f.nome', 'LIKE', '%' . $request->fornecedor . '%');
    }

    // ** Filtro por Data Inicial **
    if ($request->filled('data_inicial')) {
        $query->whereDate('c.data_compra', '>=', $request->data_inicial);
    }

    // ** Filtro por Data Final **
    if ($request->filled('data_final')) {
        $query->whereDate('c.data_compra', '<=', $request->data_final);
    }

    // ** Ordenação primeiro pela data da compra e depois pelo ID da compra **
    $compras = $query->orderByDesc('c.data_compra')->orderByDesc('ic.compra_id')->get();

     // ** Cálculo do Total de Compras **
     $totalCompras = $compras->sum('valor_total');

     return view('relatorios.compras', compact('compras', 'totalCompras'));

   
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
