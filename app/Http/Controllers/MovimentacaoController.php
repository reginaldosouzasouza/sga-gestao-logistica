<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Cliente;
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
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Models\Veiculo;

class MovimentacaoController extends Controller
{
    private function empresaId()
    {
        return auth()->user()->empresa_id;
    }

    public function create()
    {
        $empresaId = $this->empresaId();

        $cliente_id = null;

        $proximoId = (Movimentacao::where('empresa_id', $empresaId)->max('id') ?? 0) + 1;

        $formas_de_pagamento = FormaDePagamento::all();

        $prazos = Prazo::orderBy('prazo', 'asc')->get();

        $produtos = Produto::where('empresa_id', $empresaId)
            ->orderBy('nome', 'asc')
            ->get();

        $veiculos = Veiculo::with('motorista')
            ->where('empresa_id', $empresaId)
            ->where('ativo', 1)
            ->orderBy('descricao')
            ->get();

        return view('movimentacao.create', compact(
            'formas_de_pagamento',
            'prazos',
            'proximoId',
            'produtos',
            'cliente_id',
            'veiculos'
        ));
    }

    public function store(Request $request)
    {
        $empresaId = $this->empresaId();

        $request->validate([
            'data_coleta' => 'required|date|before_or_equal:today',
            'nome' => 'required',
            'endereco' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',

            'cliente_id' => [
                'nullable',
                Rule::exists('clientes', 'id')->where(function ($query) use ($empresaId) {
                    return $query->where('empresa_id', $empresaId);
                }),
            ],

            'produtos' => 'required|array',
            'produtos.*.produto_id' => [
                'required',
                Rule::exists('produtos', 'id')->where(function ($query) use ($empresaId) {
                    return $query->where('empresa_id', $empresaId);
                }),
            ],
            'produtos.*.quantidade' => 'required|integer|min:1',
            'produtos.*.valor_unitario' => 'required|numeric|min:0',
            'produtos.*.valor_total' => 'required|numeric|min:0',

            'forma_pagamento' => 'required|exists:formas_de_pagamento,id',
            'prazo' => 'required|exists:prazos,id',

            'veiculo_id' => [
                'nullable',
                Rule::exists('veiculos', 'id')->where(function ($query) use ($empresaId) {
                    return $query->where('empresa_id', $empresaId)
                        ->where('ativo', 1);
                }),
            ],
        ]);

        DB::beginTransaction();

        try {
            $formaPagamento = FormaDePagamento::findOrFail($request->forma_pagamento);
            $prazoSelecionado = Prazo::findOrFail($request->prazo);

            $valorTotalMovimentacao = array_sum(
                array_column($request->produtos, 'valor_total')
            );

            $quantidadeTotalMovimentacao = array_sum(
                array_column($request->produtos, 'quantidade')
            );

            $veiculo = null;
            $motoristaId = null;
            $comissaoTipo = null;
            $comissaoValor = 0;
            $valorComissao = 0;

            if ($request->filled('veiculo_id')) {
                $veiculo = Veiculo::with('motorista')
                    ->where('empresa_id', $empresaId)
                    ->where('ativo', 1)
                    ->find($request->veiculo_id);

                if ($veiculo) {
                    $motoristaId = $veiculo->motorista_id;
                    $comissaoTipo = $veiculo->comissao_tipo;
                    $comissaoValor = $veiculo->comissao_valor ?? 0;

                    if ($comissaoTipo === 'percentual') {
                        $valorComissao = ($valorTotalMovimentacao * $comissaoValor) / 100;
                    } elseif ($comissaoTipo === 'fixa') {
                        $valorComissao = $comissaoValor;
                    }
                }
            }


            $movimentacao = Movimentacao::create([
                'empresa_id' => $empresaId,
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
                'quantidade' => $quantidadeTotalMovimentacao,
                'origem_tipo' => $request->origem_tipo,
                'origem_id' => $request->origem_id,
                'gerar_financeiro' => $request->has('gerar_financeiro')
                    ? (bool) $request->gerar_financeiro
                    : true,
                'veiculo_id' => $request->veiculo_id,
                'motorista_id' => $motoristaId,
                'comissao_tipo' => $comissaoTipo,
                'comissao_valor' => $comissaoValor,
                'valor_comissao' => $valorComissao,
            ]);

            foreach ($request->produtos as $item) {
                $produto = Produto::where('empresa_id', $empresaId)
                    ->where('id', $item['produto_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($produto->quantidade_estoque < $item['quantidade']) {
                    throw new \Exception("Estoque insuficiente para {$produto->nome}");
                }

                MovimentacaoItem::create([
                    'empresa_id' => $empresaId,
                    'movimentacao_id' => $movimentacao->id,
                    'produto_id' => $produto->id,
                    'quantidade' => $item['quantidade'],
                    'valor_unitario' => $item['valor_unitario'],
                    'valor_total' => $item['valor_total'],
                ]);

                Estoque::create([
                    'empresa_id' => $empresaId,
                    'produto_id' => $produto->id,
                    'quantidade' => -$item['quantidade'],
                    'tipo_movimentacao' => 'saida',
                    'origem' => 'venda',
                    'data_movimentacao' => now(),
                ]);

                $produto->quantidade_estoque -= $item['quantidade'];
                $produto->save();
            }

            if ($movimentacao->origem_tipo === 'VALE_GAS' && $movimentacao->origem_id) {
                $vale = ValeGas::where('empresa_id', $empresaId)
                    ->where('id', $movimentacao->origem_id)
                    ->first();

                if ($vale) {
                    $vale->update([
                        'status' => 'RETIRADO',
                    ]);
                }
            }

            if ($movimentacao->gerar_financeiro) {
                $nomeFormaPagamento = strtolower(trim($formaPagamento->nome));

                if ($nomeFormaPagamento === 'dinheiro') {
                    Caixa::create([
                        'empresa_id' => $empresaId,
                        'data_movimentacao' => $movimentacao->data_coleta,
                        'tipo' => 'entrada',
                        'valor' => $movimentacao->valor_total,
                        'origem' => 'venda',
                        'descricao' => 'Venda em dinheiro - Coleta #' . $movimentacao->id,
                        'referencia_id' => $movimentacao->id,
                    ]);
                } elseif ($nomeFormaPagamento === 'pix') {
                    CaixaBanco::create([
                        'empresa_id' => $empresaId,
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
                        'empresa_id' => $empresaId,
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
                'erro' => $e->getMessage(),
                'linha' => $e->getLine(),
                'arquivo' => $e->getFile(),
            ]);

            return back()
                ->withInput()
                ->withErrors($e->getMessage());
        }
    }

    public function index(Request $request)
    {
        $empresaId = $this->empresaId();

        $search = $request->input('search');

        $movimentacoes = Movimentacao::with(['formaPagamento', 'veiculo.motorista', 'motorista'])
            ->where('empresa_id', $empresaId)
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
        $empresaId = $this->empresaId();

        $movimentacao = Movimentacao::with(['itens.produto', 'veiculo.motorista', 'motorista'])
            ->where('empresa_id', $empresaId)
            ->where('id', $id)
            ->firstOrFail();

        $historicoCliente = Movimentacao::with(['itens.produto', 'veiculo.motorista', 'motorista'])
            ->where('empresa_id', $empresaId)
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
        $empresaId = $this->empresaId();

        DB::beginTransaction();

        try {
            $movimentacao = Movimentacao::where('empresa_id', $empresaId)
                ->where('id', $id)
                ->firstOrFail();

            MovimentacaoItem::where('empresa_id', $empresaId)
                ->where('movimentacao_id', $movimentacao->id)
                ->delete();

            $movimentacao->delete();

            DB::commit();

            return redirect()
                ->route('movimentacao.index')
                ->with('success', 'Movimentação excluída com sucesso.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erro ao excluir movimentação', [
                'erro' => $e->getMessage(),
                'linha' => $e->getLine(),
                'arquivo' => $e->getFile(),
            ]);

            return redirect()
                ->route('movimentacao.index')
                ->with('error', 'Erro ao excluir movimentação: ' . $e->getMessage());
        }
    }

    public function verificarEstoque(Request $request)
    {
        $empresaId = $this->empresaId();

        $produto = Produto::where('empresa_id', $empresaId)
            ->where('id', $request->produto_id)
            ->first();

        return response()->json([
            'quantidade_estoque' => $produto?->quantidade_estoque ?? 0
        ]);
    }
}