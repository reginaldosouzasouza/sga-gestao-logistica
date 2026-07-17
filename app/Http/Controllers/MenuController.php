<?php

namespace App\Http\Controllers;

class MenuController extends Controller
{
    /**
     * Grava o módulo na sessão e abre o menu correspondente.
     *
     * Rota:
     * GET /menu/{modulo}
     */
    public function index(string $modulo)
    {
        $usuario = auth()->user();

    



        if (!$usuario) {
            return redirect()
                ->route('login')
                ->with('error', 'Faça login para continuar.');
        }

        /*
         * Primeiro confirma se o módulo existe
         * na configuração do sistema.
         */
        $modulosConfigurados = array_keys(
            config('modulos', [])
        );

        if (!in_array($modulo, $modulosConfigurados, true)) {
            abort(
                404,
                "Módulo [{$modulo}] não encontrado."
            );
        }

        /*
         * Permissão necessária para acessar cada módulo.
         *
         * O Salão não aparece aqui porque possui uma rota
         * própria: /menu/salao.
         */
        $permissoesPorModulo = [
            'gas' => 'gas_acessar',
            'oficina' => 'oficina_acessar',
            'gerencial' => 'gerencial_acessar',
            'padoca' => 'padoca_acessar',
            'caixa' => 'financeiro_acessar',
        ];

        $permissaoNecessaria =
            $permissoesPorModulo[$modulo] ?? null;

         /*
         * MASTER acessa todos os módulos.
         *
         * Os demais usuários precisam possuir
         * a permissão correspondente em seu perfil.
         */
        if (
            !$usuario->isMaster()
            && (
                !$permissaoNecessaria
                || !$usuario->temPermissao(
                    $permissaoNecessaria
                )
            )
        ) {
            return redirect('/sga')
                ->with(
                    'error',
                    'ACESSO NÃO AUTORIZADO, contate o suporte.'
                );
        }

        /*
         * Mantido para compatibilidade com códigos antigos
         * que utilizam session('modulo_atual').
         */
        session([
            'modulo_atual' => $modulo,
        ]);

        $configuracao = config(
            "modulos.{$modulo}"
        );

        return view('menu.index', [
            'modulo' => $modulo,
            'moduloNome' => $configuracao['label'],
            'moduloCor' => $configuracao['cor'],
            'menuExtra' => $configuracao['menu'],
        ]);
    }
}