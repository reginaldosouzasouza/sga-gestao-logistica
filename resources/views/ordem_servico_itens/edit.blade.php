@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Item da Ordem de Serviço</h2>

    <form action="{{ route('ordem_servico_itens.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="ordem_servico_id">Ordem de Serviço</label>
            <select name="ordem_servico_id" class="form-control">
                @foreach($ordens as $ordem)
                    <option value="{{ $ordem->id }}" {{ $ordem->id == $item->ordem_servico_id ? 'selected' : '' }}>{{ $ordem->id }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="produto_id">Produto</label>
            <select name="produto_id" class="form-control">
                @foreach($produtos as $produto)
                    <option value="{{ $produto->id }}" {{ $produto->id == $item->produto_id ? 'selected' : '' }}>{{ $produto->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="quantidade">Quantidade</label>
            <input type="number" name="quantidade" class="form-control" value="{{ $item->quantidade }}" required>
        </div>

        <div class="form-group">
            <label for="valor_unitario">Valor Unitário</label>
            <input type="text" name="valor_unitario" class="form-control" value="{{ $item->valor_unitario }}" required>
        </div>

        <button type="submit" class="btn btn-success">Atualizar</button>
    </form>
</div>
@endsection
