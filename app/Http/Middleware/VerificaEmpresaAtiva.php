<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificaEmpresaAtiva
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return $next($request);
        }

        $isMaster = strtoupper(trim($user->tipo ?? '')) === 'MASTER';

        if ($isMaster) {
            return $next($request);
        }

        $empresa = $user->empresa;

        if (!$empresa) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')
                ->with('error', 'Empresa não identificada. Contate o suporte.');
        }

        $status = strtolower(trim($empresa->status ?? ''));

        if (in_array($status, ['bloqueado', 'inativo'])) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')
                ->with('error', 'ACESSO BLOQUEADO. Contate o suporte.');
        }

        return $next($request);
    }
}