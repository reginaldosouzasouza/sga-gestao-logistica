@extends('layouts.app')

@section('content')
<div class="container">
    <h4><i class="fas fa-fire"></i> Editar Duração do Gás</h4>
    <hr>

    <form action="{{ route('duracao.update', $duracao->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Cliente</label>
            <input type="text" class="form-control" value="{{ $duracao->cliente->nome }}" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Produto</label>
            <input type="text" class="form-control" value="{{ $duracao->produto->nome }}" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Duração (dias)</label>
            <input type="number" name="duracao" class="form-control @error('duracao') is-invalid @enderror"
                   value="{{ old('duracao', $duracao->duracao) }}" min="1" required>
            @error('duracao') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <a href="{{ route('duracao.index') }}" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>
@endsection


