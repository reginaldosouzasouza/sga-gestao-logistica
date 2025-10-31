<?php

namespace App\Http\Controllers\Padaria;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('padaria.home');
    }
}
