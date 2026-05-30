@extends('layouts.app')

@section('title', 'Lista de Fornecedores')

@section('styles')
    <link href="{{ asset('css/fornecedores.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="fornecedores-page">

    <div class="card-pesquisa">
        <input 
            type="text" 
            id="search" 
            placeholder="Digite o nome ou telefone para pesquisar o Fornecedor" 
            class="form-control"
        >
    </div>

    <div class="topo-fornecedores">
        <div>
            <a href="{{ route('fornecedores.create') }}" class="btn-cadastrar">
                Cadastrar Fornecedor
            </a>

            <div class="total-fornecedores">
                <strong>Total de Fornecedor: {{ $totalFornecedores }}</strong>
            </div>
        </div>
    </div>

    <div class="card-tabela">
        <h1>Lista de Fornecedores</h1>

        <div class="table-responsive">
            <table class="table table-striped table-hover tabela-fornecedores">
                <thead>
                    <tr>
                        <th>CNPJ</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Cidade</th>
                        <th class="col-acoes">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($fornecedores as $fornecedor)
                        <tr>
                            <td>{{ $fornecedor->cnpj }}</td>
                            <td>{{ $fornecedor->nome }}</td>
                            <td>{{ $fornecedor->telefone }}</td>
                            <td>{{ $fornecedor->cidade }}</td>
                            <td class="col-acoes">
                                <div class="btn-group-acoes">
                                    <a href="{{ route('fornecedores.edit', $fornecedor->id) }}" class="btn-consultar">
                                        Consultar/Alterar
                                    </a>

                                    <form action="{{ route('fornecedores.destroy', $fornecedor->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn-excluir">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</div>

@endsection

@section('scripts')
<script>
    document.getElementById('search').addEventListener('input', function() {
        let filter = this.value.toUpperCase();
        let rows = document.querySelectorAll('.tabela-fornecedores tbody tr');

        rows.forEach(row => {
            let nome = row.querySelector('td:nth-child(2)').textContent.toUpperCase();
            let telefone = row.querySelector('td:nth-child(3)').textContent.toUpperCase();

            if (nome.indexOf(filter) > -1 || telefone.indexOf(filter) > -1) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endsection