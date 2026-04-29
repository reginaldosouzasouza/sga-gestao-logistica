@extends('layouts.app')
@section('title', 'Editar Fornecedor')

@section('content')
<link rel="stylesheet" href="{{ asset('css/fornecedoresedit.css') }}">

<div class="container">
    <h1>Editar Fornecedor</h1>
    <form action="{{ route('fornecedores.update', $fornecedor->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <label for="cnpj">CNPJ</label>
                <input type="text" class="form-control" id="cnpj" name="cnpj" value="{{ $fornecedor->cnpj }}" required>
            </div>
            <div class="col-md-6">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="{{ $fornecedor->nome }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="endereco">Endereço</label>
                <input type="text" class="form-control" id="endereco" name="endereco" value="{{ $fornecedor->endereco }}" required>
            </div>
            <div class="col-md-6">
                <label for="telefone">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" value="{{ $fornecedor->telefone }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $fornecedor->email }}">
            </div>
            <div class="col-md-6">
                <label for="cidade">Cidade</label>
                <input type="text" class="form-control" id="cidade" name="cidade" value="{{ $fornecedor->cidade }}">
            </div>
        </div>

        <div class="form-group">
            <label for="observacao">Observação</label>
            <textarea class="form-control" id="observacao" name="observacao" rows="3">{{ $fornecedor->observacao }}</textarea>
        </div>

        <div class="form-group">
          
            <label for="natureza_financeira_id" class="form-label">Natureza Financeira</label>

            <select 
                name="natureza_financeira_id" 
                id="natureza_financeira_id" 
                class="form-control"
            >
                <option value="">Selecione...</option>

                @foreach ($naturezas as $natureza)
                    <option value="{{ $natureza->id }}"
                        {{ old('natureza_financeira_id', $fornecedor->natureza_financeira_id ?? '') == $natureza->id ? 'selected' : '' }}>
                        {{ $natureza->nome }}
                    </option>
                @endforeach
            </select>

  
        </div>

        <button type="submit" class="btn-atualizar">Atualizar</button>
    </form>
</div>
@endsection
