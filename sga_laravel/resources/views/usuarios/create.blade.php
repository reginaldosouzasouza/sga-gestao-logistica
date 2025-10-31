@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Criar Usuário</h2>
    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Cód. Usuário</label>
            <input type="text" name="id" class="form-control" value="{{ $nextId }}" readonly>
        </div>

        <div class="mb-3">
            <label>Usuário</label>
            <input type="text" name="usuario" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nome Completo</label>
            <input type="text" name="nome_completo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Senha</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tipo</label>
            <select name="tipo" class="form-control">
                <option value="ADMIN">ADMIN</option>
                <option value="FUNCIONARIO">FUNCIONÁRIO</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
</div>
@endsection
