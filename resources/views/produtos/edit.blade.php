@extends('layouts.app')

@section('title', 'Editar Produto')

@section('content')

<head>
    <!-- Outros links e meta tags -->
    <link rel="stylesheet" href="{{ asset('css/edit-produtos.css') }}">
</head>


   <!-- <link rel="stylesheet" href="{{ asset('css/estoques.css') }}">  -->

    <h1>Editando Produto: {{ $produto->nome }}</h1>

    <form action="{{ route('produtos.update', $produto->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Campos para editar o produto -->


       <div class="form-group">
            <label for="modulo_id">Módulo</label>
                <select name="modulo_id" id="modulo_id" class="form-control" required>
                    <option value="">Selecione o módulo</option>
            @foreach($modulos as $modulo)
                    <option value="{{ $modulo->id }}"
                        {{ old('modulo_id', $produto->modulo_id) == $modulo->id ? 'selected' : '' }}>
                        {{ $modulo->descricao }}
                    </option>
            @endforeach
                </select>
        </div>


        <div class="form-group">
            <label for="codigo_barras">Código de Barras</label>
            <input type="text" name="codigo_barras" id="codigo_barras" class="form-control" value="{{ old('codigo_barras', $produto->codigo_barras) }}" required>
        </div>


        <div class="form-group">
            <label for="nome">Nome do Produto</label>
            <input type="text" name="nome" id="nome" value="{{ $produto->nome }}" required>
        </div>
        <div class="form-group">
            <label for="descricao">Descrição</label>
            <input type="text" name="descricao" id="descricao" value="{{ $produto->descricao }}">
        </div>
        <div class="form-group">
            <label for="preco_compra">Preço de Compra</label>
            <input type="text" name="preco_compra" id="preco_compra" value="{{ $produto->preco_compra }}" required>
        </div>
      
        <div class="form-group">
            <label for="preco_venda">Preço de Venda</label>
            <input type="text" class="form-control" id="preco_venda" name="preco_venda" value="{{ old('preco_venda', $produto->preco_venda) }}" required>
        </div>

        <div class="form-group">
            <label for="quantidade_estoque">Quantidade em Estoque</label>
            <input type="number" name="quantidade_estoque" id="quantidade_estoque" value="{{ $produto->quantidade_estoque }}" required>
        </div>
        <div class="form-group">
            <label for="unidade_de_medida">Unidade de Medida</label>
            <input type="text" name="unidade_de_medida" id="unidade_de_medida" value="{{ $produto->unidade_de_medida }}" required>
        </div>

        <div class="form-group">
            <label for="estoque_minimo">Estoque Mínimo</label>
            <input type="number" class="form-control" id="estoque_minimo" name="estoque_minimo" value="{{ old('estoque_minimo', $produto->estoque_minimo) }}"required>
        </div>


        <button type="submit">Salvar Alterações</button>
    </form>

    <script>
    document.querySelector('form').addEventListener('submit', function(event) {
        // Captura o campo preco_venda e converte a vírgula em ponto
        let precoVendaField = document.getElementById('preco_venda');
        precoVendaField.value = precoVendaField.value.replace(',', '.');
    });
</script>


@endsection

