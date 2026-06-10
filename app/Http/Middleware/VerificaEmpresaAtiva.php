<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VerificaEmpresaAtiva
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return $next($request);
        }

        /*
         * MASTER nunca deve ser bloqueado.
         */
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

        $hoje = Carbon::today();

        $statusEmpresa = strtolower(trim($empresa->status ?? ''));
        $statusAssinatura = strtolower(trim($empresa->status_assinatura ?? ''));
        $bloqueada = (bool) ($empresa->bloqueada ?? false);

        /*
         * 1. Bloqueio manual pelo campo bloqueada
         */
        if ($bloqueada) {
            return $this->bloquearAcesso($request, $empresa->motivo_bloqueio ?: 'ACESSO BLOQUEADO. Contate o suporte.');
        }

        /*
         * 2. Bloqueio por status geral da empresa
         */
        if (in_array($statusEmpresa, ['bloqueado', 'inativo'])) {
            return $this->bloquearAcesso($request, 'ACESSO BLOQUEADO. Contate o suporte.');
        }

        /*
         * 3. Bloqueio por status da assinatura
         */
        if (in_array($statusAssinatura, ['bloqueada', 'cancelada'])) {
            return $this->bloquearAcesso($request, 'Assinatura bloqueada ou cancelada. Contate o suporte.');
        }

        /*
         * 4. Bloqueio automático por fim do teste
         * Só aplica quando a empresa estiver em status teste.
         */
        if (
            $statusEmpresa === 'teste' &&
            $empresa->data_fim_teste &&
            Carbon::parse($empresa->data_fim_teste)->lt($hoje)
        ) {
            $this->marcarEmpresaComoBloqueada($empresa, 'Período de teste vencido.');

            return $this->bloquearAcesso($request, 'Período de teste vencido. Contate o suporte.');
        }

        /*
         * 5. Bloqueio automático por vencimento da assinatura
         * Se venceu ontem ou antes, bloqueia.
         * Se vence hoje, ainda deixa acessar.
         */
        if (
            $empresa->data_vencimento &&
            Carbon::parse($empresa->data_vencimento)->lt($hoje)
        ) {
            $this->marcarEmpresaComoBloqueada($empresa, 'Assinatura vencida.');

            return $this->bloquearAcesso($request, 'Assinatura vencida. Contate o suporte.');
        }

        return $next($request);
    }

    private function bloquearAcesso(Request $request, string $mensagem)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('error', $mensagem);
    }

    private function marcarEmpresaComoBloqueada($empresa, string $motivo): void
    {
        $empresa->update([
            'status' => 'bloqueado',
            'status_assinatura' => 'bloqueada',
            'bloqueada' => 1,
            'motivo_bloqueio' => $motivo,
        ]);
    }
}