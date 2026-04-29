@extends('layouts.app')

@section('title', 'Naturezas Financeiras')

@section('content')
<div class="container">
    <h1>Naturezas Financeiras</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('naturezas-financeiras.create') }}" class="btn btn-primary mb-3" style="font-size: 20px;">
        Cadastrar Nova Natureza
    </a>
    <br>
    <br>



    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Ativo</th>
                <th width="180">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($naturezas as $natureza)
                <tr>
                    <td>{{ $natureza->id }}</td>
                    <td>{{ $natureza->nome }}</td>
                    <td>
                        @if ($natureza->ativo)
                            Sim
                        @else
                            Não
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('naturezas-financeiras.edit', $natureza->id) }}" class="btn btn-sm btn-warning">
                            Editar
                        </a>

                        <form action="{{ route('naturezas-financeiras.destroy', $natureza->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Deseja desativar esta natureza?')">
                                Desativar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection