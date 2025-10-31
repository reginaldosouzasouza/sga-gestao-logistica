@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Usuário</h2>
    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')
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
            <input type="email" name="email" class="form-control" value="{{ $usuario->email }}" required>
        </div>
        <div class="mb-3">
            <label>Tipo</label>
            <select name="tipo" class="form-control">
                <option value="ADMIN" {{ $usuario->tipo == 'ADMIN' ? 'selected' : '' }}>ADMIN</option>
                <option value="FUNCIONARIO" {{ $usuario->tipo == 'FUNCIONARIO' ? 'selected' : '' }}>FUNCIONÁRIO</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Atualizar</button>
    </form>
</div>
@endsection
