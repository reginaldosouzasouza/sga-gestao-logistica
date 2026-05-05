<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Movimentacao;
use App\Models\MovimentacaoItem;
use App\Models\ContasAReceber;
use App\Models\FormaDePagamento;
use App\Models\Prazo;
use App\Models\Estoque;
use App\Models\Caixa;
use App\Models\CaixaBanco;
use App\Models\ValeGas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MovimentacaoController extends Controller
{
    public function create()
    {
        $cliente_id = null;
        $proximoId = Movimentacao::max('id') + 1;

        $formas_de_pagamento = FormaDePagamento::all();
        $prazos = Prazo::all();
        $produtos = Produto::orderBy('nome', 'asc')->get();

        return view('movimentacao.create', compact(
            'formas_de_pagamento',
            'prazos',
            'proximoId',
            'produtos',
            'cliente_id'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'data_coleta' => 'required|date|before_or_equal:today',
            'nome' => 'required',
            'endereco' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',

            'produtos' => 'required|array',
            'produtos.*.produto_id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1',
            'produtos.*.valor_unitario' => 'required|numeric|min:0',
            'produtos.*.valor_total' => 'required|numeric|min:0',

            'forma_pagamento' => 'required|exists:formas_de_pagamento,id',
            'prazo' => 'required|exists:prazos,id',
        ]);

        DB::beginTransaction();

        try {
            $formaPagamento = FormaDePagamento::findOrFail($request->forma_pagamento);
            $prazoSelecionado = Prazo::findOrFail($request->prazo);

            $valorTotalMovimentacao = array_sum(
                array_column($request->produtos, 'valor_total')
            );

            $movimentacao = Movimentacao::create([
                'data_coleta' => $request->data_coleta,
                'nome' => $request->nome,
                'endereco' => $request->endereco,
                'numero' => $request->numero,
                'bairro' => $request->bairro,
                'cidade' => $request->cidade,
                'cliente_id' => $request->cliente_id,
                'observacao' => $request->observacao,
                'forma_pagamento_id' => $request->forma_pagamento,
                'prazo_id' => $prazoSelecionado->id,
                'valor_total' => $valorTotalMovimentacao,
                'quantidade' => array_sum(array_column($request->produtos, 'quantidade')),
                'origem_tipo' => $request->origem_tipo,
                'origem_id' => $request->origem_id,
                'gerar_financeiro' => $request->has('gerar_financeiro')
                    ? (bool) $request->gerar_financeiro
                    : true,
            ]);

            foreach ($request->produtos as $item) {
                $produto = Produto::findOrFail($item['produto_id']);

                if ($produto->quantidade_estoque < $item['quantidade']) {
                    throw new \Exception("Estoque insuficiente para {$produto->nome}");
                }

                MovimentacaoItem::create([
                    'movimentacao_id' => $movimentacao->id,
                    'produto_id' => $item['produto_id'],
                    'quantidade' => $item['quantidade'],
                    'valor_unitario' => $item['valor_unitario'],
                    'valor_total' => $item['valor_total'],
                ]);

                Estoque::create([
                    'produto_id' => $item['produto_id'],
                    'quantidade' => -$item['quantidade'],
                    'tipo_movimentacao' => 'saida',
                    'origem' => 'venda',
                    'data_movimentacao' => now(),
                ]);

                $produto->quantidade_estoque -= $item['quantidade'];
                $produto->save();
            }

            if ($movimentacao->origem_tipo === 'VALE_GAS' && $movimentacao->origem_id) {
                $vale = ValeGas::find($movimentacao->origem_id);

                if ($vale) {
                    $vale->update([
                        'status' => 'RETIRADO',
                    ]);
                }
            }

            if ($movimentacao->gerar_financeiro) {
                if (strtolower($formaPagamento->nome) === 'dinheiro') {
                    Caixa::create([
                        'data_movimentacao' => $movimentacao->data_coleta,
                        'tipo' => 'entrada',
                        'valor' => $movimentacao->valor_total,
                        'origem' => 'venda',
                        'descricao' => 'Venda em dinheiro - Coleta #' . $movimentacao->id,
                        'referencia_id' => $movimentacao->id,
                    ]);
                } elseif (strtolower($formaPagamento->nome) === 'pix') {
                    CaixaBanco::create([
                        'data_movimentacao' => $movimentacao->data_coleta,
                        'tipo' => 'entrada',
                        'valor' => $movimentacao->valor_total,
                        'forma' => 'pix',
                        'origem' => 'venda',
                        'descricao' => 'Venda via PIX - Coleta #' . $movimentacao->id,
                        'referencia_id' => $movimentacao->id,
                    ]);
                } else {
                    ContasAReceber::create([
                        'cliente_id' => $movimentacao->cliente_id,
                        'descricao' => 'Venda realizada - Coleta #' . $movimentacao->id,
                        'valor' => $movimentacao->valor_total,
                        'data_venda' => $movimentacao->data_coleta,
                        'data_vencimento' => Carbon::parse($movimentacao->data_coleta)
                            ->addDays((int) $prazoSelecionado->prazo),
                        'status' => 'pendente',
                        'forma_pagamento_id' => $movimentacao->forma_pagamento_id,
                        'prazo' => $prazoSelecionado->id,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('movimentacao.index')
                ->with('success', 'Movimentação salva com sucesso.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erro ao salvar movimentação', [
                'erro' => $e->getMessage()
            ]);

            return back()->withErrors($e->getMessage());
        }
    }

   public function index(Request $request)
{
    $search = $request->input('search');

    $movimentacoes = Movimentacao::with(['formaPagamento'])
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', '%' . $search . '%')
                  ->orWhere('cidade', 'like', '%' . $search . '%')
                  ->orWhere('endereco', 'like', '%' . $search . '%')
                  ->orWhere('id', 'like', '%' . $search . '%');
            });
        })
        ->orderBy('id', 'desc')
        ->paginate(20)
        ->appends($request->query());

    return view('movimentacao.index', compact('movimentacoes', 'search'));
}

   public function show($id)
{
    $movimentacao = Movimentacao::with('itens.produto')->findOrFail($id);

    $historicoCliente = Movimentacao::with('itens.produto')
        ->where(function ($query) use ($movimentacao) {
            if (!empty($movimentacao->cliente_id)) {
                $query->where('cliente_id', $movimentacao->cliente_id);
            } else {
                $query->where('nome', $movimentacao->nome);
            }
        })
        ->orderBy('data_coleta', 'desc')
        ->orderBy('id', 'desc')
        ->get();

    return view('movimentacao.show', compact('movimentacao', 'historicoCliente'));
}
    

    public function destroy($id)
    {
        MovimentacaoItem::where('movimentacao_id', $id)->delete();
        Movimentacao::findOrFail($id)->delete();

        return redirect()
            ->route('movimentacao.index')
            ->with('success', 'Movimentação excluída com sucesso.');
    }

    public function verificarEstoque(Request $request)
    {
        $produto = Produto::find($request->produto_id);

        return response()->json([
            'quantidade_estoque' => $produto?->quantidade_estoque ?? 0
        ]);
    }
}