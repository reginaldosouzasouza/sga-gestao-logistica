<?php

namespace App\Http\Controllers;

use App\Models\MovimentacaoItem;
use App\Models\Movimentacao;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MovimentacaoItemController extends Controller
{
    private function empresaId()
    {
        return empresaAtualId();
    }

    public function index()
    {
        $empresaId = $this->empresaId();

        $movimentacaoItens = MovimentacaoItem::with(['movimentacao', 'produto'])
            ->where('empresa_id', $empresaId)
            ->orderBy('id', 'desc')
            ->get();

        return view('movimentacao_itens.index', compact('movimentacaoItens'));
    }

    public function create()
    {
        $empresaId = $this->empresaId();

        $movimentacoes = Movimentacao::where('empresa_id', $empresaId)
            ->orderBy('id', 'desc')
            ->get();

        $produtos = Produto::where('empresa_id', $empresaId)
            ->orderBy('nome')
            ->get();

        return view('movimentacao_itens.create', compact('movimentacoes', 'produtos'));
    }

    public function store(Request $request)
    {
        $empresaId = $this->empresaId();

        $request->validate([
            'movimentacao_id' => [
                'required',
                'integer',
                Rule::exists('movimentacao', 'id')->where(function ($query) use ($empresaId) {
                    return $query->where('empresa_id', $empresaId);
                }),
            ],
            'produto_id' => [
                'required',
                'integer',
                Rule::exists('produtos', 'id')->where(function ($query) use ($empresaId) {
                    return $query->where('empresa_id', $empresaId);
                }),
            ],
            'quantidade'      => 'required|numeric|min:0.01',
            'valor_unitario'  => 'required|numeric|min:0',
            'valor_total'     => 'required|numeric|min:0',
        ]);

        $produto = Produto::where('empresa_id', $empresaId)
            ->where('id', $request->produto_id)
            ->firstOrFail();

        MovimentacaoItem::create([
            'empresa_id'             => $empresaId,
            'movimentacao_id'        => $request->movimentacao_id,
            'produto_id'             => $produto->id,
            'quantidade'             => $request->quantidade,
            'valor_unitario'         => $request->valor_unitario,
            'preco_compra_momento'   => $produto->preco_compra,
            'valor_total'            => $request->valor_total,
        ]);

        return redirect()
            ->route('movimentacao-itens.index')
            ->with('success', 'Item adicionado com sucesso!');
    }

    public function show($id)
    {
        $empresaId = $this->empresaId();

        $movimentacaoItem = MovimentacaoItem::with(['movimentacao', 'produto'])
            ->where('empresa_id', $empresaId)
            ->where('id', $id)
            ->firstOrFail();

        return view('movimentacao_itens.show', compact('movimentacaoItem'));
    }

    public function edit($id)
    {
        $empresaId = $this->empresaId();

        $movimentacaoItem = MovimentacaoItem::where('empresa_id', $empresaId)
            ->where('id', $id)
            ->firstOrFail();

        $movimentacoes = Movimentacao::where('empresa_id', $empresaId)
            ->orderBy('id', 'desc')
            ->get();

        $produtos = Produto::where('empresa_id', $empresaId)
            ->orderBy('nome')
            ->get();

        return view('movimentacao_itens.edit', compact(
            'movimentacaoItem',
            'movimentacoes',
            'produtos'
        ));
    }

    public function update(Request $request, $id)
    {
        $empresaId = $this->empresaId();

        $request->validate([
            'produto_id' => [
                'nullable',
                'integer',
                Rule::exists('produtos', 'id')->where(function ($query) use ($empresaId) {
                    return $query->where('empresa_id', $empresaId);
                }),
            ],
            'quantidade'     => 'required|numeric|min:0.01',
            'valor_unitario' => 'required|numeric|min:0',
            'valor_total'    => 'required|numeric|min:0',
        ]);

        $movimentacaoItem = MovimentacaoItem::where('empresa_id', $empresaId)
            ->where('id', $id)
            ->firstOrFail();

        $dados = [
            'empresa_id'     => $empresaId,
            'quantidade'     => $request->quantidade,
            'valor_unitario' => $request->valor_unitario,
            'valor_total'    => $request->valor_total,
        ];

        /*
         * Regra de segurança:
         * - Se apenas quantidade ou valor de venda mudar, mantém o custo histórico salvo.
         * - Se o produto for alterado, grava o custo atual do novo produto.
         */
        if ($request->filled('produto_id') && (int) $request->produto_id !== (int) $movimentacaoItem->produto_id) {
            $produto = Produto::where('empresa_id', $empresaId)
                ->where('id', $request->produto_id)
                ->firstOrFail();

            $dados['produto_id'] = $produto->id;
            $dados['preco_compra_momento'] = $produto->preco_compra;
        }

        $movimentacaoItem->update($dados);

        return redirect()
            ->route('movimentacao-itens.index')
            ->with('success', 'Item atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $empresaId = $this->empresaId();

        $movimentacaoItem = MovimentacaoItem::where('empresa_id', $empresaId)
            ->where('id', $id)
            ->firstOrFail();

        $movimentacaoItem->delete();

        return redirect()
            ->route('movimentacao-itens.index')
            ->with('success', 'Item excluído com sucesso!');
    }
}