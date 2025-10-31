<?php

namespace App\Http\Controllers;

use App\Models\FormaDePagamento;  // Singular
use Illuminate\Http\Request;

class FormasDePagamentoController extends Controller
{
    public function index()
    {
        $formasDePagamento = FormaDePagamento::all();
        return view('formas_de_pagamento.index', compact('formasDePagamento'));
    }

    public function create()
    {
        return view('formas_de_pagamento.create');
    }

    public function store(Request $request)
    {
        \Log::info('Store method called');
        \Log::info($request->all());

        $request->validate([
            'nome' => 'required|max:255',
        ]);

        FormaDePagamento::create($request->all());

        return redirect()->route('formas_de_pagamento.index')
                         ->with('success', 'Forma de pagamento criada com sucesso.');
    }

    public function show(FormaDePagamento $formaDePagamento)  // Corrigido para singular
    {
        return view('formas_de_pagamento.show', compact('formaDePagamento'));
    }

    public function edit($id)
    {
        $forma_pagamento = FormaDePagamento::findOrFail($id);  // Corrigido para singular
        return view('formas_de_pagamento.edit', compact('forma_pagamento'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $forma_pagamento = FormaDePagamento::findOrFail($id);  // Corrigido para singular
        $forma_pagamento->nome = $request->input('nome');
        $forma_pagamento->save();

        return redirect()->route('formas_de_pagamento.index')->with('success', 'Forma de pagamento atualizada com sucesso!');
    }

    public function destroy(FormaDePagamento $formaDePagamento)  // Corrigido para singular
    {
        $formaDePagamento->delete();

        return redirect()->route('formas_de_pagamento.index')
                         ->with('success', 'Forma de pagamento excluída com sucesso.');
    }
}
