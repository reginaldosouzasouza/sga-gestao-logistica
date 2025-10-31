<?php
namespace App\Http\Controllers\SGA;

use App\Http\Controllers\Controller;

class SeletorController extends Controller
{
    public function index()
    {
        return view('sga.seletor');
    }
}
