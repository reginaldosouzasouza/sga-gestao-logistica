@extends('layouts.app')

@section('title', 'Cadastro de Mecânicos')

@section('content')
<link rel="stylesheet" href="{{ asset('css/mecanicos-create.css') }}">

<div class="container">
    <div class="card">
        <h2>Cadastro de Mecânico</h2>
        <form action="{{ route('mecanicos.store') }}" method="POST">
            @csrf

            <label for="nome" class="form-label">Nome do Mecânico</label>
            <input type="text" name="nome" id="nome" required>

            <button type="submit">Salvar</button>
            <a href="{{ route('mecanicos.index') }}" class="cancelar-link">Cancelar</a>
        </form>
    </div>
</div>
@endsection

