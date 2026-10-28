@extends('layouts.app')

@section('title', 'Monitor de Acessos')

@section('content')
<style>
    .monitor-acessos-page { background: #f5f7fb; padding: 24px; }
    .monitor-acessos-page .page-header { display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 20px; flex-wrap: wrap; }
    .monitor-acessos-page h1 { font-size: 26px; font-weight: 800; color: #1f2937; margin: 0; }
    .monitor-acessos-page .subtitle { color: #6b7280; margin-top: 4px; }
    .monitor-acessos-page .card-resumo, .monitor-acessos-page .card-filtros { background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; padding: 16px; margin-bottom: 18px; box-shadow: 0 8px 20px rgba(15, 23, 42, .06); }
    .monitor-acessos-page .legenda { display: flex; gap: 10px; flex-wrap: wrap; font-size: 14px; color: #4b5563; }
    .monitor-acessos-page .badge-status { display: inline-block; min-width: 86px; text-align: center; padding: 5px 10px; border-radius: 999px; font-weight: 700; font-size: 13px; }
    .monitor-acessos-page .status-online { color: #166534; background: #dcfce7; border: 1px solid #86efac; }
    .monitor-acessos-page .status-inativo { color: #92400e; background: #fef3c7; border: 1px solid #fcd34d; }
    .monitor-acessos-page .status-offline { color: #991b1b; background: #fee2e2; border: 1px solid #fca5a5; }
    .monitor-acessos-page .status-nunca { color: #374151; background: #f3f4f6; border: 1px solid #d1d5db; }
    .monitor-acessos-page .table-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; overflow: hidden; box-shadow: 0 8px 20px rgba(15, 23, 42, .06); }
    .monitor-acessos-page .table-responsive { overflow-x: auto; }
    .monitor-acessos-page table { width: 100%; border-collapse: collapse; min-width: 1050px; }
    .monitor-acessos-page th { background: #111827; color: #fff; text-align: left; padding: 12px; font-size: 14px; white-space: nowrap; }
    .monitor-acessos-page td { padding: 11px 12px; border-bottom: 1px solid #eef2f7; color: #374151; font-size: 14px; vertical-align: top; }
    .monitor-acessos-page tr:hover td { background: #f9fafb; }
    .monitor-acessos-page .muted { color: #6b7280; font-size: 13px; }
    .monitor-acessos-page .btn-atualizar, .monitor-acessos-page .btn-filtrar { display: inline-block; background: #ff7a00; color: #fff; padding: 10px 14px; border-radius: 8px; font-weight: 700; text-decoration: none; border: 0; cursor: pointer; }
    .monitor-acessos-page .btn-atualizar:hover, .monitor-acessos-page .btn-filtrar:hover { background: #e86f00; color: #fff; }
    .monitor-acessos-page .btn-limpar { display: inline-block; padding: 9px 14px; color: #374151; border: 1px solid #d1d5db; background: white; border-radius: 8px; text-decoration: none; }
    .monitor-acessos-page .filtros-grid { display: grid; grid-template-columns: minmax(200px, 2fr) repeat(4, minmax(125px, 1fr)); gap: 12px; }
    .monitor-acessos-page .filtro-campo label { display: block; font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px; }
    .monitor-acessos-page .filtro-campo input, .monitor-acessos-page .filtro-campo select { width: 100%; min-width: 0; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; background: #fff; color: #1f2937; box-sizing: border-box; }
    .monitor-acessos-page .filtros-acoes { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-top: 14px; }
    .monitor-acessos-page .filtros-botoes { display: flex; gap: 8px; }
    .monitor-acessos-page .resumo-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px; margin-bottom: 18px; }
    .monitor-acessos-page .resumo-card { padding: 17px 18px; border-radius: 12px; border: 1px solid; display: flex; justify-content: space-between; align-items: center; gap: 10px; }
    .monitor-acessos-page .resumo-card .resumo-titulo { font-size: 14px; font-weight: 700; }
    .monitor-acessos-page .resumo-card .resumo-numero { display: block; font-size: 30px; line-height: 1.2; font-weight: 800; margin-top: 3px; }
    .monitor-acessos-page .resumo-card .resumo-icone { font-size: 26px; opacity: .75; }
    .monitor-acessos-page .resumo-online { background: #ecfdf3; border-color: #86efac; color: #166534; }
    .monitor-acessos-page .resumo-inativo { background: #fffbeb; border-color: #fcd34d; color: #92400e; }
    .monitor-acessos-page .resumo-offline { background: #fef2f2; border-color: #fca5a5; color: #991b1b; }
    .monitor-acessos-page .resumo-total { background: #eff6ff; border-color: #bfdbfe; color: #1e40af; }
    @media (max-width: 1100px) { .monitor-acessos-page .filtros-grid, .monitor-acessos-page .resumo-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 600px) { .monitor-acessos-page { padding: 12px; } .monitor-acessos-page .filtros-grid, .monitor-acessos-page .resumo-grid { grid-template-columns: 1fr; } .monitor-acessos-page .resumo-grid { gap: 8px; } .monitor-acessos-page .resumo-card { padding: 12px; } }
</style>

<div class="monitor-acessos-page">
    <div class="page-header">
        <div>
            <h1>Monitor de Acessos</h1>
            <div class="subtitle">Acompanhe usuários online, inativos e últimos acessos ao S.G.A.</div>
        </div>
        <a href="{{ route('usuarios.monitor-acessos', request()->only(['busca', 'empresa_id', 'status', 'tipo', 'periodo'])) }}" class="btn-atualizar">Atualizar</a>
    </div>

    <div class="card-resumo">
        <div class="legenda">
            <span><span class="badge-status status-online">Online</span> atividade nos últimos 5 minutos</span>
            <span><span class="badge-status status-inativo">Inativo</span> atividade entre 5 e 30 minutos</span>
            <span><span class="badge-status status-offline">Offline</span> mais de 30 minutos sem atividade</span>
            <span><span class="badge-status status-nunca">Nunca acessou</span> sem registro de acesso</span>
        </div>
    </div>

    <div class="resumo-grid" aria-label="Resumo geral de acessos">
        <div class="resumo-card resumo-online">
            <div><div class="resumo-titulo">Online</div><span class="resumo-numero">{{ $resumoAcessos['online'] }}</span></div>
            <span class="resumo-icone" aria-hidden="true">●</span>
        </div>
        <div class="resumo-card resumo-inativo">
            <div><div class="resumo-titulo">Inativos</div><span class="resumo-numero">{{ $resumoAcessos['inativo'] }}</span></div>
            <span class="resumo-icone" aria-hidden="true">◷</span>
        </div>
        <div class="resumo-card resumo-offline">
            <div><div class="resumo-titulo">Offline</div><span class="resumo-numero">{{ $resumoAcessos['offline'] }}</span></div>
            <span class="resumo-icone" aria-hidden="true">●</span>
        </div>
        <div class="resumo-card resumo-total">
            <div><div class="resumo-titulo">Total de usuários</div><span class="resumo-numero">{{ $resumoAcessos['total'] }}</span></div>
            <span class="resumo-icone" aria-hidden="true">◎</span>
        </div>
    </div>

    <form class="card-filtros" method="GET" action="{{ route('usuarios.monitor-acessos') }}">
        <div class="filtros-grid">
            <div class="filtro-campo">
                <label for="filtro-busca">Buscar usuário</label>
                <input id="filtro-busca" name="busca" type="search" value="{{ $filtros['busca'] }}" placeholder="Nome, login ou e-mail">
            </div>
            <div class="filtro-campo">
                <label for="filtro-empresa">Empresa</label>
                <select id="filtro-empresa" name="empresa_id">
                    <option value="">Todas as empresas</option>
                    @foreach($empresasFiltro as $empresa)
                        <option value="{{ $empresa->empresa_id }}" @selected($filtros['empresa_id'] === (string) $empresa->empresa_id)>{{ $empresa->empresa ?? 'Empresa ' . $empresa->empresa_id }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filtro-campo">
                <label for="filtro-status">Status</label>
                <select id="filtro-status" name="status">
                    <option value="">Todos os status</option>
                    @foreach(['Online', 'Inativo', 'Offline', 'Nunca acessou'] as $status)
                        <option value="{{ $status }}" @selected($filtros['status'] === $status)>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filtro-campo">
                <label for="filtro-tipo">Tipo de usuário</label>
                <select id="filtro-tipo" name="tipo">
                    <option value="">Todos os tipos</option>
                    @foreach($tiposFiltro as $tipo)
                        <option value="{{ $tipo }}" @selected($filtros['tipo'] === (string) $tipo)>{{ $tipo }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filtro-campo">
                <label for="filtro-periodo">Última atividade</label>
                <select id="filtro-periodo" name="periodo">
                    <option value="">Qualquer período</option>
                    <option value="hoje" @selected($filtros['periodo'] === 'hoje')>Hoje</option>
                    <option value="7" @selected($filtros['periodo'] === '7')>Últimos 7 dias</option>
                    <option value="30" @selected($filtros['periodo'] === '30')>Últimos 30 dias</option>
                    <option value="mais30" @selected($filtros['periodo'] === 'mais30')>Mais de 30 dias</option>
                    <option value="nunca" @selected($filtros['periodo'] === 'nunca')>Sem atividade registrada</option>
                </select>
            </div>
        </div>
        <div class="filtros-acoes">
            <span class="muted">Exibindo {{ $usuarios->count() }} de {{ $totalUsuarios }} usuários</span>
            <div class="filtros-botoes">
                <a class="btn-limpar" href="{{ route('usuarios.monitor-acessos') }}">Limpar filtros</a>
                <button class="btn-filtrar" type="submit">Aplicar filtros</button>
            </div>
        </div>
    </form>

    <div class="table-card">
        <div class="table-responsive">
            <table>
                <thead><tr>
                    <th>Status</th><th>Empresa</th><th>Usuário</th><th>Nome</th><th>Tipo</th><th>Perfil</th><th>Última atividade</th><th>Último login</th><th>IP</th><th>Navegador / Dispositivo</th>
                </tr></thead>
                <tbody>
                    @forelse($usuarios as $usuario)
                        <tr>
                            <td><span class="badge-status {{ $usuario->status_classe }}">{{ $usuario->status_acesso }}</span></td>
                            <td>{{ $usuario->empresa ?? '-' }}<div class="muted">ID empresa: {{ $usuario->empresa_id ?? '-' }}</div></td>
                            <td>{{ $usuario->usuario }}</td>
                            <td>{{ $usuario->nome_completo }}<div class="muted">{{ $usuario->email }}</div></td>
                            <td>{{ $usuario->tipo }}</td>
                            <td>{{ $usuario->perfil ?? '-' }}</td>
                            <td>{{ $usuario->ultima_atividade_formatada }}</td>
                            <td>{{ $usuario->last_login_at ? $usuario->last_login_at->copy()->timezone('America/Sao_Paulo')->format('d/m/Y H:i:s') : '-' }}</td>
                            <td>{{ $usuario->last_login_ip ?? '-' }}</td>
                            <td><span class="muted">{{ $usuario->last_user_agent ? \Illuminate\Support\Str::limit($usuario->last_user_agent, 90) : '-' }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="10">Nenhum usuário encontrado com os filtros selecionados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
