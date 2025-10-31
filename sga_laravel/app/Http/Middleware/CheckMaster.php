<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckMaster
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() && Auth::user()->tipo === 'MASTER') {
            return $next($request);
        }

        return redirect('/home')->with('error', 'AQUI É PROIBIDO.');
    }
}

