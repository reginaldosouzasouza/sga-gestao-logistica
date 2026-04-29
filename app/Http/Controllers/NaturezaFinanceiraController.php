<?php

namespace App\Http\Controllers;

use App\Models\NaturezaFinanceira;
use Illuminate\Http\Request;

class NaturezaFinanceiraController extends Controller
{
    public function index()
    {
        $naturezas = NaturezaFinanceira::orderBy('nome')->get();

        return view('naturezas_financeiras.index', compact('naturezas'));
    }

    public function create()
    {
        return view('naturezas_financeiras.create');
    }

        public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100|unique:naturezas_financeiras,nome',
            'ativo' => 'nullable|boolean',
            'exibir_relatorio' => 'nullable|boolean',
            'considerar_total' => 'nullable|boolean',
        ]);

        NaturezaFinanceira::create([
            'nome' => $request->nome,
            'ativo' => $request->has('ativo') ? 1 : 0,
            'exibir_relatorio' => $request->has('exibir_relatorio') ? 1 : 0,
            'considerar_total' => $request->has('considerar_total') ? 1 : 0,
        ]);

        return redirect()
            ->route('naturezas-financeiras.index')
            ->with('success', 'Natureza financeira cadastrada com sucesso!');
    }

    public function edit($id)
    {
        $natureza = NaturezaFinanceira::findOrFail($id);

        return view('naturezas_financeiras.edit', compact('natureza'));
    }

    public function update(Request $request, $id)
    {
        $natureza = NaturezaFinanceira::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:100|unique:naturezas_financeiras,nome,' . $natureza->id,
            'ativo' => 'nullable|boolean',
            'exibir_relatorio' => 'nullable|boolean',
            'considerar_total' => 'nullable|boolean',
        ]);

        $natureza->update([
            'nome' => $request->nome,
            'ativo' => $request->has('ativo') ? 1 : 0,
            'exibir_relatorio' => $request->has('exibir_relatorio') ? 1 : 0,
            'considerar_total' => $request->has('considerar_total') ? 1 : 0,
        ]);

        return redirect()
            ->route('naturezas-financeiras.index')
            ->with('success', 'Natureza financeira atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $natureza = NaturezaFinanceira::findOrFail($id);

        /*
         * Recomendado: não excluir se já estiver vinculada a fornecedores.
         * Melhor apenas desativar.
         */
        $natureza->update([
            'ativo' => 0,
        ]);

        return redirect()
            ->route('naturezas-financeiras.index')
            ->with('success', 'Natureza financeira desativada com sucesso!');
    }
}