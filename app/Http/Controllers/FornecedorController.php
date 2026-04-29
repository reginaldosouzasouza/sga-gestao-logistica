<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fornecedor;
use App\Models\NaturezaFinanceira;

class FornecedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index()
        {
            $fornecedores = Fornecedor::with('naturezaFinanceira')
                ->orderBy('nome', 'asc')
                ->get();

            return view('fornecedores.index', [
                'fornecedores' => $fornecedores,
                'totalfornecedores' => $fornecedores->count()
            ]);
        }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $naturezas = NaturezaFinanceira::where('ativo', 1)
            ->orderBy('nome')
            ->get();

        return view('fornecedores.create', compact('naturezas'));
       
    }

    
    public function store(Request $request)
    {
    // Log dos dados recebidos antes de salvar
    \Log::info('Dados recebidos para criação:', $request->all());
    
        $validatedData = $request->validate([
            'cnpj' => 'required|unique:fornecedores|max:25',
            'nome' => 'required|max:255',
            'endereco' => 'required|max:255',
            'telefone' => 'required|max:255',
            'cidade' => 'nullable|max:50',
            'email' => 'nullable|email|max:255',
            'observacao' => 'nullable|max:255',
            'natureza_financeira' => 'nullable|max:255',
        ], [
            'cnpj.unique' => 'Este CNPJ já está cadastrado. Verifique a lista de fornecedores.'    
        ]);
    
        if (Fornecedor::where('cnpj', $request->cnpj)->exists()) {
            return redirect()->back()->withErrors(['cnpj' => 'Este CNPJ já existe no sistema.']);
        }
        
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
       
        $naturezas = NaturezaFinanceira::where('ativo', 1)
                ->orderBy('nome')
                ->get();

        return view('fornecedores.edit', compact('fornecedor', 'naturezas'));
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
