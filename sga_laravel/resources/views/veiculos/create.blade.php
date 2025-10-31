@extends('layouts.app')

@section('title', 'Cadastro de Veículos')

@section('content')
<link rel="stylesheet" href="{{ asset('css/veiculos_create.css') }}">

<div class="container-os">
    <h2>Cadastro de Veículo</h2>

    <form action="{{ route('veiculos.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Cliente:</label>
            <input type="text" name="cliente" required>
        </div>

        <div class="form-group">
            <label>Marca:</label>
            <input type="text" name="marca" required>
        </div>

        <div class="form-group">
            <label>Modelo do Veículo:</label>
            <input type="text" name="veiculo" required>
        </div>

        <div class="form-group">
            <label>Placa:</label>
            <input type="text" name="placa" required>
        </div>

        <div class="form-group">
            <label>Cor:</label>
            <input type="text" name="cor">
        </div>

        <div class="form-group">
            <label>Ano:</label>
            <input type="number" name="ano">
        </div>

        <div class="form-group">
            <label>Combustível:</label>
            <select name="combustivel">
                <option value="">Selecione</option>
                <option>Gasolina</option>
                <option>Etanol</option>
                <option>Flex</option>
                <option>Diesel</option>
                <option>GNV</option>
                <option>Elétrico</option>
                <option>Híbrido</option>
            </select>
        </div>

        <div class="form-group">
            <label>Observações:</label>
            <textarea name="observacoes" rows="3"></textarea>
        </div>

        <button type="submit" class="btn-os">Salvar Veículo</button>
    </form>
</div>
@endsection
