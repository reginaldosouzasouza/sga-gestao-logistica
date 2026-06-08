<?php

namespace App\Http\Controllers;

use App\Models\ContasAPagar;
use App\Models\Fornecedor;
use App\Models\FormaDePagamento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Prazo;
use Illuminate\Support\Facades\Log;
use App\Models\Compra;
use App\Models\Caixa;
use App\Models\CaixaBanco;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Exports\ContasAPagarExport;

class ContasAPagarController extends Controller
{
    private function empresaId()
    {
        return auth()->user()->empresa_id;
    }

    public function index(Request $request)
    {
        $empresaId = $this->empresaId();

        // Data atual
        $hoje = Carbon::now()->format('Y-m-d');

        // Atualiza o status para 'ATRASADO' somente da empresa logada
        ContasAPagar::where('empresa_id', $empresaId)
            ->where('data_vencimento', '<', $hoje)
            ->where('status', '!=', 'pago')
            ->update(['status' => 'atrasado']);

        // Atualiza o status para 'PENDENTE' somente da empresa logada
        ContasAPagar::where('empresa_id', $empresaId)
            ->where('data_vencimento', $hoje)
            ->where('status', '!=', 'pago')
            ->update(['status' => 'pendente']);

        // Filtro por fornecedor, status e datas
        $query = ContasAPagar::with(['fornecedor', 'formaPagamento'])
            ->where('empresa_id', $empresaId);

        if ($request->filled('fornecedor')) {
            $query->whereHas('fornecedor', function ($q) use ($request, $empresaId) {
                $q->where('empresa_id', $empresaId)
                    ->where('nome', 'like', '%' . $request->fornecedor . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('data_vencimento')) {
            $query->where('data_vencimento', $request->data_vencimento);
        }

        if ($request->filled('forma_pagamento_id')) {
            $query->where('forma_pagamento_id', $request->forma_pagamento_id);
        }

        if ($request->filled('data_pagamento')) {
            $query->where('data_pagamento', $request->data_pagamento);
        }

        if ($request->filled('created_at')) {
            $query->whereDate('created_at', $request->created_at);
        }

        // Filtro por período da data de compra
        if ($request->filled('data_compra_inicial') && $request->filled('data_compra_final')) {
            $query->whereBetween('data_compra', [
                $request->data_compra_inicial,
                $request->data_compra_final
            ]);
        }

        $contasAPagar = $query->orderByRaw("CASE 
                WHEN status = 'atrasado' THEN 0 
                WHEN status = 'pendente' THEN 1 
                ELSE 2 
            END")
            ->orderBy('data_vencimento', 'asc')
            ->get();

        $totalContas = $contasAPagar->count();
        $valorTotalFaturas = $contasAPagar->sum('valor');

        $formasPagamento = FormaDePagamento::orderBy('nome')->get();

        return view('contas_a_pagar.index', compact(
            'contasAPagar',
            'totalContas',
            'valorTotalFaturas',
            'formasPagamento'
        ));
    }

    public function create()
    {
        $empresaId = $this->empresaId();

        $fornecedores = Fornecedor::where('empresa_id', $empresaId)
            ->orderBy('nome')
            ->get();

        $formasDePagamento = FormaDePagamento::orderBy('nome')->get();

        $prazos = Prazo::orderBy('prazo')->get();

        return view('contas_a_pagar.create', compact(
            'fornecedores',
            'formasDePagamento',
            'prazos'
        ));
    }

    public function store(Request $request)
    {
        $empresaId = $this->empresaId();

        $request->validate([
            'fornecedor_id' => [
                'required',
                Rule::exists('fornecedores', 'id')->where(function ($query) use ($empresaId) {
                    return $query->where('empresa_id', $empresaId);
                }),
            ],
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'data_compra' => 'required|date',
            'forma_pagamento_id' => 'required|exists:formas_de_pagamento,id',
            'prazo' => 'required|exists:prazos,id',
        ]);

        $prazo = Prazo::findOrFail($request->prazo);
        $prazoDias = (int) filter_var($prazo->prazo, FILTER_SANITIZE_NUMBER_INT);

        $dataVencimento = Carbon::parse($request->data_compra)->addDays($prazoDias);

        ContasAPagar::create([
            'empresa_id' => $empresaId,
            'fornecedor_id' => $request->fornecedor_id,
            'descricao' => $request->descricao,
            'valor' => $request->valor,
            'data_compra' => $request->data_compra,
            'data_vencimento' => $dataVencimento,
            'data_pagamento' => null,
            'status' => 'pendente',
            'forma_pagamento_id' => $request->forma_pagamento_id,
            'prazo' => $prazoDias,
        ]);

        return redirect()
            ->route('contas_a_pagar.index')
            ->with('success', 'Conta a pagar criada com sucesso!');
    }

    public function edit($id)
    {
        $empresaId = $this->empresaId();

        $contaAPagar = ContasAPagar::where('empresa_id', $empresaId)
            ->where('id', $id)
            ->firstOrFail();

        $fornecedores = Fornecedor::where('empresa_id', $empresaId)
            ->orderBy('nome')
            ->get();

        $formas_pagamento = FormaDePagamento::orderBy('nome')->get();

        return view('contas_a_pagar.edit', compact(
            'contaAPagar',
            'fornecedores',
            'formas_pagamento'
        ));
    }

    public function update(Request $request, $id)
    {
        $empresaId = $this->empresaId();

        $request->validate([
            'fornecedor_id' => [
                'required',
                Rule::exists('fornecedores', 'id')->where(function ($query) use ($empresaId) {
                    return $query->where('empresa_id', $empresaId);
                }),
            ],
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'data_vencimento' => 'required|date',
            'data_pagamento' => 'nullable|date',
            'forma_pagamento_id' => 'required|exists:formas_de_pagamento,id',
            'status' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $contaAPagar = ContasAPagar::where('empresa_id', $empresaId)
                ->where('id', $id)
                ->firstOrFail();

            $statusAnterior = $contaAPagar->status;

            $dadosAtualizacao = $request->only([
                'fornecedor_id',
                'descricao',
                'valor',
                'data_vencimento',
                'data_pagamento',
                'forma_pagamento_id',
                'status',
                'observacao',
            ]);

            $dadosAtualizacao['empresa_id'] = $empresaId;

            $contaAPagar->update($dadosAtualizacao);

            if ($statusAnterior !== 'pago' && $request->status === 'pago') {
                $forma = FormaDePagamento::findOrFail($request->forma_pagamento_id);
                $nomeForma = strtolower(trim($forma->nome));

                $dados = [
                    'empresa_id' => $empresaId,
                    'data_movimentacao' => $request->data_pagamento ?? now()->toDateString(),
                    'tipo' => 'saida',
                    'valor' => $contaAPagar->valor,
                    'origem' => 'compra',
                    'descricao' => 'Pagamento conta a pagar #' . $contaAPagar->id,
                    'referencia_id' => $contaAPagar->id,
                ];

                if ($nomeForma === 'dinheiro') {
                    Caixa::create($dados);
                } else {
                    CaixaBanco::create(array_merge($dados, [
                        'forma' => $nomeForma
                    ]));
                }
            }

            DB::commit();

            return redirect($request->return_url ?? route('contas_a_pagar.index'))
                ->with('success', 'Conta a pagar atualizada com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erro ao atualizar conta a pagar', [
                'erro' => $e->getMessage(),
                'linha' => $e->getLine(),
                'arquivo' => $e->getFile(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao atualizar conta a pagar: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $empresaId = $this->empresaId();

        $contaAPagar = ContasAPagar::where('empresa_id', $empresaId)
            ->where('id', $id)
            ->firstOrFail();

        $contaAPagar->delete();

        return redirect($request->return_url ?? route('contas-a-pagar.index'))
            ->with('success', 'Conta a pagar excluída com sucesso!');
    }

    public function relatorioContasAPagar(Request $request)
    {
        $empresaId = $this->empresaId();

        $query = ContasAPagar::with(['fornecedor', 'formaPagamento'])
            ->where('empresa_id', $empresaId);

        if ($request->filled('fornecedor')) {
            $query->whereHas('fornecedor', function ($q) use ($request, $empresaId) {
                $q->where('empresa_id', $empresaId)
                    ->where('nome', 'like', '%' . $request->fornecedor . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->data_pagamento_inicial) {
            $query->whereDate('data_pagamento', '>=', $request->data_pagamento_inicial);
        }

        if ($request->data_pagamento_final) {
            $query->whereDate('data_pagamento', '<=', $request->data_pagamento_final);
        }

        if ($request->filled('data_compra_inicial') && $request->filled('data_compra_final')) {
            $query->whereBetween('data_compra', [
                $request->data_compra_inicial,
                $request->data_compra_final
            ]);
        }

        if ($request->filled('data_emissao')) {
            $query->whereDate('data_compra', $request->data_emissao);
        }

        if ($request->filled('data_vencimento_inicial') && $request->filled('data_vencimento_final')) {
            $query->whereBetween('data_vencimento', [
                $request->data_vencimento_inicial,
                $request->data_vencimento_final
            ]);
        }

        if ($request->filled('data_pagamento')) {
            $query->whereDate('data_pagamento', $request->data_pagamento);
        }

        $contas = $query->orderBy('data_vencimento', 'asc')->get();

        $total_faturas = $contas->sum('valor');

        $formasDePagamento = FormaDePagamento::orderBy('nome')->get();

        return view('contas_a_pagar.relatorio', compact(
            'contas',
            'total_faturas',
            'formasDePagamento'
        ));
    }

    public function exportarExcel(Request $request)
    {
        $filtros = $request->only([
            'fornecedor',
            'status',
            'forma_pagamento_id',
            'data_compra_inicial',
            'data_compra_final',
            'data_vencimento_inicial',
            'data_vencimento_final',
            'data_pagamento',
        ]);

        $filtros['empresa_id'] = $this->empresaId();

        return (new ContasAPagarExport($filtros))->download();
    }
}