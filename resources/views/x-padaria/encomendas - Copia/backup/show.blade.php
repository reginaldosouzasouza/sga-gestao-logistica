@extends('layouts.app')

@section('title', 'Detalhes da Encomenda')

@section('content')
<link rel="stylesheet" href="{{ asset('/padaria/css/detalhesencomenda.css') }}">

<div class="container">
  <h1>Detalhes da Encomenda #{{ $encomenda->id }}</h1>

  <a href="{{ route('padaria.encomendas.index') }}" class="btn btn-outline-secondary mb-3">← Voltar</a>
  <a href="{{ route('padaria.encomendas.edit',$encomenda) }}" class="btn btn-warning mb-3">Editar</a>

  <div class="mb-3">
    <p><strong>Cliente:</strong>
        @if($encomenda->cliente_codigo){{ $encomenda->cliente_codigo }}@endif
        @if($encomenda->nome) — {{ $encomenda->nome }} @endif
    </p>
    <p><strong>Data do Pedido:</strong>
        @if($encomenda->data_pedido)
            {{ \Carbon\Carbon::parse($encomenda->data_pedido)->format('d/m/Y') }}
        @else — @endif
    </p>
    <p><strong>Data Encomenda (registro):</strong>
        {{ \Carbon\Carbon::parse($encomenda->data_encomenda)->format('d/m/Y') }}
    </p>
    <p><strong>Data da Entrega:</strong>
        {{ \Carbon\Carbon::parse($encomenda->data_retirada)->format('d/m/Y') }}
        as {{ $encomenda->hora_retirada }}
    </p>
    <p><strong>Status:</strong> {{ $encomenda->status }}</p>

    <p><strong>Pagamento:</strong>
        @php
            $pago = ($encomenda->pagamento_status === 'Pago');
        @endphp

        {{-- Regras:
            - Se "Pago": mostra a forma e o selo verde
            - Se "Pendente": mostra só o selo amarelo --}}
        @if($pago && $encomenda->forma_pagamento)
            <span>{{ strtoupper($encomenda->forma_pagamento) }}</span>
        @endif

        <span style="padding:4px 8px;border-radius:6px;
            background: {{ $pago ? '#a9e5a1' : '#f7e07d' }};">
            {{ $encomenda->pagamento_status ?? '—' }}
        </span>
    </p>


   <!-- <p><strong>Status:</strong> {{ $encomenda->status }}</p>
    <p><strong>Pagamento:</strong>
        {{ strtoupper($encomenda->forma_pagamento ?? '-') }}
        @if($encomenda->pagamento_status)
            — {{ $encomenda->pagamento_status }}
        @endif
    </p>-->
    <p><strong>Sinal:</strong> R$ {{ number_format($encomenda->sinal,2,',','.') }}</p>
    <p><strong>Canal:</strong> {{ $encomenda->canal ?: '—' }}</p>
    <p><strong>Observação:</strong> {{ $encomenda->observacao ?: '—' }}</p>
  </div>

  <h4>Itens</h4>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Produto</th>
        <th>Qtd</th>
        <th>Vlr Unit (R$)</th>
        <th>Adiant. (R$)</th>
        <th>Tamanho</th>
        <th>Sabor</th>
        <th>Personalização</th>
        <th>Total (R$)</th>
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
        <td>{{ number_format($it->valor_total,2,',','.') }}</td>
      </tr>
    @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th colspan="7" class="text-end">Valor Total</th>
        <th>R$ {{ number_format($encomenda->valor_total,2,',','.') }}</th>
      </tr>
    </tfoot>
  </table>
</div>

<h4>Histórico de Status</h4>

@php
    $badge = function($s){
        $cores = [
          'Aberto'   => '#f7e07d',
          'Produção' => '#f9b44a',
          'Pronto'   => '#8ec5ff',
          'Entregue' => '#a9e5a1',
          'Cancelado'=> '#f59b9b'
        ];
        $cor = $cores[$s] ?? '#ddd';
        return "display:inline-block;padding:2px 8px;border-radius:6px;background:$cor;";
    };
@endphp

@if($encomenda->statusLogs->isEmpty())
  <p>Sem alterações de status ainda.</p>
@else
  <table class="table table-bordered" style="width:100%;">
    <thead>
      <tr>
        <th>Registro</th>
        {{-- (sem a coluna "De") --}}
        <th>Status</th>
        <th>Usuário</th>
        <th>Obs.</th>
      </tr>
    </thead>
    <tbody>
    @foreach($encomenda->statusLogs as $log)
      <tr>
        <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i') }}</td>

        <td>
          <span style="{{ $badge($log->status_novo) }}">{{ $log->status_novo }}</span>
        </td>

        <td>
          {{-- mostra nome do usuário se existir; senão, id; senão, traço --}}
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


@endsection
