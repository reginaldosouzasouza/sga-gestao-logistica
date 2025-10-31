<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuleAccess
{
    /**
     * Handle an incoming request.
     * Usar nas rotas: ->middleware('module:padaria'), 'module:gas', etc.
     */
    public function handle(Request $request, Closure $next, string $module)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Guarda o módulo atual na sessão
        if (session('current_module') !== $module) {
            session(['current_module' => $module]);
        }

        // Bypass para MASTER
        if (
            (property_exists($user, 'tipo') && strtoupper((string) $user->tipo) === 'MASTER') ||
            (method_exists($user, 'hasRole') && $user->hasRole('MASTER'))
        ) {
            return $next($request);
        }

        // Checa permissões/roles possíveis
        $permNames = [
            "entrar-{$module}",
            "acesso_{$module}",
            "access-{$module}",
        ];
        foreach ($permNames as $perm) {
            if (method_exists($user, 'hasPermissionTo') && $user->hasPermissionTo($perm)) {
                return $next($request);
            }
        }

        $roleNames = [
            "mod-{$module}",
            "{$module}",
        ];
        foreach ($roleNames as $role) {
            if (method_exists($user, 'hasRole') && $user->hasRole($role)) {
                return $next($request);
            }
        }

        // Sem permissão → volta ao seletor
        return redirect()->route('sga.seletor')->with('error', "Acesso negado ao módulo: {$module}");
    }

    /**
     * Evita erro em terminateMiddleware quando o kernel tenta encerrar middlewares.
     */
    public function terminate($request, $response)
    {
        // no-op
    }
}