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
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;







class MovimentacaoController extends Controller

{

    public function create() 
    {
        $cliente_id = null; // Inicialize como null
    
        $ultimo_id = Movimentacao::max('id');
        $proximo_id = $ultimo_id ? $ultimo_id + 1 : 1;
        $formas_de_pagamento = FormaDePagamento::all();
        $prazos = Prazo::all();
        $produtos = Produto::orderBy('nome', 'asc')->get();
    
        return view('movimentacao.create', compact('formas_de_pagamento', 'prazos', 'proximo_id', 'produtos', 'cliente_id'));
    }
        
  


// Função store atualizada
public function store(Request $request)
{
    // Adicione um log para verificar o valor de cliente_id
    Log::info('Cliente ID recebido:', ['cliente_id' => $request->input('cliente_id')]);

    // Validação dos dados de entrada
    $validatedData = $request->validate([
        'cliente_id' => 'required|exists:clientes,id',
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

    // Adicionando o log para depurar o cliente_id
    Log::info('Criando movimentação', [
        'cliente_id' => $request->input('cliente_id'),  // Verifica o cliente_id recebido
        'data_coleta' => $request->input('data_coleta'),
        'controle_coleta' => $request->input('controle_coleta'),
        'forma_pagamento' => $request->input('forma_pagamento'),      
        'valor_total' => $request->input('valor_total')
    ]);

    
    Log::info('Cliente ID recebido:', ['cliente_id' => $request->input('cliente_id')]);

    try {
        // Iniciar transação
        DB::beginTransaction();

        // Criar a movimentação
        $movimentacao = Movimentacao::create([
            'cliente_id' => $request->input('cliente_id'), // Verifique se o cliente_id está vindo do request
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
            'quantidade' => $request->quantidade_total,
        ]);

        // Iterar pelos produtos e salvar os itens do pedido
        foreach ($request->produtos as $index => $produto_id) {
            $produto = Produto::findOrFail($produto_id);

            // Verificar quantidade solicitada e estoque mínimo
            if ($produto->quantidade_estoque < $request->quantidades[$index]) {
                $mensagemErro = 'Quantidade solicitada para o produto "' . $produto->nome . '" é maior que o estoque disponível.';
                return redirect()->back()->withErrors($mensagemErro);
            }

            if ($produto->quantidade_estoque <= $produto->estoque_minimo) {
                $mensagemErro = 'Atenção: o estoque do produto "' . $produto->nome . '" está abaixo do estoque mínimo.';
                return redirect()->back()->withErrors($mensagemErro);
            }

            // Criar item da movimentação
            MovimentacaoItem::create([
                'movimentacao_id' => $movimentacao->id,
                'produto_id' => $produto_id,
                'quantidade' => $request->quantidades[$index],
                'valor_unitario' => $request->valores_unitarios[$index],
            ]);

            // Atualizar o estoque
            $produto->quantidade_estoque -= $request->quantidades[$index];
            $produto->save();

            // Registrar a saída na tabela de estoques
            Estoque::create([
                'produto_id' => $produto_id,
                'quantidade' => $request->quantidades[$index],
                'tipo_movimentacao' => 'saida',
                'origem' => 'venda',
                'data_movimentacao' => now(),
            ]);
        }

        // Criar conta a receber se necessário
        if ($movimentacao->forma_pagamento_id != 1) {
            $this->criarContaAReceber($movimentacao);
        }

        // Commit da transação
        DB::commit();

        return redirect()->route('movimentacoes.index')->with('success', 'Movimentação criada com sucesso!');
        
         } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao criar movimentação: ', [
                'mensagem' => $e->getMessage(),
                'arquivo' => $e->getFile(),
                'linha' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
        
            
            return redirect()->back()->withErrors('OK.');
         }
        
}

// Função para criar a conta a receber (fora da função store)
protected function criarContaAReceber($movimentacao)
{
    if (!$movimentacao->cliente_id) {
        Log::error('Cliente ID não encontrado na movimentação.', [
            'movimentacao_id' => $movimentacao->id
        ]);
        return; // Evitar continuar se não houver cliente_id
    }

    // Buscar o prazo associado à movimentação
    $prazo = Prazo::find($movimentacao->prazo_id);

    // Verificar se o prazo foi encontrado e calcular a data de vencimento
    $diasPrazo = $prazo ? (int) filter_var($prazo->prazo, FILTER_SANITIZE_NUMBER_INT) : 0;
    $dataVencimento = Carbon::now()->addDays($diasPrazo);

    // Criar nova conta a receber
    $contaReceber = new \App\Models\ContasAReceber();
    $contaReceber->cliente_id = $movimentacao->cliente_id;
    $contaReceber->descricao = 'Recebimento referente à movimentação';
    $contaReceber->valor = $movimentacao->valor_total;
    $contaReceber->data_vencimento = $dataVencimento;
    $contaReceber->status = 'pendente';
    $contaReceber->forma_pagamento_id = $movimentacao->forma_pagamento_id;
    $contaReceber->observacao = $movimentacao->observacao;
    $contaReceber->save();
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
