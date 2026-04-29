<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    // Middleware para restringir acesso
    public function __construct()
    {
        $this->middleware('auth'); // Garante que apenas usuários autenticados acessem
        $this->middleware(function ($request, $next) {
            if (auth()->user()->tipo !== 'MASTER' && auth()->user()->tipo !== 'ADMIN') {
                return redirect('/')->with('error', 'Acesso não autorizado!');
            }
            return $next($request);
        });
    }

    // Exibir a lista de usuários
    public function index()
    {
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    // Exibir o formulário de criação de usuário
    public function create()
    {
    // Obtém o próximo ID da tabela 'users'
    $nextId = User::max('id') + 1;

    return view('usuarios.create', compact('nextId'));
    }


    // Salvar um novo usuário no banco de dados
    public function store(Request $request)
{
    $request->validate([
        'usuario' => 'required|string|max:255|unique:users,usuario',
        'nome_completo' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:6',
        'tipo' => 'required|in:MASTER,ADMIN,FUNCIONARIO',
    ]);

    User::create([
        'usuario' => $request->usuario,
        'nome_completo' => $request->nome_completo,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'tipo' => $request->tipo,
    ]);

    return redirect()->route('usuarios.create')->with('success', 'Usuário criado com sucesso!');
}


    // Exibir o formulário de edição de usuário
    public function edit(User $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    // Atualizar os dados de um usuário
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'tipo' => 'required|in:MASTER,ADMIN,FUNCIONARIO',
        ]);

        $usuario->update([
            'id' => $request->id,
            'name' => $request->name,
            'email' => $request->email,
            'tipo' => $request->tipo,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    // Excluir um usuário
    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuário excluído com sucesso!');
    }

   

public function login(Request $request)
{
    Log::info('Tentativa de login', $request->all());
    
    $credentials = $request->only('codigo_usuario', 'password');

    if (auth()->attempt(['id' => $credentials['codigo_usuario'], 'password' => $credentials['password']])) {
        Log::info('Login bem-sucedido para o usuário ID: ' . auth()->user()->id);
        return redirect()->route('dashboard'); // Redireciona para a página principal
    } else {
        Log::error('Erro ao fazer login: Credenciais inválidas');
        return back()->withErrors(['message' => 'Usuário ou senha incorretos.']);
    }
}

}


