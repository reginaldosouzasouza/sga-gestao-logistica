<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissao
{
    public function handle(Request $request, Closure $next, ?string $permissao = null): Response
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (!$permissao) {
            abort(403, 'Permissão não informada para esta rota.');
        }

        if (!$user->temPermissao($permissao)) {
            abort(403, 'Acesso não autorizado.');
        }

        return $next($request);
    }
}