@extends('layouts.app')

@section('title', 'Relatório de Vendas por Produto')

@section('content')
<link rel="stylesheet" href="{{ asset('css/relatorio-vendas-produto.css') }}">

<div class="container">
    <h1>Relatório de Vendas por Produto</h1>

    <form method="GET" action="{{ route('relatorios.vendasPorProduto') }}">
        <div class="form-group">
            <label for="nome_cliente">Nome do Cliente</label>
            <input type="text" name="nome_cliente" id="nome_cliente" class="form-control" placeholder="Digite o nome do cliente" value="{{ request('nome_cliente') }}">
        </div>

        <div class="form-group">
            <label for="nome_produto">Nome do Produto</label>
            <input type="text" name="nome_produto" id="nome_produto" class="form-control" placeholder="Digite o nome do produto" value="{{ request('nome_produto') }}">
        </div>

        <div class="form-group">
            <label for="nome_produto">Nome do Bairro</label>
            <input type="text" name="nome_bairro" id="nome_bairro" class="form-control" placeholder="Digite o nome do Bairro" value="{{ request('nome_bairro') }}">
        </div>

        <div class="form-group">
            <label for="data_inicial">Data Inicial</label>
            <input type="date" name="data_inicial" id="data_inicial" class="form-control" value="{{ request('data_inicial') }}">
        </div>

        <div class="form-group">
            <label for="data_final">Data Final</label>
            <input type="date" name="data_final" id="data_final" class="form-control" value="{{ request('data_final') }}">
        </div>

        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>

    <h3>Total de Registros: {{ $vendas->count() }}</h3>
    <h3>Valor Total: R$ {{ number_format($valorTotal, 2, ',', '.') }}</h3>
    <h3>Quantidade Total: {{ $quantidadeTotal }}</h3>

    <table class="table table-striped mt-4">
        <thead>
            <tr>
                
                <th>Data</th>
                <th>Nome do Cliente</th>
                <th>Nome do Produto</th>
                <th>Quantidade</th>
                <th>Valor Unitário</th>
                <th>Valor Total</th>
                <th> Nome do Bairro</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vendas as $venda)
            <tr>
               
                <td>{{ \Carbon\Carbon::parse($venda->data_coleta)->format('d/m/Y') }}</td>
                <td>{{ $venda->nome_cliente }}</td>
                <td>{{ $venda->nome_produto }}</td>
                <td>{{ $venda->quantidade }}</td>
                <td>R$ {{ number_format($venda->valor_unitario, 2, ',', '.') }}</td>
                <td>R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</td>
                <td>{{ $venda->nome_bairro }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
   
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery UI for Autocomplete -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script>
$(document).ready(function() {
    $('#nome_produto').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{ route('autocomplete.produtos') }}",
                dataType: "json",
                data: {
                    query: request.term
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.text,
                            value: item.text
                        };
                    }));
                }
            });
        },
        minLength: 2
    });
});
</script>
@endsection
