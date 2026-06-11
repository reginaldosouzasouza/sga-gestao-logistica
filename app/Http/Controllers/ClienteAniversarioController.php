<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Carbon\Carbon;

class ClienteAniversarioController extends Controller
{
    public function index()
    {
        $empresaId = auth()->user()->empresa_id;

        $hoje = Carbon::today();

        $aniversariantesHoje = Cliente::where('empresa_id', $empresaId)
            ->whereNotNull('nascimento')
            ->whereMonth('nascimento', $hoje->month)
            ->whereDay('nascimento', $hoje->day)
            ->orderBy('nome')
            ->get();

        $aniversariantesMes = Cliente::where('empresa_id', $empresaId)
            ->whereNotNull('nascimento')
            ->whereMonth('nascimento', $hoje->month)
            ->orderByRaw('DAY(nascimento)')
            ->orderBy('nome')
            ->get();

        return view('clientes.aniversariantes', compact(
            'aniversariantesHoje',
            'aniversariantesMes'
        ));
    }
}