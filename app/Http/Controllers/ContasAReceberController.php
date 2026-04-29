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
use App\Exports\ContasAReceberExport;

class ContasAReceberController extends Controller
{
    public function atualizarStatus()
    {
        $hoje = Carbon::today();

        $contasAtualizadas = ContasAReceber::where('status', 'pendente')
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
    $query = ContasAReceber::with(['cliente', 'formaPagamento']);

    // 1. Filtro por Cliente (Campo 'cliente' no Blade)
    if ($request->filled('cliente')) {
        $query->whereHas('cliente', fn($q) =>
            $q->where('nome', 'like', '%' . $request->cliente . '%')
        );
    }

    // 2. Filtro por Status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // 3. Filtro por Forma de Pagamento
    if ($request->filled('forma_pagamento_id')) {
        $query->where('forma_pagamento_id', $request->forma_pagamento_id);
    }

    // 4. Filtro por Intervalo de Data de Venda (Campos inicial e final no Blade)
    if ($request->filled('data_venda_inicial') && $request->filled('data_venda_final')) {
        $query->whereBetween('data_venda', [$request->data_venda_inicial, $request->data_venda_final]);
    }

    // 5. Filtro por Data de Vencimento (Campo 'data_vencimento' no Blade)
    if ($request->filled('data_vencimento')) {
        $query->whereDate('data_vencimento', $request->data_vencimento);
    }

    // 6. Filtro por Data de Recebimento (Campo 'data_recebimento' no Blade)
    if ($request->filled('data_recebimento')) {
        $query->whereDate('data_recebimento', $request->data_recebimento);
    }

    // ... (restante do código de ordenação e retorno da view permanece igual)



    // Ordenação
    if ($request->filled('status')) {
        // Quando filtrar por status (ex: pendente), ordenar por vencimento (mais antigo primeiro)
        $query->orderBy('data_vencimento', 'asc');
    } else {
        // Ao abrir a tela sem filtro:
        // 1º atrasado
        // 2º pendente
        // 3º recebido
        // Dentro de cada grupo: vencimento (mais antigo primeiro)
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
        return view('contas_a_receber.create', [
            'clientes' => Cliente::orderBy('nome')->get(),
            'formasDePagamento' => FormaDePagamento::all(),
            'prazos' => Prazo::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'data_vencimento' => 'required|date',
            'forma_pagamento_id' => 'required|exists:formas_de_pagamento,id',
            'prazo' => 'required|exists:prazos,prazo',
        ]);

        ContasAReceber::create([
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

        return redirect()->route('contas_a_receber.index')
            ->with('success', 'Conta a receber criada com sucesso!');
    }

    public function edit($id)
    {
        return view('contas_a_receber.edit', [
            'contaAReceber' => ContasAReceber::findOrFail($id),
            'clientes' => Cliente::all(),
            'formasDePagamento' => FormaDePagamento::all(),
            'prazos' => Prazo::all(),
        ]);
    }

        public function update(Request $request, $id)
{
    DB::beginTransaction();

    try {
        $conta = ContasAReceber::findOrFail($id);
        $statusAnterior = $conta->status;

        $conta->update([
            'cliente_id' => $request->cliente_id,
            'descricao' => $request->descricao,
            'valor' => $request->valor,
            'data_venda' => $request->data_venda ?? $conta->data_venda,
            'data_vencimento' => $request->data_vencimento,
            'data_recebimento' => $request->status === 'recebido' ? now()->toDateString() : null,
            'status' => $request->status,
            'forma_pagamento_id' => $request->forma_pagamento_id,
            'observacao' => $request->observacao,
            'prazo' => $request->prazo,
        ]);

        // Se mudou para recebido, lança no caixa/banco
        if ($statusAnterior !== 'recebido' && $request->status === 'recebido') {

            $forma = FormaDePagamento::find($request->forma_pagamento_id);
            $nomeForma = strtolower($forma->nome);

            if (str_contains($nomeForma, 'dinheiro')) {

                Caixa::create([
                    'data_movimentacao' => now()->toDateString(),
                    'tipo' => 'entrada',
                    'valor' => $conta->valor,
                    'origem' => 'recebimento',
                    'descricao' => 'Recebimento conta a receber #' . $conta->id,
                    'referencia_id' => $conta->id,
                ]);

            } else {

                CaixaBanco::create([
                    'data_movimentacao' => now()->toDateString(),
                    'tipo' => 'entrada',
                    'valor' => $conta->valor,
                    'origem' => 'recebimento',
                    'descricao' => 'Recebimento conta a receber #' . $conta->id,
                    'referencia_id' => $conta->id,
                ]);
            }
        }

        DB::commit();

        // 🔥 AQUI ESTÁ A CORREÇÃO
        return redirect()->route('contas_a_receber.index', $request->query())
            ->with('success', 'Conta a receber atualizada com sucesso.');

    } catch (\Exception $e) {

        DB::rollBack();
        Log::error('Erro ao atualizar conta a receber', ['erro' => $e->getMessage()]);

        return redirect()->back()->withErrors('Erro ao atualizar conta.');
    }
}

    public function destroy($id)
    {
        ContasAReceber::findOrFail($id)->delete();
        return redirect()->route('contas_a_receber.index')
            ->with('success', 'Conta a receber excluída com sucesso!');
    }

    // RELATÓRIO CONTAS A RECEBER
   public function relatorio(Request $request)
{
    $query = ContasAReceber::with(['cliente', 'formaPagamento']);

    // Filtro por Cliente
    if ($request->filled('cliente')) {
        $query->whereHas('cliente', fn($q) => $q->where('nome', 'like', '%' . $request->cliente . '%'));
    }

    // Filtro por Status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Filtro por Forma de Pagamento
    if ($request->filled('forma_pagamento_id')) {
        $query->where('forma_pagamento_id', $request->forma_pagamento_id);
    }

    // Intervalos de Datas (Venda, Vencimento e Recebimento)
    $filtrosData = [
        'data_venda' => ['inicial' => 'data_venda_inicial', 'final' => 'data_venda_final'],
        'data_vencimento' => ['inicial' => 'data_vencimento_inicial', 'final' => 'data_vencimento_final'],
        'data_recebimento' => ['inicial' => 'data_recebimento_inicial', 'final' => 'data_recebimento_final']
    ];

    foreach ($filtrosData as $coluna => $campos) {
        if ($request->filled($campos['inicial']) && $request->filled($campos['final'])) {
            $query->whereBetween($coluna, [$request->input($campos['inicial']), $request->input($campos['final'])]);
        }
    }

    $contas = $query->orderBy('data_vencimento', 'asc')->get();

    return view('contas_a_receber.relatorio', [
        'contas' => $contas,
        'formasDePagamento' => \App\Models\FormaDePagamento::all(),
        'total_faturas' => $contas->sum('valor'),
    ]);
}

public function exportarCsv(Request $request)
{
    $filtros = $request->only([
        'cliente', 'status', 'forma_pagamento_id',
        'data_venda_inicial', 'data_venda_final',
        'data_vencimento_inicial', 'data_vencimento_final',
        'data_recebimento_inicial', 'data_recebimento_final',
    ]);

    return (new ContasAReceberExport($filtros))->download();
}


}
