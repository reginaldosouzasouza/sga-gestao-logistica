<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mecanico;

class MecanicoController extends Controller
{
    // Listar todos os mecânicos
    public function index()
    {
        $mecanicos = Mecanico::all();
        return view('mecanicos.index', compact('mecanicos'));
    }

    // Mostrar formulário de criação
    public function create()
    {
        return view('mecanicos.create');
    }

    // Armazenar novo mecânico
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        Mecanico::create([
            'nome' => $request->nome
        ]);

        return redirect()->route('mecanicos.index')->with('success', 'Mecânico cadastrado com sucesso!');
    }

    // Mostrar formulário de edição
    public function edit($id)
    {
        $mecanico = Mecanico::findOrFail($id);
        return view('mecanicos.edit', compact('mecanico'));
    }

    // Atualizar o mecânico
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $mecanico = Mecanico::findOrFail($id);
        $mecanico->update([
            'nome' => $request->nome
        ]);

        return redirect()->route('mecanicos.index')->with('success', 'Mecânico atualizado com sucesso!');
    }

    // Excluir o mecânico
    public function destroy($id)
    {
        $mecanico = Mecanico::findOrFail($id);
        $mecanico->delete();

        return redirect()->route('mecanicos.index')->with('success', 'Mecânico excluído com sucesso!');
    }
}
