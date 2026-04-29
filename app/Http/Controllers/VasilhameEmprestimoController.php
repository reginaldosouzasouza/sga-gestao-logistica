<?php

namespace App\Http\Controllers;

use App\Models\VasilhameEmprestimo;
use Illuminate\Http\Request;

class VasilhameEmprestimoController extends Controller
{
    public function index(Request $request)
    {
        $emprestimos = VasilhameEmprestimo::orderBy('data_saida', 'desc')->get();

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json($emprestimos);
        }

        return redirect()->route('controle-vasilhames.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente'                 => 'required|string|max:255',
            'produto'                 => 'nullable|string|max:255',
            'quantidade'              => 'required|integer|min:1',
            'data_saida'              => 'required|date',
            'data_previsao_devolucao' => 'nullable|date',
        ]);

        $emprestimo = VasilhameEmprestimo::create([
            'cliente'                 => $request->cliente,
            'produto'                 => $request->produto,
            'quantidade'              => $request->quantidade,
            'data_saida'              => $request->data_saida,
            'data_previsao_devolucao' => $request->data_previsao_devolucao,
            'data_devolucao'          => null,
            'status'                  => 'pendente',
            'user_id'                 => auth()->check() ? auth()->id() : 1,
        ]);

        return response()->json($emprestimo, 201);
    }

    public function registrarDevolucao(Request $request, $id)
    {
        $request->validate([
            'data_devolucao' => 'required|date',
        ]);

        $emprestimo = VasilhameEmprestimo::findOrFail($id);
        $emprestimo->update([
            'data_devolucao' => $request->data_devolucao,
            'status'         => 'devolvido',
        ]);

        return response()->json($emprestimo);
    }

    public function destroy($id)
    {
        $emprestimo = VasilhameEmprestimo::findOrFail($id);
        $emprestimo->delete();

        return response()->json(['ok' => true]);
    }
}