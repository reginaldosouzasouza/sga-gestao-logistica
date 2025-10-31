<?php

namespace App\Http\Controllers;

use App\Models\Produto; // Adicione esta linha para importar o modelo Produto
use App\Models\Movimentacao;
use Illuminate\Http\Request;
use App\Models\MovimentacaoItem;
use Illuminate\Support\Facades\Log;
use App\Models\FormaDePagamento;
use App\Models\Prazo;
use App\Models\Estoque;






class MovimentacaoController extends Controller

{

    public function create() 
{
    // Buscar o último ID inserido na tabela 'movimentacao'
    $ultimo_id = Movimentacao::max('id');

    // Se não houver registros, o próximo ID será 1, caso contrário, será o último ID + 1
    $proximo_id = $ultimo_id ? $ultimo_id + 1 : 1;

    // Buscar a lista de formas de pagamento, prazos e produtos no banco de dados
    
   
    $formas_de_pagamento = FormaDePagamento::all(); // Alterado para corresponder ao nome da view
    $prazos = Prazo::all();
    $produtos = Produto::orderBy('nome', 'asc')->get();

    // Definindo o cliente_id (ajuste conforme necessário)
    $cliente_id = null; // Ou defina um valor padrão ou lógica para obter o ID do cliente atual




// Enviar o próximo ID, formas de pagamento, prazos e produtos para a view


return view('movimentacao.create', compact('formas_de_pagamento', 'prazos', 'proximo_id', 'produtos', 'cliente_id'));
}

  



// Função store atualizada
public function store(Request $request)
{
    // Verificar todos os dados recebidos
   // dd($request->all());

    // Validação dos dados de entrada
    $request->validate([
       
        'data_coleta' => 'required|date|before_or_equal:today',
        'controle_coleta' => 'required',
        'nome' => 'required',
        'endereco' => 'required',
        'numero' => 'required',
        'bairro' => 'required',
        'cidade' => 'required',
        'produtos' => 'required|array',
        'produtos.*' => 'required|exists:produtos,id',
        'quantidades' => 'required|array',
        'quantidades.*' => 'required|numeric|min:1',
        'valores_unitarios' => 'required|array',
        'valores_unitarios.*' => 'required|numeric|min:0',
        'forma_pagamento' => 'required',
        'prazo' => 'required|integer',
        'valor_total' => 'required|numeric|min:0',
        'quantidade_total' => 'required|numeric|min:1',
    ]);

     
    // Verificar se os dados estão corretos no log
    Log::info('Request Data:', [
        'controle_coleta' => $request->controle_coleta,
        'produtos' => $request->produtos,
        'quantidades' => $request->quantidades,
        'valores_unitarios' => $request->valores_unitarios,
        'forma_pagamento' => $request->forma_pagamento,
        'prazo' => $request->prazo,
        'quantidade_total' => $request->quantidade_total
    ]);

    // Adicione o log aqui para verificar a quantidade_total recebida
    Log::info('Quantidade Total Recebida:', ['quantidade_total' => $request->quantidade_total]);




    // Criar a movimentação

    $movimentacao = Movimentacao::create([
       
        'data_coleta' => $request->input('data_coleta'),
        'controle_coleta' => $request->controle_coleta,
        'nome' => $request->nome,
        'endereco' => $request->endereco,
        'numero' => $request->numero,
        'bairro' => $request->bairro,
        'cidade' => $request->cidade,
        'observacao' => $request->observacao,
        'forma_pagamento_id' => $request->forma_pagamento,
        'prazo_id' => $request->prazo,
        'valor_total' => $request->valor_total,
        'quantidade' => $request->input('quantidade_total'),  // Usar o valor do campo quantidade_total
    ]);
    Log::info('Quantidade salva:', ['quantidade' => $movimentacao->quantidade]);


    Log::info('Movimentação criada', ['movimentacao_id' => $movimentacao->id]);

    // Iterar pelos produtos e salvar os itens do pedido
    foreach ($request->produtos as $index => $produto_id) {
        if (isset($request->quantidades[$index]) && isset($request->valores_unitarios[$index])) {

           // Verificar se o estoque é suficiente
           $produto = Produto::findOrFail($produto_id);

           if ($produto->quantidade_estoque < $request->quantidades[$index]) {
               // Se a quantidade solicitada for maior que o estoque disponível, retornar com erro
               return redirect()->back()->withErrors(
                  'Quantidade solicitada para o produto "' . $produto->nome .'
               " é maior que o estoque disponível.<div class="mensagem-erro"> NÃO foi possível realizar esta venda, consulte a QUANTIDADE.</div>');
           }



            // Verificar se o estoque está abaixo do mínimo
      if ($produto->quantidade_estoque <= $produto->estoque_minimo) {
          // Exibir mensagem de alerta sobre estoque baixo
          return redirect()->back()->withErrors(
              '<div class="mensagem-minimo">Atenção: o estoque do produto "' . $produto->nome . '" está abaixo do estoque mínimo (' . $produto->estoque_minimo . ' unidades).</div>');

         
          }


              
        
            
            Log::info('Salvando item da movimentação', [
                'movimentacao_id' => $movimentacao->id,
                'produto_id' => $produto_id,
                'quantidade' => $request->quantidades[$index],
                'valor_unitario' => $request->valores_unitarios[$index],
            ]);

            MovimentacaoItem::create([
                'movimentacao_id' => $movimentacao->id,
                'produto_id' => $produto_id,
                'quantidade' => $request->quantidades[$index],
                'valor_unitario' => $request->valores_unitarios[$index],
            ]);

            // Atualizar o estoque
            $produto = Produto::findOrFail($produto_id);
            $produto->quantidade_estoque -= $request->quantidades[$index];
            $produto->save();
            
             // **Registrar a saída na tabela de estoques**
             Estoque::create([
                'produto_id' => $produto_id,
                'quantidade' => $request->quantidades[$index],
                'tipo_movimentacao' => 'saida', // Indica que é uma saída do estoque
                'origem' => 'venda', // Indica que a origem é uma venda
                'data_movimentacao' => now(), // Define a data da movimentação
            ]);

        } else {
            Log::warning('Dados ausentes para o produto', [
                'produto_id' => $produto_id,
                'quantidade' => $request->quantidades[$index] ?? 'ausente',
                'valor_unitario' => $request->valores_unitarios[$index] ?? 'ausente',
            ]);
        }
    }
   
    return redirect()->route('movimentacao.index')->with('success', 'Movimentação salva com sucesso!');
}

    public function verificarEstoque(Request $request)
    {
        $produto = Produto::find($request->produto_id);

        return response()->json([
            'quantidade_estoque' => $produto->quantidade_estoque
        ]);
    }






    //FUNÇÃO DESTROY

public function destroy($id)
{
    // Buscar a movimentação pelo ID
    $movimentacao = Movimentacao::findOrFail($id);

    // Excluir os itens relacionados à movimentação primeiro
    \App\Models\MovimentacaoItem::where('movimentacao_id', $id)->delete();

    // Depois, excluir a movimentação
    $movimentacao->delete();

    // Redirecionar de volta para a lista de movimentações com uma mensagem de sucesso
    return redirect()->route('movimentacao.index')->with('success', 'Movimentação excluída com sucesso.');
}





    public function index()
    {
        // Buscar todas as movimentações
        $movimentacoes = Movimentacao::all();

            // Obter as movimentações com paginação de 30 registros por página, ordenadas pelo ID de forma crescente
                $movimentacoes = Movimentacao::orderBy('id', 'desc') // Aqui você pode ordenar por 'id', 'data_coleta' ou outro campo
                ->paginate(20); // Limite de 30 registros por págin

        // Retornar a view com as movimentações
        return view('movimentacao.index', compact('movimentacoes'));
    }

    public function show($id)
    {
        $movimentacao = Movimentacao::with('itens.produto')->findOrFail($id); // Carregar movimentação com itens e produto relacionado
        return view('movimentacao.show', compact('movimentacao'));
    }

    
        public function itens()
    {
        return $this->hasMany(MovimentacaoItem::class, 'movimentacao_id');
    }




        public function pesquisar(Request $request)
        {
            $termo = $request->input('termo');
            dd($termo);
            
            // Pesquisar movimentações pelo nome ou endereço
            $movimentacoes = Movimentacao::where('nome', 'like', "%{$termo}%")
                ->orWhere('endereco', 'like', "%{$termo}%")
                ->get();
                
            dd($movimentacoes);  // Isto irá mostrar os dados pesquisados na tela
            
            // Retornar a view com os resultados filtrados
            return view('movimentacao.index', compact('movimentacoes'));
        }

    
        



}
