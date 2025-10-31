@extends('layouts.app')

@section('title', 'Mecânicos')

@section('content')

<link rel="stylesheet" href="{{ asset('css/mecanicos-index.css') }}">

<div class="container">
    <h2>Lista de Mecânicos</h2>

    <a href="{{ route('mecanicos.create') }}" class="novo-mecanico">Cadastrar</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mecanicos as $mecanico)
            <tr>
                <td>{{ $mecanico->id }}</td>
                <td>{{ $mecanico->nome }}</td>
                <td>
                    <a href="{{ route('mecanicos.edit', $mecanico->id) }}">Editar</a>
                    <form action="{{ route('mecanicos.destroy', $mecanico->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Deseja excluir este mecânico?')">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
