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

        $user = User::where('usuario', $credentials['usuario'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['login' => 'Usuário ou senha inválidos.']);
        }

        Auth::attempt(['usuario' => $user->usuario, 'password' => $credentials['password']]);
        $request->session()->regenerate();

        // 👉 PÓS-LOGIN: volta para o que tentou acessar ou para /sga
        return redirect()->intended(route('sga.seletor'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // Redireciono padrão (fallback)
protected $redirectTo = '/modulos';

// Redireciono dinâmico por perfil
protected function authenticated($request, $user)
{
    if ($user->tipo_usuario === 'master') {
        return redirect()->route('modulos.index');
    }
    return redirect()->route('menu.index');
}

}
