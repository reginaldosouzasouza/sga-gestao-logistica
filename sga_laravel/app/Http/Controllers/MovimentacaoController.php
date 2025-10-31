<?php

namespace App\Http\Controllers;

use App\Models\Produto; // Adicione esta linha para importar o modelo Produto
use App\Models\Movimentacao;
use App\Models\ContasAReceber;
use Illuminate\Http\Request;
use App\Models\MovimentacaoItem;
use Illuminate\Support\Facades\Log;
use App\Models\FormaDePagamento;
use App\Models\Prazo;
use App\Models\Estoque;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;







class MovimentacaoController extends Controller

{

    public function create() 
    {
        $cliente_id = null; // Inicialize como null
    
       // $ultimo_id = Movimentacao::max('id');
        $proximoId = Movimentacao::max('id') + 1;
        $formas_de_pagamento = FormaDePagamento::all();
        $prazos = Prazo::all();
        $produtos = Produto::orderBy('nome', 'asc')->get();

       
          
    
        return view('movimentacao.create', compact('formas_de_pagamento', 'prazos', 'proximoId', 'produtos', 'cliente_id'));
    }
        
   






    public function store(Request $request)
    {

      //Log::info('Produtos recebidos no request:', ['produtos' => $request->produtos]);


      


        $request->validate([
            'data_coleta' => 'required|date|before_or_equal:today',
            'id' => 'required',
            'nome' => 'required',
            'endereco' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'produtos' => 'required|array',
            'produtos.*.produto_id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1',
            'produtos.*.valor_unitario' => 'required|numeric|min:0',
          'forma_pagamento' => 'required|exists:formas_de_pagamento,id',

        ]);
    
        DB::beginTransaction();
        try {

             // Buscar a forma de pagamento
        $formaPagamento = FormaDePagamento::find($request->forma_pagamento);
        if (!$formaPagamento) {
            \Log::error('Forma de pagamento não encontrada para o ID: ' . $request->forma_pagamento);
            return redirect()->back()->withErrors('Forma de pagamento inválida.');
        }

        // Buscar o prazo
        $prazoSelecionado = Prazo::find($request->prazo);
        if (!$prazoSelecionado) {
            \Log::error('Prazo não encontrado para o ID: ' . $request->prazo);
            
            return redirect()->back()->withErrors('Prazo inválido ou não encontrado.');
        }

        \Log::info('Forma de pagamento: ' . $formaPagamento->nome);
        \Log::info('Prazo selecionado: ' . $prazoSelecionado->prazo);
        \Log::info('Prazo ID: ' . $prazoSelecionado->id);

            // Calcular o valor total da movimentação

            $valorTotalMovimentacao = 0;         
            foreach ($request->produtos as $item) {
                $valorTotalMovimentacao += $item['quantidade'] * $item['valor_unitario'];
            }

            $movimentacao = Movimentacao::create([
                'data_coleta' => $request->data_coleta,
                'nome' => $request->nome,
                'endereco' => $request->endereco,
                'numero' => $request->numero,
                'bairro' => $request->bairro,
                'cidade' => $request->cidade,
                'cliente_id' => $request->cliente_id,
                'observacao' => $request->observacao,
                'forma_pagamento_id' => $request->forma_pagamento,
                'prazo_id' => $prazoSelecionado->id,
                'valor_total' => $valorTotalMovimentacao,
                'quantidade' => array_sum(array_column($request->produtos, 'quantidade')),
            ]);
            
            // Pegando o ID gerado automaticamente como número da coleta
                $numeroColeta = $movimentacao->id;

    

           
            // Processar cada item vendido e atualizar o estoque corretamente
foreach ($request->produtos as $item) {
    $produto = Produto::find($item['produto_id']);

    if (!$produto) {
        $erros[] = "Produto ID {$item['produto_id']} não encontrado.";
        continue;
    }

    // Verificar se há estoque suficiente antes da saída
    if ($produto->quantidade_estoque < $item['quantidade']) {
        $erros[] = "Estoque insuficiente para o produto '{$produto->nome}'."; 
        continue;
    }

    // Criar um novo registro de saída no estoque (movimentação)
    Estoque::create([
        'produto_id' => $item['produto_id'],
        'quantidade' => -$item['quantidade'], // Saída representada como negativa
        'tipo_movimentacao' => 'saida',
        'origem' => 'venda',
        'data_movimentacao' => now(),
    ]);

    // Removido: $produto->decrement('quantidade_estoque', $item['quantidade']);
}

            

// Verificar se há produtos no request
if (!isset($request->produtos) || empty($request->produtos)) {
    \Log::error('Nenhum produto foi enviado no request.');
    return redirect()->back()->withErrors('Nenhum produto foi adicionado ao pedido.');
}

// Registrar todos os produtos recebidos para análise no log
\Log::info('Produtos recebidos no request:', ['produtos' => $request->produtos]);

// Processar cada item da movimentação
$erros = [];



foreach ($request->produtos as $index => $item) {
    \Log::info("Processando item {$index}", $item);

    $produto = Produto::find($item['produto_id']);
    
    if (!$produto) {
        $erros[] = 'Produto ID ' . $item['produto_id'] . ' não encontrado.';
        continue; // Pula para o próximo item
    }

    // Verificar o estoque do produto antes de salvar
    if ($produto->quantidade_estoque < $item['quantidade']) {
        $erros[] = 'Quantidade solicitada para o produto "' . $produto->nome . '" é maior que o estoque disponível.';
        continue; // Pula para o próximo item
    }

    try {
        // Criar um novo registro de movimentação de item para cada produto
        $novoItem = new MovimentacaoItem();
        $novoItem->movimentacao_id = $movimentacao->id;
        $novoItem->produto_id = $item['produto_id'];
        $novoItem->quantidade = $item['quantidade'];
        $novoItem->valor_unitario = $item['valor_unitario'];
        $novoItem->valor_total = $item['quantidade'] * $item['valor_unitario'];
        $novoItem->save(); // Salva o item no banco

        \Log::info('Item salvo com sucesso', ['Item ID' => $novoItem->id]);

        // Atualizar o estoque do produto dentro do loop
        $produto->quantidade_estoque -= $item['quantidade'];
        $produto->save();

        DB::commit(); // Garante que os dados são salvos

    } catch (\Exception $e) {
        \Log::error('Erro ao salvar item', [
            'Produto ID' => $item['produto_id'],
            'Mensagem' => $e->getMessage()
        ]);
        continue; // Pula para o próximo item em caso de erro
    }
}

// Se houver erros, exibir mensagem no frontend
if (!empty($erros)) {
    return redirect()->back()->withErrors($erros);
}

\Log::info('Processamento da movimentação concluído.');

        
            // Lógica adicional para PIX ou dinheiro com prazo à vista
            if (in_array(strtolower($formaPagamento->nome), ['pix', 'dinheiro']) && strtolower(trim($prazoSelecionado->prazo)) === 'avista') {
                \Log::info('Condição atendida: Criando conta como recebida.');
            }

         
        
                 /*    CONTAS A RECEBER    */

                 // Sempre criar contas a receber independente da forma de pagamento
\Log::info('Criando registro em Contas a Receber para a movimentação ID: ' . $movimentacao->id);


     

// Buscar o prazo da tabela prazos
$prazoSelecionado = Prazo::find($request->prazo);
$prazoDias = intval($prazoSelecionado ? $prazoSelecionado->prazo : 0);

// Definir status e datas conforme a forma de pagamento
if (in_array($request->forma_pagamento, [1, 2])) { // 1 = Dinheiro, 2 = PIX
    $status = 'recebido';
    $dataVencimento = $movimentacao->data_coleta; // Dinheiro e PIX são pagos no ato
    $dataRecebimento = \Carbon\Carbon::now();
} else {
    $status = 'pendente';
    $dataVencimento = \Carbon\Carbon::parse($movimentacao->data_coleta)->addDays($prazoDias);
    $dataRecebimento = null;
}

// Criar registro em contas a receber, vinculado à movimentação
ContasAReceber::create([
    'cliente_id' => $movimentacao->cliente_id,
    'descricao' => 'Venda realizada - Ordem de Coleta: ' . $movimentacao->id,
    'valor' => $movimentacao->valor_total,
    'data_venda' => $movimentacao->data_coleta,
    'data_vencimento' => Carbon::parse($dataVencimento)->format('Y-m-d'),
    'data_recebimento' => $dataRecebimento,
    'status' => $status,
    'forma_pagamento_id' => $movimentacao->forma_pagamento_id,
    'prazo' => $movimentacao->prazo_id,
]);

\Log::info('Registro de contas a receber criado com sucesso, vinculado à movimentação ID: ' . $movimentacao->id);

    
    


       DB::commit();
        return redirect()->route('movimentacao.index')->with('success', 'Movimentação salva com sucesso.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erro ao salvar itens da movimentação:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors('Erro ao salvar a movimentação.');
        }
    }   


 

    public function atualizarStatusAutomaticamente()
    {
        $contas = ContaReceber::all();
    
        foreach ($contas as $conta) {
            if (Carbon::parse($conta->data_vencimento)->isPast() && $conta->status != 'Pago') {
                $conta->status = 'Atrasado';
                $conta->save();
            }
        }
    
        return view('contas_a_receber.index', compact('contas'));
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
        $movimentacoes = Movimentacao::with('formaPagamento')->get();
        $movimentacoes = Movimentacao::with('itens');



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
