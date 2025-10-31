@extends('layouts.app')

@section('title', 'Editar, Alterar Módulo')

@section('content')
<div class="container mt-4">
    <h2 class="text-warning">Editar Módulo</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $erro)<li>{{ $erro }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('modulos.update', $modulo->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Descrição do Módulo</label>
            <input type="text" name="descricao" class="form-control" value="{{ $modulo->descricao }}" required>
        </div>

        <button class="btn btn-primary" type="submit">Atualizar</button>
        <a href="{{ route('modulos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
