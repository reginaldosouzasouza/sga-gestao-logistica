<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use App\Models\Motorista;
use Illuminate\Http\Request;

class VeiculoController extends Controller
{
    public function index(Request $request)
    {
        $empresaId = empresaAtualId();

        $query = Veiculo::with('motorista');

        if ($empresaId) {
            $query->where('empresa_id', $empresaId);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('descricao', 'like', "%{$search}%")
                  ->orWhere('placa', 'like', "%{$search}%")
                  ->orWhere('marca', 'like', "%{$search}%")
                  ->orWhere('modelo', 'like', "%{$search}%");
            });
        }

        $totalVeiculos = (clone $query)->count();

        $veiculos = $query
            ->orderBy('descricao')
            ->paginate(10);

        return view('veiculos.index', compact('veiculos', 'totalVeiculos'));
    }

    public function create()
    {
        $empresaId = empresaAtualId();
        $motoristas = Motorista::query()
            ->when($empresaId, function ($query) use ($empresaId) {
                $query->where('empresa_id', $empresaId);
            })
            ->where('ativo', 1)
            ->orderBy('nome')
            ->get();

        return view('veiculos.create', compact('motoristas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'motorista_id' => 'nullable|exists:motoristas,id',
            'descricao' => 'required|string|max:255',
            'placa' => 'nullable|string|max:20',
            'marca' => 'nullable|string|max:255',
            'modelo' => 'nullable|string|max:255',
            'ano' => 'nullable|integer|min:1900|max:2100',
            'tipo' => 'nullable|string|max:100',
            'combustivel' => 'nullable|string|max:100',
            'comissao_tipo' => 'nullable|string|max:50',
            'comissao_valor' => 'nullable|numeric|min:0',
            'observacao' => 'nullable|string',
            'ativo' => 'nullable|boolean',
        ]);

        Veiculo::create([
            'empresa_id' => empresaAtualId(),
            'motorista_id' => $request->motorista_id,
            'descricao' => $request->descricao,
            'placa' => strtoupper($request->placa),
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'ano' => $request->ano,
            'tipo' => $request->tipo,
            'combustivel' => $request->combustivel,
            'comissao_tipo' => $request->comissao_tipo,
            'comissao_valor' => $request->comissao_valor ?? 0,
            'ativo' => $request->has('ativo') ? 1 : 0,
            'observacao' => $request->observacao,
        ]);

        return redirect()
            ->route('veiculos.index')
            ->with('success', 'Veículo cadastrado com sucesso!');
    }

    public function edit(Veiculo $veiculo)
    {
        $this->verificarEmpresa($veiculo);

        $empresaId = empresaAtualId();
        $motoristas = Motorista::query()
            ->when($empresaId, function ($query) use ($empresaId) {
                $query->where('empresa_id', $empresaId);
            })
            ->where('ativo', 1)
            ->orderBy('nome')
            ->get();

        return view('veiculos.edit', compact('veiculo', 'motoristas'));
    }

    public function update(Request $request, Veiculo $veiculo)
    {
        $this->verificarEmpresa($veiculo);

        $request->validate([
            'motorista_id' => 'nullable|exists:motoristas,id',
            'descricao' => 'required|string|max:255',
            'placa' => 'nullable|string|max:20',
            'marca' => 'nullable|string|max:255',
            'modelo' => 'nullable|string|max:255',
            'ano' => 'nullable|integer|min:1900|max:2100',
            'tipo' => 'nullable|string|max:100',
            'combustivel' => 'nullable|string|max:100',
            'comissao_tipo' => 'nullable|string|max:50',
            'comissao_valor' => 'nullable|numeric|min:0',
            'observacao' => 'nullable|string',
            'ativo' => 'nullable|boolean',
        ]);

        $veiculo->update([
            'motorista_id' => $request->motorista_id,
            'descricao' => $request->descricao,
            'placa' => strtoupper($request->placa),
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'ano' => $request->ano,
            'tipo' => $request->tipo,
            'combustivel' => $request->combustivel,
            'comissao_tipo' => $request->comissao_tipo,
            'comissao_valor' => $request->comissao_valor ?? 0,
            'ativo' => $request->has('ativo') ? 1 : 0,
            'observacao' => $request->observacao,
        ]);

        return redirect()
            ->route('veiculos.index')
            ->with('success', 'Veículo atualizado com sucesso!');
    }

    public function destroy(Veiculo $veiculo)
    {
        $this->verificarEmpresa($veiculo);

        $veiculo->delete();

        return redirect()
            ->route('veiculos.index')
            ->with('success', 'Veículo excluído com sucesso!');
    }

    private function verificarEmpresa(Veiculo $veiculo)
    {
        $empresaId = empresaAtualId();
        if ($empresaId && $veiculo->empresa_id != $empresaId) {
            abort(403, 'Acesso não autorizado.');
        }
    }
}