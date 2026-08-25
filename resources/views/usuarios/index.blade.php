@extends('layouts.app')

@section('title', 'USUÁRIOS')

@section('styles')
<style>
    .usuarios-wrapper {
        width: min(1560px, calc(100vw - 56px));
        max-width: 1560px;
        margin: 42px auto;
        padding: 0;
    }

    .usuarios-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px 26px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        overflow: visible;
    }

    .usuarios-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 22px;
    }

    .usuarios-header h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
    }

    .usuarios-header p {
        margin: 6px 0 0;
        color: #64748b;
        font-size: 14px;
    }

    .btn-criar-usuario {
        background: #0d6efd;
        color: #ffffff !important;
        border: none;
        border-radius: 10px;
        padding: 12px 20px;
        font-weight: 800;
        text-decoration: none;
        box-shadow: 0 6px 14px rgba(13, 110, 253, 0.25);
        white-space: nowrap;
    }

    .alert-sucesso,
    .alert-erro {
        border-radius: 10px;
        padding: 12px 16px;
        margin-bottom: 18px;
        font-weight: 700;
    }

    .alert-sucesso {
        background: #d1e7dd;
        color: #0f5132;
    }

    .alert-erro {
        background: #f8d7da;
        color: #842029;
    }

    .filtros-usuarios {
        display: grid;
        grid-template-columns: minmax(210px, 1.5fr) minmax(115px, .75fr) minmax(230px, 1.7fr) minmax(200px, 1.35fr) minmax(115px, .75fr) auto;
        gap: 12px;
        align-items: end;
        background: #ffffff;
        border: 1px solid #eef2f7;
        border-radius: 14px;
        padding: 18px 18px;
        margin-bottom: 22px;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.06);
    }

    .campo-filtro {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .campo-filtro label {
        font-size: 13px;
        font-weight: 800;
        color: #475569;
    }

    .campo-filtro input,
    .campo-filtro select {
        width: 100%;
        min-width: 0;
        height: 40px;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        padding: 0 12px;
        font-size: 14px;
        background: #ffffff;
        color: #0f172a;
        box-sizing: border-box;
    }

    .acoes-filtro {
        display: flex;
        gap: 8px;
        align-items: center;
        justify-content: flex-start;
        white-space: nowrap;
    }

    .btn-filtrar,
    .btn-limpar-filtro {
        height: 40px;
        border-radius: 9px;
        border: none;
        padding: 0 15px;
        font-weight: 800;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        white-space: nowrap;
    }

    .btn-filtrar {
        background: #0d6efd;
        color: #ffffff;
    }

    .btn-limpar-filtro {
        background: #e2e8f0;
        color: #0f172a;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
        overflow-y: visible;
    }

    .tabela-usuarios {
        width: 100%;
        min-width: 1180px;
        border-collapse: collapse;
        font-size: 13.5px;
        table-layout: auto;
    }

    .tabela-usuarios thead th {
        background: #2b3035;
        color: #ffffff;
        padding: 13px 10px;
        text-align: left;
        font-weight: 800;
        white-space: nowrap;
    }

    .tabela-usuarios tbody td {
        padding: 13px 10px;
        border-bottom: 1px solid #e5e7eb;
        vertical-align: middle;
        color: #0f172a;
    }

    .tabela-usuarios th:nth-child(1),
    .tabela-usuarios td:nth-child(1) {
        width: 48px;
        text-align: center;
    }

    .tabela-usuarios th:nth-child(2),
    .tabela-usuarios td:nth-child(2) {
        width: 88px;
    }

    .tabela-usuarios th:nth-child(3),
    .tabela-usuarios td:nth-child(3) {
        width: 205px;
    }

    .tabela-usuarios th:nth-child(4),
    .tabela-usuarios td:nth-child(4) {
        width: 125px;
    }

    .tabela-usuarios th:nth-child(5),
    .tabela-usuarios td:nth-child(5) {
        width: 160px;
    }

    .tabela-usuarios th:nth-child(6),
    .tabela-usuarios td:nth-child(6) {
        width: 230px;
    }

    .tabela-usuarios th:nth-child(7),
    .tabela-usuarios td:nth-child(7) {
        width: 92px;
    }

    .tabela-usuarios th:nth-child(8),
    .tabela-usuarios td:nth-child(8) {
        width: 145px;
    }

    .tabela-usuarios th:nth-child(9),
    .tabela-usuarios td:nth-child(9) {
        width: 154px;
    }

    .col-id {
        font-weight: 800;
        width: 60px;
    }

    .usuario-login,
    .usuario-nome {
        font-weight: 800;
    }

    .empresa-texto strong {
        display: block;
        font-weight: 800;
    }

    .empresa-texto small {
        display: block;
        color: #64748b;
        margin-top: 3px;
        font-size: 12px;
    }

    .badge-modulo,
    .perfil-badge,
    .tipo-badge {
        display: inline-block;
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 900;
        white-space: nowrap;
    }

    .badge-gas {
        background: #fff3cd;
        color: #856404;
    }

    .badge-oficina {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge-salao {
        background: #fce7f3;
        color: #9d174d;
    }

    .badge-financas {
        background: #dff7f4;
        color: #0f766e;
    }

    .badge-default {
        background: #e2e8f0;
        color: #334155;
    }

    .tipo-master {
        background: #ede9fe;
        color: #5b21b6;
    }

    .tipo-admin {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .tipo-funcionario {
        background: #dcfce7;
        color: #166534;
    }

    .perfil-default {
        background: #e5e7eb;
        color: #374151;
    }

    .perfil-admin {
        background: #dbeafe;
        color: #0d6efd;
    }

    .perfil-operacional {
        background: #d1e7dd;
        color: #087f5b;
    }

    .perfil-financeiro {
        background: #fff3cd;
        color: #856404;
    }

    .perfil-oficina {
        background: #fee2e2;
        color: #991b1b;
    }

    .perfil-salao {
        background: #fce7f3;
        color: #9d174d;
    }

    .perfil-financas {
        background: #dff7f4;
        color: #0f766e;
    }

    .acoes-box {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: nowrap;
        white-space: nowrap;
    }

    .btn-acao {
        border: none;
        border-radius: 8px;
        padding: 8px 11px;
        font-weight: 800;
        text-decoration: none;
        cursor: pointer;
        font-size: 12.5px;
        display: inline-block;
        line-height: 1.2;
    }

    .btn-editar {
        background: #ffc107;
        color: #111827 !important;
    }

    .btn-excluir {
        background: #dc3545;
        color: #ffffff;
    }

    .form-excluir {
        display: inline;
        margin: 0;
    }

    .sem-registros {
        text-align: center;
        color: #64748b;
        font-weight: 700;
        padding: 24px !important;
    }

    .paginacao {
        margin-top: 18px;
    }

    @media (max-width: 1350px) {
        .usuarios-wrapper {
            width: min(100%, calc(100vw - 32px));
            padding: 0;
        }

        .filtros-usuarios {
            grid-template-columns: 1fr 1fr 1fr;
        }

        .campo-busca {
            grid-column: 1 / -1;
        }

        .acoes-filtro {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 768px) {
        .usuarios-wrapper {
            margin: 24px auto;
            padding: 0 14px;
        }

        .usuarios-card {
            padding: 18px;
        }

        .usuarios-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-criar-usuario {
            width: 100%;
            text-align: center;
        }

        .filtros-usuarios {
            grid-template-columns: 1fr;
        }

        .campo-busca,
        .acoes-filtro {
            grid-column: auto;
        }

        .acoes-filtro {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')
@php
    $isMaster = auth()->user() && strtoupper(auth()->user()->tipo ?? '') === 'MASTER';
@endphp

<div class="usuarios-wrapper">
    <div class="usuarios-card">
        <div class="usuarios-header">
            <div>
                <h2>Gerenciar Usuários</h2>
                <p>Controle de acesso, perfis e manutenção de usuários do sistema.</p>
            </div>

            <a href="{{ route('usuarios.create') }}" class="btn-criar-usuario">
                + Criar Usuário
            </a>
        </div>

        @if(session('success'))
            <div class="alert-sucesso">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-erro">
                {{ session('error') }}
            </div>
        @endif

        <form method="GET" action="{{ route('usuarios.index') }}" class="filtros-usuarios">
            <div class="campo-filtro campo-busca">
                <label>Buscar usuário</label>
                <input
                    type="text"
                    name="busca"
                    value="{{ request('busca') }}"
                    placeholder="Usuário, nome, e-mail, empresa ou perfil..."
                >
            </div>

            @if($isMaster)
                <div class="campo-filtro">
                    <label>Módulo</label>
                    <select name="modulo">
                        <option value="">Todos</option>
                        <option value="gas" {{ request('modulo') === 'gas' ? 'selected' : '' }}>Gás</option>
                        <option value="oficina" {{ request('modulo') === 'oficina' ? 'selected' : '' }}>Oficina</option>
                        <option value="salao" {{ request('modulo') === 'salao' ? 'selected' : '' }}>Salão / Barbearia</option>
                        <option value="financas" {{ request('modulo') === 'financas' ? 'selected' : '' }}>SGA Finanças</option>
                    </select>
                </div>

                <div class="campo-filtro">
                    <label>Empresa</label>
                    <select name="empresa_id">
                        <option value="">Todas</option>
                        @foreach($empresas as $empresa)
                            <option value="{{ $empresa->id }}" {{ request('empresa_id') == $empresa->id ? 'selected' : '' }}>
                                {{ $empresa->id }} - {{ $empresa->nome_fantasia }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="campo-filtro">
                <label>Perfil</label>
                <select name="perfil_id">
                    <option value="">Todos</option>
                    @foreach($perfis as $perfil)
                        <option value="{{ $perfil->id }}" {{ request('perfil_id') == $perfil->id ? 'selected' : '' }}>
                            {{ $perfil->nome }}
                            @if(!empty($perfil->modulo))
                                - {{ strtoupper($perfil->modulo) }}
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="campo-filtro">
                <label>Tipo</label>
                <select name="tipo">
                    <option value="">Todos</option>
                    <option value="MASTER" {{ request('tipo') === 'MASTER' ? 'selected' : '' }}>MASTER</option>
                    <option value="ADMIN" {{ request('tipo') === 'ADMIN' ? 'selected' : '' }}>ADMIN</option>
                    <option value="FUNCIONARIO" {{ request('tipo') === 'FUNCIONARIO' ? 'selected' : '' }}>FUNCIONÁRIO</option>
                </select>
            </div>

            <div class="acoes-filtro">
                <button type="submit" class="btn-filtrar">Buscar</button>
                <a href="{{ route('usuarios.index') }}" class="btn-limpar-filtro">Limpar</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="tabela-usuarios align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        @if($isMaster)
                            <th>Módulo</th>
                            <th>Empresa</th>
                        @endif
                        <th>Usuário</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Tipo</th>
                        <th>Perfil</th>
                        <th class="col-acoes">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($usuarios as $usuario)
                        @php
                            $perfilNome = $usuario->perfil ?? 'Sem perfil';
                            $perfilTexto = strtolower(trim($perfilNome));

                            $perfilClasse = 'perfil-default';

                            if (str_contains($perfilTexto, 'oficina')) {
                                $perfilClasse = 'perfil-oficina';
                            } elseif (str_contains($perfilTexto, 'salão') || str_contains($perfilTexto, 'salao')) {
                                $perfilClasse = 'perfil-salao';
                            } elseif (str_contains($perfilTexto, 'sga finanças') || str_contains($perfilTexto, 'sga financas')) {
                                $perfilClasse = 'perfil-financas';
                            } elseif (str_contains($perfilTexto, 'admin')) {
                                $perfilClasse = 'perfil-admin';
                            } elseif (str_contains($perfilTexto, 'oper')) {
                                $perfilClasse = 'perfil-operacional';
                            } elseif (str_contains($perfilTexto, 'finan')) {
                                $perfilClasse = 'perfil-financeiro';
                            }

                            $modulo = strtolower($usuario->modulo ?? '');
                            $moduloClasse = match ($modulo) {
                                'gas' => 'badge-gas',
                                'oficina' => 'badge-oficina',
                                'salao' => 'badge-salao',
                                'financas' => 'badge-financas',
                                default => 'badge-default',
                            };

                            $moduloLabel = match ($modulo) {
                                'gas' => 'Gás',
                                'oficina' => 'Oficina',
                                'salao' => 'Salão',
                                'financas' => 'Finanças',
                                default => '-',
                            };

                            $tipoClasse = match (strtoupper($usuario->tipo ?? '')) {
                                'MASTER' => 'tipo-master',
                                'ADMIN' => 'tipo-admin',
                                'FUNCIONARIO' => 'tipo-funcionario',
                                default => 'perfil-default',
                            };
                        @endphp

                        <tr>
                            <td class="col-id">{{ $usuario->id }}</td>

                            @if($isMaster)
                                <td>
                                    <span class="badge-modulo {{ $moduloClasse }}">
                                        {{ $moduloLabel }}
                                    </span>
                                </td>

                                <td class="empresa-texto">
                                    @if($usuario->empresa_id)
                                        <strong>{{ $usuario->empresa_id }} - {{ $usuario->empresa ?? 'Empresa não encontrada' }}</strong>
                                    @else
                                        <strong>Sem empresa</strong>
                                    @endif
                                </td>
                            @endif

                            <td class="usuario-login">{{ $usuario->usuario }}</td>
                            <td class="usuario-nome">{{ $usuario->nome_completo }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>
                                <span class="tipo-badge {{ $tipoClasse }}">
                                    {{ $usuario->tipo ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <span class="perfil-badge {{ $perfilClasse }}">
                                    {{ $perfilNome }}
                                </span>
                            </td>
                            <td>
                                <div class="acoes-box">
                                    <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn-acao btn-editar">
                                        Alterar
                                    </a>

                                    <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="form-excluir">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-acao btn-excluir" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $isMaster ? 9 : 7 }}" class="sem-registros">
                                Nenhum usuário cadastrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="paginacao">
            {{ $usuarios->links() }}
        </div>
    </div>
</div>
@endsection