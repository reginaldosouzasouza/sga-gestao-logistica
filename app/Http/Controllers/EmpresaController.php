<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::orderBy('nome_fantasia', 'asc')->paginate(15);

        return view('empresas.index', compact('empresas'));
    }

    public function create()
    {
        return view('empresas.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome_fantasia' => 'required|string|max:255',
            'razao_social' => 'nullable|string|max:255',
            'cnpj' => 'nullable|string|max:20|unique:empresas,cnpj',
            'telefone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'endereco' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:2',
            'cep' => 'nullable|string|max:20',
            'status' => 'required|in:ativo,inativo,bloqueado,teste',
            'plano' => 'nullable|string|max:50',
            'data_inicio_teste' => 'nullable|date',
            'data_vencimento' => 'nullable|date',
        ], [
            'nome_fantasia.required' => 'Informe o nome fantasia da empresa.',
            'cnpj.unique' => 'Este CNPJ já está cadastrado.',
            'email.email' => 'Informe um e-mail válido.',
        ]);

        Empresa::create($validatedData);

        return redirect()
            ->route('empresas.index')
            ->with('success', 'Empresa cadastrada com sucesso.');
    }

    public function show($id)
    {
        $empresa = Empresa::findOrFail($id);

        return view('empresas.show', compact('empresa'));
    }

    public function edit($id)
    {
        $empresa = Empresa::findOrFail($id);

        return view('empresas.edit', compact('empresa'));
    }

    public function update(Request $request, $id)
    {
        $empresa = Empresa::findOrFail($id);

        $validatedData = $request->validate([
            'nome_fantasia' => 'required|string|max:255',
            'razao_social' => 'nullable|string|max:255',
            'cnpj' => 'nullable|string|max:20|unique:empresas,cnpj,' . $empresa->id,
            'telefone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'endereco' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:2',
            'cep' => 'nullable|string|max:20',
            'status' => 'required|in:ativo,inativo,bloqueado,teste',
            'plano' => 'nullable|string|max:50',
            'data_inicio_teste' => 'nullable|date',
            'data_vencimento' => 'nullable|date',
        ], [
            'nome_fantasia.required' => 'Informe o nome fantasia da empresa.',
            'cnpj.unique' => 'Este CNPJ já está cadastrado.',
            'email.email' => 'Informe um e-mail válido.',
        ]);

        $empresa->update($validatedData);

        return redirect()
            ->route('empresas.index')
            ->with('success', 'Empresa atualizada com sucesso.');
    }

    public function destroy($id)
    {
        $empresa = Empresa::findOrFail($id);

        if ($empresa->id == 1) {
            return redirect()
                ->route('empresas.index')
                ->with('error', 'A empresa principal MARIGÁS não pode ser excluída.');
        }

        $empresa->delete();

        return redirect()
            ->route('empresas.index')
            ->with('success', 'Empresa excluída com sucesso.');
    }
}