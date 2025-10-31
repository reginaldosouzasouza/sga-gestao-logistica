<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckMaster
{
    public function handle(Request $request, Closure $next)
    {
        // Pega o campo tipo ou tipo_usuario do usuário logado
        $tipo = strtoupper((string) (Auth::user()->tipo ?? Auth::user()->tipo_usuario ?? ''));

        // Permite acesso apenas se for MASTER
        if (Auth::check() && $tipo === 'MASTER') {
            return $next($request);
        }

        // Caso contrário, redireciona com mensagem
        return redirect('/home')->with('error', 'AQUI É PROIBIDO.');
    }
}


