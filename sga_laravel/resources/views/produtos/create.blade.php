@extends('layouts.app')
@section('title', 'Produtos')

@section('content')
<link rel="stylesheet" href="{{ asset('css/produtos_create.css') }}">

<div class="container">
    <h1>Cadastro de Produtos</h1>
    <form action="{{ route('produtos.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="codigo_barras">Código de Barras</label>
            <input type="text" name="codigo_barras" id="codigo_barras" 
            value="{{ old('codigo_barras') }}" class="form-control" required>
        </div>



        <div class="form-group">
            <label for="nome">Nome do Produto</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>

        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao"></textarea>
        </div>

        <div class="form-group">
            <label for="preco_compra">Preço de Compra</label>
            <input type="text" class="form-control" id="preco_compra" name="preco_compra" required>
        </div>

        <div class="form-group">
            <label for="preco_venda">Preço de Venda</label>
            <input type="text" class="form-control" id="preco_venda" name="preco_venda" required>
        </div>

        <div class="form-group">
            <label for="quantidade_estoque">Quantidade em Estoque</label>
            <input type="number" class="form-control" id="quantidade_estoque" name="quantidade_estoque" required>
        </div>

        <div class="form-group">
            <label for="unidade_de_medida">Unidade de Medida</label>
            <input type="text" class="form-control" id="unidade_de_medida" name="unidade_de_medida" required>
        </div>

        <div class="form-group">
            <label for="estoque_minimo">Estoque Mínimo</label>
            <input type="number" class="form-control" id="estoque_minimo" name="estoque_minimo" value="{{ old('estoque_minimo', $produto->estoque_minimo ?? 5) }}">
        </div>


        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
</div>
@endsection

