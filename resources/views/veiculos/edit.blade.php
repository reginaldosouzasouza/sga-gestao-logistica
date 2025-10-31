@extends('layouts.app')

@section('title', 'Editar Cadastro')

@section('content')

<link rel="stylesheet" href="{{ asset('css/vei_edit.css') }}">

<div class="container">
    <h2 style="color: purple;">Editar Veículo</h2>

    <form action="{{ route('veiculos.update', $veiculo->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Cliente:</label>
            <select name="cliente" class="form-control" required>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->nome }}" {{ $veiculo->cliente == $cliente->nome ? 'selected' : '' }}>
                        {{ $cliente->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Marca:</label>
            <input type="text" name="marca" class="form-control" value="{{ $veiculo->marca }}" required>
        </div>

        <div class="form-group">
            <label>Modelo:</label>
            <input type="text" name="veiculo" class="form-control" value="{{ $veiculo->veiculo }}" required>
        </div>

        <div class="form-group">
            <label>Placa:</label>
            <input type="text" name="placa" class="form-control" value="{{ $veiculo->placa }}" required>
        </div>

        <div class="form-group">
            <label>Cor:</label>
            <input type="text" name="cor" class="form-control" value="{{ $veiculo->cor }}">
        </div>

        <div class="form-group">
            <label>Ano:</label>
            <input type="text" name="ano" class="form-control" value="{{ $veiculo->ano }}">
        </div>

        <div class="form-group">
            <label>Combustível:</label>
            <select name="combustivel" class="form-control">
                <option value="Flex" {{ $veiculo->combustivel == 'Flex' ? 'selected' : '' }}>Flex</option>
                <option value="Gasolina" {{ $veiculo->combustivel == 'Gasolina' ? 'selected' : '' }}>Gasolina</option>
                <option value="Diesel" {{ $veiculo->combustivel == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                <option value="Etanol" {{ $veiculo->combustivel == 'Etanol' ? 'selected' : '' }}>Etanol</option>
            </select>
        </div>

        <div class="form-group">
            <label>Observações:</label>
            <textarea name="observacoes" class="form-control">{{ $veiculo->observacoes }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Salvar Alterações</button>
    </form>
</div>
@endsection
