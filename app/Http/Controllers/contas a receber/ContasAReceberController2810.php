<?php
namespace App\Http\Controllers;

use App\Models\ContasAReceber;
use App\Models\Cliente;
use App\Models\FormaDePagamento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ContasAReceberController extends Controller
{
    // Função para atualizar o status das contas atrasadas
    protected function atualizarStatusAtrasado()
    {
        // Buscar todas as contas a receber com status 'pendente' e data de vencimento menor que hoje
        $contasPendentes = ContasAReceber::where('status', 'pendente')
            ->where('data_vencimento', '<', Carbon::today())
            ->get();

        // Atualizar o status para 'atrasado'
        foreach ($contasPendentes as $conta) {
            $conta->status = 'atrasado';
            $conta->save();
        }
    }

    // Método index atualizado
    public function index(Request $request)
    {
        // Chamar a função para atualizar o status das contas atrasadas
        $this->atualizarStatusAtrasado();

        // Iniciar a query
        $query = ContasAReceber::query();

        // Filtros aplicados
        if ($request->filled('cliente')) {
            $query->whereHas('cliente', function ($q) use ($request) {
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

    use Carbon\Carbon;
    use Illuminate\Support\Facades\Log;
    
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
    
        // Define a data de venda como a data atual se não for fornecida
        $dataVenda = $request->input('data_venda') ?? now()->format('Y-m-d');
    
        // Converte a data de vencimento para um objeto Carbon
        $dataVencimento = Carbon::parse($request->data_vencimento);
    
        // Verifica se a data de vencimento é anterior à data atual para definir o status
        $status = $dataVencimento->lt(Carbon::today()) ? 'atrasado' : 'pendente';
    
        // Adiciona logs para depuração
        Log::info('Data de vencimento recebida: ' . $dataVencimento->format('Y-m-d'));
        Log::info('Data atual: ' . Carbon::today()->format('Y-m-d'));
        Log::info('Status definido antes de salvar: ' . $status);
    
        // Verificar se é "Dinheiro", "PIX" ou "À vista"
        $formaPagamento = FormaDePagamento::find($request->forma_pagamento_id);
        $prazo = $request->prazo;
    
        if (in_array($formaPagamento->nome, ['Dinheiro', 'PIX']) || $prazo === 'À vista') {
            // Cria um registro direto no pedido de coleta com pagamento concluído
            PedidoColeta::create([
                'cliente_id' => $request->cliente_id,
                'descricao' => $request->descricao,
                'valor' => $request->valor,
                'data_venda' => $dataVenda,
                'data_recebimento' => now()->format('Y-m-d'),
                'status' => 'pago',
                'forma_pagamento_id' => $request->forma_pagamento_id,
            ]);
    
            return redirect()->route('pedidos_coleta.index')
                ->with('success', 'Pedido de coleta com pagamento à vista registrado com sucesso!');
        }
    
        // Adiciona log antes de salvar a conta a receber
        Log::info('Criando conta a receber com status: ' . $status);
    
        // Cria a conta a receber para outras condições
        ContasAReceber::create([
            'cliente_id' => $request->cliente_id,
            'descricao' => $request->descricao,
            'valor' => $request->valor,
            'data_venda' => $dataVenda,
            'data_vencimento' => $request->data_vencimento,
            'status' => $status, // Define o status conforme a lógica
            'forma_pagamento_id' => $request->forma_pagamento_id,
            'observacao' => $request->observacao,
            'prazo' => $prazoSelecionado->prazo, // Salva o nome do prazo
        ]);
    
        Log::info('Conta a receber criada com sucesso. Status final: ' . $status);
    
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
        'status' => 'required|string|in:pendente,pago,atrasado',
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
