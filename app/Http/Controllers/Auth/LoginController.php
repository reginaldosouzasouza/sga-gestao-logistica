<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        // Já logado? Vai direto para o seletor
        if (auth()->check()) {
            return redirect()->route('sga.seletor');
        }
        return view('auth.login');
    }

   public function login(Request $request)
{
    $credentials = $request->validate([
        'usuario'  => 'required|string',
        'password' => 'required'
    ]);

    if (!Auth::attempt($credentials)) {
        return back()->withErrors([
            'login' => 'Usuário ou senha inválidos.'
        ]);
    }

    $request->session()->regenerate();

    return redirect()->route('sga.seletor');
}

// ← REMOVA ou comente o método authenticated() inteiro
// protected function authenticated($request, $user) { ... }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    


}
