@extends('layouts.app')

@section('title', 'Lista de Módulos')

@section('content')

<link rel="stylesheet" href="{{ asset('css/modulos.css') }}">

<div class="container mt-4">
    <h2 class="text-primary">Lista de Módulos</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('modulos.create') }}" class="btn btn-success mb-3">Novo Módulo</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($modulos as $modulo)
                <tr>
                    <td>{{ $modulo->id }}</td>
                    <td>{{ $modulo->descricao }}</td>
                    <td>
                        <a href="{{ route('modulos.edit', $modulo->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('modulos.destroy', $modulo->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Deseja excluir este módulo?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
