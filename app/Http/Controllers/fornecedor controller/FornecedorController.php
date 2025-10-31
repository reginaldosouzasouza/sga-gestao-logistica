<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fornecedor;

class FornecedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fornecedores = Fornecedor::all();
        return view('fornecedores.index', compact('fornecedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fornecedores.create');
    }
    
    public function store(Request $request)
    {
     //   dd($request->all());
    
        $validatedData = $request->validate([
            'cnpj' => 'required|unique:fornecedores|max:18',
            'nome' => 'required|max:255',
            'endereco' => 'required|max:255',
            'telefone' => 'required|max:255',
            'cidade' => 'nullable|max:255',
            'email' => 'nullable|email|max:255',
            'observacao' => 'nullable|max:255',
        ]);
    
        Fornecedor::create($validatedData);
    
        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor cadastrado com sucesso!');
    }
    
    

    /**
     * Store a newly created resource in storage.
     */
    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        return view('fornecedores.show', compact('fornecedor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        return view('fornecedores.edit', compact('fornecedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $fornecedor = Fornecedor::findOrFail($id);

        $fornecedor->update($request->all());

        return redirect()->route('fornecedores.index')
            ->with('success', 'Fornecedor atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        $fornecedor->delete();

        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor deletado com sucesso!');
    }
}
