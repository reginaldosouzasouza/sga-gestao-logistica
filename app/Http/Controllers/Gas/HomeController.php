<?php

namespace App\Http\Controllers\Gas;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('gas.home');
    }
}
