<?php

namespace App\Http\Controllers\Padaria;

use App\Http\Controllers\Controller;
use App\Models\Padaria\PadEncomenda;
use App\Models\Padaria\PadEncomendaStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EncomendaController extends Controller
{
    public function index(Request $request)
    {
        $q = PadEncomenda::query()->orderByDesc('created_at');

        if ($request->filled('status')) {
            $q->where('status', $request->status);
        }
         // 🔎 filtro por data_pedido (intervalo, início, fim)
        if ($request->filled('data_ini') && $request->filled('data_fim')) {
            $q->whereBetween('data_pedido', [$request->data_ini, $request->data_fim]);
        } elseif ($request->filled('data_ini')) {
            $q->whereDate('data_pedido', '>=', $request->data_ini);
        } elseif ($request->filled('data_fim')) {
            $q->whereDate('data_pedido', '<=', $request->data_fim);
        }
        if ($request->filled('cliente_codigo')) {
            $q->where('cliente_codigo', $request->cliente_codigo);
        }

        $encomendas = $q->paginate(15);
        return view('padaria.encomendas.index', compact('encomendas'));
    }

    public function create()  
    {
        $proxCodigo = (\App\Models\Padaria\PadEncomenda::max('cliente_codigo') ?? 0) + 1;
        return view('padaria.encomendas.create', compact('proxCodigo'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
    'cliente_codigo'        => 'required|integer|min:1',
    'cliente_id'            => 'nullable|integer', // se algum dia quiser referenciar cliente do GAS
    'nome'                  => 'nullable|string|max:150',
    'data_pedido'           => 'nullable|date',
    'data_retirada'         => 'required|date',
    'hora_retirada'         => 'nullable',
    'forma_pagamento'       => 'nullable|string|max:30',
    'pagamento_status'      => 'required|in:Pago,Pendente',
    'sinal'                 => 'nullable|numeric|min:0',
    'canal'                 => 'nullable|string|max:50',
    'observacao'            => 'nullable|string|max:5000',
    'status_obs'            => 'nullable|string|max:500', // observação opcional do log

    'itens'                         => 'required|array|min:1',
    'itens.*.produto_nome'          => 'required|string|max:150',
    'itens.*.quantidade'            => 'required|numeric|min:0.01',
    'itens.*.valor_unitario'        => 'required|numeric|min:0',
    'itens.*.adiantamento'          => 'nullable|numeric|min:0',
    'itens.*.tamanho'               => 'nullable|string|max:50',
    'itens.*.sabor'                 => 'nullable|string|max:50',
    'itens.*.personalizacao'        => 'nullable|string|max:2000',
]);

DB::connection('padaria')->transaction(function () use ($data) {
    $enc = \App\Models\Padaria\PadEncomenda::create([
        'cliente_id'         => $data['cliente_id'] ?? null,
        'cliente_codigo'     => $data['cliente_codigo'],
        'nome'               => $data['nome'] ?? null,
        'data_pedido'        => $data['data_pedido'] ?? now()->toDateString(),
        'data_encomenda'     => now()->toDateString(),
        'data_retirada'      => $data['data_retirada'],
        'hora_retirada'      => $data['hora_retirada'] ?? null,
        'status'             => 'Aberto',
        'forma_pagamento'    => $data['forma_pagamento'] ?? null,
        'pagamento_status'   => $data['pagamento_status'],
        'sinal'              => $data['sinal'] ?? 0,
        'valor_total'        => 0,
        'canal'              => $data['canal'] ?? null,
        'observacao'         => $data['observacao'] ?? null,
    ]);

    $total = 0;
    foreach ($data['itens'] as $i) {
        $qtd = (float)$i['quantidade'];
        $vu  = (float)$i['valor_unitario'];
        $ad  = isset($i['adiantamento']) ? (float)$i['adiantamento'] : 0;
        $linha = max(0, round(($qtd * $vu) - $ad, 2));

        $enc->itens()->create([
            'produto_id'     => null, // não usamos mais id
            'produto_nome'   => $i['produto_nome'],
            'quantidade'     => $qtd,
            'valor_unitario' => $vu,
            'adiantamento'   => $ad,
            'valor_total'    => $linha,
            'tamanho'        => $i['tamanho'] ?? null,
            'sabor'          => $i['sabor'] ?? null,
            'personalizacao' => $i['personalizacao'] ?? null,
        ]);

        $total += $linha;
    }

    $enc->update(['valor_total' => $total]);

        \App\Models\Padaria\PadEncomendaStatusLog::create([
        'encomenda_id'    => $enc->id,
        'status_anterior' => null,
        'status_novo'     => 'Aberto',
        'user_id'         => auth()->id() ?? null,
        'observacao'      => 'Criação da encomenda'
    ]);



});


        return redirect()->route('padaria.encomendas.index')->with('success', 'Encomenda criada com sucesso!');
    }


    public function show(\App\Models\Padaria\PadEncomenda $encomenda)
    {
        $encomenda->load(['itens','statusLogs']);
        return view('padaria.encomendas.show', compact('encomenda'));
    }

    public function edit(\App\Models\Padaria\PadEncomenda $encomenda)
    {
        return view('padaria.encomendas.edit', compact('encomenda'));
    }

    public function update(Request $request, PadEncomenda $encomenda)
    {
        // 1) Validação dos campos da encomenda + status_obs (só para o log)
        $data = $request->validate([
            'nome'              => 'nullable|string|max:150',
            'data_pedido'       => 'nullable|date',
            'data_retirada'     => 'nullable|date',
            'hora_retirada'     => 'nullable',
            'forma_pagamento'   => 'nullable|string|max:30',
            'pagamento_status'  => 'required|in:Pago,Pendente',
            'sinal'             => 'nullable|numeric|min:0',
            'canal'             => 'nullable|string|max:50',
            'observacao'        => 'nullable|string|max:5000', // observação geral da encomenda
            'status'            => 'required|in:Aberto,Produção,Pronto,Entregue,Cancelado',

            // ⚠️ ESTA É A OBSERVAÇÃO DO LOG DE STATUS
            'status_obs'        => 'nullable|string|max:500',
        ]);

        // 2) Captura e remove a observação do log do array de update
        $statusObs = trim((string)($data['status_obs'] ?? ''));
        unset($data['status_obs']); // não deve ir para a tabela pad_encomendas

        // 3) Detecta mudança de status
        $statusAntes = $encomenda->status;

        // 4) Atualiza a encomenda normalmente
        $encomenda->update($data);

        // 5) Critério para criar log:
        //    - status mudou OU o usuário digitou 'status_obs'
        $deveLogar = ($statusAntes !== $encomenda->status) || ($statusObs !== '');

        if ($deveLogar) {
            PadEncomendaStatusLog::create([
                'encomenda_id'    => $encomenda->id,
                'status_anterior' => $statusAntes,
                'status_novo'     => $encomenda->status,
                'user_id'         => auth()->id() ?? null,
                'observacao'      => $statusObs !== '' ? $statusObs : null,
            ]);
        }

        return back()->with('success', 'Encomenda atualizada!');
    }


    public function destroy(\App\Models\Padaria\PadEncomenda $encomenda)
    {
        $encomenda->delete();
        return back()->with('success', 'Encomenda excluída!');
    }
}
