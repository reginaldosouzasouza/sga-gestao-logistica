@extends('layouts.app')

@section('content')
<div class="container">
    <h4><i class="fas fa-fire"></i> Cadastrar Duração do Gás</h4>
    <hr>

    <form action="{{ route('duracao.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Cliente</label>
            <select name="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                <option value="">-- Selecione --</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nome }}
                    </option>
                @endforeach
            </select>
            @error('cliente_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Produto</label>
            <select name="produto_id" class="form-select" required>
                @foreach($produtos as $produto)
                    <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Duração (dias)</label>
            <input type="number" name="duracao" class="form-control @error('duracao') is-invalid @enderror"
                   value="{{ old('duracao', 30) }}" min="1" required>
            @error('duracao') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <a href="{{ route('duracao.index') }}" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
@endsection