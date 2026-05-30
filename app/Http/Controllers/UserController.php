<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            if (auth()->user()->tipo !== 'MASTER' && auth()->user()->tipo !== 'ADMIN') {
                return redirect('/')->with('error', 'Acesso não autorizado!');
            }

            return $next($request);
        });
    }

    private function isMaster(): bool
    {
        return auth()->user()->tipo === 'MASTER';
    }

    private function empresaId()
    {
        return auth()->user()->empresa_id;
    }

    public function index()
    {
        $query = User::leftJoin('perfis', 'perfis.id', '=', 'users.perfil_id')
            ->leftJoin('empresas', 'empresas.id', '=', 'users.empresa_id')
            ->select(
                'users.id',
                'users.usuario',
                'users.nome_completo',
                'users.email',
                'users.tipo',
                'users.empresa_id',
                'perfis.nome as perfil',
                'empresas.nome_fantasia as empresa'
            );

        if (!$this->isMaster()) {
            $query->where('users.empresa_id', $this->empresaId());
        }

        $usuarios = $query
            ->orderBy('users.id', 'asc')
            ->get();

        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $perfis = DB::table('perfis')->orderBy('nome')->get();

        if ($this->isMaster()) {
            $empresas = Empresa::orderBy('nome_fantasia')->get();
        } else {
            $empresas = Empresa::where('id', $this->empresaId())->get();
        }

        return view('usuarios.create', compact('perfis', 'empresas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'usuario' => 'required|string|max:255|unique:users,usuario',
            'nome_completo' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'tipo' => 'required|in:MASTER,ADMIN,FUNCIONARIO',
            'perfil_id' => 'nullable|exists:perfis,id',
        ]);

        if (!$this->isMaster() && (int) $request->empresa_id !== (int) $this->empresaId()) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Você não pode criar usuário para outra empresa.');
        }

        if (!$this->isMaster() && $request->tipo === 'MASTER') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Somente o MASTER pode criar outro usuário MASTER.');
        }

        User::create([
            'empresa_id' => $request->empresa_id,
            'usuario' => $request->usuario,
            'nome_completo' => $request->nome_completo,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'tipo' => $request->tipo,
            'perfil_id' => $request->perfil_id,
        ]);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuário criado com sucesso!');
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);

        if (!$this->isMaster() && (int) $usuario->empresa_id !== (int) $this->empresaId()) {
            return redirect()
                ->route('usuarios.index')
                ->with('error', 'Você não pode editar usuário de outra empresa.');
        }

        if ($usuario->id == 1 && auth()->id() != 1) {
            return redirect()
                ->route('usuarios.index')
                ->with('error', 'O usuário MASTER é protegido e só pode ser alterado pelo próprio MASTER.');
        }

        $perfis = DB::table('perfis')->orderBy('nome')->get();

        if ($this->isMaster()) {
            $empresas = Empresa::orderBy('nome_fantasia')->get();
        } else {
            $empresas = Empresa::where('id', $this->empresaId())->get();
        }

        return view('usuarios.edit', compact('usuario', 'perfis', 'empresas'));
    }

    public function update(Request $request, User $usuario)
    {
        if (!$this->isMaster() && (int) $usuario->empresa_id !== (int) $this->empresaId()) {
            return redirect()
                ->route('usuarios.index')
                ->with('error', 'Você não pode alterar usuário de outra empresa.');
        }

        if ($usuario->id == 1 && auth()->id() != 1) {
            return redirect()
                ->route('usuarios.index')
                ->with('error', 'O usuário MASTER é protegido e só pode ser alterado pelo próprio MASTER.');
        }

        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'usuario' => 'required|string|max:255|unique:users,usuario,' . $usuario->id,
            'nome_completo' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $usuario->id,
            'password' => 'nullable|string|min:6',
            'tipo' => 'required|in:MASTER,ADMIN,FUNCIONARIO',
            'perfil_id' => 'nullable|exists:perfis,id',
        ]);

        if (!$this->isMaster() && (int) $request->empresa_id !== (int) $this->empresaId()) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Você não pode vincular usuário a outra empresa.');
        }

        if (!$this->isMaster() && $request->tipo === 'MASTER') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Somente o MASTER pode definir usuário como MASTER.');
        }

        $dados = [
            'empresa_id' => $request->empresa_id,
            'usuario' => $request->usuario,
            'nome_completo' => $request->nome_completo,
            'email' => $request->email,
            'tipo' => $request->tipo,
            'perfil_id' => $request->perfil_id,
        ];

        if ($request->filled('password')) {
            $dados['password'] = bcrypt($request->password);
        }

        $usuario->update($dados);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (!$this->isMaster() && (int) $user->empresa_id !== (int) $this->empresaId()) {
            return redirect()
                ->route('usuarios.index')
                ->with('error', 'Você não pode excluir usuário de outra empresa.');
        }

        if ($user->id == 1 || $user->tipo === 'MASTER') {
            return redirect()
                ->route('usuarios.index')
                ->with('error', 'O usuário MASTER não pode ser excluído.');
        }

        $user->delete();

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuário excluído.');
    }

    public function login(Request $request)
    {
        Log::info('Tentativa de login', $request->all());

        $credentials = $request->only('codigo_usuario', 'password');

        if (auth()->attempt(['id' => $credentials['codigo_usuario'], 'password' => $credentials['password']])) {
            Log::info('Login bem-sucedido para o usuário ID: ' . auth()->user()->id);
            return redirect()->route('sga');
        }

        Log::error('Erro ao fazer login: Credenciais inválidas');
        return back()->withErrors(['message' => 'Usuário ou senha incorretos.']);
    }
}