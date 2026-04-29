@extends('layouts.app')

@section('title', 'USUÁRIOS')

@section('content')
<style>
    .usuarios-page {
        padding: 25px 10px;
    }

    .usuarios-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0,0,0,.08);
        padding: 24px;
        border: 1px solid #e9ecef;
    }

    .usuarios-topo {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .usuarios-titulo {
        margin: 0;
        font-size: 30px;
        font-weight: 700;
        color: #212529;
    }

    .usuarios-subtitulo {
        margin: 4px 0 0;
        color: #6c757d;
        font-size: 14px;
    }

    .btn-criar-usuario {
        border-radius: 10px;
        padding: 10px 18px;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(13,110,253,.15);
    }

    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
    }

    .tabela-usuarios {
        margin-bottom: 0;
        vertical-align: middle;
    }

    .tabela-usuarios thead th {
        background: #2b3035;
        color: #fff;
        border: none;
        font-size: 14px;
        font-weight: 600;
        padding: 14px 12px;
        white-space: nowrap;
      
    }

    .tabela-usuarios tbody td {
        padding: 14px 12px;
        vertical-align: middle;
    }

    .tabela-usuarios tbody tr:hover {
        background: #abacac;
    }

    .col-id {
        width: 70px;
        font-weight: 600;
        color: #495057;
    }

    .usuario-nome {
        font-weight: 600;
        color: #212529;
    }

    .usuario-login {
        font-weight: 600;
        color: #0d6efd;
    }

    .perfil-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .2px;
    }

    .perfil-admin {
        background: rgba(13,110,253,.12);
        color: #0d6efd;
    }

    .perfil-operacional {
        background: rgba(25,135,84,.12);
        color: #198754;
    }

    .perfil-financeiro {
        background: rgba(255,193,7,.18);
        color: #9a6700;
    }

    .perfil-default {
        background: rgba(108,117,125,.14);
        color: #495057;
    }

    .acoes-box {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .acoes-box .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 6px 12px;
    }

    .alert-sucesso {
        border-radius: 10px;
        border: none;
        box-shadow: 0 4px 12px rgba(25,135,84,.10);
    }

    .sem-registros {
        text-align: center;
        padding: 25px !important;
        color: #6c757d;
        font-weight: 600;
    }
</style>

<div class="container usuarios-page">
    <div class="usuarios-card">
        <div class="usuarios-topo">
            <div>
                <h2 class="usuarios-titulo">Gerenciar Usuários</h2>
                <p class="usuarios-subtitulo">Controle de acesso, perfis e manutenção de usuários do sistema.</p>
            </div>

            <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-criar-usuario">
                + Criar Usuário
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-sucesso">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table tabela-usuarios align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuário</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Perfil</th>
                        <th style="width: 180px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $usuario)
                        @php
                            $perfilNome = is_object($usuario->perfil) ? ($usuario->perfil->nome ?? 'Sem perfil') : ($usuario->perfil ?? 'Sem perfil');

                            $perfilClasse = 'perfil-default';
                            $perfilTexto = strtolower(trim($perfilNome));

                            if (str_contains($perfilTexto, 'admin')) {
                                $perfilClasse = 'perfil-admin';
                            } elseif (str_contains($perfilTexto, 'oper')) {
                                $perfilClasse = 'perfil-operacional';
                            } elseif (str_contains($perfilTexto, 'finan')) {
                                $perfilClasse = 'perfil-financeiro';
                            }
                        @endphp

                        <tr>
                            <td class="col-id">{{ $usuario->id }}</td>
                            <td class="usuario-login">{{ $usuario->usuario }}</td>
                            <td class="usuario-nome">{{ $usuario->nome_completo }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>
                                <span class="perfil-badge {{ $perfilClasse }}">
                                    {{ $perfilNome }}
                                </span>
                            </td>
                            <td>
                                <div class="acoes-box">
                                    <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-warning btn-sm">
                                        Alterar
                                    </a>

                                    <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="sem-registros">
                                Nenhum usuário cadastrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection