<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="{{ asset('css/edit_cliente.css') }}"> 
   

</head>
<body>
    <div class="container">
        <h1 class="title">Alteração de Cliente</h1>

        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="text" name="telefone" id="telefone" value="{{ $cliente->telefone }}" required>
            </div>

            <div class="form-group">
                <label for="cpf">CPF / CNPJ:</label>
                <input type="text" name="cpf" id="cpf" value="{{ $cliente->cpf }}" required>
            </div>

            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" value="{{ $cliente->nome }}" required>
            </div>

            <div class="form-group">
                <label for="endereco">Endereço:</label>
                <input type="text" name="endereco" id="endereco" value="{{ $cliente->endereco }}" required>
            </div>

            <div class="form-group">
                <label for="numero">Número:</label>
                <input type="text" name="numero" id="numero" value="{{ $cliente->numero }}" required>
            </div>

            <div class="form-group">
                <label for="bairro">Bairro:</label>
                <input type="text" name="bairro" id="bairro" value="{{ $cliente->bairro }}" required>
            </div>

            <div class="form-group">
                <label for="cidade">Cidade:</label>
                <input type="text" name="cidade" id="cidade" value="{{ $cliente->cidade }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="{{ $cliente->email }}">
            </div>

            <div class="form-group">
                <label for="nascimento">Data de Nascimento:</label>
                <input type="date" name="nascimento" id="nascimento" value="{{ $cliente->nascimento }}">
            </div>

            <div class="form-group">
                <label for="observacao">Observação:</label>
                <textarea name="observacao" id="observacao">{{ $cliente->observacao }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Atualizar</button>
                      
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
                     
           
        </form>

    </div>
</body>
</html>
