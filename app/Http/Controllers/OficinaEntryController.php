<?php

namespace App\Http\Controllers;

class OficinaEntryController extends Controller
{
    public function index()
    {
        // Troque pela sua view/tela real da Oficina
        return view('oficina.home');
    }
}

