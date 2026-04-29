@extends('layouts.app')

@section('title', 'Relatório de Caixa')

@section('content')
<div class="container-fluid py-4">
    <!-- Cabeçalho -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-0">📊 Relatório de Caixa</h2>
                            <p class="text-muted mb-0">
                                Período: {{ \Carbon\Carbon::parse($periodo['data_inicio'])->format('d/m/Y') }} 
                                até {{ \Carbon\Carbon::parse($periodo['data_fim'])->format('d/m/Y') }}
                            </p>
                        </div>
                        <div>
                            <a href="{{ route('rel-caixa.exportar', request()->all()) }}" 
                               class="btn btn-success">
                                <i class="fas fa-file-excel"></i> Exportar CSV
                            </a>
                            <a href="{{ route('rel-caixa.imprimir', request()->all()) }}" 
                               target="_blank" 
                               class="btn btn-primary">
                                <i class="fas fa-print"></i> Imprimir
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('rel-caixa.index') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="data_inicio" class="form-label">Data Início</label>
                                <input type="date" 
                                       class="form-control" 
                                       id="data_inicio" 
                                       name="data_inicio" 
                                       value="{{ request('data_inicio', $periodo['data_inicio']) }}">
                            </div>
                            <div class="col-md-4">
                                <label for="data_fim" class="form-label">Data Fim</label>
                                <input type="date" 
                                       class="form-control" 
                                       id="data_fim" 
                                       name="data_fim" 
                                       value="{{ request('data_fim', $periodo['data_fim']) }}">
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i> Filtrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards de Totalizadores -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-success shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-success mb-2">💰 Total Receitas</h6>
                    <h3 class="mb-0">{{ $totais_formatados['total_receitas'] }}</h3>
                    <small class="text-muted">{{ $totais_formatados['quantidade_entradas'] }} entradas</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-danger shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-danger mb-2">💸 Total Despesas</h6>
                    <h3 class="mb-0">{{ $totais_formatados['total_despesas'] }}</h3>
                    <small class="text-muted">{{ $totais_formatados['quantidade_saidas'] }} saídas</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-primary shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-primary mb-2">📊 Saldo do Período</h6>
                    <h3 class="mb-0 {{ $totais['saldo_periodo'] >= 0 ? 'text-success' : 'text-danger' }}">
                        {{ $totais_formatados['saldo_periodo'] }}
                    </h3>
                    <small class="text-muted">{{ $totais_formatados['total_transacoes'] }} transações</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-info shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-info mb-2">📈 Resultado</h6>
                    <h3 class="mb-0">
                        @if($totais['saldo_periodo'] >= 0)
                            <span class="text-success">✅ Positivo</span>
                        @else
                            <span class="text-danger">❌ Negativo</span>
                        @endif
                    </h3>
                    <small class="text-muted">
                        {{ number_format(($totais['total_receitas'] > 0 ? ($totais['saldo_periodo'] / $totais['total_receitas']) * 100 : 0), 1) }}% líquido
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela de Movimentações -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">📋 Movimentações Detalhadas</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0" id="tabelaRelatorio">
                            <thead class="table-light">
                                <tr>
                                    <th>Data</th>
                                    <th>Hora</th>
                                    <th>Tipo</th>
                                    <th>Forma Pagamento</th>
                                    <th class="text-end">Valor</th>
                                    <th>Origem</th>
                                    <th>Descrição</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($movimentacoes as $mov)
                                <tr class="{{ $mov->tipo == 'entrada' ? 'table-success' : 'table-danger' }}">
                                    <td>{{ $mov->data }}</td>
                                    <td>{{ $mov->hora }}</td>
                                    <td>
                                        <span class="badge {{ $mov->tipo == 'entrada' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $mov->tipo_formatado }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $mov->forma_pagamento }}</span>
                                    </td>
                                    <td class="text-end fw-bold">{{ $mov->valor_formatado }}</td>
                                    <td>{{ $mov->origem }}</td>
                                    <td>{{ $mov->descricao }}</td>
                                    <td class="text-center">{{ $mov->status }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                        Nenhuma movimentação encontrada para o período selecionado.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .table tbody tr.table-success {
        background-color: #d4edda !important;
    }
    .table tbody tr.table-danger {
        background-color: #f8d7da !important;
    }
    .card {
        border-radius: 10px;
    }
    .table-responsive {
        max-height: 600px;
        overflow-y: auto;
    }
</style>
@endpush

@push('scripts')
<script>
    // DataTables (opcional)
    $(document).ready(function() {
        $('#tabelaRelatorio').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json'
            },
            order: [[0, 'desc']],
            pageLength: 50
        });
    });
</script>
@endpush
@endsection
