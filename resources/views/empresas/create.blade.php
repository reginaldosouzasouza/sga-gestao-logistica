@extends('layouts.app')

@section('title', 'Nova Empresa')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/empresas-form.css') }}">
@endsection

@section('content')

<div class="empresas-page">

    <div class="empresas-header">
        <div>
            <h2>Nova Empresa</h2>
            <p class="empresas-subtitle">Cadastre uma nova empresa no S.G.A SaaS.</p>
        </div>
    </div>

    <div class="card empresas-card mt-3">
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

            <form action="{{ route('empresas.store') }}" method="POST">
                @csrf

                <h5 class="empresas-section-title">Dados da Empresa</h5>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Nome Fantasia *</label>
                        <input
                            type="text"
                            name="nome_fantasia"
                            class="form-control"
                            value="{{ old('nome_fantasia') }}"
                            required
                        >
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Módulo *</label>

                        <select
                            name="modulo"
                            class="form-control"
                            required
                        >
                            <option value="">Selecione o módulo</option>

                            <option value="gas" {{ old('modulo') === 'gas' ? 'selected' : '' }}>
                                Revenda de Gás
                            </option>

                            <option value="salao" {{ old('modulo') === 'salao' ? 'selected' : '' }}>
                                Salão / Barbearia
                            </option>

                            <option value="oficina" {{ old('modulo') === 'oficina' ? 'selected' : '' }}>
                                Oficina
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Razão Social</label>
                        <input
                            type="text"
                            name="razao_social"
                            class="form-control"
                            value="{{ old('razao_social') }}"
                        >
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>CNPJ</label>
                        <input type="text" name="cnpj" class="form-control"
                               value="{{ old('cnpj') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Telefone</label>
                        <input type="text" name="telefone" class="form-control"
                               value="{{ old('telefone') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>E-mail</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email') }}">
                    </div>

                    <div class="col-md-5 mb-3">
                        <label>Endereço</label>
                        <input type="text" name="endereco" class="form-control"
                               value="{{ old('endereco') }}">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>Número</label>
                        <input type="text" name="numero" class="form-control"
                               value="{{ old('numero') }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Bairro</label>
                        <input type="text" name="bairro" class="form-control"
                               value="{{ old('bairro') }}">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>CEP</label>
                        <input type="text" name="cep" class="form-control"
                               value="{{ old('cep') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Cidade</label>
                        <input type="text" name="cidade" class="form-control"
                               value="{{ old('cidade') }}">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>Estado</label>
                        <input type="text" name="estado" maxlength="2" class="form-control"
                               value="{{ old('estado') }}">
                    </div>
                </div>

                <hr class="empresas-divider">

                <h5 class="empresas-section-title">Controle SaaS</h5>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label>Status da Empresa *</label>
                        <select name="status" class="form-control" required>
                            <option value="teste" {{ old('status', 'teste') == 'teste' ? 'selected' : '' }}>Teste</option>
                            <option value="ativo" {{ old('status') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                            <option value="inativo" {{ old('status') == 'inativo' ? 'selected' : '' }}>Inativo</option>
                            <option value="bloqueado" {{ old('status') == 'bloqueado' ? 'selected' : '' }}>Bloqueado</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Plano</label>
                        <select name="plano" class="form-control">
                            <option value="teste" {{ old('plano', 'teste') == 'teste' ? 'selected' : '' }}>Teste</option>
                            <option value="basico" {{ old('plano') == 'basico' ? 'selected' : '' }}>Básico</option>
                            <option value="completo" {{ old('plano') == 'completo' ? 'selected' : '' }}>Completo</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Status da Assinatura</label>
                        <select name="status_assinatura" class="form-control">
                            <option value="teste" {{ old('status_assinatura', 'teste') == 'teste' ? 'selected' : '' }}>Teste</option>
                            <option value="ativa" {{ old('status_assinatura') == 'ativa' ? 'selected' : '' }}>Ativa</option>
                            <option value="vencida" {{ old('status_assinatura') == 'vencida' ? 'selected' : '' }}>Vencida</option>
                            <option value="bloqueada" {{ old('status_assinatura') == 'bloqueada' ? 'selected' : '' }}>Bloqueada</option>
                            <option value="cancelada" {{ old('status_assinatura') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Início do Teste</label>
                        <input type="date" name="data_inicio_teste" class="form-control"
                               value="{{ old('data_inicio_teste', date('Y-m-d')) }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Fim do Teste</label>
                        <input type="date" name="data_fim_teste" class="form-control"
                               value="{{ old('data_fim_teste') }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Vencimento</label>
                        <input type="date" name="data_vencimento" class="form-control"
                               value="{{ old('data_vencimento') }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Limite de Usuários</label>
                        <input type="number" name="limite_usuarios" class="form-control"
                               min="1"
                               value="{{ old('limite_usuarios', 3) }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Limite de Clientes</label>
                        <input type="number" name="limite_clientes" class="form-control"
                               min="1"
                               value="{{ old('limite_clientes') }}">
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="bloqueada" value="1"
                                   class="form-check-input"
                                   id="bloqueada"
                                   {{ old('bloqueada') ? 'checked' : '' }}>

                            <label class="form-check-label" for="bloqueada">
                                Empresa bloqueada
                            </label>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Motivo do Bloqueio</label>
                        <input type="text" name="motivo_bloqueio" class="form-control"
                               value="{{ old('motivo_bloqueio') }}"
                               placeholder="Ex: Teste vencido, inadimplência, bloqueio manual...">
                    </div>
                </div>

                <div class="empresas-actions">
                    <button type="submit" class="btn btn-success">
                        Salvar Empresa
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