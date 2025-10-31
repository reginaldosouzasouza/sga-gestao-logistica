@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detalhes do Item</h2>

    <p><strong>ID:</strong> {{ $item->id }}</p>
    <p><strong>Ordem de Serviço:</strong> {{ $item->ordemServico->id ?? '-' }}</p>
    <p><strong>Produto:</strong> {{ $item->produto->nome ?? '-' }}</p>
    <p><strong>Quantidade:</strong> {{ $item->quantidade }}</p>
    <p><strong>Valor Unitário:</strong> R$ {{ number_format($item->valor_unitario, 2, ',', '.') }}</p>

    <a href="{{ route('ordem_servico_itens.index') }}" class="btn btn-secondary">Voltar</a>
</div>
@endsection
