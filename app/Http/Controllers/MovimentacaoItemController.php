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
        return view('movimentacao_itens.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'movimentacao_id' => 'required|integer',
            'produto_id'      => 'required|integer',
            'quantidade'      => 'required|numeric',
            'valor_unitario'  => 'required|numeric',
            'valor_total'     => 'required|numeric',
        ]);

        MovimentacaoItem::create([
            'movimentacao_id' => $request->movimentacao_id,
            'produto_id'      => $request->produto_id,
            'quantidade'      => $request->quantidade,
            'valor_unitario'  => $request->valor_unitario,
            'valor_total'     => $request->valor_total, // 👈 RESPEITA O VALOR DIGITADO
        ]);

        return redirect()
            ->route('movimentacao-itens.index')
            ->with('success', 'Item adicionado com sucesso!');
    }

    public function show($id)
    {
        $movimentacaoItem = MovimentacaoItem::with(['movimentacao', 'produto'])->findOrFail($id);
        return view('movimentacao_itens.show', compact('movimentacaoItem'));
    }

    public function edit($id)
    {
        $movimentacaoItem = MovimentacaoItem::findOrFail($id);
        return view('movimentacao_itens.edit', compact('movimentacaoItem'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantidade'     => 'required|numeric',
            'valor_unitario' => 'required|numeric',
            'valor_total'    => 'required|numeric',
        ]);

        $movimentacaoItem = MovimentacaoItem::findOrFail($id);

        $movimentacaoItem->update([
            'quantidade'     => $request->quantidade,
            'valor_unitario' => $request->valor_unitario,
            'valor_total'    => $request->valor_total, // 👈 NÃO recalcula
        ]);

        return redirect()
            ->route('movimentacao-itens.index')
            ->with('success', 'Item atualizado com sucesso!');
    }

    public function destroy($id)
    {
        MovimentacaoItem::findOrFail($id)->delete();

        return redirect()
            ->route('movimentacao-itens.index')
            ->with('success', 'Item excluído com sucesso!');
    }
}
