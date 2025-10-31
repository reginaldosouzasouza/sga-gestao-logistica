@extends('layouts.app')

@section('title', 'Cadastro de Módulos')

@section('content')

<link rel="stylesheet" href="{{ asset('css/modulos.css') }}">

<div class="container mt-4">
    <h2 class="text-success">Cadastrar Novo Módulo</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $erro)<li>{{ $erro }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('modulos.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Descrição do Módulo</label>
            <input type="text" name="descricao" class="form-control" required>
        </div>

        <button class="btn btn-primary" type="submit">Salvar</button>
        <a href="{{ route('modulos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
