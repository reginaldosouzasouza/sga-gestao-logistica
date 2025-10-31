@extends('layouts.app')

@section('title', 'Controle de Estoque')

@section('content')
<link rel="stylesheet" href="{{ asset('css/estoques.css') }}">

<div class="container">
    <h1>Movimentações de Estoque</h1>

    <!-- Formulário de Filtros -->
    <form method="GET" action="{{ route('estoques.index') }}" class="filter-form mb-4 p-3">
        <div class="row">
            <div class="col-md-4">
                <label for="nome" class="form-label">Nome do Produto</label>
                <input type="text" name="nome" id="nome" class="form-control" placeholder="Digite o nome do produto" value="{{ request('nome') }}">
            </div>
            <div class="col-md-3">
                <label for="data_inicial" class="form-label">Data Inicial</label>
                <input type="date" name="data_inicial" id="data_inicial" class="form-control" value="{{ request('data_inicial') }}">
            </div>
            <div class="col-md-3">
                <label for="data_final" class="form-label">Data Final</label>
                <input type="date" name="data_final" id="data_final" class="form-control" value="{{ request('data_final') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end justify-content-center">
                <button type="submit" class="btn btn-primary btn-block w-auto">Filtrar</button>
                <a href="{{ route('estoques.index') }}" class="btn btn-secondary w-auto ms-2">Limpar</a>
            </div>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Tipo de Movimentação</th>
                <th>Origem</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movimentacoes as $movimentacao)
            <tr>
                <td>{{ $movimentacao->produto->nome }}</td>
                <td>{{ $movimentacao->quantidade }}</td>
                <td>{{ $movimentacao->tipo_movimentacao }}</td>
                <td>{{ $movimentacao->origem }}</td>
                <td>{{ $movimentacao->data_movimentacao }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection



