@extends('layouts.app')

@section('title', 'Consultar Compra')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/edit-compra.css') }}">
@endsection

@section('content')

<div class="container">
    <h1>Editar Compra</h1>

    <div class="back-button">
        <button onclick="window.location.href='{{ route('compras.index') }}'" class="btn-voltar_index">
            Voltar
        </button>
    </div>

    <form action="{{ route('compras.update', $compra->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="fornecedor">Fornecedor:</label>
            <input 
                type="text" 
                class="form-control" 
                id="fornecedor" 
                name="fornecedor" 
                value="{{ $compra->fornecedor->nome ?? '' }}" 
                disabled
            >
        </div>

        <div class="form-group">
            <label for="data_compra">Data da Compra:</label>
            <input 
                type="date" 
                name="data_compra" 
                class="form-control"
                value="{{ old('data_compra', $compra->data_compra ? \Carbon\Carbon::parse($compra->data_compra)->format('Y-m-d') : '') }}" 
                required
            >
        </div>

        <div class="form-group">
            <label for="nota_fiscal">Nota Fiscal:</label>
            <input 
                type="number" 
                class="form-control" 
                id="nota_fiscal" 
                name="nota_fiscal" 
                value="{{ intval($compra->nota_fiscal) }}" 
                step="1"
            >
        </div>

        <div class="form-group">
            <label for="data_vencimento">Data de Vencimento:</label>
            <input 
                type="date" 
                name="data_vencimento" 
                class="form-control" 
                value="{{ old('data_vencimento', $compra->data_vencimento ? \Carbon\Carbon::parse($compra->data_vencimento)->format('Y-m-d') : '') }}" 
                required
            >
        </div>

        <div class="form-group">
            <label for="total">Total da Nota Fiscal:</label>
            <input 
                type="text" 
                class="form-control" 
                id="total" 
                name="total" 
                value="{{ number_format($compra->total, 2, ',', '.') }}" 
                disabled
            >
        </div>

        <button type="submit" class="btn btn-primary">
            Salvar Alterações
        </button>
    </form>
</div>

<h3 class="detalhes-compra">DETALHES DA COMPRA</h3>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Valor Unitário</th>
                <th>Valor Total</th>
            </tr>
        </thead>

        <tbody>
            @foreach($compra->itensDeCompras as $item)
                <tr>
                    <td>{{ $item->produto->nome ?? 'Produto não encontrado' }}</td>
                    <td>{{ $item->quantidade }}</td>
                    <td>R$ {{ number_format($item->valor_unitario, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($item->valor_total, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection