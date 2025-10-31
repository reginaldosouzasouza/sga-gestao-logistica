<?php

namespace App\Http\Controllers;

use App\Models\MovimentacaoItem;
use Illuminate\Http\Request;

class MovimentacaoItemController extends Controller
{
            public function index()
        {
            $movimentacaoItens = MovimentacaoItem::with(['movimentacao', 'produto'])->get(); 
            return view('movimentacao_itens.index', compact('movimentacaoItens'));
        }


    public function create()
    {
        // Retornar a view para criar um novo item de movimentação
        return view('movimentacao_itens.create');
    }

   public function store(Request $request)
    {
        // Validar e salvar um novo item de movimentação
        $request->validate([
            'movimentacao_id' => 'required',
            'produto_id' => 'required',
            'quantidade' => 'required|numeric',
            'valor_unitario' => 'required|numeric',
        ]);

        // Calcular o valor total
        $valorTotal = $request->quantidade * $request->valor_unitario;

        MovimentacaoItem::create([
            'movimentacao_id' => $movimentacao->id,
            'produto_id' => $item['produto_id'],
            'quantidade' => $item['quantidade'],
            'valor_unitario' => $item['valor_unitario'],
          // 'valor_total' => $valorTotal, remover esta linha
        ]);

        return redirect()->route('movimentacao-itens.index')
                         ->with('success', 'Item adicionado com sucesso!');
    }

    public function show($id)
    {
        // Exibir detalhes de um item específico
        $movimentacaoItem = MovimentacaoItem::findOrFail($id);
        return view('movimentacao_itens.show', compact('movimentacaoItem'));
    }

    public function edit($id)
    {
        // Retornar a view para editar um item específico
        $movimentacaoItem = MovimentacaoItem::findOrFail($id);
        return view('movimentacao_itens.edit', compact('movimentacaoItem'));
    }

    public function update(Request $request, $id)
    {
        // Validar e atualizar um item de movimentação existente
        $request->validate([
            'quantidade' => 'required|numeric',
            'valor_unitario' => 'required|numeric',
        ]);

        $movimentacaoItem = MovimentacaoItem::findOrFail($id);
        $movimentacaoItem->update($request->all());

        return redirect()->route('movimentacao-itens.index')
                         ->with('success', 'Item atualizado com sucesso!');
    }
     
    public function destroy($id)
    {
        // Excluir um item de movimentação
        MovimentacaoItem::findOrFail($id)->delete();
        return redirect()->route('movimentacao-itens.index')
                         ->with('success', 'Item excluído com sucesso!');
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }



}
