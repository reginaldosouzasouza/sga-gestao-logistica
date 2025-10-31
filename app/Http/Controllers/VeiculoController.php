<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Veiculo;


class VeiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $veiculos = \App\Models\Veiculo::orderBy('id', 'desc')->get();
        return view('veiculos.index', compact('veiculos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        $clientes = Cliente::orderBy('nome')->get();
        return view('veiculos.create', compact('clientes'));    

    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    {
        $request->validate([
            'cliente' => 'required|string|max:255',
            'marca' => 'required|string|max:100',
            'veiculo' => 'required|string|max:100',
            'placa' => 'required|string|max:10|unique:veiculos,placa',
            'cor' => 'nullable|string|max:50',
            'ano' => 'nullable|integer',
            'combustivel' => 'nullable|string|max:50',
            'observacoes' => 'nullable|string',
        ]);

        Veiculo::create($request->all());

        return redirect()->route('veiculos.index')
                         ->with('success', 'Veículo cadastrado com sucesso!');
    }

    // Você pode adicionar aqui os outros métodos depois


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $veiculo = Veiculo::findOrFail($id);
        $clientes = Cliente::orderBy('nome')->get();

        return view('veiculos.edit', compact('veiculo', 'clientes'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    
    {
        $request->validate([
            'cliente'      => 'required|string|max:100',
            'marca'        => 'required|string|max:50',
            'modelo'       => 'required|string|max:50',
            'placa'        => 'required|string|max:20',
            'cor'          => 'nullable|string|max:30',
            'ano'          => 'nullable|integer',
            'combustivel'  => 'nullable|string|max:50',
            'observacoes'  => 'nullable|string',
        ]);

        $veiculo = Veiculo::findOrFail($id);

        $veiculo->update($request->all());

        return redirect()->route('veiculos.index')
                        ->with('success', 'Veículo atualizado com sucesso!');
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

  
        public function buscarPorPlaca($placa)
        {
            $veiculo = Veiculo::where('placa', $placa)->first();

            if ($veiculo) {
                return response()->json([
                    'marca' => $veiculo->marca,
                    'modelo' => $veiculo->veiculo,
                    'cliente' => $veiculo->cliente // já é o nome
                ]);
            }

            return response()->json(['mensagem' => 'Veículo não encontrado'], 404);
        }

}
