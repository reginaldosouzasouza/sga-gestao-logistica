@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Editar Encomenda #{{ $encomenda->id }}</h1>

  <a href="{{ route('padaria.encomendas.index') }}" class="btn btn-outline-secondary mb-3">← Voltar</a>
  <a href="{{ route('padaria.encomendas.show',$encomenda) }}" class="btn btn-info mb-3">Ver Detalhes</a>

  @if(session('success'))
    <div style="background:#dff0d8;padding:8px;margin-bottom:10px;border-radius:4px;">
      {{ session('success') }}
    </div>
  @endif

  <form method="POST" action="{{ route('padaria.encomendas.update',$encomenda) }}">
    @csrf @method('PUT')

    {{-- Dados do cliente (somente leitura) --}}
    <div class="row mb-3">
      <div class="col-md-3">
          <label>Cód. Pedido</label>
          <input type="text" class="form-control" value="{{ $encomenda->cliente_codigo ? '#'.$encomenda->cliente_codigo : '—' }}" disabled>
      </div>
      <div class="col-md-9">
          <label>Nome</label>
          <input type="text" name="nome" class="form-control" value="{{ old('nome',$encomenda->nome) }}">
      </div>
    </div>

    {{-- Datas --}}
    <div class="row mb-3">
      <div class="col-md-4">
          <label>Data do Pedido</label>
          <input type="date" name="data_pedido" class="form-control"
                 value="{{ old('data_pedido',$encomenda->data_pedido) }}">
      </div>
      <div class="col-md-4">
          <label>Data de Entrega</label>
          <input type="date" name="data_retirada" class="form-control"
                 value="{{ old('data_retirada',$encomenda->data_retirada) }}">
      </div>
      <div class="col-md-4">
          <label>Hora de Entrega</label>
          <input type="time" name="hora_retirada" class="form-control"
                 value="{{ old('hora_retirada',$encomenda->hora_retirada) }}">
      </div>
    </div>

    {{-- Pagamento --}}
    <div class="row mb-3">
      <div class="col-md-4">
          <label>Forma de Pagamento</label>
          <select name="forma_pagamento" class="form-control">
              @php $fp = old('forma_pagamento',$encomenda->forma_pagamento); @endphp
              <option value="">Selecione...</option>
              <option value="pix"      {{ $fp==='pix'?'selected':'' }}>PIX</option>
              <option value="dinheiro" {{ $fp==='dinheiro'?'selected':'' }}>Dinheiro</option>
              <option value="cartao"   {{ $fp==='cartao'?'selected':'' }}>Cartão</option>
              <option value="Acerta na Entrega" {{ $fp==='Acerta na Entrega'?'selected':'' }}>Acerta na Entrega</option>
              <option value="Fiado"   {{ $fp==='Fiado'?'selected':'' }}>Fiado</option>
          </select>
      </div>
      <div class="col-md-4">
          <label>Status do Pagamento</label>
          <select name="pagamento_status" class="form-control" required>
              @php $ps = old('pagamento_status',$encomenda->pagamento_status); @endphp
              <option value="Pendente" {{ $ps==='Pendente'?'selected':'' }}>Pendente</option>
              <option value="Pago"     {{ $ps==='Pago'?'selected':'' }}>Pago</option>
          </select>
      </div>
      <div class="col-md-4">
          <label>Sinal (R$)</label>
          <input type="number" step="0.01" name="sinal" class="form-control"
                 value="{{ old('sinal',$encomenda->sinal) }}">
      </div>
    </div>

    {{-- Status geral --}}
    <div class="row mb-3">
      <div class="col-md-4">
          <label>Status</label>
          @php $st = old('status',$encomenda->status); @endphp
          <select name="status" class="form-control" required>
              @foreach(['Aberto','Produção','Pronto','Entregue','Cancelado'] as $s)
                  <option value="{{ $s }}" {{ $st===$s?'selected':'' }}>{{ $s }}</option>
              @endforeach
          </select>
      </div>
      <div class="col-md-8">
          <label>Canal</label>
          <input type="text" name="canal" class="form-control"
                 value="{{ old('canal',$encomenda->canal) }}" placeholder="WhatsApp, balcão...">
      </div>
    </div>

    {{-- Observação --}}
    <div class="mb-3">
      <label>Detalhes da Encomenda</label>
      <textarea name="observacao" class="form-control" rows="3">{{ old('observacao',$encomenda->observacao) }}</textarea>
    </div>

    <div class="mb-3">
      <label>Observação desta alteração de status (opcional)</label>
      <input type="text" name="status_obs" class="form-control" placeholder="Ex.: Cliente pediu urgência">
   </div>

    <button class="btn btn-success">Salvar</button>
  </form>

  

</div>
@endsection
