@extends('layouts.app')

@section('title', 'Empresas')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/empresas.css') }}">
@endsection

@section('content')

<style>
    .filtros-empresas {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr auto;
        gap: 14px;
        align-items: end;
        background: #ffffff;
        border-radius: 14px;
        padding: 18px 22px;
        margin: 20px 0;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.08);
    }

    .campo-filtro {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .campo-filtro label {
        font-size: 13px;
        font-weight: 700;
        color: #475569;
    }

    .campo-filtro input,
    .campo-filtro select {
        height: 40px;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        padding: 0 12px;
        font-size: 14px;
        background: #ffffff;
    }

    .acoes-filtro {
        display: flex;
        gap: 8px;
    }

    .btn-filtrar,
    .btn-limpar-filtro {
        height: 40px;
        border-radius: 9px;
        border: none;
        padding: 0 15px;
        font-weight: 700;
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

    .badge-modulo {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .badge-gas {
        background: #fff3cd;
        color: #856404;
    }

    .badge-oficina {
        background: #7f7d7b59;
        color: #0f0f0f;
    }

    .badge-salao {
        background: #fce7f3;
        color: #9d174d;
    }

    .badge-financas {
        background: #dff7f4;
        color: #0f766e;
    }

    @media (max-width: 1000px) {
        .filtros-empresas {
            grid-template-columns: 1fr 1fr;
        }

        .campo-busca {
            grid-column: 1 / -1;
        }

        .acoes-filtro {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 640px) {
        .filtros-empresas {
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

<div class="empresas-page">

    <div class="empresas-header">
        <div>
            <h2>Cadastro de Empresas</h2>
            <p>Gerencie as empresas cadastradas no S.G.A SaaS.</p>
        </div>

        <a href="{{ route('empresas.create') }}" class="btn-nova-empresa">
            + Nova Empresa
        </a>
    </div>

    @if(session('success'))
        <div class="alerta sucesso">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alerta erro">
            {{ session('error') }}
        </div>
    @endif

    <div class="resumo-empresas">
        <div class="card-resumo">
            <span>Total</span>
            <strong>{{ $resumo['total'] }}</strong>
        </div>

        <div class="card-resumo ativo">
            <span>Ativas</span>
            <strong>{{ $resumo['ativas'] }}</strong>
        </div>

        <div class="card-resumo teste">
            <span>Em Teste</span>
            <strong>{{ $empresas->where('status', 'teste')->count() }}</strong>
        </div>

        <div class="card-resumo bloqueado">
            <span>Bloqueadas</span>
            <strong>{{ $resumo['bloqueadas'] }}</strong>
        </div>
    </div>

    <form method="GET" action="{{ route('empresas.index') }}" class="filtros-empresas">
        <div class="campo-filtro campo-busca">
            <label>Buscar empresa</label>
            <input 
                type="text" 
                name="busca" 
                value="{{ request('busca') }}"
                placeholder="Nome, razão social, CNPJ, cidade ou e-mail..."
            >
        </div>

        <div class="campo-filtro">
            <label>Módulo</label>
            <select name="modulo">
                <option value="">Todos</option>
                <option value="gas" {{ request('modulo') === 'gas' ? 'selected' : '' }}>Revenda de Gás</option>
                <option value="oficina" {{ request('modulo') === 'oficina' ? 'selected' : '' }}>Oficina</option>
                <option value="salao" {{ request('modulo') === 'salao' ? 'selected' : '' }}>Salão / Barbearia</option>
                <option value="financas" {{ request('modulo') === 'financas' ? 'selected' : '' }}>SGA Finanças</option>
            </select>
        </div>

        <div class="campo-filtro">
            <label>Status</label>
            <select name="status">
                <option value="">Todos</option>
                <option value="ativo" {{ request('status') === 'ativo' ? 'selected' : '' }}>Ativo</option>
                <option value="teste" {{ request('status') === 'teste' ? 'selected' : '' }}>Teste</option>
                <option value="bloqueado" {{ request('status') === 'bloqueado' ? 'selected' : '' }}>Bloqueado</option>
                <option value="inativo" {{ request('status') === 'inativo' ? 'selected' : '' }}>Inativo</option>
            </select>
        </div>

        <div class="campo-filtro">
            <label>Plano</label>
            <select name="plano">
                <option value="">Todos</option>
                <option value="teste" {{ request('plano') === 'teste' ? 'selected' : '' }}>Teste</option>
                <option value="basico" {{ request('plano') === 'basico' ? 'selected' : '' }}>Básico</option>
                <option value="completo" {{ request('plano') === 'completo' ? 'selected' : '' }}>Completo</option>
            </select>
        </div>

        <div class="acoes-filtro">
            <button type="submit" class="btn-filtrar">
                Buscar
            </button>

            <a href="{{ route('empresas.index') }}" class="btn-limpar-filtro">
                Limpar
            </a>
        </div>
    </form>



    <div class="empresas-card">

        <div class="table-responsive">
            <table class="empresas-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Módulo</th>
                        <th>Empresa</th>                      
                        <th>CNPJ</th>
                        <th>Cidade/UF</th>
                        <th>Status</th>
                        <th>Plano</th>
                        <th>Vencimento</th>
                        <th class="acoes-coluna">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($empresas as $empresa)
                        <tr>
                            <td class="empresa-id">
                                {{ $empresa->id }}
                            </td>

                            <td>
                                @if($empresa->modulo === 'gas')
                                    <span class="badge-modulo badge-gas">Gás</span>
                                @elseif($empresa->modulo === 'oficina')
                                    <span class="badge-modulo badge-oficina">Oficina</span>
                                @elseif($empresa->modulo === 'salao')
                                    <span class="badge-modulo badge-salao">Salão</span>
                                @elseif($empresa->modulo === 'financas')
                                    <span class="badge-modulo badge-financas">Finanças</span>
                                @else
                                    <span class="badge-modulo">-</span>
                                @endif
                            </td>



                            <td class="empresa-nome">
                                <strong>{{ $empresa->nome_fantasia }}</strong>
                                <small>{{ $empresa->razao_social ?? 'Sem razão social informada' }}</small>
                            </td>

                            <td>
                                {{ $empresa->cnpj ?? '-' }}
                            </td>

                            <td>
                                {{ $empresa->cidade ?? '-' }}
                                @if($empresa->estado)
                                    / {{ $empresa->estado }}
                                @endif
                            </td>

                            <td>
                                @if($empresa->status === 'ativo')
                                    <span class="badge-status badge-ativo">Ativo</span>
                                @elseif($empresa->status === 'teste')
                                    <span class="badge-status badge-teste">Teste</span>
                                @elseif($empresa->status === 'bloqueado')
                                    <span class="badge-status badge-bloqueado">Bloqueado</span>
                                @else
                                    <span class="badge-status badge-inativo">Inativo</span>
                                @endif
                            </td>

                            <td>
                                <span class="badge-plano">
                                    {{ $empresa->plano ?? '-' }}
                                </span>
                            </td>

                            <td>
                                {{ $empresa->data_vencimento ? \Carbon\Carbon::parse($empresa->data_vencimento)->format('d/m/Y') : '-' }}
                            </td>

                            <td class="acoes">
                                <a href="{{ route('empresas.show', $empresa->id) }}" class="btn-acao btn-ver">
                                    Ver
                                </a>

                                <a href="{{ route('empresas.edit', $empresa->id) }}" class="btn-acao btn-editar">
                                    Editar
                                </a>

                                @if($empresa->id != 1)
                                    <form action="{{ route('empresas.destroy', $empresa->id) }}"
                                          method="POST"
                                          class="form-excluir"
                                          onsubmit="return confirm('Deseja realmente excluir esta empresa?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn-acao btn-excluir">
                                            Excluir
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="sem-registros">
                                Nenhuma empresa cadastrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="paginacao">
            {{ $empresas->links() }}
        </div>

    </div>

</div>

@endsection