<?php

namespace App\Http\Controllers;

use App\Models\OrdemServicoItem;
use App\Models\OrdemServico;
use App\Models\Produto;
use Illuminate\Http\Request;
use App\Models\FormaDePagamento; 
use App\Models\Prazo; 


class OrdemServicoItemController extends Controller
{
    public function index()
    {
        $itens = OrdemServicoItem::with('ordemServico', 'produto')->get();
        return view('ordem_servico_itens.index', compact('itens'));
    }

    public function create()
    {
        $ordens = OrdemServico::orderBy('id')->get();
        $produtos = Produto::orderBy('nome')->get();
        $formasPagamento = FormaDePagamento::orderBy('nome')->get(); // traz do banco
        $prazos = Prazo::orderBy('prazo')->get(); // usado na sugestão 3
        return view('ordem_servico_itens.create', compact('ordens', 'produtos', 'formasPagamento', 'prazos'));
    }

   public function store(Request $request)
    {
        $validated = $request->validate([
            'ordem_servico_id' => 'required|exists:ordem_servicos,id',
            'produto_id'       => 'required|exists:produtos,id',
            'quantidade'       => 'required|numeric|min:1',
            'valor_unitario'   => 'required|numeric|min:0',

        ]);

        $validated['valor_total'] = $validated['quantidade'] * $validated['valor_unitario'];

        OrdemServicoItem::create($validated);

        return redirect()->route('ordem_servico_itens.index')
                        ->with('success', 'Item adicionado com sucesso!');
    }


    public function edit($id)
    {
        $item = OrdemServicoItem::findOrFail($id);
        $ordens = OrdemServico::orderBy('id')->get();
        $produtos = Produto::orderBy('nome')->get();
        return view('ordem_servico_itens.edit', compact('item', 'ordens', 'produtos'));
    }

    public function update(Request $request, $id)
    {
        $item = OrdemServicoItem::findOrFail($id);

        $request->validate([
            'ordem_servico_id' => 'required|exists:ordem_servicos,id',
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|numeric|min:1',
            'valor_unitario' => 'required|numeric|min:0',
        ]);

        $request['valor_total'] = $request->quantidade * $request->valor_unitario;
        $item->update($request->all());

        return redirect()->route('ordem-servico-itens.index')->with('success', 'Item atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $item = OrdemServicoItem::findOrFail($id);
        $item->delete();

        return redirect()->route('ordem-servico-itens.index')->with('success', 'Item removido com sucesso!');
    }
}
