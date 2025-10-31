@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 style="color: navy;">Editar Mecânico</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('mecanicos.update', $mecanico->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nome" class="form-label">Nome do Mecânico</label>
            <input type="text" name="nome" value="{{ $mecanico->nome }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Salvar Alterações</button>
        <a href="{{ route('mecanicos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
