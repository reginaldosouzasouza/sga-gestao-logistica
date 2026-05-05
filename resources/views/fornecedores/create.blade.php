@extends('layouts.app')

@section('title', 'Cadastro de Fornecedores')

@section('content')
<link rel="stylesheet" href="{{ asset('css/fornecedores_create.css') }}">

<div class="container">
    <h1>Cadastro de Fornecedor</h1>

    <!-- Formulário de Importação de XML -->
    <form action="{{ route('fornecedores.importarXML') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="xml_file">Importar Nota Fiscal (XML):</label>
            <input type="file" class="form-control" id="xml_file" name="xml_file" accept=".xml" required>
        </div>
        <button type="submit" class="btn btn-primary">Importar XML</button>
    </form>

    <hr>

    <!-- Formulário de Cadastro de Fornecedor -->
    <form action="{{ route('fornecedores.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <label for="cnpj">CNPJ</label>
                <input type="text" class="form-control" id="cnpj" name="cnpj" value="{{ $cnpj ?? '' }}" required>
            </div>
            <div class="col-md-6">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="{{ $nome ?? '' }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
            <label for="endereco">Endereço</label>
            <input type="text" class="form-control" id="endereco" name="endereco" value="{{ $enderecoCompleto ?? '' }}" required>
        </div>

            <div class="col-md-6">
                <label for="telefone">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" value="{{ $telefone ?? '' }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $email ?? '' }}">
            </div>
            <div class="col-md-6">
                <label for="cidade">Cidade</label>
                <input type="text" class="form-control" id="cidade" name="cidade" value="{{ $cidade ?? '' }}">
            </div>
        </div>

        <div class="form-group">
            <label for="observacao">Observação</label>
            <textarea class="form-control" id="observacao" name="observacao" rows="3">{{ $observacao ?? '' }}</textarea>
        </div>

        <div class="form-group">
            <label>Natureza Financeira</label>
            <select name="natureza_financeira" class="form-control" required>

                <option value="administrativa">Administrativa</option>
                <option value="Alimentação">Alimentação</option>
                <option value="DESP. NÃO CONTÁBIL">Despesas Não Contábeis</option>
                <option value="estoque">Estoque (CMV)</option>
                <option value="financeiro">Financeiro</option>
                <option value="MERCADO">Mercado</option>
                <option value="operacional">Operacional</option>             
                <option value="pessoal">Pessoal / Retirada</option>
                 
            </select>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
</div>
@endsection


