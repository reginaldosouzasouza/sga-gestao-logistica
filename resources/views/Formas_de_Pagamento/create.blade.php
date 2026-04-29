@extends('layouts.app')

@section('title', 'Cadastrar Formas de Pagamento')

@section('content')
<div class="container">
    <h1>Cadastrar Nova Forma de Pagamento</h1>

    <form action="{{ route('formas_de_pagamento.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nome">Nome da Forma de Pagamento</label>
            <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
@endsection
