<?php

namespace App\Http\Controllers\Gerencial;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('gerencial.home');
    }
}
