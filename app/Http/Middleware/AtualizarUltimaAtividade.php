<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AtualizarUltimaAtividade
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();

            // Evita gravar no banco a cada clique. Atualiza no máximo a cada 60 segundos.
            if (!$user->last_seen_at || $user->last_seen_at->diffInSeconds(now()) >= 60) {
                $user->forceFill([
                    'last_seen_at' => now(),
                    'last_login_ip' => $request->ip(),
                    'last_user_agent' => substr((string) $request->userAgent(), 0, 1000),
                ])->save();
            }
        }

        return $next($request);
    }
}
