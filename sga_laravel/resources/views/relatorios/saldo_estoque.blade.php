@extends('layouts.app')

@section('title', 'Relatório de Saldo de Estoque - ATUAL')

@section('content')
<link rel="stylesheet" href="{{ asset('css/saldo-estoque.css') }}">

<div class="container">
    <h1>Relatório de Saldo de Estoque - ATUAL</h1>

    <!-- Formulário de Filtro -->
    <form method="GET" action="{{ route('relatorios.saldoEstoque') }}" class="mb-4">
        <div class="row">
            <div class="col-md-6">
                <label for="nome" class="form-label">Nome do Produto:</label>
                <input type="text" name="nome" id="nome" class="form-control" placeholder="Digite o nome do produto">
                <div id="autocomplete-results" class="autocomplete-results"></div>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>

         <!-- Totalizador de produtos -->
      <div class="mt-3">
        <strong>Total de produtos exibidos: {{ $produtos->count() }}</strong>
    </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Nome do Produto</th>
                <th>Quantidade em Estoque</th>
                <th>Descrição</th>                
                <th>Estoque Mínimo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produtos as $produto)
            <tr class="{{ $produto->quantidade_estoque < $produto->estoque_minimo ? 'table-danger' : '' }}">
                <td>{{ $produto->nome }}</td>
                <td>{{ $produto->quantidade_estoque }}</td>
                <td>{{ $produto->unidade_de_medida }}</td>
                <td>{{ $produto->estoque_minimo }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

      
</div>

<!-- jQuery e JavaScript para o Autocomplete -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#nome').on('keyup', function() {
            var query = $(this).val();
            if (query.length >= 2) { // Inicia o autocomplete após 2 caracteres
                $.ajax({
                    url: "{{ route('produtos.buscar') }}",
                    type: "GET",
                    data: { query: query },
                    success: function(data) {
                        var autocompleteResults = $('#autocomplete-results');
                        autocompleteResults.empty(); // Limpa resultados anteriores
                        data.forEach(function(item) {
                            autocompleteResults.append('<div class="autocomplete-item">' + item + '</div>');
                        });
                        $('.autocomplete-item').on('click', function() {
                            $('#nome').val($(this).text());
                            autocompleteResults.empty();
                        });
                    }
                });
            } else {
                $('#autocomplete-results').empty();
            }
        });
    });
</script>

@endsection
