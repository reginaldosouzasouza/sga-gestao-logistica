<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Models\PedidoDeColeta;
use Illuminate\Support\Facades\Log;



class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtém todos os clientes do banco de dados
        $clientes = Cliente::all();
        $totalClientes = Cliente::count(); //conta o numero de total de clientes

       

        
        // Retorna a view 'clientes.index' com os dados dos clientes
        return view('clientes.index', compact('clientes', 'totalClientes'));
    }

    /**
     * Show the form for creating a new resource.
     */

     public function create(Request $request)
    {
        $from = $request->input('from'); // Pegando o valor do parâmetro 'from'
        return view('clientes.create', compact('from')); // Passando o valor para a view
    }


    /**
     * Store a newly created resource in storage.
     */

     public function store(Request $request)
    {
         // Log para verificar o valor do parâmetro 'from'
        Log::info('Parâmetro from recebido: ', ['from' => $request->input('from')]);


        // Validação dos campos do cliente
        $request->validate([
            'nome' => 'required',
            'telefone' => 'required',
            'endereco' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
        ]);

       

        // Criação do novo cliente
        $cliente = Cliente::create([
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'endereco' => $request->endereco,
            'numero' => $request->numero,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'cpf' => $request->cpf,
            'email' => $request->email,
            'nascimento' => $request->nascimento,
            'observacao' => $request->observacao,
        ]);
     

        // Verificar se o usuário veio da tela de movimentação
        if ($request->input('from') == 'movimentacao') {
            // Redirecionar de volta para a tela de movimentação com os dados do cliente
            return redirect()->route('movimentacao.create')->with([
                'cliente_id' => $cliente->id,
                'nome' => $cliente->nome,
                'telefone' => $cliente->telefone,
                'endereco' => $cliente->endereco,
                'numero' => $cliente->numero,
                'bairro' => $cliente->bairro,
                'cidade' => $cliente->cidade
            ]);
        }

                // Verificar se o cadastro foi feito a partir da tela de pedidos de coleta
            /*   if ($request->input('from') == 'pedido_coleta') {
               Log::info('Redirecionando para a página de pedidos de coleta...');


                // Redirecionar de volta para a página de pedidos de coleta                
                return redirect()->route('pedido_coleta.create')->with([
                'cliente_id' => $cliente->id,
                'nome' => $cliente->nome,
                'telefone' => $cliente->telefone,
                'endereco' => $cliente->endereco,
                'numero' => $cliente->numero,
                'bairro' => $cliente->bairro,
                'cidade' => $cliente->cidade,
            ]);with('success', 'Cliente cadastrado com sucesso!');
        }*/

        // Se o cadastro veio de outra tela, redirecionar normalmente
        return redirect()->route('clientes.index')->with('success', 'Cliente cadastrado com sucesso!');
        }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Encontra o cliente pelo ID
        $cliente = Cliente::findOrFail($id);
        
        // Retorna a view para mostrar o cliente
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Encontra o cliente pelo ID
        $cliente = Cliente::findOrFail($id);
        
        // Retorna a view para editar o cliente
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    
     public function update(Request $request, $id)
     {
         // Valida os dados do formulário
         $validatedData = $request->validate([
             'telefone' => 'required',
             'cpf' => 'nullable|string',
             'nome' => 'required|max:255',
             'endereco' => 'required',
             'numero' => 'required|string|max:255',
             'bairro' => 'required',
             'cidade' => 'required',
             'email' => 'nullable|email',
             'nascimento' => 'nullable|date',
             'observacao' => 'nullable|string',
         ]);
     
         // Encontra o cliente pelo ID
         $cliente = Cliente::find($id);
     
         // Verifica se o cliente foi encontrado
         if (!$cliente) {
             return redirect()->route('clientes.index')->with('error', 'Cliente não encontrado!');
         }
     
         // Atualiza o cliente com os dados validados
         $cliente->update($validatedData);
     
         return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso!');
     }
     
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Encontra o cliente pelo ID e exclui
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        // Redireciona para a lista de clientes com uma mensagem de sucesso
        return redirect()->route('clientes.index')->with('success', 'Cliente excluído com sucesso!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
    
        // Procura clientes pelo nome ou telefone
        $clientes = Cliente::where('nome', 'LIKE', "%{$query}%")
                    ->orWhere('telefone', 'LIKE', "%{$query}%")
                    ->get();
    
        // Se não encontrar, retorna status 'not_found'
        if ($clientes->isEmpty()) {
            return response()->json(['status' => 'not_found']);
        }
    
        // Caso contrário, retorna os clientes encontrados
        return response()->json($clientes);
    }
    
    public function detalhes($id)
    {
        // Procura o cliente pelo ID e retorna os dados
        $cliente = Cliente::find($id);
    
        if ($cliente) {
            return response()->json($cliente);
        }
    
        return response()->json(['status' => 'not_found']);
    }


    public function pesquisar(Request $request)
{
    // Capturar o termo pesquisado
    $termo = $request->input('query');

    // Buscar clientes cujo nome ou telefone contenham o termo pesquisado
    $clientes = Cliente::where('nome', 'LIKE', "%{$termo}%")
                        ->orWhere('telefone', 'LIKE', "%{$termo}%")
                        ->get(['id', 'nome', 'telefone', 'endereco', 'cpf', 'numero', 'bairro', 'cidade']); // Incluindo os novos campos

    // Retornar os dados em formato JSON
    return response()->json($clientes);
}

    
    
public function buscar(Request $request)
{
    $termo = $request->input('termo');

    // Buscar clientes pelo nome ou telefone
    $clientes = Cliente::where('nome', 'like', "%{$termo}%")
        ->orWhere('telefone', 'like', "%{$termo}%")
        ->get();

    return response()->json($clientes);
}  

    




}
