<?php

namespace App\Http\Controllers\Oficina;

use App\Http\Controllers\Controller;
use App\Models\OrdemServico;
use Illuminate\Http\Request;

class OrdemServicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->input('per_page', 15);
        $status  = trim((string) $request->input('status', ''));
        $busca   = trim((string) $request->input('busca',  ''));

        $ordens = OrdemServico::query()
            // status exato, ignorando espaços no banco
            ->when($status !== '', function ($q) use ($status) {
                $q->whereRaw('TRIM(status) = ?', [$status]);
            })
            // busca por cliente, placa ou serviço
            ->when($busca !== '', function ($q) use ($busca) {
                $q->where(function ($qq) use ($busca) {
                    $like = '%'.$busca.'%';
                    $qq->where('cliente', 'like', $like)
                       ->orWhere('placa', 'like', $like)
                       ->orWhere('servico_realizado', 'like', $like);
                });
            })
            ->paginate($perPage)
            ->withQueryString(); // preserva filtros na paginação

        return view('ordens-servico.index', compact('ordens'));
    }

    // ... (demais métodos create/store/show/edit/update/destroy)







    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ordens-servico.create');
    }

    /*
      Store a newly created resource in storage.
     
    public function store(Request $request)
    {
        $validated = $request->validate([
            'data_lancamento' => 'required|date',
            'cliente' => 'required|string|max:255',
            'placa' => 'required|string|max:20',
            'servico_realizado' => 'required|string',
            'data_prevista_entrega' => 'required|date',
            'valor' => 'required|numeric',
            'status' => 'required|string',
        ]);

        OrdemServico::create($validated);

        return redirect()->route('ordens-servico.index')
            ->with('success', 'Ordem de serviço criada com sucesso!');
    }
     */




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ordem = OrdemServico::findOrFail($id);
        return view('ordens-servico.show', compact('ordem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ordem = OrdemServico::findOrFail($id);
        return view('ordens-servico.edit', compact('ordem'));
    }




   


   /* public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'data_lancamento' => 'required|date',
            'cliente' => 'required|string|max:255',
            'placa' => 'required|string|max:20',
            'servico_realizado' => 'required|string',
            'data_prevista_entrega' => 'required|date',
            'valor' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $ordem = OrdemServico::findOrFail($id);
        $ordem->update($validated);

        return redirect()->route('ordens-servico.index')
            ->with('success', 'Ordem de serviço atualizada com sucesso!');
    }*/


 

    /**
     * Converte valor brasileiro (R$ 1.500,00) para float (1500.00)
     */
    private function converterValorBrasileiro($valor)
    {
        if (empty($valor)) {
            return 0;
        }
        
        // Remove "R$" e espaços
        $valor = str_replace(['R$', ' '], '', $valor);
        
        // Remove pontos (separador de milhar)
        $valor = str_replace('.', '', $valor);
        
        // Substitui vírgula (separador decimal) por ponto
        $valor = str_replace(',', '.', $valor);
        
        return (float) $valor;
    }

    public function store(Request $request)

    {

         abort(500, 'ENTROU NO STORE DA ORDEM DE SERVIÇO');

      

        // Converte o valor antes da validação
        $request->merge([
            'valor' => $this->converterValorBrasileiro($request->valor) / 100
        ]);

        $validated = $request->validate([
            'data_lancamento' => 'required|date',
            'cliente' => 'required|string|max:255',
            'placa' => 'required|string|max:20',
            'servico_realizado' => 'required|string',
            'data_prevista_entrega' => 'required|date',
            'valor' => 'required|numeric|min:0',
            'status' => 'required|string',
        ]);

        
            // 3️⃣ DEBUG AQUI (ANTES DE GRAVAR)
        dd([
            'valor_request'   => $request->input('valor'),
            'valor_validated' => $validated['valor'],
            'tipo'            => gettype($validated['valor']),
        ]);
       
       
       
       
       
        OrdemServico::create($validated);

        return redirect()->route('ordens-servico.index')
            ->with('success', 'Ordem de serviço criada com sucesso!');
    }

    public function update(Request $request, string $id)
    {
        // Converte o valor antes da validação
        $request->merge([
            'valor' => $this->converterValorBrasileiro($request->valor) / 100
        ]);

        $validated = $request->validate([
            'data_lancamento' => 'required|date',
            'cliente' => 'required|string|max:255',
            'placa' => 'required|string|max:20',
            'servico_realizado' => 'required|string',
            'data_prevista_entrega' => 'required|date',
            'valor' => 'required|numeric|min:0',
            'status' => 'required|string',
        ]);

        $ordem = OrdemServico::findOrFail($id);
        $ordem->update($validated);

        return redirect()->route('ordens-servico.index')
            ->with('success', 'Ordem de serviço atualizada com sucesso!');
    }














    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ordem = OrdemServico::findOrFail($id);
        $ordem->delete();

        return redirect()->route('ordens-servico.index')
            ->with('success', 'Ordem de serviço excluída com sucesso!');
    }
}
