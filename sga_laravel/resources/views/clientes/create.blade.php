<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Cliente</title>
    <link rel="stylesheet" href="{{ asset('css/add_cliente.css') }}">
</head>
<body>
<div class="container">
    <h1>Cadastro de Clientes</h1>
   <!-- <form method="POST" action="/clientes">-->
   <form method="POST" action="{{ route('clientes.store') }}">
        @csrf
        <input type="hidden" name="from" value="pedido_coleta">
        
        <div class="row">
            <div class="col-50">
                <label for="cpf">CPF</label>
                <input type="text" name="cpf" value="{{ old('cpf') }}">
            </div>
            <div class="col-50">
                <label for="telefone">Telefone</label>
                <input type="text" id="telefone" name="telefone" value="{{ old('telefone') }}">
            </div>
            <div class="col-50">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" value="{{ old('nome') }}">
            </div>
            <div class="col-50">
                <label for="endereco">Endereço</label>
                <input type="text" id="endereco" name="endereco" value="{{ old('endereco') }}">
            </div>
            <div class="col-50">
                <label for="numero">Número</label>
                <input type="text" name="numero" value="{{ old('numero') }}">
            </div>
            <div class="col-50">
                <label for="bairro">Bairro</label>
                <input type="text" id="bairro" name="bairro" value="{{ old('bairro') }}">
            </div>
            <div class="col-50">
                <label for="cidade">Cidade</label>
                <input type="text" id="cidade" name="cidade" value="{{ old('cidade') }}">
            </div>
            <div class="col-50">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}">
            </div>
            <div class="col-50">
                <label for="nascimento">Aniversário</label>
                <input type="date" id="nascimento" name="nascimento" value="{{ old('nascimento') }}">
            </div>
            <div class="col-50">
                <label for="data_cadastro">Data do Cadastro</label>
                <input type="text" id="data_cadastro" name="data_cadastro" value="{{ now()->format('Y-m-d') }}" readonly>
            </div>
            <div class="col-100">
                <label for="observacao">Observação</label>
                <textarea id="observacao" name="observacao">{{ old('observacao') }}</textarea>
            </div>
        </div>
        <button type="submit">Salvar</button>
    </form>
</div>


</body>
</html>
