@extends('layouts.app')

@section('title', 'Cadastro de Veículos')

@section('content')
<link rel="stylesheet" href="{{ asset('css/veiculos-index.css') }}">

<div class="container-os">
    <h2>Lista de Veículos</h2>

    @if(session('success'))
        <div style="background-color: #d4edda; padding: 10px; border-radius: 5px; margin-bottom: 15px; color: #155724;">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('veiculos.create') }}" class="btn-os" style="margin-bottom: 15px;">Novo Veículo</a>

    <table class="tabela-veiculos">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Placa</th>
                <th>Combustível</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($veiculos as $veiculo)
            <tr>
                <td>{{ $veiculo->id }}</td>
                <td>{{ $veiculo->cliente }}</td>
                <td>{{ $veiculo->marca }}</td>
                <td>{{ $veiculo->veiculo }}</td>
                <td>{{ $veiculo->placa }}</td>
                <td>{{ $veiculo->combustivel }}</td>
                <td>
                    <a href="{{ route('veiculos.edit', $veiculo->id) }}" class="btn-editar">Editar</a>
                    <form action="{{ route('veiculos.destroy', $veiculo->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Tem certeza que deseja excluir?')" class="btn-excluir">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
