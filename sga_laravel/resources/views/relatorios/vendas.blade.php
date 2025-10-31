@extends('layouts.app')

@section('title', 'Relatório de Vendas')

@section('content')

<link rel="stylesheet" href="{{ asset('css/relatorio-vendas1.css') }}">

<div class="container">
    <h1 class="titulo-relatorio">Relatório de Vendas</h1>

    <form class="filtro-form" action="{{ route('relatorios.vendas') }}" method="GET">
        <div class="form-group">
            <label for="nome">Nome do Cliente</label>
            <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome do cliente" value="{{ request('nome') }}">
        </div>
        <div class="form-group">
            <label for="data_inicial">Data Inicial</label>
            <input type="date" class="form-control" id="data_inicial" name="data_inicial" value="{{ request('data_inicial') }}">
        </div>
        <div class="form-group">
            <label for="data_final">Data Final</label>
            <input type="date" class="form-control" id="data_final" name="data_final" value="{{ request('data_final') }}">
        </div>
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>

    <div class="totalizador">
        <h4>Total de Registros: {{ $vendas->count() }}</h4>
        <h4>Valor Total: R$ {{ number_format($vendas->sum('valor_total'), 2, ',', '.') }}</h4>
    </div>

    <table class="relatorio-tabela">
        <thead>
            <tr>
                <th>Nº de Coleta</th>
                <th>Data</th>
                <th>Nome do Cliente</th>
                <th>Quantidade</th>
                <th>Valor Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vendas as $venda)
            <tr>
                <td>{{ $venda->id }}</td>
                <td>{{ \Carbon\Carbon::parse($venda->data_coleta)->format('d/m') }}</td>
                <td>{{ $venda->nome }}</td>
                <td>{{ number_format($venda->quantidade) }}</td>
                <td>{{ number_format($venda->valor_total, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

