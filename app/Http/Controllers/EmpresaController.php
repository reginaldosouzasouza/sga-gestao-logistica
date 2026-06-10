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

            // Controle geral
            'status' => 'required|in:ativo,inativo,bloqueado,teste',

            // Controle SaaS
            'plano' => 'nullable|string|max:50',
            'status_assinatura' => 'nullable|in:teste,ativa,vencida,bloqueada,cancelada',
            'data_inicio_teste' => 'nullable|date',
            'data_fim_teste' => 'nullable|date',
            'data_vencimento' => 'nullable|date',
            'motivo_bloqueio' => 'nullable|string|max:255',
            'limite_usuarios' => 'nullable|integer|min:1',
            'limite_clientes' => 'nullable|integer|min:1',
        ], [
            'nome_fantasia.required' => 'Informe o nome fantasia da empresa.',
            'cnpj.unique' => 'Este CNPJ já está cadastrado.',
            'email.email' => 'Informe um e-mail válido.',
        ]);

        /*
         * Checkbox: quando desmarcado, o campo não vem no request.
         */
        $validatedData['bloqueada'] = $request->has('bloqueada') ? 1 : 0;

        /*
         * Valores padrão SaaS
         */
        $validatedData['plano'] = $validatedData['plano'] ?? 'teste';
        $validatedData['status_assinatura'] = $validatedData['status_assinatura'] ?? 'teste';

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

            // Controle geral
            'status' => 'required|in:ativo,inativo,bloqueado,teste',

            // Controle SaaS
            'plano' => 'nullable|string|max:50',
            'status_assinatura' => 'nullable|in:teste,ativa,vencida,bloqueada,cancelada',
            'data_inicio_teste' => 'nullable|date',
            'data_fim_teste' => 'nullable|date',
            'data_vencimento' => 'nullable|date',
            'motivo_bloqueio' => 'nullable|string|max:255',
            'limite_usuarios' => 'nullable|integer|min:1',
            'limite_clientes' => 'nullable|integer|min:1',
        ], [
            'nome_fantasia.required' => 'Informe o nome fantasia da empresa.',
            'cnpj.unique' => 'Este CNPJ já está cadastrado.',
            'email.email' => 'Informe um e-mail válido.',
        ]);

        /*
         * Checkbox: quando desmarcado, o campo não vem no request.
         */
        $validatedData['bloqueada'] = $request->has('bloqueada') ? 1 : 0;

        /*
         * Valores padrão SaaS
         */
        $validatedData['plano'] = $validatedData['plano'] ?? 'teste';
        $validatedData['status_assinatura'] = $validatedData['status_assinatura'] ?? 'teste';

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