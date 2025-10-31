<?php

namespace App\Http\Controllers\Oficina;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('oficina.home');
    }
}
