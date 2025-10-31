<?php

namespace App\Http\Controllers\Padoca;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('padoca.home'); // resources/views/padoca/home.blade.php
    }
}
