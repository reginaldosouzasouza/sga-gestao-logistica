<?php

namespace App\Http\Controllers;

use App\Models\Motorista;
use Illuminate\Http\Request;

class MotoristaController extends Controller
{
    public function index(Request $request)
    {
        $empresaId = empresaAtualId();
        $query = Motorista::query();

        if ($empresaId) {
            $query->where('empresa_id', $empresaId);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('telefone', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%")
                  ->orWhere('cnh', 'like', "%{$search}%");
            });
        }

        $motoristas = $query
            ->orderBy('nome')
            ->paginate(10);

        $totalMotoristas = $query->count();

        return view('motoristas.index', compact('motoristas', 'totalMotoristas'));
    }

    public function create()
    {
        return view('motoristas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'nullable|string|max:30',
            'cpf' => 'nullable|string|max:20',
            'cnh' => 'nullable|string|max:50',
            'categoria_cnh' => 'nullable|string|max:10',
            'validade_cnh' => 'nullable|date',
            'endereco' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'bairro' => 'nullable|string|max:100',
            'cidade' => 'nullable|string|max:100',
            'observacao' => 'nullable|string',
            'ativo' => 'nullable|boolean',
        ]);

        Motorista::create([
            'empresa_id' => empresaAtualId(),
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'cpf' => $request->cpf,
            'cnh' => $request->cnh,
            'categoria_cnh' => $request->categoria_cnh,
            'validade_cnh' => $request->validade_cnh,
            'endereco' => $request->endereco,
            'numero' => $request->numero,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'observacao' => $request->observacao,
            'ativo' => $request->has('ativo') ? 1 : 0,
        ]);

        return redirect()
            ->route('motoristas.index')
            ->with('success', 'Motorista cadastrado com sucesso!');
    }

    public function edit(Motorista $motorista)
    {
        $this->verificarEmpresa($motorista);

        return view('motoristas.edit', compact('motorista'));
    }

    public function update(Request $request, Motorista $motorista)
    {
        $this->verificarEmpresa($motorista);

        $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'nullable|string|max:30',
            'cpf' => 'nullable|string|max:20',
            'cnh' => 'nullable|string|max:50',
            'categoria_cnh' => 'nullable|string|max:10',
            'validade_cnh' => 'nullable|date',
            'endereco' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'bairro' => 'nullable|string|max:100',
            'cidade' => 'nullable|string|max:100',
            'observacao' => 'nullable|string',
            'ativo' => 'nullable|boolean',
        ]);

        $motorista->update([
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'cpf' => $request->cpf,
            'cnh' => $request->cnh,
            'categoria_cnh' => $request->categoria_cnh,
            'validade_cnh' => $request->validade_cnh,
            'endereco' => $request->endereco,
            'numero' => $request->numero,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'observacao' => $request->observacao,
            'ativo' => $request->has('ativo') ? 1 : 0,
        ]);

        return redirect()
            ->route('motoristas.index')
            ->with('success', 'Motorista atualizado com sucesso!');
    }

    public function destroy(Motorista $motorista)
    {
        $this->verificarEmpresa($motorista);

        $motorista->delete();

        return redirect()
            ->route('motoristas.index')
            ->with('success', 'Motorista excluído com sucesso!');
    }

    private function verificarEmpresa(Motorista $motorista)
    {
        $empresaId = empresaAtualId();
        if ($empresaId && $motorista->empresa_id != $empresaId) {
            abort(403, 'Acesso não autorizado.');
        }
    }
}