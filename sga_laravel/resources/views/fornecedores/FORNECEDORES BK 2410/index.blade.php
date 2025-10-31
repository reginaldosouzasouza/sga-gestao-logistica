@extends('layouts.app')

@section('title', 'Lista de Fornecedores')

@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORNECEDORES</title>
    <link href="{{ asset('css/fornecedores.css') }}" rel="stylesheet">
</head>



<div class="container">
    <input type="text" id="search" placeholder="Digite o nome ou telefone para pesquisar o Fornecedor" class="form-control">
</div>

<div class="actions">
    <a href="{{ route('fornecedores.create') }}" class="btn btn-success">Cadastrar Fornecedor</a>
</div>
<div class="container">

    <h1>Lista de Fornecedores</h1>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>CNPJ</th>
                    <th>Nome</th>
                    <th>Endereço</th>
                    <th>Telefone</th>
                    <th>Cidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fornecedores as $fornecedor)
                <tr>
                    <td>{{ $fornecedor->cnpj }}</td>
                    <td>{{ $fornecedor->nome }}</td>
                    <td>{{ $fornecedor->endereco }}</td>
                    <td>{{ $fornecedor->telefone }}</td>
                    <td>{{ $fornecedor->cidade }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('fornecedores.edit', $fornecedor->id) }}" class="btn-consultar">Consultar/Alterar</a>
                            <form action="{{ route('fornecedores.destroy', $fornecedor->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-excluir">Excluir</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<script>
    document.getElementById('search').addEventListener('input', function() {
        let filter = this.value.toUpperCase();
        let rows = document.querySelectorAll('table tbody tr');

        rows.forEach(row => {
            let name = row.querySelector('td:nth-child(2)').textContent.toUpperCase();
            let phone = row.querySelector('td:nth-child(4)').textContent.toUpperCase();

            if (name.indexOf(filter) > -1 || phone.indexOf(filter) > -1) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

@endsection

