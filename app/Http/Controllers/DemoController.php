<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemoController extends Controller
{
    /**
     * Acesso público à demonstração do módulo Gás e Água.
     */
    public function gas(Request $request)
    {
        /*
         * Evita substituir uma sessão real já autenticada.
         * Para testar enquanto estiver logado, use uma janela anônima.
         */
        if (Auth::check()) {
            return redirect()
                ->route('sga.seletor')
                ->with(
                    'error',
                    'Você já está autenticado. Para abrir a demonstração, use uma janela anônima ou saia do sistema.'
                );
        }

        $usuarioId = (int) config('demo.gas.user_id');
        $empresaId = (int) config('demo.gas.empresa_id');
        $perfilId = (int) config('demo.gas.perfil_id');

        $usuario = User::with(['empresa', 'perfil'])
            ->whereKey($usuarioId)
            ->where('empresa_id', $empresaId)
            ->where('perfil_id', $perfilId)
            ->first();

        if (!$usuario) {
            abort(503, 'A demonstração do sistema está temporariamente indisponível.');
        }

        if (!$usuario->empresa) {
            abort(503, 'A empresa de demonstração não foi encontrada.');
        }

        if (!$usuario->temPermissao('gas_acessar')) {
            abort(403, 'O usuário de demonstração não possui acesso ao módulo Gás e Água.');
        }

        Auth::login($usuario, false);

        /*
         * Impede fixação de sessão e cria uma sessão independente
         * para cada navegador/visitante.
         */
        $request->session()->regenerate();

        $request->session()->put([
            'modulo_atual' => 'gas',
            'acesso_demo' => true,
            'demo_modulo' => 'gas',
        ]);

        return redirect()
            ->route('menu.index', ['modulo' => 'gas'])
            ->with(
                'status',
                'Você está em um ambiente demonstrativo compartilhado. Os dados são fictícios e podem ser alterados por outros visitantes.'
            );
    }
}
