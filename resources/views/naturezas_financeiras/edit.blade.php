@extends('layouts.app')
@section('title', 'Alterar Naturezas Financeiras')

@section('content')
<div class="container">
    <h1>Editar Natureza Financeira</h1>

    <form action="{{ route('naturezas-financeiras.update', $natureza->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input 
                type="text" 
                name="nome" 
                id="nome" 
                class="form-control @error('nome') is-invalid @enderror"
                value="{{ old('nome', $natureza->nome) }}"
                required
            >

            @error('nome')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-check mb-3">
            <input 
                type="checkbox" 
                name="ativo" 
                id="ativo" 
                class="form-check-input"
                value="1"
                {{ old('ativo', $natureza->ativo) ? 'checked' : '' }}
            >
            <label for="ativo" class="form-check-label">
                Ativo
            </label>
        </div>

        <div class="form-check mb-3">
            <input 
                type="checkbox" 
                name="exibir_relatorio" 
                id="exibir_relatorio" 
                class="form-check-input"
                value="1"
                {{ old('exibir_relatorio', $natureza->exibir_relatorio) ? 'checked' : '' }}
            >
            <label for="exibir_relatorio" class="form-check-label">
                Exibir no relatório
            </label>
        </div>

        <div class="form-check mb-3">
            <input 
                type="checkbox" 
                name="considerar_total" 
                id="considerar_total" 
                class="form-check-input"
                value="1"
                {{ old('considerar_total', $natureza->considerar_total) ? 'checked' : '' }}
            >
            <label for="considerar_total" class="form-check-label">
                Considerar no total do relatório
            </label>
        </div>

        <button type="submit" class="btn btn-success">
            Atualizar
        </button>

        <a href="{{ route('naturezas-financeiras.index') }}" class="btn btn-secondary">
            Voltar
        </a>
    </form>
</div>
@endsection