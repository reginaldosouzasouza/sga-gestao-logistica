@extends('layouts.app')

@section('title', 'Lista de Produtos')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRODUTOS</title>
    <link href="{{ asset('css/produtos.css') }}" rel="stylesheet">
</head>



<div class="container">
    <h1>Lista de Produtos</h1>

    <div class="actions">
    <a href="{{ route('produtos.create') }}" class="btn btn-success mb-3">Cadastrar Produtos</a>
    </div>
    <form action="{{ route('produtos.index') }}" method="GET" class="mb-4">
        <!--<div class="input-group">-->
        <div class="search-container">    
            <input type="text" name="search" class="form-control" placeholder="Pesquisar produtos" value="{{ request()->get('search') }}">
            <button type="submit" class="btn btn-primary">Pesquisar</button>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                <!--    <th>ID.</th> -->
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço de Compra</th>
                    <th>Preço de Venda</th>
                <!--    <th>Unidade de Medida</th>  -->
                    <th>Estoque</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produtos as $produto)
                <tr>
                <!--    <td>{{ $produto->id }}</td> -->
                    <td>{{ $produto->nome }}</td>
                    <td>{{ $produto->descricao }}</td>
                    <td>{{ $produto->preco_compra }}</td>
                    <td>{{ $produto->preco_venda }}</td>
                <!--    <td>{{ $produto->unidade_de_medida }}</td> -->
                    <td>{{ $produto->quantidade_estoque }}</td>
                    <td>
                        <a href="{{ route('produtos.edit', $produto->id) }}" class="btn-consultar">Consultar/Alterar</a>
                        <form action="{{ route('produtos.destroy', $produto->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-excluir">Excluir</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
