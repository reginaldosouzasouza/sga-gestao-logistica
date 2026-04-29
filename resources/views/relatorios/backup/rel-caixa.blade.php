@extends('layouts.app')

@section('title', 'Relatório de Caixa')

@section('content')
<div class="container-fluid py-4">

    {{-- CABEÇALHO --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">📊 Relatório de Caixa</h2>
        <a href="{{ route('rel-caixa.exportar', request()->all()) }}" class="btn btn-success">
            📥 Exportar Excel
        </a>
    </div>

    {{-- FILTRO --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('rel-caixa.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Data Início</label>
                        <input type="date" class="form-control" name="data_inicio"
                               value="{{ $periodo['data_inicio'] }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Data Fim</label>
                        <input type="date" class="form-control" name="data_fim"
                               value="{{ $periodo['data_fim'] }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">🔍 Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- CARDS TOTALIZADORES --}}
    <div class="row mb-4 g-3">
        <div class="col-md-2">
            <div class="card border-0 shadow-sm text-center h-100" style="background:#1565c0; color:white;">
                <div class="card-body py-3">
                    <div style="font-size:12px;">💵 Entradas Caixa</div>
                    <div style="font-size:18px; font-weight:bold;">R$ {{ number_format($totais['entradas_caixa'], 2, ',', '.') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm text-center h-100" style="background:#b71c1c; color:white;">
                <div class="card-body py-3">
                    <div style="font-size:12px;">💸 Saídas Caixa</div>
                    <div style="font-size:18px; font-weight:bold;">R$ {{ number_format($totais['saidas_caixa'], 2, ',', '.') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm text-center h-100" style="background:#1b5e20; color:white;">
                <div class="card-body py-3">
                    <div style="font-size:12px;">🏦 Entradas Banco</div>
                    <div style="font-size:18px; font-weight:bold;">R$ {{ number_format($totais['entradas_banco'], 2, ',', '.') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm text-center h-100" style="background:#e65100; color:white;">
                <div class="card-body py-3">
                    <div style="font-size:12px;">🏦 Saídas Banco</div>
                    <div style="font-size:18px; font-weight:bold;">R$ {{ number_format($totais['saidas_banco'], 2, ',', '.') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm text-center h-100" style="background:#4a148c; color:white;">
                <div class="card-body py-3">
                    <div style="font-size:12px;">🟣 Saldo Geral</div>
                    <div style="font-size:18px; font-weight:bold;">R$ {{ number_format($totais['saldo_geral'], 2, ',', '.') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm text-center h-100" style="background:#37474f; color:white;">
                <div class="card-body py-3">
                    <div style="font-size:12px;">📋 Total Lançamentos</div>
                    <div style="font-size:18px; font-weight:bold;">{{ count($lancamentos) }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABELA DE LANÇAMENTOS --}}
    <div class="card shadow-sm">
        <div class="card-header text-white d-flex justify-content-between align-items-center" style="background:#37474f;">
            <h5 class="mb-0">📋 Lançamentos Detalhados —
                {{ \Carbon\Carbon::parse($periodo['data_inicio'])->format('d/m/Y') }}
                até
                {{ \Carbon\Carbon::parse($periodo['data_fim'])->format('d/m/Y') }}
            </h5>
            <span class="badge bg-light text-dark">{{ count($lancamentos) }} registros</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead style="background:#eceff1; position:sticky; top:0;">
                        <tr>
                            <th>📅 Data</th>
                            <th>🕐 Hora</th>
                            <th>Tipo</th>
                            <th>Forma</th>
                            <th class="text-end">💰 Valor</th>
                            <th>Origem</th>
                            <th>Descrição</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lancamentos as $lan)
                        <tr>
                            <td>{{ $lan['data'] }}</td>
                            <td>{{ $lan['hora'] }}</td>
                            <td>
                                @if($lan['tipo'] === 'entrada')
                                    <span class="badge" style="background:#1b5e20;">⬆ Entrada</span>
                                @else
                                    <span class="badge" style="background:#b71c1c;">⬇ Saída</span>
                                @endif
                            </td>
                            <td>
                                @if($lan['forma'] === 'Dinheiro')
                                    <span class="badge" style="background:#1565c0;">💵 Dinheiro</span>
                                @else
                                    <span class="badge" style="background:#2e7d32;">🏦 PIX/Banco</span>
                                @endif
                            </td>
                            <td class="text-end fw-bold {{ $lan['tipo'] === 'entrada' ? 'text-success' : 'text-danger' }}">
                                R$ {{ number_format($lan['valor'], 2, ',', '.') }}
                            </td>
                            <td><small class="text-muted">{{ $lan['origem'] }}</small></td>
                            <td>{{ $lan['descricao'] }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                Nenhum lançamento encontrado no período.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if(count($lancamentos) > 0)
                    <tfoot style="background:#37474f; color:white; font-weight:bold;">
                        <tr>
                            <td colspan="4">TOTAL DO PERÍODO</td>
                            <td class="text-end">
                                <div style="color:#a5d6a7;">▲ R$ {{ number_format($totais['total_entradas'], 2, ',', '.') }}</div>
                                <div style="color:#ef9a9a;">▼ R$ {{ number_format($totais['total_saidas'], 2, ',', '.') }}</div>
                                <div>= R$ {{ number_format($totais['saldo_geral'], 2, ',', '.') }}</div>
                            </td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
