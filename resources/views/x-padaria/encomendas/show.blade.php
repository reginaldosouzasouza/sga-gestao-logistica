@extends('layouts.app')

@section('title', 'Detalhes da Encomenda')

@section('content')
{{-- CSS da página (com cache-busting) --}}
<link rel="stylesheet"
      href="{{ asset('padaria/css/detalhesencomenda.css') }}?v={{ filemtime(public_path('padaria/css/detalhesencomenda.css')) }}">

@php
    // helper para mapear o status para a classe css do badge
    $statusClass = function ($s) {
        return match($s) {
            'Aberto'     => 'status-aberto',
            'Produção'   => 'status-producao',
            'Pronto'     => 'status-pronto',
            'Entregue'   => 'status-entregue',
            'Cancelado'  => 'status-cancelado',
            default      => ''
        };
    };
@endphp

<div class="padaria">
  <div class="page">

    <h1>Detalhes da Encomenda #{{ $encomenda->id }}</h1>

    <div class="mb-2">
      <a href="{{ route('padaria.encomendas.index') }}" class="btn btn-outline">← Voltar</a>
      <a href="{{ route('padaria.encomendas.edit',$encomenda) }}" class="btn btn-warning">Editar</a>
    </div>

    {{-- CARD: dados principais --}}
    <div class="card mb-3">
      <p><strong>Cod. Pedido / Cliente:</strong>
        {{ $encomenda->cliente_codigo ? '#'.$encomenda->cliente_codigo : '—' }}
        @if($encomenda->nome) — {{ $encomenda->nome }} @endif
      </p>

      <p><strong>Data do Pedido:</strong>
        @if($encomenda->data_pedido)
          {{ \Carbon\Carbon::parse($encomenda->data_pedido)->format('d/m/Y') }}
        @else — @endif
      </p>

      <p><strong>Data do Registro:</strong>
        {{ \Carbon\Carbon::parse($encomenda->data_encomenda)->format('d/m/Y') }}
      </p>

      <p><strong>Data da Entrega:</strong>
        {{ \Carbon\Carbon::parse($encomenda->data_retirada)->format('d/m/Y') }}
        {{ $encomenda->hora_retirada }}
      </p>

      <p><strong>Status:</strong>
        <span class="badge {{ $statusClass($encomenda->status) }}">{{ $encomenda->status }}</span>
      </p>

      @php $pago = ($encomenda->pagamento_status === 'Pago'); @endphp
      <p><strong>Pagamento:</strong>
        @if($pago && $encomenda->forma_pagamento)
          <span class="muted">{{ strtoupper($encomenda->forma_pagamento) }}</span>
        @endif
        <span class="badge {{ $pago ? 'pay-paid' : 'pay-pending' }}">
          {{ $encomenda->pagamento_status ?? '—' }}
        </span>
      </p>

      <p><strong>Sinal:</strong> R$ {{ number_format($encomenda->sinal,2,',','.') }}</p>
      <p><strong>Canal:</strong> {{ $encomenda->canal ?: '—' }}</p>
      <p><strong>Detalhes da Encomenda:</strong> {{ $encomenda->observacao ?: '—' }}</p>
    </div>

    {{-- ITENS --}}
    <h4>Itens</h4>
    <table class="table">
      <thead>
        <tr>
          <th>Produto</th>
          <th>Qtd</th>
          <th>Vlr Unit (R$)</th>
          <th>Adiant. (R$)</th>
          <th>Tamanho</th>
          <th>Sabor</th>
          <th>Personalização</th>
          <th class="text-right">Total (R$)</th>
        </tr>
      </thead>
      <tbody>
      @foreach($encomenda->itens as $it)
        <tr>
          <td>{{ $it->produto_nome }}</td>
          <td>{{ number_format($it->quantidade,3,',','.') }}</td>
          <td>{{ number_format($it->valor_unitario,2,',','.') }}</td>
          <td>{{ number_format($it->adiantamento,2,',','.') }}</td>
          <td>{{ $it->tamanho }}</td>
          <td>{{ $it->sabor }}</td>
          <td>{{ $it->personalizacao }}</td>
          <td class="text-right">{{ number_format($it->valor_total,2,',','.') }}</td>
        </tr>
      @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th colspan="7" class="text-right">Valor Total</th>
          <th class="text-right">R$ {{ number_format($encomenda->valor_total,2,',','.') }}</th>
        </tr>
      </tfoot>
    </table>

    {{-- HISTÓRICO DE STATUS --}}
    <h4>Histórico de Status</h4>

    @if($encomenda->statusLogs->isEmpty())
      <p class="muted">Sem alterações de status ainda.</p>
    @else
      <table class="status-log-table">
        <thead>
          <tr>
            <th>Registro</th>
            <th>Status</th>
            <th>Usuário</th>
            <th>Obs.</th>
          </tr>
        </thead>
        <tbody>
        @foreach($encomenda->statusLogs as $log)
          <tr>
            <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i') }}</td>
            <td><span class="badge {{ $statusClass($log->status_novo) }}">{{ $log->status_novo }}</span></td>
            <td>
              @if($log->user && $log->user->name)
                {{ $log->user->name }}
              @elseif($log->user_id)
                #{{ $log->user_id }}
              @else
                —
              @endif
            </td>
            <td>{{ $log->observacao ?? '—' }}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
    @endif

  </div>
</div>
@endsection

