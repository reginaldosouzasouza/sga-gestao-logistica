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


class ContasAPagarController extends Controller
{
    public function index(Request $request)
    {
        // Data atual
        $hoje = Carbon::now()->format('Y-m-d');
    
        // Atualiza o status para 'ATRASADO' apenas quando a data de vencimento é menor que a data de hoje
        ContasAPagar::where('data_vencimento', '<', $hoje)
            ->where('status', '!=', 'pago')
            ->update(['status' => 'atrasado']);

        // Atualiza o status para 'PENDENTE' quando a data de vencimento é igual à data de hoje
        ContasAPagar::where('data_vencimento', $hoje)
            ->where('status', '!=', 'pago')
            ->update(['status' => 'pendente']);
    
        // Filtro por fornecedor, status e data de vencimento
        $query = ContasAPagar::query();
    
        if ($request->filled('fornecedor')) {
            $query->whereHas('fornecedor', function ($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->fornecedor . '%');
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

     /*   if ($request->filled('data_compra')) {
            $query->where('data_compra', $request->data_compra);
        }*/

        // Filtro por período da data de compra
        if ($request->filled('data_compra_inicial') && $request->filled('data_compra_final')) {
            $query->whereBetween('data_compra', [$request->data_compra_inicial, $request->data_compra_final]);
        }

        // Ordena os resultados pela data de vencimento em ordem decrescente
        $contasAPagar = $query->orderBy('data_vencimento', 'desc')->get();

        // Calcula o total de registros
        $totalContas = $contasAPagar->count();

        // Calcula o valor total das faturas
        $valorTotalFaturas = $contasAPagar->sum('valor');

        // Retorna a view com os dados
        return view('contas_a_pagar.index', compact('contasAPagar', 'totalContas', 'valorTotalFaturas'));
    }

    public function create()
    {
        $fornecedores = Fornecedor::all();
        $formasDePagamento = FormaDePagamento::all();
        $prazos = Prazo::all(); // Carregar todos os prazos para o dropdown

        return view('contas_a_pagar.create', compact('fornecedores', 'formasDePagamento', 'prazos'));
    }

    public function store(Request $request) 
{
    Log::info('Teste de Log - Início do método store');

    // Log dos dados da requisição recebidos
    Log::info('Dados da requisição recebidos:', $request->all());

    // Validação dos campos de entrada
    $request->validate([
        'fornecedor_id' => 'required|exists:fornecedores,id',
        'descricao' => 'required|string|max:255',
        'valor' => 'required|numeric',
        'data_compra' => 'required|date',
        'forma_pagamento_id' => 'required|exists:formas_de_pagamento,id',
        'prazo' => 'required|exists:prazos,id',
    ]);

    // Obter o prazo selecionado e extrair o valor em dias
    $prazoSelecionado = Prazo::findOrFail($request->prazo);
    $prazoDias = (int) filter_var($prazoSelecionado->prazo, FILTER_SANITIZE_NUMBER_INT);
    Log::info('Prazo em dias extraído da tabela prazos:', ['prazoDias' => $prazoDias]);

    // Obter a compra associada
    $compra = Compra::where('fornecedor_id', $request->fornecedor_id)
                    ->where('data_compra', $request->data_compra)
                    ->first();

    if (!$compra) {
        return redirect()->back()->with('error', 'Compra não encontrada.');
    }

    // Criar a conta a pagar com base nos dados da compra
    ContasAPagar::create([
        'fornecedor_id' => $request->fornecedor_id,
        'descricao' => $request->descricao,
        'valor' => $request->valor,
        'data_compra' => $request->data_compra,
        'data_vencimento' => $compra->data_vencimento,
        'data_pagamento' => $compra->data_pagamento,
        'status' => $compra->status,
        'forma_pagamento_id' => $request->forma_pagamento_id,
        'prazo' => $prazoDias,
    ]);

    Log::info('Conta a pagar criada com sucesso no banco de dados.');

   // return redirect()->route('contas_a_pagar.index')->with('success', 'Conta a pagar criada com sucesso!');
    // Retorna a view
    return view('contas_a_pagar.index', compact(
        'contasAPagar',
        'totalContas',
        'valorTotalFaturas',
        'formas_de_pagamento'
    ));
}






    public function edit($id)
    {
        $contaAPagar = ContasAPagar::findOrFail($id);
        $fornecedores = Fornecedor::all();
        $formas_pagamento = FormaDePagamento::all();
        return view('contas_a_pagar.edit', compact('contaAPagar', 'fornecedores', 'formas_pagamento'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fornecedor_id' => 'required|exists:fornecedores,id',
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'data_vencimento' => 'required|date',
            'data_pagamento' => 'nullable|date',
            'forma_pagamento_id' => 'required|exists:formas_de_pagamento,id',
        ]);

        $contaAPagar = ContasAPagar::findOrFail($id);
        $contaAPagar->update($request->all());

        return redirect()->route('contas_a_pagar.index')->with('success', 'Conta a pagar atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $contaAPagar = ContasAPagar::findOrFail($id);
        $contaAPagar->delete();
        return redirect()->route('contas_a_pagar.index')->with('success', 'Conta a pagar excluída com sucesso!');
    }


    public function relatorioContasAPagar(Request $request)
    {
        $query = ContasAPagar::with(['fornecedor', 'formaPagamento']); 

        // Aplicar filtros caso sejam informados
        if ($request->filled('fornecedor')) {
            $query->whereHas('fornecedor', function ($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->fornecedor . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('forma_pagamento_id')) {
            $query->where('forma_pagamento_id', $request->forma_pagamento_id);
        }
        
        // Filtro por período da data de compra
        if ($request->filled('data_compra_inicial') && $request->filled('data_compra_final')) {
            $query->whereBetween('data_compra', [$request->data_compra_inicial, $request->data_compra_final]);
        }
   
        if ($request->filled('data_emissao')) {
            $query->whereDate('data_compra', $request->data_emissao);
        }

        if ($request->filled('data_vencimento')) {
            $query->whereDate('data_vencimento', $request->data_vencimento);
        }

        if ($request->filled('data_pagamento')) {
            $query->whereDate('data_pagamento', $request->data_pagamento);
        }

        $contas = $query->orderBy('data_vencimento', 'asc')->get();
        $total_faturas = $contas->sum('valor');
        $formasDePagamento = FormaDePagamento::all();

        return view('contas_a_pagar.relatorio', compact('contas', 'total_faturas', 'formasDePagamento'));
    }
}

