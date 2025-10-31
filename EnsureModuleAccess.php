<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureModuleAccess
{
    public function handle(Request $request, Closure $next, string $module): Response
    {
        if (session('current_module') !== $module) {
            session(['current_module' => $module]);
        }

        $perm = "acesso_{$module}";
        if (!$request->user() || !$request->user()->can($perm)) {
            abort(403, 'Você não tem permissão para este módulo.');
        }

        return $next($request);
    }
}
