@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/estoques.css') }}">

<h1>Itens da Movimentação</h1>

<a href="{{ route('movimentacao-itens.create') }}" class="btn btn-primary">Adicionar Novo Item</a>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Controle de Coleta</th>
            <th>Movimentação</th>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Valor Unitário</th>
            <th>Valor Total</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($movimentacaoItens as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->movimentacao->controle_de_coleta ?? 'N/A' }}</td>
                <td>{{ $item->movimentacao_id }}</td>
                <td>{{ $item->produto->nome ?? 'Produto não encontrado' }}</td>
                <td>{{ $item->quantidade }}</td>
                <td>R$ {{ number_format($item->valor_unitario, 2, ',', '.') }}</td>
                <td>R$ {{ number_format($item->valor_total, 2, ',', '.') }}</td>
                <td>
                    <a href="{{ route('movimentacao-itens.edit', $item->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('movimentacao-itens.destroy', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection

