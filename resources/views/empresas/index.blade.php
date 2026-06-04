@extends('layouts.app')

@section('title', 'Empresas')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/empresas.css') }}">
@endsection

@section('content')

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
            <strong>{{ $empresas->total() }}</strong>
        </div>

        <div class="card-resumo ativo">
            <span>Ativas</span>
            <strong>{{ $empresas->where('status', 'ativo')->count() }}</strong>
        </div>

        <div class="card-resumo teste">
            <span>Em Teste</span>
            <strong>{{ $empresas->where('status', 'teste')->count() }}</strong>
        </div>

        <div class="card-resumo bloqueado">
            <span>Bloqueadas</span>
            <strong>{{ $empresas->where('status', 'bloqueado')->count() }}</strong>
        </div>
    </div>

    <div class="empresas-card">

        <div class="table-responsive">
            <table class="empresas-table">
                <thead>
                    <tr>
                        <th>ID</th>
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
                            <td colspan="8" class="sem-registros">
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