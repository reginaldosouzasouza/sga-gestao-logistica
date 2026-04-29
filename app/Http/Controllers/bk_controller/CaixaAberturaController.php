<?php

namespace App\Http\Controllers;

use App\Models\FechamentoCaixa;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CaixaAberturaController extends Controller
{
    /* ============================================
       TELA DE ABERTURA DE CAIXA
    ============================================ */
    public function abrir()
    {
        $hoje = Carbon::today()->toDateString();

        // Se já existe fechamento HOJE, não pode abrir novamente
        if (FechamentoCaixa::whereDate('data', $hoje)->exists()) {
            return redirect()
                ->route('caixa.index')
                ->withErrors('O caixa do dia de hoje já foi fechado.');
        }

        // Último fechamento (obrigatório para abertura)
        $ultimoFechamento = FechamentoCaixa::orderBy('data', 'desc')->first();

        if (!$ultimoFechamento) {
            return redirect()
                ->route('caixa.index')
                ->withErrors('Não existe fechamento anterior para abrir o caixa.');
        }

        return view('caixa.abrir', compact('ultimoFechamento'));
    }

    /* ============================================
       CONFIRMA ABERTURA
    ============================================ */
    public function confirmar(Request $request)
    {
        $hoje = Carbon::today()->toDateString();

        // Segurança: impede abrir se já fechou hoje
        if (FechamentoCaixa::whereDate('data', $hoje)->exists()) {
            return redirect()
                ->route('caixa.index')
                ->withErrors('O caixa do dia de hoje já foi fechado.');
        }

        // Marca abertura do caixa (controle simples via sessão)
        session()->put('caixa_aberto', true);
        session()->put('data_caixa_aberto', $hoje);

        return redirect()
            ->route('caixa.index')
            ->with('success', 'Caixa aberto com sucesso.');
    }
}
