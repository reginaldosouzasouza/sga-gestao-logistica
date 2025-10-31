<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckFuncionario
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica se o usuário está autenticado
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Você precisa estar logado.');
        }

        // Verifica se o tipo do usuário é FUNCIONÁRIO
        if (Auth::user()->tipo !== 'FUNCIONARIO') {
            return redirect('/')->with('error', 'Acesso não autorizado!');
        }

        return $next($request);
    }
}
