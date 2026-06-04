<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Grava o módulo na session e redireciona para a view do menu.
     * Rota: GET /menu/{modulo}
     *
     * O módulo é passado pela URL → sem conflito de session entre abas,
     * pois cada aba carrega sua própria URL com o módulo explícito.
     */
    public function index(string $modulo)
    {
        // Valida módulos permitidos

        
        $user = auth()->user();

        $isMaster = $user && strtoupper(trim($user->tipo ?? '')) === 'MASTER';

        $modulosPermitidosParaCliente = ['gas'];

        if (!$isMaster && !in_array($modulo, $modulosPermitidosParaCliente)) {
            return redirect('/sga')
                ->with('error', 'ACESSO NÃO AUTORIZADO, contate o suporte.');
        }

        $permitidos = array_keys(config('modulos'));

        if (!in_array($modulo, $permitidos)) {
            abort(404, "Módulo [{$modulo}] não encontrado.");
        }

        // Grava na session SOMENTE para compatibilidade com código legado
        // que ainda usa session('modulo_atual')
        session(['modulo_atual' => $modulo]);

        // Carrega config do módulo
        $cfg = config("modulos.{$modulo}");

        return view('menu.index', [
            'modulo'    => $modulo,          // ex: 'oficina'
            'moduloNome'=> $cfg['label'],    // ex: 'Oficina'
            'moduloCor' => $cfg['cor'],      // ex: 'mod-oficina'
            'menuExtra' => $cfg['menu'],     // itens extras do módulo
        ]);
    }
}
