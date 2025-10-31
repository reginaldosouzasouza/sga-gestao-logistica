<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;


class PedidoColetaController extends Controller
{
    // Exibe a página de criação do pedido de coleta
   public function create()
   {
       //  Verifica se os dados estão sendo recebidos na sessão
            Log::info('Dados na sessão: ', session()->all());

        return view('pedido_coleta.create'); // Certifique-se de que a view 'pedido_coleta.create' existe
   }

    // Armazena os dados do pedido de coleta no banco de dados
    public function store(Request $request)
    {
        // Valida os dados de entrada
        $request->validate([
            'nome' => 'required',
            'endereco' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required'
        ]);

        // Aqui você pode salvar os dados no banco
        // Exemplo:
        // PedidoColeta::create($request->all());

        return redirect()->route('pedido_coleta.create')->with('success', 'Pedido de coleta cadastrado com sucesso!');
    }
}
