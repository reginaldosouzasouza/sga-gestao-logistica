@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/ordem_servico_itens.css') }}">

<div class="container">
    <h2>Itens da Ordem de Serviço</h2>
    <a href="{{ route('ordem_servico_itens.create') }}" class="btn btn-primary mb-3">Novo Item</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ordem de Serviço</th>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Valor Unitário</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($itens as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->ordemServico->id ?? '-' }}</td>
                    <td>{{ $item->produto->nome ?? '-' }}</td>
                    <td>{{ $item->quantidade }}</td>
                    <td>R$ {{ number_format($item->valor_unitario, 2, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('ordem_servico_itens.show', $item->id) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('ordem_servico_itens.edit', $item->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('ordem_servico_itens.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
