<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        if (auth()->check()) {
            // 👉 Se já logado e tentar abrir /login, manda pro seletor
            return redirect()->route('sga.seletor');
        }
        return $next($request);
    }
}
