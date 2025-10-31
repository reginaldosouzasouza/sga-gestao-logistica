@extends('layouts.app')

@section('title', 'Consultar, Visualizar e Alterar')

@section('content')
<div class="container">
    <h1>Encomendas - Padoca</h1>

    @if(session('success'))
        <div style="background:#dff0d8;padding:8px;margin-bottom:10px;border-radius:4px;">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" class="mb-3" style="display:grid;grid-template-columns:repeat(5,1fr);gap:8px;align-items:end;">
        <div>
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="">Todos</option>
                @foreach(['Aberto','Produção','Pronto','Entregue','Cancelado'] as $s)
                    <option value="{{ $s }}" {{ request('status')===$s?'selected':'' }}>{{ $s }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Data Inicial</label>
            <input type="date" name="data_ini" value="{{ request('data_ini') }}" class="form-control">
        </div>
        <div>
            <label>Data Final</label>
            <input type="date" name="data_fim" value="{{ request('data_fim') }}" class="form-control">
        </div>
        <div>
            <label>Cliente Cód.</label>
            <input type="number" name="cliente_codigo" value="{{ request('cliente_codigo') }}" class="form-control" placeholder="ex.: 101">
        </div>
        <div>
            <button class="btn btn-primary">Filtrar</button>
        </div>
    </form>

    <div class="mb-2">
        <a href="{{ route('padoca.encomendas.create') }}" class="btn btn-success">Nova Encomenda</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="text-align:center;">Cód. Cliente</th>
                <th>Cliente</th>
                <th>Data do Pedido</th>
                <th>Data e hora da Entrega</th>
                <th>Status</th>
                <th>Pagamento</th>
                <th>Valor Total (R$)</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($encomendas as $e)
                <tr>
                    {{-- CÓDIGO DO CLIENTE --}}
                    <td style="text-align: center;">
                        @if($e->cliente_codigo)
                            {{ $e->cliente_codigo }}
                        @else
                            —
                        @endif
                    </td>

                    {{-- NOME DO CLIENTE --}}
                    <td>{{ $e->nome ?? '—' }}</td>

                    {{-- DATA DO PEDIDO --}}
                    <td>
                        @if($e->data_pedido)
                            {{ \Carbon\Carbon::parse($e->data_pedido)->format('d/m/Y') }}
                        @else
                            —
                        @endif
                    </td>

                    {{-- DATA E HORA da ENTREGA --}}
                    <td>
                        @if($e->data_retirada)
                            {{ \Carbon\Carbon::parse($e->data_retirada)->format('d/m/Y') }}
                        @endif
                        {{ $e->hora_retirada }}
                    </td>

                    {{-- STATUS --}}
                    <td>
                        @php
                            $cores = [
                                'Aberto'=>'#f7e07d',
                                'Produção'=>'#f9b44a',
                                'Pronto'=>'#8ec5ff',
                                'Entregue'=>'#a9e5a1',
                                'Cancelado'=>'#f59b9b'
                            ];
                        @endphp
                        <span style="padding:4px 8px;border-radius:6px;background:{{ $cores[$e->status] ?? '#eee' }};">
                            {{ $e->status }}
                        </span>
                    </td>

                    {{-- PAGAMENTO --}}
                    <td>
                        @php $pago = ($e->pagamento_status === 'Pago'); @endphp

                        @if($pago && $e->forma_pagamento)
                            <span>{{ strtoupper($e->forma_pagamento) }}</span>
                        @endif

                        <span style="padding:2px 6px;border-radius:6px;
                            background: {{ $pago ? '#a9e5a1' : '#f7e07d' }};">
                            {{ $e->pagamento_status ?? '—' }}
                        </span>
                    </td>

                    {{-- VALOR TOTAL --}}
                    <td>{{ number_format($e->valor_total, 2, ',', '.') }}</td>

                    {{-- AÇÕES --}}
                    <td style="white-space:nowrap;">
                        <a href="{{ route('padoca.encomendas.show', $e) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('padoca.encomendas.edit', $e) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('padoca.encomendas.destroy', $e) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Excluir encomenda?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8">Nenhum registro.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- Paginação mantendo filtros --}}
    {{ $encomendas->withQueryString()->links() }}
</div>
@endsection

