<?php

namespace App\Http\Controllers;


use App\Models\ContasAReceber;
use App\Models\Cliente;
use App\Models\FormaDePagamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Prazo;
use Carbon\Carbon;



class ContasAReceberController extends Controller
{

    public function atualizarStatus()
{
    $hoje = Carbon::today();

    // Atualiza as contas pendentes cujo vencimento já passou
    $contasAtualizadas = ContasAReceber::where('status', 'pendente')
        ->where('data_vencimento', '<', $hoje)
        ->update(['status' => 'atrasado']);

    // Retorne uma mensagem baseada na atualização
    if ($contasAtualizadas > 0) {
        return redirect()->back()->with('success', 'Status atualizado com sucesso!');
    } else {
        return redirect()->back()->with('info', 'Nenhuma conta para atualizar.');
    }
}



    public function index(Request $request)
    {
        $query = ContasAReceber::query();
    
        // Filtros aplicados
        if ($request->filled('cliente')) {
            $query->whereHas('cliente', function($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->cliente . '%');
            });
        }
    
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        if ($request->filled('forma_pagamento_id')) {
            $query->where('forma_pagamento_id', $request->forma_pagamento_id);
        }

        // Filtro por período da data de venda
        if ($request->filled('data_venda_inicial') && $request->filled('data_venda_final')) {
            $query->whereBetween('data_venda', [$request->data_venda_inicial, $request->data_venda_final]);
        }
            
        if ($request->filled('data_venda')) {
            $query->whereDate('data_venda', $request->data_venda);
        }
    
        if ($request->filled('data_vencimento')) {
            $query->whereDate('data_vencimento', $request->data_vencimento);
        }
    
        if ($request->filled('data_recebimento')) {
            $query->whereDate('data_recebimento', $request->data_recebimento);
        }
    
        $contasAReceber = $query->with(['cliente', 'formaPagamento'])->get();


            // Ordenar pela data de vencimento de forma decrescente
            $contasAReceber = $query->orderBy('data_vencimento', 'desc')->get();

        // Variáveis de totalização
            $totalContas = $contasAReceber->count(); // Total de registros
            $valorTotalFaturas = $contasAReceber->sum('valor'); // Soma dos valores


        $formasDePagamento = FormaDePagamento::all(); // Carregando todas as formas de pagamento
    
        return view('contas_a_receber.index', compact('contasAReceber', 'formasDePagamento', 'totalContas', 'valorTotalFaturas'));
    }
    


    
    public function create()
    {
        $clientes = Cliente::all();
        $formasDePagamento = FormaDePagamento::all();
        $prazos = Prazo::all(); // Carregando os prazos
        return view('contas_a_receber.create', compact('clientes', 'formasDePagamento', 'prazos'));
    }




    public function store(Request $request)
{
    $request->validate([
        'cliente_id' => 'required|exists:clientes,id',
        'descricao' => 'required|string|max:255',
        'valor' => 'required|numeric',
        'data_vencimento' => 'required|date',
        'forma_pagamento_id' => 'required|exists:formas_de_pagamento,id',
        'data_venda' => 'nullable|date',
        'prazo' => 'required|exists:prazos,prazo',
    ]);

    // Log dos dados recebidos
    \Log::info('Dados recebidos na requisição:', $request->all());

    // Define a data de venda como a data atual se não for fornecida
    $dataVenda = $request->input('data_venda') ?? now()->format('Y-m-d');
    $prazo = $request->input('prazo');
    $formaPagamento = FormaDePagamento::find($request->forma_pagamento_id);

    // Log dos valores importantes
    \Log::info('Forma de pagamento recebida: ' . $formaPagamento->nome);
    \Log::info('Prazo recebido: ' . $prazo);

    // Verificar se é "Dinheiro", "PIX" ou "À vista"
    if (in_array(strtolower($formaPagamento->nome), ['dinheiro', 'pix']) && strtolower($prazo) === 'avista') {
        \Log::info('Condição atendida: Forma de pagamento = Dinheiro/PIX e Prazo = À vista');
        
        // Criar uma conta a receber como paga
        ContasAReceber::create([
            'cliente_id' => $request->cliente_id,
            'descricao' => $request->descricao,
            'valor' => $request->valor,
            'data_venda' => $dataVenda,
            'data_vencimento' => $dataVenda,
            'data_recebimento' => now()->format('Y-m-d'),
            'status' => 'recebido',
            'forma_pagamento_id' => $request->forma_pagamento_id,
            'observacao' => $request->observacao,
            'prazo' => $prazo,
        ]);

        return redirect()->route('contas_a_receber.index')
            ->with('success', 'Conta a receber registrada como paga com sucesso!');
    }

    // Lógica para outras condições
    \Log::info('Condição não atendida, criando conta como pendente.');
    ContasAReceber::create([
        'cliente_id' => $request->cliente_id,
        'descricao' => $request->descricao,
        'valor' => $request->valor,
        'data_venda' => $dataVenda,
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
    // Registrar o ID recebido no log para depuração
    Log::info('ID recebido no método edit: ' . $id);

    // Buscar a conta a receber pelo ID ou lançar um erro 404 se não encontrar
    $conta = ContasAReceber::findOrFail($id);

    // Carregar todos os clientes para o dropdown
    $clientes = Cliente::all();

    // Carregar todas as formas de pagamento para o dropdown
    $formasDePagamento = FormaDePagamento::all();
    $prazos = Prazo::all(); // Adiciona os prazos

    // Retornar a view de edição com os dados necessários
    return view('contas_a_receber.edit', [
        'contaAReceber' => $conta,
        'clientes' => $clientes,
        'formasDePagamento' => $formasDePagamento,
        'prazos' => $prazos,
    ]);    
}



public function update(Request $request, $id)
{
    $request->validate([
        'cliente_id' => 'required|exists:clientes,id',
        'descricao' => 'required|string|max:255',
        'valor' => 'required|numeric',
        'data_venda' => 'nullable|date',
        'data_vencimento' => 'required|date',
        'forma_pagamento_id' => 'required|exists:formas_de_pagamento,id',
        'status' => 'required|string|in:pendente,recebido,atrasado',
        'observacao' => 'nullable|string|max:500',
        'prazo' => 'nullable|string',
    ]);

    $conta = ContasAReceber::findOrFail($id);

    // Define a data de venda como a data atual se não for fornecida
    $dataVenda = $request->input('data_venda') ?? $conta->data_venda;

    $conta->update([
        'cliente_id' => $request->cliente_id,
        'descricao' => $request->descricao,
        'valor' => $request->valor,
        'data_venda' => $dataVenda, // Certifica-se de que a data de venda está sendo atualizada
        'data_vencimento' => $request->data_vencimento,
        'data_recebimento' => $request->status == 'recebido' ? now() : $request->data_recebimento,
        'status' => $request->status,
        'forma_pagamento_id' => $request->forma_pagamento_id,
        'observacao' => $request->observacao,
        'prazo' => $request->prazo,
    ]);

    return redirect()->route('contas_a_receber.index')
        ->with('success', 'Conta a receber atualizada com sucesso!');
}




public function destroy($id)
{
    // Buscar a conta a receber pelo ID
    $conta = ContasAReceber::findOrFail($id);

    // Excluir a conta a receber
    $conta->delete();

    // Redirecionar para a listagem com uma mensagem de sucesso
    return redirect()->route('contas_a_receber.index')
        ->with('success', 'Conta a receber excluída com sucesso!');
}
 
   
}
