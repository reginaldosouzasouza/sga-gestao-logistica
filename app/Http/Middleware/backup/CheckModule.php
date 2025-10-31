<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModule
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $module): Response
    {
        $user = $request->user();

        // Verifica se o usuário está autenticado
        if (!$user) {
            return redirect()->route('login');
        }

        // Armazena o módulo atual na sessão
        session(['current_module' => $module]);

        // OPÇÃO 1: Se você tem uma coluna 'module' na tabela users
        // if ($user->module !== $module) {
        //     abort(403, 'Você não tem permissão para acessar este módulo.');
        // }

        // OPÇÃO 2: Se você tem uma relação many-to-many (users_modules)
        // if (!$user->hasModule($module)) {
        //     abort(403, 'Você não tem permissão para acessar este módulo.');
        // }

        // OPÇÃO 3: Se você usa um campo JSON ou array na tabela users
        // $allowedModules = $user->modules ?? []; // campo 'modules' no banco
        // if (!in_array($module, $allowedModules)) {
        //     abort(403, 'Você não tem permissão para acessar este módulo.');
        // }

        // TEMPORÁRIO: Permite acesso a todos os módulos
        // Remova esta linha quando implementar a verificação acima
        return $next($request);
    }

    /**
     * Handle tasks after the response has been sent to the browser.
     */
    public function terminate(Request $request, Response $response): void
    {
        // Você pode adicionar lógica de log aqui se necessário
    }
}