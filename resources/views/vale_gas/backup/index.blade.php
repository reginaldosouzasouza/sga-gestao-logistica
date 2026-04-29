@extends('layouts.app')

@section('content')

<style>
    body {
        background-color: #fffefe;
    }

    .vale-gas-page .titulo-pagina {
        font-weight: 700;
        color: #1f2937;
    }

    .vale-gas-page .card {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .vale-gas-page .card-header {
        background-color: #f8fafc;
        font-weight: 600;
        border-bottom: 1px solid #e5e7eb;
    }

    .vale-gas-page .table {
        margin-bottom: 0;
    }

    .vale-gas-page .table thead th {
        background-color: #f8fafc;
        vertical-align: middle;
        font-size: 14px;
    }

   
    .vale-gas-page .table td,
    .vale-gas-page .table th {
        vertical-align: middle;
        padding: 12px 10px;
    }

    .badge-status {
        display: inline-block;
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 999px;
        font-weight: 600;
    }

    .badge-aberto {
        background-color: #198754;
        color: #fff;
    }

    .badge-cancelado {
        background-color: #dc3545;
        color: #fff;
    }

    .btn-acoes {
        min-width: 72px;
    }

    .vale-gas-page .acoes-wrap {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
        flex-wrap: nowrap;
    }

    .vale-gas-page .filtros label {
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 6px;
    }
 
    /* HOVER NA TABELA */
    .vale-gas-page .table tbody tr {
        transition: all 0.2s ease;
    }

    .vale-gas-page .table tbody tr:hover {
        background-color: #a1c0fa;
        cursor: pointer;
    }
    


   
</style>

<div class="container mt-4 vale-gas-page">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0 titulo-pagina">Vale Gás</h3>
        <a href="{{ route('vale-gas.create') }}" class="btn btn-success">
            Novo Vale
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            Filtros
        </div>
        <div class="card-body filtros">
            <form method="GET" action="{{ route('vale-gas.index') }}">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="cliente" class="form-label">Cliente</label>
                        <input type="text" name="cliente" id="cliente" class="form-control" value="{{ request('cliente') }}">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">Todos</option>
                            <option value="ABERTO" {{ request('status') == 'ABERTO' ? 'selected' : '' }}>ABERTO</option>
                            <option value="CANCELADO" {{ request('status') == 'CANCELADO' ? 'selected' : '' }}>CANCELADO</option>
                        </select>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="data_inicio" class="form-label">Data Inicial</label>
                        <input type="date" name="data_inicio" id="data_inicio" class="form-control" value="{{ request('data_inicio') }}">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="data_fim" class="form-label">Data Final</label>
                        <input type="date" name="data_fim" id="data_fim" class="form-control" value="{{ request('data_fim') }}">
                    </div>

                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">Filtrar</button>
                        <a href="{{ route('vale-gas.index') }}" class="btn btn-secondary">Limpar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Listagem de Vales
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Data</th>
                            <th>Cliente</th>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Valor Pago</th>
                            <th>Status</th>
                            <th>Usuário</th>
                            <th class="text-center" style="min-width: 260px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vales as $vale)
                            <tr>
                                <td>{{ $vale->codigo }}</td>
                                <td>{{ $vale->data_vale->format('d/m/Y') }}</td>
                                <td>{{ $vale->cliente->nome ?? '' }}</td>
                                <td>{{ $vale->produto->nome ?? '' }}</td>
                                <td>{{ number_format($vale->quantidade, 2, ',', '.') }}</td>
                                <td>R$ {{ number_format($vale->valor_pago, 2, ',', '.') }}</td>
                                <td>
                                    @if($vale->status === 'ABERTO')
                                        <span class="badge-status badge-aberto">ABERTO</span>
                                    @else
                                        <span class="badge-status badge-cancelado">CANCELADO</span>
                                    @endif
                                </td>
                                <td>{{ $vale->usuarioCadastro->nome_completo ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="acoes-wrap">
                                        <a href="{{ route('vale-gas.show', $vale->id) }}" class="btn btn-sm btn-info btn-acoes">
                                            Ver
                                        </a>

                                        @if($vale->status === 'ABERTO')
                                            <a href="{{ route('vale-gas.edit', $vale->id) }}" class="btn btn-sm btn-primary btn-acoes">
                                                Editar
                                            </a>

                                            <form action="{{ route('vale-gas.cancelar', $vale->id) }}" method="POST" class="m-0 p-0"
                                                onsubmit="return confirm('Deseja realmente cancelar este vale?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger btn-acoes">
                                                    Cancelar
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Nenhum vale encontrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $vales->links() }}
            </div>
        </div>
    </div>
</div>

@endsection