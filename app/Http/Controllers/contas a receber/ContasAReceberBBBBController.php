<?php

namespace App\Http\Controllers;


use App\Models\ContasAReceber;
use App\Models\Cliente;
use App\Models\FormaDePagamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Prazo;



class ContasAReceberController extends Controller
{
 
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

        // Ordenação pela data de venda de forma decrescente
            $contasAReceber = $query->with(['cliente', 'formaPagamento'])
            ->orderBy('data_venda', 'desc')
            ->get();

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
        return view('contas_a_receber.create', compact('clientes', 'formasDePagamento'));
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
    
        $dataVenda = $request->input('data_venda') ?? now()->format('Y-m-d');
        $formaPagamento = FormaDePagamento::find($request->forma_pagamento_id);
        $prazo = $request->prazo;
    
        // Log para depuração
        \Log::info('Forma de Pagamento: ' . $formaPagamento->nome);
        \Log::info('Prazo: ' . $prazo);
    
        // Verificar se é "Dinheiro ou PIX", "PIX" ou prazo "À vista"
        if (in_array($formaPagamento->nome, ['Dinheiro', 'PIX']) || $prazo === 'À vista') {
            // Criar um registro direto no pedido de coleta com pagamento concluído
            PedidoColeta::create([
                'cliente_id' => $request->cliente_id,
                'descricao' => $request->descricao,
                'valor' => $request->valor,
                'data_venda' => $dataVenda,
                'data_recebimento' => now()->format('Y-m-d'),
                'status' => 'pago',
                'forma_pagamento_id' => $request->forma_pagamento_id,
            ]);
    
            \Log::info('Pedido de coleta criado com pagamento à vista, sem gerar conta a receber.');
    
            return redirect()->route('pedidos_coleta.index')
                ->with('success', 'Pedido de coleta com pagamento à vista registrado com sucesso!');
        }
    
        // Gerar conta a receber para outras condições
        ContasAReceber::create(array_merge($request->all(), [
            'data_venda' => $dataVenda,
        ]));
    
        \Log::info('Conta a receber criada com sucesso.');
    
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
    // Validação dos dados do formulário
    $request->validate([
        'cliente_id' => 'required|exists:clientes,id',
        'descricao' => 'required|string|max:255',
        'valor' => 'required|numeric',
        'data_venda' => 'nullable|date',
        'data_vencimento' => 'required|date',
        'forma_pagamento_id' => 'required|exists:formas_de_pagamento,id',
        'status' => 'required|string|in:pendente,pago,atrasado', // Validação do status
        'observacao' => 'nullable|string|max:500',
        'prazo' => 'nullable|string',
      
    ]);
    

    // Buscar a conta a receber pelo ID
    $conta = ContasAReceber::findOrFail($id);

    $dataVenda = $request->input('data_venda') ?? $conta->data_venda;

    $conta->update(array_merge($request->all(), [
        'data_venda' => $dataVenda,
    ]));

    
    // Redirecionar para a listagem com uma mensagem de sucesso
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
