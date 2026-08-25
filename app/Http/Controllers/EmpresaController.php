<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
{
    public function index(Request $request)
    {
        $usuario = auth()->user();

        if (!$usuario || !$usuario->isMaster()) {
            return redirect('/sga')
                ->with('error', 'Acesso permitido somente para MASTER.');
        }

        $busca = $request->input('busca');
        $modulo = $request->input('modulo');
        $status = $request->input('status');
        $plano = $request->input('plano');

        $queryBase = Empresa::query();

        $empresas = Empresa::query()
            ->when($busca, function ($query) use ($busca) {
                $query->where(function ($q) use ($busca) {
                    $q->where('nome_fantasia', 'like', "%{$busca}%")
                        ->orWhere('razao_social', 'like', "%{$busca}%")
                        ->orWhere('cnpj', 'like', "%{$busca}%")
                        ->orWhere('cidade', 'like', "%{$busca}%")
                        ->orWhere('email', 'like', "%{$busca}%");
                });
            })
            ->when($modulo, function ($query) use ($modulo) {
                $query->where('modulo', $modulo);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($plano, function ($query) use ($plano) {
                $query->where('plano', $plano);
            })
            ->orderBy('modulo', 'asc')
            ->paginate(15)
            ->appends($request->query());

        $resumo = [
            'total' => (clone $queryBase)->count(),
            'ativas' => (clone $queryBase)->where('status', 'ativo')->count(),
            'teste' => (clone $queryBase)->where('status', 'teste')->count(),
            'bloqueadas' => (clone $queryBase)->where('status', 'bloqueado')->count(),
        ];

        return view('empresas.index', compact('empresas', 'resumo'));
    }

    public function create()
    {
        return view('empresas.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome_fantasia' => 'required|string|max:255',
            'modulo' => 'required|in:gas,salao,oficina,financas',
            'razao_social' => 'nullable|string|max:255',
            'cnpj' => 'nullable|string|max:20|unique:empresas,cnpj',
            'telefone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'endereco' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:2',
            'cep' => 'nullable|string|max:20',

            'status' => 'required|in:ativo,inativo,bloqueado,teste',

            'plano' => 'nullable|string|max:50',
            'status_assinatura' => 'nullable|in:teste,ativa,vencida,bloqueada,cancelada',
            'data_inicio_teste' => 'nullable|date',
            'data_fim_teste' => 'nullable|date',
            'data_vencimento' => 'nullable|date',
            'motivo_bloqueio' => 'nullable|string|max:255',
            'limite_usuarios' => 'nullable|integer|min:1',
            'limite_clientes' => 'nullable|integer|min:1',
        ], [
            'nome_fantasia.required' => 'Informe o nome fantasia da empresa.',
            'modulo.in' => 'Selecione um módulo válido.',
            'cnpj.unique' => 'Este CNPJ já está cadastrado.',
            'email.email' => 'Informe um e-mail válido.',
        ]);

        $validatedData['bloqueada'] = $request->has('bloqueada') ? 1 : 0;

        $validatedData['plano'] = $validatedData['plano'] ?? 'teste';
        $validatedData['status_assinatura'] = $validatedData['status_assinatura'] ?? 'teste';

        DB::transaction(function () use ($validatedData) {
            $empresa = Empresa::create($validatedData);

            $this->garantirPerfilSalao($empresa);
        });

        return redirect()
            ->route('empresas.index')
            ->with('success', 'Empresa cadastrada com sucesso.');
    }

    public function show($id)
    {
        $empresa = Empresa::findOrFail($id);

        return view('empresas.show', compact('empresa'));
    }

    public function edit($id)
    {
        $empresa = Empresa::findOrFail($id);

        return view('empresas.edit', compact('empresa'));
    }

    public function update(Request $request, $id)
    {
        $empresa = Empresa::findOrFail($id);

        $validatedData = $request->validate([
            'nome_fantasia' => 'required|string|max:255',
            'modulo' => 'required|in:gas,salao,oficina,financas',
            'razao_social' => 'nullable|string|max:255',
            'cnpj' => 'nullable|string|max:20|unique:empresas,cnpj,' . $empresa->id,
            'telefone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'endereco' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:2',
            'cep' => 'nullable|string|max:20',

            'status' => 'required|in:ativo,inativo,bloqueado,teste',

            'plano' => 'nullable|string|max:50',
            'status_assinatura' => 'nullable|in:teste,ativa,vencida,bloqueada,cancelada',
            'data_inicio_teste' => 'nullable|date',
            'data_fim_teste' => 'nullable|date',
            'data_vencimento' => 'nullable|date',
            'motivo_bloqueio' => 'nullable|string|max:255',
            'limite_usuarios' => 'nullable|integer|min:1',
            'limite_clientes' => 'nullable|integer|min:1',
        ], [
            'nome_fantasia.required' => 'Informe o nome fantasia da empresa.',
            'modulo.in' => 'Selecione um módulo válido.',
            'cnpj.unique' => 'Este CNPJ já está cadastrado.',
            'email.email' => 'Informe um e-mail válido.',
        ]);

        $validatedData['bloqueada'] = $request->has('bloqueada') ? 1 : 0;

        $validatedData['plano'] = $validatedData['plano'] ?? 'teste';
        $validatedData['status_assinatura'] = $validatedData['status_assinatura'] ?? 'teste';

        DB::transaction(function () use ($empresa, $validatedData) {
            $empresa->update($validatedData);

            $this->garantirPerfilSalao($empresa);
        });

        return redirect()
            ->route('empresas.index')
            ->with('success', 'Empresa atualizada com sucesso.');
    }

    private function garantirPerfilSalao(Empresa $empresa): void
    {
        if ($empresa->modulo !== 'salao') {
            return;
        }

        $perfil = DB::table('perfis')
            ->where('empresa_id', $empresa->id)
            ->where('modulo', 'salao')
            ->first();

        if (!$perfil) {
            $perfilId = DB::table('perfis')->insertGetId([
                'nome' => 'Administrador do Salão',
                'empresa_id' => $empresa->id,
                'modulo' => 'salao',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $perfilId = $perfil->id;
        }

        $permissoesSalao = DB::table('permissoes')
            ->where('nome', 'like', 'salao_%')
            ->pluck('id');

        foreach ($permissoesSalao as $permissaoId) {
            DB::table('perfil_permissoes')->updateOrInsert([
                'perfil_id' => $perfilId,
                'permissao_id' => $permissaoId,
            ]);
        }
    }

    public function destroy($id)
    {
        $empresa = Empresa::findOrFail($id);

        if ($empresa->id == 1) {
            return redirect()
                ->route('empresas.index')
                ->with('error', 'A empresa principal MARIGÁS não pode ser excluída.');
        }

        $empresa->delete();

        return redirect()
            ->route('empresas.index')
            ->with('success', 'Empresa excluída com sucesso.');
    }
}