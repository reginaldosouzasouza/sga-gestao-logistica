<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClienteController extends Controller
{
    /**
     * Retorna o ID da empresa do usuário logado.
     */
    private function empresaId()
    {
        return auth()->user()->empresa_id;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empresaId = $this->empresaId();

        $clientes = Cliente::where('empresa_id', $empresaId)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalClientes = Cliente::where('empresa_id', $empresaId)->count();

        return view('clientes.index', compact('clientes', 'totalClientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $from = $request->input('from');

        return view('clientes.create', compact('from'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Parâmetro from recebido: ', ['from' => $request->input('from')]);

        $empresaId = $this->empresaId();

        $request->validate([
            'nome' => 'required',
            'telefone' => 'required',
            'endereco' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
        ]);

        $cliente = Cliente::create([
            'empresa_id' => $empresaId,
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

        if ($request->input('from') == 'movimentacao') {
            return redirect()->route('movimentacao.create')->with([
                'cliente_id' => $cliente->id,
                'nome' => $cliente->nome,
                'telefone' => $cliente->telefone,
                'endereco' => $cliente->endereco,
                'numero' => $cliente->numero,
                'bairro' => $cliente->bairro,
                'cidade' => $cliente->cidade,
            ]);
        }

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $empresaId = $this->empresaId();

        $cliente = Cliente::where('empresa_id', $empresaId)
            ->where('id', $id)
            ->firstOrFail();

        return view('clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $empresaId = $this->empresaId();

        $cliente = Cliente::where('empresa_id', $empresaId)
            ->where('id', $id)
            ->firstOrFail();

        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $empresaId = $this->empresaId();

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

        $cliente = Cliente::where('empresa_id', $empresaId)
            ->where('id', $id)
            ->first();

        if (!$cliente) {
            return redirect()
                ->route('clientes.index')
                ->with('error', 'Cliente não encontrado!');
        }

        $cliente->update($validatedData);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!auth()->user()->temPermissao('cliente_excluir')) {
            abort(403, 'Você não tem permissão para excluir clientes.');
        }

        $empresaId = $this->empresaId();

        $cliente = Cliente::where('empresa_id', $empresaId)
            ->where('id', $id)
            ->firstOrFail();

        $cliente->delete();

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente excluído com sucesso.');
    }

    /**
     * Pesquisa clientes por nome ou telefone.
     */
    public function search(Request $request)
    {
        $empresaId = $this->empresaId();
        $query = $request->input('query');

        $clientes = Cliente::where('empresa_id', $empresaId)
            ->where(function ($q) use ($query) {
                $q->where('nome', 'LIKE', "%{$query}%")
                  ->orWhere('telefone', 'LIKE', "%{$query}%");
            })
            ->get();

        if ($clientes->isEmpty()) {
            return response()->json(['status' => 'not_found']);
        }

        return response()->json($clientes);
    }

    /**
     * Retorna detalhes de um cliente.
     */
    public function detalhes($id)
    {
        $empresaId = $this->empresaId();

        $cliente = Cliente::where('empresa_id', $empresaId)
            ->where('id', $id)
            ->first();

        if ($cliente) {
            return response()->json($cliente);
        }

        return response()->json(['status' => 'not_found']);
    }

    /**
     * Pesquisa usada por autocomplete.
     */
    public function pesquisar(Request $request)
    {
        $empresaId = $this->empresaId();
        $termo = $request->input('query');

        $clientes = Cliente::where('empresa_id', $empresaId)
            ->where(function ($q) use ($termo) {
                $q->where('nome', 'LIKE', "%{$termo}%")
                  ->orWhere('telefone', 'LIKE', "%{$termo}%");
            })
            ->get([
                'id',
                'nome',
                'telefone',
                'endereco',
                'cpf',
                'numero',
                'bairro',
                'cidade',
            ]);

        return response()->json($clientes);
    }

    /**
     * Busca clientes por nome ou telefone.
     */
    public function buscar(Request $request)
    {
        $empresaId = $this->empresaId();
        $termo = $request->input('termo');

        $clientes = Cliente::where('empresa_id', $empresaId)
            ->where(function ($q) use ($termo) {
                $q->where('nome', 'LIKE', "%{$termo}%")
                  ->orWhere('telefone', 'LIKE', "%{$termo}%");
            })
            ->get();

        return response()->json($clientes);
    }
}