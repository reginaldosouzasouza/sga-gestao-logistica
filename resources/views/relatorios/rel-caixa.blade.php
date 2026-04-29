@extends('layouts.app')

@section('title', 'Consulta Diário do Caixa')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('css/relatorio-caixa.css') }}">


@section('content')
<div class="container-fluid py-4 relatorio-caixa">

    {{-- CABEÇALHO --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 relatorio-titulo">Consulta Diário do Caixa</h2>
        <a href="{{ route('rel-caixa.exportar', request()->all()) }}" 
           class="btn btn-success shadow-sm">
            Exportar Excel
        </a>
    </div>

    {{-- FILTRO --}}
    <div class="card shadow-sm mb-4 filtro-card">
        <div class="card-body">
            <form method="GET" action="{{ route('rel-caixa.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-xl-2 col-lg-4 col-md-4 col-6">
                        <label class="form-label fw-semibold">Data Início</label>
                        <input type="date" class="form-control" name="data_inicio"
                               value="{{ $periodo['data_inicio'] }}">
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-6">
                        <label class="form-label fw-semibold">Data Fim</label>
                        <input type="date" class="form-control" name="data_fim"
                               value="{{ $periodo['data_fim'] }}">
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-6">
                        <button type="submit" class="btn btn-primary w-100 shadow-sm">
                            Filtrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

        
        {{-- ================= RESUMO FINANCEIRO ================= --}}

        @php
            $saldoCaixa = $totais['entradas_caixa'] - $totais['saidas_caixa'];
            $percentualCaixa = $totais['entradas_caixa'] > 0 
                ? ($saldoCaixa / $totais['entradas_caixa']) * 100 
                : 0;

            $saldoBanco = $totais['entradas_banco'] - $totais['saidas_banco'];
            $percentualBanco = $totais['entradas_banco'] > 0 
                ? ($saldoBanco / $totais['entradas_banco']) * 100 
                : 0;

            $saldoGeral = $totais['saldo_geral'];
        @endphp


        {{-- LINHA 1 --}}
        <div class="row g-4 mb-4">

            <div class="col-lg-4 col-md-6">
                <div class="card resumo-card bg-entrada-caixa">
                    <div class="resumo-titulo">ENTRADAS CAIXA</div>
                    <div class="resumo-valor">
                        R$ {{ number_format($totais['entradas_caixa'], 2, ',', '.') }}
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card resumo-card bg-saida-caixa">
                    <div class="resumo-titulo">SAÍDAS CAIXA</div>
                    <div class="resumo-valor">
                        R$ {{ number_format($totais['saidas_caixa'], 2, ',', '.') }}
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="card resumo-card saldo-dinamico {{ $saldoCaixa >= 0 ? 'positivo' : 'negativo' }}">
                    <div class="resumo-titulo">
                        SALDO - CAIXA
                    </div>

                    <div class="resumo-valor">
                        {{ $saldoCaixa >= 0 ? '↑' : '↓' }}
                        R$ {{ number_format($saldoCaixa, 2, ',', '.') }}
                    </div>

                    <div class="percentual">
                        {{ number_format($percentualCaixa, 1, ',', '.') }}%
                    </div>
                </div>
            </div>

        </div>


        {{-- LINHA 2 --}}
        <div class="row g-4 mb-4">

            <div class="col-lg-4 col-md-6">
                <div class="card resumo-card bg-entrada-banco">
                    <div class="resumo-titulo">ENTRADAS BANCO</div>
                    <div class="resumo-valor">
                        R$ {{ number_format($totais['entradas_banco'], 2, ',', '.') }}
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card resumo-card bg-saida-banco">
                    <div class="resumo-titulo">SAÍDAS BANCO</div>
                    <div class="resumo-valor">
                        R$ {{ number_format($totais['saidas_banco'], 2, ',', '.') }}
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="card resumo-card saldo-dinamico {{ $saldoBanco >= 0 ? 'positivo' : 'negativo' }}">
                    <div class="resumo-titulo">
                        SALDO -  BANCO
                    </div>

                    <div class="resumo-valor">
                        {{ $saldoBanco >= 0 ? '↑' : '↓' }}
                        R$ {{ number_format($saldoBanco, 2, ',', '.') }}
                    </div>

                    <div class="percentual">
                        {{ number_format($percentualBanco, 1, ',', '.') }}%
                    </div>
                </div>
            </div>

        </div>


        {{-- SALDO GERAL --}}
        <div class="row justify-content-center mb-5">
            <div class="col-lg-6 col-md-8">
                <div class="card resumo-card saldo-geral-dinamico {{ $saldoGeral >= 0 ? 'positivo' : 'negativo' }}">
                    <div class="resumo-titulo">SALDO GERAL</div>

                    <div class="resumo-valor super-grande">
                        {{ $saldoGeral >= 0 ? '↑' : '↓' }}
                        R$ {{ number_format($saldoGeral, 2, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>

      


    {{-- TABELA --}}
    <div class="card shadow-sm">
       <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                Lançamentos Detalhados —
                {{ \Carbon\Carbon::parse($periodo['data_inicio'])->format('d/m/Y') }}
                até
                {{ \Carbon\Carbon::parse($periodo['data_fim'])->format('d/m/Y') }}
            </h5>
            <span class="badge bg-secondary">
                {{ count($lancamentos) }} registros
            </span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 table-relatorio">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Hora</th>
                            <th>Tipo</th>
                            <th>Forma</th>
                            <th class="text-end">Valor</th>
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
                                    <span class="badge badge-entrada">Entrada</span>
                                @else
                                    <span class="badge badge-saida">Saída</span>
                                @endif
                            </td>

                            <td>
                                @if($lan['forma'] === 'Dinheiro')
                                    <span class="badge badge-dinheiro">Dinheiro</span>
                                @else
                                    <span class="badge badge-pix">PIX/Banco</span>
                                @endif
                            </td>

                            <td class="text-end fw-bold {{ $lan['tipo'] === 'entrada' ? 'text-success' : 'text-danger' }}">
                                R$ {{ number_format($lan['valor'], 2, ',', '.') }}
                            </td>

                            <td>
                                <small class="text-muted">
                                    {{ $lan['origem'] }}
                                </small>
                            </td>

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
                    <tfoot class="tfoot-total">
                        <tr>
                            <td colspan="4">TOTAL DO PERÍODO</td>
                            <td class="text-end">
                                <div class="text-success">
                                    ▲ R$ {{ number_format($totais['total_entradas'], 2, ',', '.') }}
                                </div>
                                <div class="text-danger">
                                    ▼ R$ {{ number_format($totais['total_saidas'], 2, ',', '.') }}
                                </div>
                                <div>
                                    = R$ {{ number_format($totais['saldo_geral'], 2, ',', '.') }}
                                </div>
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