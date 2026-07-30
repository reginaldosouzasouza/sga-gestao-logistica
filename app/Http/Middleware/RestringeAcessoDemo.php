<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestringeAcessoDemo
{
    /**
     * Restringe o ambiente público de demonstração.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $usuario = $request->user();

        /*
         * Usuários comuns seguem normalmente.
         */
        if (
            !$usuario
            || $request->session()->get('acesso_demo') !== true
        ) {
            return $next($request);
        }

        /*
         * Confirma que a sessão demo continua vinculada
         * aos registros esperados.
         */
        if (
            (int) $usuario->id !== (int) config('demo.gas.user_id')
            || (int) $usuario->empresa_id !== (int) config('demo.gas.empresa_id')
            || (int) $usuario->perfil_id !== (int) config('demo.gas.perfil_id')
        ) {
            abort(403, 'Sessão de demonstração inválida.');
        }

        /*
         * A demonstração de Gás não pode abrir outros módulos.
         */
        if ($request->routeIs('menu.index')) {
            $modulo = (string) $request->route('modulo');

            if ($modulo !== 'gas') {
                return redirect()
                    ->route('menu.index', ['modulo' => 'gas'])
                    ->with('error', 'A demonstração atual permite acesso somente ao módulo Gás e Água.');
            }
        }

        /*
         * Não permite voltar ao seletor de módulos.
         */
        if ($request->routeIs('sga.seletor')) {
            return redirect()
                ->route('menu.index', ['modulo' => 'gas']);
        }

        /*
         * Rotas e áreas administrativas sempre bloqueadas,
         * mesmo quando a URL for digitada diretamente.
         */
        $rotasBloqueadas = [
            'usuarios.*',
            'perfis.*',
            'empresas.*',
            'modulos.*',
            'backups.*',
            'configuracao-previsao-vendas.*',
            'clientes.importar*',
            'contas-pagar.importacao.*',
            'empresa-atendimento.*',
        ];

        foreach ($rotasBloqueadas as $rota) {
            if ($request->routeIs($rota)) {
                return $this->bloquear($request);
            }
        }

        /*
         * Proteção adicional por caminho, cobrindo rotas
         * antigas ou sem nome.
         */
        $prefixosBloqueados = [
            'usuarios',
            'perfis',
            'empresas',
            'modulos',
            'backups',
            'configuracao-previsao-vendas',
            'clientes/importar',
            'financeiro/contas-a-pagar/importar-despesas',
            'empresa-atendimento',
            'buscar-usuario',
        ];

        foreach ($prefixosBloqueados as $prefixo) {
            if ($request->is($prefixo) || $request->is($prefixo . '/*')) {
                return $this->bloquear($request);
            }
        }

        return $next($request);
    }

    private function bloquear(Request $request): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Esta ação não está disponível no ambiente de demonstração.',
            ], 403);
        }

        return redirect()
            ->route('menu.index', ['modulo' => 'gas'])
            ->with('error', 'Esta ação não está disponível no ambiente de demonstração.');
    }
}
