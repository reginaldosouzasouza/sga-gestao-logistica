<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermissao
{
    public function handle(Request $request, Closure $next, $permissao)
    {
        $user = auth()->user();

        if (!$user || !$user->temPermissao($permissao)) {
            abort(403, 'Acesso não autorizado.');
        }

        return $next($request);
    }
}
