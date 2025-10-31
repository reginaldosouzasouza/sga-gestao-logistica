<?php

namespace App\Http\Controllers\Padaria;

use App\Http\Controllers\Controller;
use App\Models\Padaria\PadEncomenda;
use App\Models\Padaria\PadEncomendaStatusLog;
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

        return view('padaria.encomendas.index', compact('encomendas'));
    }

    public function create()
    {
        // Gera o próximo código com segurança (lock) em uma transação rápida
        $proxCodigo = DB::connection('padaria')->transaction(function () {
            return (PadEncomenda::lockForUpdate()->max('cliente_codigo') ?? 0) + 1;
        });

        return view('padaria.encomendas.create', compact('proxCodigo'));
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
            ->route('padaria.encomendas.index')
            ->with('success', 'Encomenda criada com sucesso!');
    }

    public function show(PadEncomenda $encomenda)
    {
        $encomenda->load(['itens','statusLogs']);
        return view('padaria.encomendas.show', compact('encomenda'));
    }

    public function edit(PadEncomenda $encomenda)
    {
        return view('padaria.encomendas.edit', compact('encomenda'));
    }

    public function update(Request $request, PadEncomenda $encomenda)
    {
        $data = $request->validate([
            'nome'              => 'nullable|string|max:150',
            'data_pedido'       => 'nullable|date',
            'data_retirada'     => 'nullable|date',
            'hora_retirada'     => 'nullable',
            'forma_pagamento'   => 'nullable|string|max:30',
            'pagamento_status'  => ['required', Rule::in(['Pago','Pendente'])],
            'sinal'             => 'nullable|numeric|min:0',
            'canal'             => 'nullable|string|max:50',
            'observacao'        => 'nullable|string|max:5000',
            'status'            => ['required', Rule::in(\App\Models\Padaria\PadEncomenda::STATUS)],
            'status_obs'        => 'nullable|string|max:500',
        ]);

        $statusObs = trim((string)($data['status_obs'] ?? ''));
        unset($data['status_obs']);

        $statusAntes = $encomenda->status;

        $encomenda->update($data);

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

    public function destroy(PadEncomenda $encomenda)
    {
        $encomenda->delete();
        return back()->with('success', 'Encomenda excluída!');
    }
}

