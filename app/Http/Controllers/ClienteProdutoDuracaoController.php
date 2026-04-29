<?php

namespace App\Http\Controllers;

use App\Models\ClienteProdutoDuracao;
use App\Models\Cliente;
use App\Models\Produto;
use Illuminate\Http\Request;

class ClienteProdutoDuracaoController extends Controller
{
    

    public function create()
    {
        $clientes = Cliente::orderBy('nome')->get();
        $produtos = Produto::where('id', 2)->get(); // somente GÁS P-13
        return view('duracao.create', compact('clientes', 'produtos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'produto_id' => 'required|exists:produtos,id',
            'duracao'    => 'required|integer|min:1',
        ]);

        ClienteProdutoDuracao::updateOrCreate(
            [
                'cliente_id' => $request->cliente_id,
                'produto_id' => $request->produto_id,
            ],
            ['duracao' => $request->duracao]
        );

        return redirect()->route('duracao.index')
                         ->with('success', 'Duração cadastrada com sucesso!');
    }

    public function edit($id)
    {
        $duracao  = ClienteProdutoDuracao::findOrFail($id);
        $clientes = Cliente::orderBy('nome')->get();
        $produtos = Produto::where('id', 2)->get();
        return view('duracao.edit', compact('duracao', 'clientes', 'produtos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'duracao' => 'required|integer|min:1',
        ]);

        $duracao = ClienteProdutoDuracao::findOrFail($id);
        $duracao->update(['duracao' => $request->duracao]);

        return redirect()->route('duracao.index')
                         ->with('success', 'Duração atualizada com sucesso!');
    }

    public function destroy($id)
    {
        ClienteProdutoDuracao::findOrFail($id)->delete();
        return redirect()->route('duracao.index')
                         ->with('success', 'Registro removido com sucesso!');
    }

    public function index(Request $request)
    {
        $busca = $request->get('busca');

        $duracoes = ClienteProdutoDuracao::with(['cliente', 'produto'])
            ->when($busca, function ($q) use ($busca) {
                $q->whereHas('cliente', function ($q2) use ($busca) {
                    $q2->where('nome', 'like', '%' . $busca . '%');
                });
            })
            ->orderBy('cliente_id')
            ->paginate(20);

        return view('duracao.index', compact('duracoes'));
    }
}


