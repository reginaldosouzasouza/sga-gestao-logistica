@extends('layouts.app')

@section('title', 'Cadastro de Fornecedores')

@section('content')
<link rel="stylesheet" href="{{ asset('css/fornecedores_create.css') }}">

<div class="container">
    <h1>Cadastro de Fornecedor</h1>
    <form action="{{ route('fornecedores.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <label for="cnpj">CNPJ</label>
                <input type="text" class="form-control" id="cnpj" name="cnpj" required>
            </div>
            <div class="col-md-6">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="endereco">Endereço</label>
                <input type="text" class="form-control" id="endereco" name="endereco" required>
            </div>
            <div class="col-md-6">
                <label for="telefone">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="col-md-6">
                <label for="cidade">Cidade</label>
                <input type="text" class="form-control" id="cidade" name="cidade">
            </div>
        </div>

        <div class="form-group">
            <label for="observacao">Observação</label>
            <textarea class="form-control" id="observacao" name="observacao" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
</div>
@endsection

