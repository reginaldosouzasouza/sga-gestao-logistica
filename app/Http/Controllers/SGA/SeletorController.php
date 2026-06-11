<?php

namespace App\Http\Controllers\SGA;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Carbon\Carbon;

class SeletorController extends Controller
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

        return view('sga.seletor', compact('aniversariantesHoje'));
    }
}