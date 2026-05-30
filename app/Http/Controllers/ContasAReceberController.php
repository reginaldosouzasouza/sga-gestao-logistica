<?php

namespace App\Http\Controllers;

use App\Models\ContasAReceber;
use App\Models\Cliente;
use App\Models\FormaDePagamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Prazo;
use Carbon\Carbon;
use App\Models\CaixaBanco;
use App\Models\Caixa;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Exports\ContasAReceberExport;

class ContasAReceberController extends Controller
{
    private function empresaId()
    {
        return auth()->user()->empresa_id;
    }

    public function atualizarStatus()
    {
        $empresaId = $this->empresaId();
        $hoje = Carbon::today();

        $contasAtualizadas = ContasAReceber::where('empresa_id', $empresaId)
            ->where('status', 'pendente')
            ->where('data_vencimento', '<', $hoje)
            ->update(['status' => 'atrasado']);

        return redirect()->back()->with(
            $contasAtualizadas > 0 ? 'success' : 'info',
            $contasAtualizadas > 0
                ? 'Status atualizado com sucesso!'
                : 'Nenhuma conta para atualizar.'
        );
    }

    public function index(Request $request)
    {
        $empresaId = $this->empresaId();

        $query = ContasAReceber::with(['cliente', 'formaPagamento'])
            ->where('empresa_id', $empresaId);

        if ($request->filled('cliente')) {
            $query->whereHas('cliente', function ($q) use ($request, $empresaId) {
                $q->where('empresa_id', $empresaId)
                    ->where('nome', 'like', '%' . $request->cliente . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('forma_pagamento_id')) {
            $query->where('forma_pagamento_id', $request->forma_pagamento_id);
        }

        if ($request->filled('data_venda_inicial') && $request->filled('data_venda_final')) {
            $query->whereBetween('data_venda', [
                $request->data_venda_inicial,
                $request->data_venda_final
            ]);
        }

        if ($request->filled('data_vencimento')) {
            $query->whereDate('data_vencimento', $request->data_vencimento);
        }

        if ($request->filled('data_recebimento')) {
            $query->whereDate('data_recebimento', $request->data_recebimento);
        }

        if ($request->filled('status')) {
            $query->orderBy('data_vencimento', 'asc');
        } else {
            $query->orderByRaw("
                CASE
                    WHEN status = 'atrasado' THEN 0
                    WHEN status = 'pendente' THEN 1
                    WHEN status = 'recebido' THEN 2
                    ELSE 3
                END
            ")->orderBy('data_vencimento', 'asc');
        }

        $contasAReceber = $query->get();

        return view('contas_a_receber.index', [
            'contasAReceber' => $contasAReceber,
            'formasDePagamento' => FormaDePagamento::all(),
            'totalContas' => $contasAReceber->count(),
            'valorTotalFaturas' => $contasAReceber->sum('valor'),
        ]);
    }

    public function create()
    {
        $empresaId = $this->empresaId();

        return view('contas_a_receber.create', [
            'clientes' => Cliente::where('empresa_id', $empresaId)
                ->orderBy('nome')
                ->get(),
            'formasDePagamento' => FormaDePagamento::all(),
            'prazos' => Prazo::all(),
        ]);
    }

    public function store(Request $request)
    {
        $empresaId = $this->empresaId();

        $request->validate([
            'cliente_id' => [
                'required',
                Rule::exists('clientes', 'id')->where(function ($query) use ($empresaId) {
                    return $query->where('empresa_id', $empresaId);
                }),
            ],
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'data_vencimento' => 'required|date',
            'forma_pagamento_id' => 'required|exists:formas_de_pagamento,id',
            'prazo' => 'required|exists:prazos,prazo',
        ]);

        ContasAReceber::create([
            'empresa_id' => $empresaId,
            'cliente_id' => $request->cliente_id,
            'descricao' => $request->descricao,
            'valor' => $request->valor,
            'data_venda' => $request->data_venda ?? now()->toDateString(),
            'data_vencimento' => $request->data_vencimento,
            'status' => 'pendente',
            'forma_pagamento_id' => $request->forma_pagamento_id,
            'observacao' => $request->observacao,
            'prazo' => $request->prazo,
        ]);

        return redirect()
            ->route('contas_a_receber.index')
            ->with('success', 'Conta a receber criada com sucesso!');
    }

    public function edit($id)
    {
        $empresaId = $this->empresaId();

        return view('contas_a_receber.edit', [
            'contaAReceber' => ContasAReceber::where('empresa_id', $empresaId)
                ->where('id', $id)
                ->firstOrFail(),

            'clientes' => Cliente::where('empresa_id', $empresaId)
                ->orderBy('nome')
                ->get(),

            'formasDePagamento' => FormaDePagamento::all(),
            'prazos' => Prazo::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $empresaId = $this->empresaId();

        DB::beginTransaction();

        try {
            $conta = ContasAReceber::where('empresa_id', $empresaId)
                ->where('id', $id)
                ->firstOrFail();

            $request->validate([
                'cliente_id' => [
                    'required',
                    Rule::exists('clientes', 'id')->where(function ($query) use ($empresaId) {
                        return $query->where('empresa_id', $empresaId);
                    }),
                ],
                'descricao' => 'required|string|max:255',
                'valor' => 'required|numeric',
                'data_vencimento' => 'required|date',
                'forma_pagamento_id' => 'required|exists:formas_de_pagamento,id',
                'status' => 'required',
                'prazo' => 'nullable',
            ]);

            $statusAnterior = $conta->status;

            $conta->update([
                'empresa_id' => $empresaId,
                'cliente_id' => $request->cliente_id,
                'descricao' => $request->descricao,
                'valor' => $request->valor,
                'data_venda' => $request->data_venda ?? $conta->data_venda,
                'data_vencimento' => $request->data_vencimento,
                'data_recebimento' => $request->status === 'recebido'
                    ? now()->toDateString()
                    : null,
                'status' => $request->status,
                'forma_pagamento_id' => $request->forma_pagamento_id,
                'observacao' => $request->observacao,
                'prazo' => $request->prazo,
            ]);

            if ($statusAnterior !== 'recebido' && $request->status === 'recebido') {
                $forma = FormaDePagamento::find($request->forma_pagamento_id);
                $nomeForma = strtolower($forma->nome ?? '');

                $dadosMovimento = [
                    'empresa_id' => $empresaId,
                    'data_movimentacao' => now()->toDateString(),
                    'tipo' => 'entrada',
                    'valor' => $conta->valor,
                    'origem' => 'recebimento',
                    'descricao' => 'Recebimento conta a receber #' . $conta->id,
                    'referencia_id' => $conta->id,
                ];

                if (str_contains($nomeForma, 'dinheiro')) {
                    Caixa::create($dadosMovimento);
                } else {
                    CaixaBanco::create(array_merge($dadosMovimento, [
                        'forma' => $nomeForma,
                    ]));
                }
            }

            DB::commit();

            return redirect()
                ->route('contas_a_receber.index', $request->query())
                ->with('success', 'Conta a receber atualizada com sucesso.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erro ao atualizar conta a receber', [
                'erro' => $e->getMessage(),
                'linha' => $e->getLine(),
                'arquivo' => $e->getFile(),
            ]);

            return redirect()
                ->back()
                ->withErrors('Erro ao atualizar conta: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $empresaId = $this->empresaId();

        ContasAReceber::where('empresa_id', $empresaId)
            ->where('id', $id)
            ->firstOrFail()
            ->delete();

        return redirect()
            ->route('contas_a_receber.index')
            ->with('success', 'Conta a receber excluída com sucesso!');
    }

    public function relatorio(Request $request)
    {
        $empresaId = $this->empresaId();

        $query = ContasAReceber::with(['cliente', 'formaPagamento'])
            ->where('empresa_id', $empresaId);

        if ($request->filled('cliente')) {
            $query->whereHas('cliente', function ($q) use ($request, $empresaId) {
                $q->where('empresa_id', $empresaId)
                    ->where('nome', 'like', '%' . $request->cliente . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('forma_pagamento_id')) {
            $query->where('forma_pagamento_id', $request->forma_pagamento_id);
        }

        $filtrosData = [
            'data_venda' => [
                'inicial' => 'data_venda_inicial',
                'final' => 'data_venda_final'
            ],
            'data_vencimento' => [
                'inicial' => 'data_vencimento_inicial',
                'final' => 'data_vencimento_final'
            ],
            'data_recebimento' => [
                'inicial' => 'data_recebimento_inicial',
                'final' => 'data_recebimento_final'
            ],
        ];

        foreach ($filtrosData as $coluna => $campos) {
            if ($request->filled($campos['inicial']) && $request->filled($campos['final'])) {
                $query->whereBetween($coluna, [
                    $request->input($campos['inicial']),
                    $request->input($campos['final'])
                ]);
            }
        }

        $contas = $query->orderBy('data_vencimento', 'asc')->get();

        return view('contas_a_receber.relatorio', [
            'contas' => $contas,
            'formasDePagamento' => FormaDePagamento::all(),
            'total_faturas' => $contas->sum('valor'),
        ]);
    }

    public function exportarCsv(Request $request)
    {
        $filtros = $request->only([
            'cliente',
            'status',
            'forma_pagamento_id',
            'data_venda_inicial',
            'data_venda_final',
            'data_vencimento_inicial',
            'data_vencimento_final',
            'data_recebimento_inicial',
            'data_recebimento_final',
        ]);

        $filtros['empresa_id'] = $this->empresaId();

        return (new ContasAReceberExport($filtros))->download();
    }
}