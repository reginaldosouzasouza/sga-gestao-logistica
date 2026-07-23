@extends('layouts.app')

@section('title', 'Criar Usuário')

@section('content')
<style>
    .usuario-form-page {
        padding: 25px 10px;
    }

    .usuario-form-card {
        max-width: 900px;
        margin: 0 auto;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0,0,0,.08);
        border: 1px solid #e9ecef;
        padding: 28px;
    }

    .usuario-form-topo {
        margin-bottom: 24px;
    }

    .usuario-form-titulo {
        margin: 0;
        font-size: 30px;
        font-weight: 700;
        color: #212529;
    }

    .usuario-form-subtitulo {
        margin: 6px 0 0;
        color: #6c757d;
        font-size: 14px;
    }

    .bloco-form {
        background: #f8f9fa;
        border: 1px solid #eceff3;
        border-radius: 14px;
        padding: 20px;
    }

    .form-label-custom {
        font-weight: 600;
        color: #343a40;
        margin-bottom: 8px;
        display: block;
    }

    .form-control,
    .form-select {
        border-radius: 10px;
        min-height: 46px;
        border: 1px solid #ced4da;
        box-shadow: none !important;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #86b7fe;
    }

    .acoes-form {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 24px;
    }

    .acoes-form .btn {
        border-radius: 10px;
        padding: 10px 18px;
        font-weight: 600;
    }

    .alert-custom {
        border-radius: 10px;
        border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,.05);
    }

    .senha-info {
        font-size: 13px;
        color: #6c757d;
        margin-top: 6px;
    }
</style>

<div class="container usuario-form-page">
    <div class="usuario-form-card">
        <div class="usuario-form-topo">
            <h2 class="usuario-form-titulo">Criar Usuário</h2>
            <p class="usuario-form-subtitulo">
                Cadastre um novo usuário e defina o tipo de acesso e o perfil no sistema.
            </p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-custom">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-custom">
                <strong>Confira os campos abaixo:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        @if(session('error'))
            <div style="
                background: #fee2e2;
                color: #991b1b;
                padding: 12px 16px;
                border-radius: 8px;
                margin-bottom: 16px;
                font-weight: 700;
            ">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div style="
                background: #fee2e2;
                color: #991b1b;
                padding: 12px 16px;
                border-radius: 8px;
                margin-bottom: 16px;
            ">
                <strong>Não foi possível salvar o usuário:</strong>

                <ul style="margin: 8px 0 0; padding-left: 20px;">
                    @foreach($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif



        <form action="{{ route('usuarios.store') }}" method="POST" autocomplete="off">
            @csrf

            <div class="bloco-form">
                <div class="form-group mb-3">
                    <label for="empresa_id">Empresa</label>
                    <select name="empresa_id" id="empresa_id" class="form-control" required>
                        <option value="">Selecione a empresa</option>

                        @foreach($empresas as $empresa)
                            <option value="{{ $empresa->id }}" {{ old('empresa_id') == $empresa->id ? 'selected' : '' }}>
                                {{ $empresa->nome_fantasia }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Usuário</label>
                        <input type="text"
                               name="usuario"
                               id="usuario_sistema"
                               class="form-control"
                               value="{{ old('usuario') }}"
                               autocomplete="new-password"
                               readonly
                               onfocus="this.removeAttribute('readonly');"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Nome completo</label>
                        <input type="text"
                               name="nome_completo"
                               class="form-control"
                               value="{{ old('nome_completo') }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Email</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ old('email') }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Senha</label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               required>
                        <div class="senha-info">
                            Defina uma senha segura para o novo usuário, minimo 6 caracteres.
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Tipo</label>
                        <select name="tipo" class="form-select">
                            <option value="FUNCIONARIO" {{ old('tipo') == 'FUNCIONARIO' ? 'selected' : '' }}>Funcionário</option>
                            <option value="ADMIN" {{ old('tipo') == 'ADMIN' ? 'selected' : '' }}>Administrador</option>
                      
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Perfil</label>

                        <select
                            name="perfil_id"
                            id="perfil_id"
                            class="form-select"
                        >
                            <option value="">Selecione o perfil</option>

                            @foreach($perfis as $perfil)
                                <option
                                    value="{{ $perfil->id }}"
                                    data-empresa-id="{{ $perfil->empresa_id ?? '' }}"
                                    {{ old('perfil_id') == $perfil->id ? 'selected' : '' }}
                                >
                                    {{ $perfil->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="acoes-form">
                <button type="submit" class="btn btn-success">
                    Salvar Usuário
                </button>

                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                    Voltar
                </a>
            </div>
        </form>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const empresaSelect = document.getElementById('empresa_id');
        const perfilSelect = document.getElementById('perfil_id');

        if (!empresaSelect || !perfilSelect) {
            return;
        }

        const opcoesPerfis = Array.from(
            perfilSelect.querySelectorAll('option[data-empresa-id]')
        );

        function filtrarPerfis() {
            const empresaId = empresaSelect.value;
            const perfilSelecionado = perfilSelect.value;

            opcoesPerfis.forEach(function (option) {
                const perfilEmpresaId = option.dataset.empresaId;

                const perfilGeral = perfilEmpresaId === '';
                const pertenceEmpresa = perfilEmpresaId === empresaId;

                option.hidden = !(perfilGeral || pertenceEmpresa);
                option.disabled = !(perfilGeral || pertenceEmpresa);
            });

            const selecionado = perfilSelect.querySelector(
                `option[value="${perfilSelecionado}"]`
            );

            if (
                selecionado &&
                selecionado.disabled
            ) {
                perfilSelect.value = '';
            }
        }

        empresaSelect.addEventListener('change', filtrarPerfis);

        filtrarPerfis();
    });
</script>

@endsection