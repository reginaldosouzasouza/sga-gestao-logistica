<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(?string $mod = null)
    {
        // Se o módulo for informado, salva na sessão
        if ($mod) {
            session(['modulo_atual' => strtolower($mod)]);
        }

        // Retorna a view do menu principal
        return view('menu');
    }
}

