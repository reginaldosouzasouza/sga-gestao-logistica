<?php

namespace App\Http\Controllers\Padoca;

use App\Http\Controllers\Controller;
use App\Models\Padoca\PadEncomenda;
use App\Models\Padoca\PadEncomendaStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EncomendaController extends Controller
{
    public function index(Request $request)
    {
        $q = PadEncomenda::query()->orderByDesc('created_at');

        if ($request->filled('status')) {
            $q->where('status', $request->status);
        }

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

        return view('padoca.encomendas.index', compact('encomendas'));
    }

    public function create()
    {
        // Gera o próximo código com segurança (lock) em uma transação rápida
        $proxCodigo = DB::connection('padaria')->transaction(function () {
            return (PadEncomenda::lockForUpdate()->max('cliente_codigo') ?? 0) + 1;
        });

        return view('padoca.encomendas.create', compact('proxCodigo'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cliente_codigo'        => 'required|integer|min:1',
            'cliente_id'            => 'nullable|integer',
            'nome'                  => 'nullable|string|max:150',
            'data_pedido'           => 'nullable|date',
            'data_retirada'         => 'required|date',
            'hora_retirada'         => 'nullable',
            'forma_pagamento'       => 'nullable|string|max:30',
            'pagamento_status'      => ['required', Rule::in(['Pago','Pendente'])],
            'sinal'                 => 'nullable|numeric|min:0',
            'canal'                 => 'nullable|string|max:50',
            'observacao'            => 'nullable|string|max:5000',
            'status_obs'            => 'nullable|string|max:500',

            'itens'                         => 'required|array|min:1',
            'itens.*.produto_nome'          => 'required|string|max:150',
            'itens.*.quantidade'            => 'required|numeric|min:0.01',
            'itens.*.valor_unitario'        => 'required|numeric|min:0',
            'itens.*.adiantamento'          => 'nullable|numeric|min:0',
            'itens.*.tamanho'               => 'nullable|string|max:50',
            'itens.*.sabor'                 => 'nullable|string|max:50',
            'itens.*.personalizacao'        => 'nullable|string|max:2000',
        ]);

        DB::transaction(function () use ($data) {
            // (opcional) garantir unicidade do cliente_codigo
            $maxAtual = PadEncomenda::lockForUpdate()->max('cliente_codigo') ?? 0;
            if ((int)$data['cliente_codigo'] <= $maxAtual) {
                $data['cliente_codigo'] = $maxAtual + 1; // corrige silenciosamente
            }

            $enc = PadEncomenda::create([
                'cliente_id'       => $data['cliente_id'] ?? null,
                'cliente_codigo'   => $data['cliente_codigo'],
                'nome'             => $data['nome'] ?? null,
                'data_pedido'      => $data['data_pedido'] ?? now()->toDateString(),
                'data_encomenda'   => now()->toDateString(),
                'data_retirada'    => $data['data_retirada'],
                'hora_retirada'    => $data['hora_retirada'] ?? null,
                'status'           => 'Aberto',
                'forma_pagamento'  => $data['forma_pagamento'] ?? null,
                'pagamento_status' => $data['pagamento_status'],
                'sinal'            => $data['sinal'] ?? 0,
                'valor_total'      => 0,
                'canal'            => $data['canal'] ?? null,
                'observacao'       => $data['observacao'] ?? null,
            ]);

            $total = 0;
            foreach ($data['itens'] as $i) {
                $qtd = (float) $i['quantidade'];
                $vu  = (float) $i['valor_unitario'];
                $ad  = (float) ($i['adiantamento'] ?? 0);
                $linha = max(0, round(($qtd * $vu) - $ad, 2));

                $enc->itens()->create([
                    'produto_id'     => null,
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

            PadEncomendaStatusLog::create([
                'encomenda_id'    => $enc->id,
                'status_anterior' => null,
                'status_novo'     => 'Aberto',
                'user_id'         => auth()->id(),
                'observacao'      => $data['status_obs'] ?? 'Criação da encomenda',
            ]);
        });

        return redirect()
            ->route('padoca.encomendas.index')
            ->with('success', 'Encomenda criada com sucesso!');
    }

    public function show(PadEncomenda $encomenda)
    {
        $encomenda->load(['itens','statusLogs']);
        return view('padoca.encomendas.show', compact('encomenda'));
    }

    public function edit(PadEncomenda $encomenda)
    {
        return view('padoca.encomendas.edit', compact('encomenda'));
    }

    public function update(Request $request, PadEncomenda $encomenda)
{
    // 1. Valida só o que pode realmente mudar
    $data = $request->validate([
        'nome'              => 'nullable|string|max:150',
        'data_pedido'       => 'nullable|date',
        'data_retirada'     => 'nullable|date', // vamos tratar isso manualmente abaixo
        'hora_retirada'     => 'nullable',
        'forma_pagamento'   => 'nullable|string|max:30',
        'pagamento_status'  => ['required', Rule::in(['Pago','Pendente'])],
        'sinal'             => 'nullable|numeric|min:0',
        'canal'             => 'nullable|string|max:50',
        'observacao'        => 'nullable|string|max:5000',

        'status'            => ['required', Rule::in(\App\Models\Padoca\PadEncomenda::STATUS)],
        'status_obs'        => 'nullable|string|max:500',
    ]);

    // Pega o texto da observação de status e tira do array principal
    $statusObs = trim((string)($data['status_obs'] ?? ''));
    unset($data['status_obs']);

    // 2. NÃO perder valores obrigatórios já existentes
    // Se o front não mandou data_retirada, mantém a que já estava no banco
    if (!array_key_exists('data_retirada', $data) || empty($data['data_retirada'])) {
        $data['data_retirada'] = $encomenda->data_retirada;
    }

    // Se o front não mandou data_pedido, mantém a anterior
    if (!array_key_exists('data_pedido', $data) || empty($data['data_pedido'])) {
        $data['data_pedido'] = $encomenda->data_pedido;
    }

    // idem hora_retirada
    if (!array_key_exists('hora_retirada', $data) || $data['hora_retirada'] === null) {
        $data['hora_retirada'] = $encomenda->hora_retirada;
    }

    // 3. Guarda status anterior
    $statusAntes = $encomenda->status;

    // 4. Atualiza sem estourar NOT NULL
    $encomenda->update($data);

    // 5. Registrar log de alteração de status (se mudou o status ou se houve obs)
    $deveLogar = ($statusAntes !== $encomenda->status) || ($statusObs !== '');
    if ($deveLogar) {
        PadEncomendaStatusLog::create([
            'encomenda_id'    => $encomenda->id,
            'status_anterior' => $statusAntes,
            'status_novo'     => $encomenda->status,
            'user_id'         => auth()->id(),
            'observacao'      => $statusObs !== '' ? $statusObs : null,
        ]);
    }

    return back()->with('success', 'Encomenda atualizada!');
}

}

