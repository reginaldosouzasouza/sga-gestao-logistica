<?php



namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    // login
    public function login(Request $request)
{
    // Validação dos campos
    $credentials = $request->validate([
        'usuario' => 'required|string',
        'password' => 'required'
    ]);

    // Verifica se o usuário existe no banco de dados
    $user = User::where('usuario', $credentials['usuario'])->first();
    if (!$user) {
        return back()->withErrors(['usuario' => 'Usuário não encontrado.']);
    }

    // Log para depuração
    \Log::info('Tentando autenticar usuário:', ['usuario' => $user->usuario]);

    // Verifica se a senha está correta
    if (!\Hash::check($credentials['password'], $user->password)) {
        \Log::warning('Senha incorreta para usuário:', ['usuario' => $user->usuario]);
        return back()->withErrors(['password' => 'Senha incorreta.']);
    }

    // Autenticação pelo campo `usuario`
    if (Auth::attempt(['usuario' => $user->usuario, 'password' => $credentials['password']])) {
        \Log::info('Usuário autenticado com sucesso!', ['usuario' => $user->usuario]);
        return redirect()->route('menu');
    }

    \Log::error('Erro inesperado no login');
    return back()->withErrors(['login' => 'Erro no login.']);
}





    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }

    // 🚀 Aqui está a função corrigida, dentro da classe
    protected function authenticated(Request $request, $user)
    {
        return redirect('menu'); // Altere para a rota correta do seu menu principal
    }
}
