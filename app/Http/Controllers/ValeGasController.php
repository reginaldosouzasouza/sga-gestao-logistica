<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\FormaDePagamento;
use App\Models\Movimentacao;
use App\Models\Produto;
use App\Models\Estoque;
use App\Models\ValeGas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValeGasController extends Controller
{
    public function index(Request $request)
    {
        $query = ValeGas::with([
            'cliente',
            'produto',
            'formaPagamento',
            'usuarioCadastro',
            'usuarioRetirada',
        ]);

        if ($request->filled('cliente')) {
            $query->whereHas('cliente', function ($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->cliente . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('data_inicio')) {
            $query->whereDate('data_vale', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('data_vale', '<=', $request->data_fim);
        }

        $vales = $query->orderByDesc('id')->paginate(15);

        return view('vale_gas.index', compact('vales'));
    }

    public function create()
    {
        $clientes = Cliente::orderBy('nome')->get();
        $produtos = Produto::orderBy('nome')->get();
        $formasPagamento = FormaDePagamento::orderBy('nome')->get();

        return view('vale_gas.create', compact('clientes', 'produtos', 'formasPagamento'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'data_vale' => 'required|date',
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
            'valor_pago' => 'required|numeric|min:0',
            'forma_pagamento_id' => 'nullable|exists:formas_de_pagamento,id',
        ], [
            'cliente_id.required' => 'Informe o cliente.',
            'produto_id.required' => 'Informe o produto.',
            'data_vale.required' => 'Informe a data do vale.',
        ]);

        $vale = ValeGas::create([
            'codigo' => $this->gerarCodigoVale(),
            'cliente_id' => $request->cliente_id,
            'data_vale' => $request->data_vale,
            'produto_id' => $request->produto_id,
            'quantidade' => $request->quantidade,
            'valor_pago' => $request->valor_pago,
            'forma_pagamento_id' => $request->forma_pagamento_id,
            'observacao' => $request->observacao,
            'status' => 'ABERTO',
            'usuario_cadastro_id' => auth()->id(),
        ]);

        return redirect()->route('vale-gas.index')
            ->with('success', 'Vale Gás cadastrado com sucesso.');
    }

    public function show($id)
    {
        $vale = ValeGas::with([
            'cliente',
            'produto',
            'formaPagamento',
            'usuarioCadastro',
            'usuarioRetirada',
        ])->findOrFail($id);

        return view('vale_gas.show', compact('vale'));
    }

    public function edit($id)
    {
        $vale = ValeGas::findOrFail($id);

        if ($vale->status !== 'ABERTO') {
            return redirect()->route('vale-gas.index')
                ->with('error', 'Somente vales com status ABERTO podem ser editados.');
        }

        $clientes = Cliente::orderBy('nome')->get();
        $produtos = Produto::orderBy('nome')->get();
        $formasPagamento = FormaDePagamento::orderBy('nome')->get();

        return view('vale_gas.edit', compact('vale', 'clientes', 'produtos', 'formasPagamento'));
    }

    public function update(Request $request, $id)
    {
        $vale = ValeGas::findOrFail($id);

        if ($vale->status !== 'ABERTO') {
            return redirect()->route('vale-gas.index')
                ->with('error', 'Somente vales com status ABERTO podem ser alterados.');
        }

        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'data_vale' => 'required|date',
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
            'valor_pago' => 'required|numeric|min:0',
            'forma_pagamento_id' => 'nullable|exists:formas_de_pagamento,id',
        ]);

        $vale->update([
            'cliente_id' => $request->cliente_id,
            'data_vale' => $request->data_vale,
            'produto_id' => $request->produto_id,
            'quantidade' => $request->quantidade,
            'valor_pago' => $request->valor_pago,
            'forma_pagamento_id' => $request->forma_pagamento_id,
            'observacao' => $request->observacao,
        ]);

        return redirect()->route('vale-gas.show', $vale->id)
            ->with('success', 'Vale Gás atualizado com sucesso.');
    }

    public function cancelar($id)
    {
        $vale = ValeGas::findOrFail($id);

        if ($vale->status !== 'ABERTO') {
            return back()->with('error', 'Somente vales com status ABERTO podem ser cancelados.');
        }

        $vale->update([
            'status' => 'CANCELADO',
        ]);

        return redirect()->route('vale-gas.index')
            ->with('success', 'Vale Gás cancelado com sucesso.');
    }

    public function iniciarRetirada($id)
    {
        $vale = ValeGas::with(['cliente', 'produto'])->findOrFail($id);

        if ($vale->status !== 'ABERTO') {
            return back()->with('error', 'Somente vales com status ABERTO podem iniciar retirada.');
        }

        DB::beginTransaction();

        try {
            $produto = Produto::findOrFail($vale->produto_id);

            if ($produto->quantidade_estoque < $vale->quantidade) {
                throw new \Exception("Estoque insuficiente para {$produto->nome}");
            }

            $movimentacao = Movimentacao::create([
                'cliente_id' => $vale->cliente_id,
                'data_coleta' => now()->toDateString(),
                'cpf' => $vale->cliente->cpf ?? null,
                'nome' => $vale->cliente->nome ?? '',
                'endereco' => $vale->cliente->endereco ?? '',
                'numero' => $vale->cliente->numero ?? '',
                'bairro' => $vale->cliente->bairro ?? '',
                'cidade' => $vale->cliente->cidade ?? '',
                'observacao' => 'Retirada referente ao Vale Gás ' . $vale->codigo,
                'forma_pagamento_id' => $vale->forma_pagamento_id,
                'prazo_id' => 1,
                'valor_total' => $vale->valor_pago,
                'quantidade' => $vale->quantidade,
                'origem_tipo' => 'VALE_GAS',
                'origem_id' => $vale->id,
                'gerar_financeiro' => false,
            ]);

            $valorUnitario = $vale->quantidade > 0
                ? ($vale->valor_pago / $vale->quantidade)
                : $vale->valor_pago;

            $movimentacao->itens()->create([
                'produto_id' => $vale->produto_id,
                'quantidade' => $vale->quantidade,
                'valor_unitario' => $valorUnitario,
                'valor_total' => $vale->valor_pago,
            ]);

            Estoque::create([
                'produto_id' => $vale->produto_id,
                'quantidade' => -$vale->quantidade,
                'tipo_movimentacao' => 'saida',
                'origem' => 'vale_gas',
                'data_movimentacao' => now(),
            ]);

            $produto->quantidade_estoque -= $vale->quantidade;
            $produto->save();

            $vale->update([
                'status' => 'RETIRADO',
                'pedido_coleta_id' => $movimentacao->id,
                'data_retirada' => now(),
                'usuario_retirada_id' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('vale-gas.show', $vale->id)
                ->with('success', 'Vale retirado com sucesso e estoque baixado automaticamente.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Erro ao retirar vale: ' . $e->getMessage());
        }
    }

    private function gerarCodigoVale(): string
    {
        $ultimo = ValeGas::latest('id')->first();
        $numero = $ultimo ? $ultimo->id + 1 : 1;

        return 'VG' . str_pad($numero, 6, '0', STR_PAD_LEFT);
    }
}