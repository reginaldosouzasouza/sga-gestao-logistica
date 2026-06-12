@extends('layouts.app')

@section('title', 'Monitor de Acessos')

@section('content')
<style>
    .monitor-acessos-page {
        background: #f5f7fb;
        padding: 24px;
    }

    .monitor-acessos-page .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .monitor-acessos-page h1 {
        font-size: 26px;
        font-weight: 800;
        color: #1f2937;
        margin: 0;
    }

    .monitor-acessos-page .subtitle {
        color: #6b7280;
        margin-top: 4px;
    }

    .monitor-acessos-page .card-resumo {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 16px;
        margin-bottom: 18px;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.06);
    }

    .monitor-acessos-page .legenda {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        font-size: 14px;
        color: #4b5563;
    }

    .monitor-acessos-page .badge-status {
        display: inline-block;
        min-width: 86px;
        text-align: center;
        padding: 5px 10px;
        border-radius: 999px;
        font-weight: 700;
        font-size: 13px;
    }

    .monitor-acessos-page .status-online {
        color: #166534;
        background: #dcfce7;
        border: 1px solid #86efac;
    }

    .monitor-acessos-page .status-inativo {
        color: #92400e;
        background: #fef3c7;
        border: 1px solid #fcd34d;
    }

    .monitor-acessos-page .status-offline {
        color: #991b1b;
        background: #fee2e2;
        border: 1px solid #fca5a5;
    }

    .monitor-acessos-page .status-nunca {
        color: #374151;
        background: #f3f4f6;
        border: 1px solid #d1d5db;
    }

    .monitor-acessos-page .table-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.06);
    }

    .monitor-acessos-page .table-responsive {
        overflow-x: auto;
    }

    .monitor-acessos-page table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1050px;
    }

    .monitor-acessos-page th {
        background: #111827;
        color: #ffffff;
        text-align: left;
        padding: 12px;
        font-size: 14px;
        white-space: nowrap;
    }

    .monitor-acessos-page td {
        padding: 11px 12px;
        border-bottom: 1px solid #eef2f7;
        color: #374151;
        font-size: 14px;
        vertical-align: top;
    }

    .monitor-acessos-page tr:hover td {
        background: #f9fafb;
    }

    .monitor-acessos-page .muted {
        color: #6b7280;
        font-size: 13px;
    }

    .monitor-acessos-page .btn-atualizar {
        display: inline-block;
        background: #ff7a00;
        color: #ffffff;
        padding: 10px 14px;
        border-radius: 8px;
        font-weight: 700;
        text-decoration: none;
    }

    .monitor-acessos-page .btn-atualizar:hover {
        background: #e86f00;
        color: #ffffff;
    }
</style>

<div class="monitor-acessos-page">
    <div class="page-header">
        <div>
            <h1>Monitor de Acessos</h1>
            <div class="subtitle">
                Acompanhe usuários online, inativos e últimos acessos ao S.G.A.
            </div>
        </div>

        <a href="{{ route('usuarios.monitor-acessos') }}" class="btn-atualizar">
            Atualizar
        </a>
    </div>

    <div class="card-resumo">
        <div class="legenda">
            <span><span class="badge-status status-online">Online</span> atividade nos últimos 5 minutos</span>
            <span><span class="badge-status status-inativo">Inativo</span> atividade entre 5 e 30 minutos</span>
            <span><span class="badge-status status-offline">Offline</span> mais de 30 minutos sem atividade</span>
            <span><span class="badge-status status-nunca">Nunca acessou</span> sem registro de acesso</span>
        </div>
    </div>

    <div class="table-card">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Empresa</th>
                        <th>Usuário</th>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Perfil</th>
                        <th>Última atividade</th>
                        <th>Último login</th>
                        <th>IP</th>
                        <th>Navegador / Dispositivo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $usuario)
                        <tr>
                            <td>
                                <span class="badge-status {{ $usuario->status_classe }}">
                                    {{ $usuario->status_acesso }}
                                </span>
                            </td>
                            <td>
                                {{ $usuario->empresa ?? '-' }}
                                <div class="muted">ID empresa: {{ $usuario->empresa_id ?? '-' }}</div>
                            </td>
                            <td>{{ $usuario->usuario }}</td>
                            <td>
                                {{ $usuario->nome_completo }}
                                <div class="muted">{{ $usuario->email }}</div>
                            </td>
                            <td>{{ $usuario->tipo }}</td>
                            <td>{{ $usuario->perfil ?? '-' }}</td>
                            <td>{{ $usuario->ultima_atividade_formatada }}</td>
                            <td>
                                {{ $usuario->last_login_at ? $usuario->last_login_at->copy()->timezone('America/Sao_Paulo')->format('d/m/Y H:i:s') : '-' }}
                            </td>
                            <td>{{ $usuario->last_login_ip ?? '-' }}</td>
                            <td>
                                <span class="muted">
                                    {{ $usuario->last_user_agent ? \Illuminate\Support\Str::limit($usuario->last_user_agent, 90) : '-' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">Nenhum usuário encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
