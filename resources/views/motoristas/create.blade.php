@extends('layouts.app')

@section('title', 'Novo Motorista')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/motoristas.css') }}">
@endsection

@section('content')

<div class="motoristas-page">

    <h2>Cadastrar Motorista</h2>

    @if($errors->any())
        <div class="motoristas-alert-danger">
            <strong>Verifique os campos abaixo:</strong>
            <ul>
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('motoristas.store') }}" method="POST">
        @csrf

        <div class="motoristas-form-card">

            <div class="motoristas-form-header">
                Dados do Motorista
            </div>

            <div class="motoristas-form-body">

                <div class="motoristas-row">
                    <div class="motoristas-field field-40">
                        <label>Nome *</label>
                        <input 
                            type="text" 
                            name="nome" 
                            value="{{ old('nome') }}" 
                            required
                        >
                    </div>

                    <div class="motoristas-field field-20">
                        <label>Telefone</label>
                        <input 
                            type="text" 
                            name="telefone" 
                            value="{{ old('telefone') }}"
                        >
                    </div>

                    <div class="motoristas-field field-20">
                        <label>CPF</label>
                        <input 
                            type="text" 
                            name="cpf" 
                            value="{{ old('cpf') }}"
                        >
                    </div>
                </div>

                <div class="motoristas-row">
                    <div class="motoristas-field field-25">
                        <label>CNH</label>
                        <input 
                            type="text" 
                            name="cnh" 
                            value="{{ old('cnh') }}"
                        >
                    </div>

                    <div class="motoristas-field field-20">
                        <label>Categoria CNH</label>
                        <input 
                            type="text" 
                            name="categoria_cnh" 
                            value="{{ old('categoria_cnh') }}"
                            placeholder="Ex: A, B, AB"
                        >
                    </div>

                    <div class="motoristas-field field-25">
                        <label>Validade CNH</label>
                        <input 
                            type="date" 
                            name="validade_cnh" 
                            value="{{ old('validade_cnh') }}"
                        >
                    </div>
                </div>

                <div class="motoristas-row">
                    <div class="motoristas-field field-40">
                        <label>Endereço</label>
                        <input 
                            type="text" 
                            name="endereco" 
                            value="{{ old('endereco') }}"
                        >
                    </div>

                    <div class="motoristas-field field-15">
                        <label>Número</label>
                        <input 
                            type="text" 
                            name="numero" 
                            value="{{ old('numero') }}"
                        >
                    </div>

                    <div class="motoristas-field field-25">
                        <label>Bairro</label>
                        <input 
                            type="text" 
                            name="bairro" 
                            value="{{ old('bairro') }}"
                        >
                    </div>

                    <div class="motoristas-field field-20">
                        <label>Cidade</label>
                        <input 
                            type="text" 
                            name="cidade" 
                            value="{{ old('cidade') }}"
                        >
                    </div>
                </div>

                <div class="motoristas-row">
                    <div class="motoristas-field field-100">
                        <label>Observação</label>
                        <textarea 
                            name="observacao" 
                            rows="4"
                        >{{ old('observacao') }}</textarea>
                    </div>
                </div>

                <div class="motoristas-checkbox">
                    <input 
                        type="checkbox" 
                        name="ativo" 
                        id="ativo" 
                        value="1" 
                        checked
                    >

                    <label for="ativo">Motorista ativo</label>
                </div>

            </div>
        </div>

        <div class="motoristas-actions">
            <button type="submit" class="btn-salvar">
                Salvar Motorista
            </button>

            <a href="{{ route('motoristas.index') }}" class="btn-cancelar">
                Cancelar
            </a>
        </div>

    </form>

</div>

@endsection