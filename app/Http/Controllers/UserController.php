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

    public function index(Request $request)
    {
        $busca = $request->input('busca');
        $modulo = $request->input('modulo');
        $empresaId = $request->input('empresa_id');
        $perfilId = $request->input('perfil_id');
        $tipo = $request->input('tipo');

        $query = User::leftJoin('perfis', 'perfis.id', '=', 'users.perfil_id')
            ->leftJoin('empresas', 'empresas.id', '=', 'users.empresa_id')
            ->select(
                'users.id',
                'users.usuario',
                'users.nome_completo',
                'users.email',
                'users.tipo',
                'users.empresa_id',
                'users.perfil_id',
                'perfis.nome as perfil',
                'perfis.modulo as perfil_modulo',
                'empresas.nome_fantasia as empresa',
                'empresas.modulo as modulo'
            );

        if (!$this->isMaster()) {
            $query->where('users.empresa_id', $this->empresaId());
        }

        $query
            ->when($busca, function ($query) use ($busca) {
                $query->where(function ($q) use ($busca) {
                    $q->where('users.usuario', 'like', "%{$busca}%")
                        ->orWhere('users.nome_completo', 'like', "%{$busca}%")
                        ->orWhere('users.email', 'like', "%{$busca}%")
                        ->orWhere('empresas.nome_fantasia', 'like', "%{$busca}%")
                        ->orWhere('perfis.nome', 'like', "%{$busca}%");
                });
            })
            ->when($modulo, function ($query) use ($modulo) {
                $query->where('empresas.modulo', $modulo);
            })
            ->when($empresaId, function ($query) use ($empresaId) {
                $query->where('users.empresa_id', $empresaId);
            })
            ->when($perfilId, function ($query) use ($perfilId) {
                $query->where('users.perfil_id', $perfilId);
            })
            ->when($tipo, function ($query) use ($tipo) {
                $query->where('users.tipo', $tipo);
            });

        $usuarios = $query
            ->orderByRaw("CASE empresas.modulo WHEN 'gas' THEN 1 WHEN 'oficina' THEN 2 WHEN 'salao' THEN 3 ELSE 9 END")
            ->orderBy('empresas.nome_fantasia', 'asc')
            ->orderBy('users.usuario', 'asc')
            ->paginate(15)
            ->appends($request->query());

        if ($this->isMaster()) {
            $empresas = Empresa::orderByRaw("CASE modulo WHEN 'gas' THEN 1 WHEN 'oficina' THEN 2 WHEN 'salao' THEN 3 ELSE 9 END")
                ->orderBy('nome_fantasia')
                ->get();

            $perfis = DB::table('perfis')
                ->orderByRaw("CASE modulo WHEN 'gas' THEN 1 WHEN 'oficina' THEN 2 WHEN 'salao' THEN 3 ELSE 9 END")
                ->orderBy('nome')
                ->get();
        } else {
            $empresas = Empresa::where('id', $this->empresaId())
                ->orderBy('nome_fantasia')
                ->get();

            $perfis = DB::table('perfis')
                ->where(function ($query) {
                    $query->where('empresa_id', $this->empresaId())
                        ->orWhereNull('empresa_id');
                })
                ->orderBy('nome')
                ->get();
        }

        return view('usuarios.index', compact('usuarios', 'empresas', 'perfis'));
    }

    public function monitorAcessos()
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
                'users.last_seen_at',
                'users.last_login_at',
                'users.last_login_ip',
                'users.last_user_agent',
                'perfis.nome as perfil',
                'empresas.nome_fantasia as empresa'
            );

        /*
         * MASTER enxerga todas as empresas.
         * ADMIN enxerga somente os usuários da própria empresa.
         */
        if (!$this->isMaster()) {
            $query->where('users.empresa_id', $this->empresaId());
        }

        $timezone = 'America/Sao_Paulo';

        $usuarios = $query
            ->orderByRaw('users.last_seen_at IS NULL')
            ->orderByDesc('users.last_seen_at')
            ->orderBy('empresas.nome_fantasia')
            ->orderBy('users.nome_completo')
            ->get()
            ->map(function ($usuario) use ($timezone) {
                $lastSeen = $usuario->last_seen_at;

                if (!$lastSeen) {
                    $usuario->status_acesso = 'Nunca acessou';
                    $usuario->status_classe = 'status-nunca';
                    $usuario->ultima_atividade_formatada = '-';
                    return $usuario;
                }

                $minutos = $lastSeen->diffInMinutes(now());

                if ($minutos <= 5) {
                    $usuario->status_acesso = 'Online';
                    $usuario->status_classe = 'status-online';
                } elseif ($minutos <= 30) {
                    $usuario->status_acesso = 'Inativo';
                    $usuario->status_classe = 'status-inativo';
                } else {
                    $usuario->status_acesso = 'Offline';
                    $usuario->status_classe = 'status-offline';
                }

                $usuario->ultima_atividade_formatada = $lastSeen
                    ->copy()
                    ->timezone($timezone)
                    ->format('d/m/Y H:i:s');

                return $usuario;
            });

        return view('usuarios.monitor_acessos', compact('usuarios'));
    }

    public function create()
    {
        if ($this->isMaster()) {
            $empresas = Empresa::orderByRaw("CASE modulo WHEN 'gas' THEN 1 WHEN 'oficina' THEN 2 WHEN 'salao' THEN 3 ELSE 9 END")
                ->orderBy('nome_fantasia')
                ->get();

            /*
            * O MASTER escolhe primeiro a empresa no formulário.
            * Os perfis serão filtrados também na validação do store.
            */
            $perfis = DB::table('perfis')
                ->orderByRaw("CASE modulo WHEN 'gas' THEN 1 WHEN 'oficina' THEN 2 WHEN 'salao' THEN 3 ELSE 9 END")
                ->orderBy('nome')
                ->get();
        } else {
            $empresas = Empresa::where('id', $this->empresaId())->get();

            $perfis = DB::table('perfis')
                ->where(function ($query) {
                    $query->where('empresa_id', $this->empresaId())
                        ->orWhereNull('empresa_id');
                })
                ->orderBy('nome')
                ->get();
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

        if ($request->filled('perfil_id')) {
            $perfilValido = DB::table('perfis')
                ->where('id', $request->perfil_id)
                ->where(function ($query) use ($request) {
                    $query->where('empresa_id', $request->empresa_id)
                        ->orWhereNull('empresa_id');
                })
                ->exists();

            if (!$perfilValido) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'O perfil selecionado não pertence à empresa informada.');
            }
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

        if ($this->isMaster()) {
            $perfis = DB::table('perfis')
                ->where(function ($query) use ($usuario) {
                    $query->where('empresa_id', $usuario->empresa_id)
                        ->orWhereNull('empresa_id');
                })
                ->orderByRaw("CASE modulo WHEN 'gas' THEN 1 WHEN 'oficina' THEN 2 WHEN 'salao' THEN 3 ELSE 9 END")
                ->orderBy('nome')
                ->get();

            $empresas = Empresa::orderByRaw("CASE modulo WHEN 'gas' THEN 1 WHEN 'oficina' THEN 2 WHEN 'salao' THEN 3 ELSE 9 END")
                ->orderBy('nome_fantasia')
                ->get();
        } else {
            $perfis = DB::table('perfis')
                ->where(function ($query) {
                    $query->where('empresa_id', $this->empresaId())
                        ->orWhereNull('empresa_id');
                })
                ->orderBy('nome')
                ->get();

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

        if ($request->filled('perfil_id')) {
            $perfilValido = DB::table('perfis')
                ->where('id', $request->perfil_id)
                ->where(function ($query) use ($request) {
                    $query->where('empresa_id', $request->empresa_id)
                        ->orWhereNull('empresa_id');
                })
                ->exists();

            if (!$perfilValido) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'O perfil selecionado não pertence à empresa informada.');
            }
        }

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
        Log::info('Tentativa de login', $request->except('password'));

        $credentials = $request->only('codigo_usuario', 'password');

        if (auth()->attempt(['id' => $credentials['codigo_usuario'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            auth()->user()->forceFill([
                'last_login_at' => now(),
                'last_seen_at' => now(),
                'last_login_ip' => $request->ip(),
                'last_user_agent' => substr((string) $request->userAgent(), 0, 1000),
            ])->save();

            Log::info('Login bem-sucedido para o usuário ID: ' . auth()->user()->id);
            return redirect()->route('sga');
        }

        Log::error('Erro ao fazer login: Credenciais inválidas');
        return back()->withErrors(['message' => 'Usuário ou senha incorretos.']);
    }
}