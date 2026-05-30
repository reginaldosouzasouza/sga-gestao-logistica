@extends('layouts.app')

@section('title', 'Editar Empresa')

@section('content')

<div class="container mt-4">

    <h2>Editar Empresa</h2>

    <div class="card mt-3">
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Verifique os campos abaixo:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('empresas.update', $empresa->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nome Fantasia *</label>
                        <input type="text" name="nome_fantasia" class="form-control"
                               value="{{ old('nome_fantasia', $empresa->nome_fantasia) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Razão Social</label>
                        <input type="text" name="razao_social" class="form-control"
                               value="{{ old('razao_social', $empresa->razao_social) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>CNPJ</label>
                        <input type="text" name="cnpj" class="form-control"
                               value="{{ old('cnpj', $empresa->cnpj) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Telefone</label>
                        <input type="text" name="telefone" class="form-control"
                               value="{{ old('telefone', $empresa->telefone) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>E-mail</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email', $empresa->email) }}">
                    </div>

                    <div class="col-md-5 mb-3">
                        <label>Endereço</label>
                        <input type="text" name="endereco" class="form-control"
                               value="{{ old('endereco', $empresa->endereco) }}">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>Número</label>
                        <input type="text" name="numero" class="form-control"
                               value="{{ old('numero', $empresa->numero) }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Bairro</label>
                        <input type="text" name="bairro" class="form-control"
                               value="{{ old('bairro', $empresa->bairro) }}">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>CEP</label>
                        <input type="text" name="cep" class="form-control"
                               value="{{ old('cep', $empresa->cep) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Cidade</label>
                        <input type="text" name="cidade" class="form-control"
                               value="{{ old('cidade', $empresa->cidade) }}">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>Estado</label>
                        <input type="text" name="estado" maxlength="2" class="form-control"
                               value="{{ old('estado', $empresa->estado) }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Status *</label>
                        <select name="status" class="form-control" required>
                            <option value="teste" {{ old('status', $empresa->status) == 'teste' ? 'selected' : '' }}>Teste</option>
                            <option value="ativo" {{ old('status', $empresa->status) == 'ativo' ? 'selected' : '' }}>Ativo</option>
                            <option value="inativo" {{ old('status', $empresa->status) == 'inativo' ? 'selected' : '' }}>Inativo</option>
                            <option value="bloqueado" {{ old('status', $empresa->status) == 'bloqueado' ? 'selected' : '' }}>Bloqueado</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Plano</label>
                        <input type="text" name="plano" class="form-control"
                               value="{{ old('plano', $empresa->plano) }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Início do Teste</label>
                        <input type="date" name="data_inicio_teste" class="form-control"
                               value="{{ old('data_inicio_teste', $empresa->data_inicio_teste) }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Vencimento</label>
                        <input type="date" name="data_vencimento" class="form-control"
                               value="{{ old('data_vencimento', $empresa->data_vencimento) }}">
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success">
                        Atualizar Empresa
                    </button>

                    <a href="{{ route('empresas.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection