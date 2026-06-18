<?php

namespace App\Http\Controllers;

use App\Models\VasilhameEmprestimo;
use Illuminate\Http\Request;

class VasilhameEmprestimoController extends Controller
{
    private function empresaId()
    {
        return empresaAtualId();
    }

  public function index(Request $request)
{
    $empresaId = $this->empresaId();

    $dataLimite = now()->subDays(5)->toDateString();

    $emprestimos = VasilhameEmprestimo::where('empresa_id', $empresaId)
        ->where(function ($query) use ($dataLimite) {
            $query->where('status', 'pendente')
                ->orWhere(function ($q) use ($dataLimite) {
                    $q->where('status', 'devolvido')
                        ->where(function ($sub) use ($dataLimite) {
                            $sub->whereNull('data_devolucao')
                                ->orWhereDate('data_devolucao', '>', $dataLimite);
                        });
                });
        })
        ->orderByRaw("CASE WHEN status = 'pendente' THEN 0 ELSE 1 END")
        ->orderBy('data_saida', 'desc')
        ->get();

    $totalEmprestadosPendentes = VasilhameEmprestimo::where('empresa_id', $empresaId)
        ->where('status', 'pendente')
        ->sum('quantidade');

    if ($request->expectsJson() || $request->wantsJson()) {
        return response()->json([
            'emprestimos' => $emprestimos,
            'totalEmprestadosPendentes' => $totalEmprestadosPendentes,
        ]);
    }

    return redirect()->route('controle-vasilhames.index');
}

    public function store(Request $request)
    {
        $empresaId = $this->empresaId();

        $request->validate([
            'cliente'                 => 'required|string|max:255',
            'produto'                 => 'nullable|string|max:255',
            'quantidade'              => 'required|integer|min:1',
            'data_saida'              => 'required|date',
            'data_previsao_devolucao' => 'nullable|date',
        ]);

        $emprestimo = VasilhameEmprestimo::create([
            'empresa_id'              => $empresaId,
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
        $empresaId = $this->empresaId();

        $request->validate([
            'data_devolucao' => 'required|date',
        ]);

        $emprestimo = VasilhameEmprestimo::where('empresa_id', $empresaId)
            ->where('id', $id)
            ->firstOrFail();

        $emprestimo->update([
            'data_devolucao' => $request->data_devolucao,
            'status'         => 'devolvido',
        ]);

        return response()->json($emprestimo);
    }

    public function destroy($id)
    {
        $empresaId = $this->empresaId();

        $emprestimo = VasilhameEmprestimo::where('empresa_id', $empresaId)
            ->where('id', $id)
            ->firstOrFail();

        $emprestimo->delete();

        return response()->json(['ok' => true]);
    }
}