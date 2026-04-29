@extends('layouts.app')

@section('title', 'Relatório Gerencial — Emissões x Margem x Custos')

@section('content')

<style>
    /* FORÇAR GRID DE 3 COLUNAS (Caso o Bootstrap não carregue) */
    .grid-cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* 3 colunas iguais */
        gap: 20px; /* Espaçamento entre os cards */
        margin-bottom: 30px;
    }

    /* Ajuste para Celular (Ficar 1 card por linha em telas pequenas) */
    @media (max-width: 768px) {
        .grid-cards {
            grid-template-columns: 1fr;
        }
    }

    .card-resumo {
        border-radius: 12px;
        padding: 20px;
        color: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        min-height: 120px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        transition: transform 0.2s;
    }

    .card-resumo:hover {
        transform: translateY(-3px);
    }

    .card-resumo .label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 5px;
        opacity: 0.9;
    }

    .card-resumo .valor {
        font-size: 22px;
        font-weight: 800;
        margin: 5px 0;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .card-resumo .sub {
        font-size: 10px;
        opacity: 0.8;
        margin-top: 3px;
    }

    /* Cores Customizadas */
    .bg-info-custom    { background-color: #42a5f5; }
    .bg-warning-custom { background-color: #ffb74d; }
    .bg-success-custom { background-color: #66bb6a; }
    .bg-purple-custom  { background-color: #ab47bc; }
    .bg-danger-custom  { background-color: #ef5350; }

    /* Estilo do Filtro */
    .filtro-card {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 25px;
        border: 1px solid #e9ecef;
    }
</style>

<div class="container-fluid px-4 py-4" style="max-width:1350px;">

    <h2 class="fw-bold mb-1">📊 Relatório Gerencial</h2>
    <p class="text-muted mb-4">Emissões do dia × Margem de Lucro × Custos Pagos — saiba se cada dia foi produtivo.</p>

    {{-- ─── FILTROS ─── --}}
    <div class="filtro-card">
        <form method="GET" action="{{ route('relatorio.gerencial.margem') }}">
            <div class="row g-3 align-items-end" style="display: flex; flex-wrap: wrap; gap: 15px;">
                <div style="flex: 1; min-width: 200px;">
                    <label class="form-label fw-bold small">Data Início</label>
                    <input type="date" name="data_inicio" class="form-control" value="{{ $dataInicio }}">
                </div>
                <div style="flex: 1; min-width: 200px;">
                    <label class="form-label fw-bold small">Data Fim</label>
                    <input type="date" name="data_fim" class="form-control" value="{{ $dataFim }}">
                </div>
             
                <div style="flex: 1; min-width: 200px; display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-primary" style="flex:1">🔍 Filtrar</button>
                    <a href="{{ route('relatorio.gerencial.margem') }}" class="btn btn-secondary" style="flex:1; text-align:center; text-decoration:none; line-height: 2.2;">Limpar</a>
                </div>
            </div>
        </form>
    </div>

    {{-- ─── GRID DE CARDS (2 Linhas x 3 Colunas) ─── --}}
    <div class="grid-cards">
        <!-- Linha 1 -->
        <div class="card-resumo bg-info-custom">
            <div class="label">Total Emitido</div>
            <div class="valor">R$ {{ number_format($totalEmitido, 2, ',', '.') }}</div>
            <div class="sub">Pedidos de coleta gerados</div>
        </div>

        <div class="card-resumo bg-warning-custom">
            <div class="label">Custo dos Produtos</div>
            <div class="valor">R$ {{ number_format($totalCustosProd, 2, ',', '.') }}</div>
            <div class="sub">Preço de compra × qtd vendida</div>
        </div>

        <div class="card-resumo bg-success-custom">
            <div class="label">Margem Bruta</div>
            <div class="valor"><span>↑</span> R$ {{ number_format($totalMargemBruta, 2, ',', '.') }}</div>
            <div class="sub">Emitido − Custo produtos</div>
        </div>

        <!-- Linha 2 -->
        <div class="card-resumo bg-purple-custom">
            <div class="label">Margem %</div>
            <div class="valor">{{ number_format($margemGeralPerc, 2, ',', '.') }}%</div>
            <div class="sub">Sobre o total emitido</div>
        </div>

        <div class="card-resumo bg-danger-custom">
            <div class="label">Despesas Pagas</div>
            <div class="valor">R$ {{ number_format($totalCustosPagos, 2, ',', '.') }}</div>
            <div class="sub">Compras pagas no período</div>
        </div>

        <div class="card-resumo {{ $totalLucroReal >= 0 ? 'bg-success-custom' : 'bg-danger-custom' }}">
            <div class="label">Lucro Real</div>
            <div class="valor">
                <span>{{ $totalLucroReal >= 0 ? '↑' : '↓' }}</span> 
                R$ {{ number_format($totalLucroReal, 2, ',', '.') }}
            </div>
            <div class="sub">Emitido − Custos pagos</div>
        </div>
    </div>

    {{-- ─── TABELA DE RESULTADOS ─── --}}
    <div style="border-radius:10px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.08); border: 1px solid #ddd;">
        <table class="table table-bordered mb-0 bg-white" style="width: 100%; border-collapse: collapse;">
            <thead style="background: #f1f1f1;">
                <tr>
                    <th style="padding: 12px;">Data</th>
                    <th style="padding: 12px; text-align: center;">Pedidos</th>
                    <th style="padding: 12px; text-align: right;">Total Emitido</th>
                    <th style="padding: 12px; text-align: right;">Margem Bruta</th>
                    <th style="padding: 12px; text-align: right;">Lucro Real</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resultadoDiario as $dia)
                    <tr>
                        <td style="padding: 10px;">{{ \Carbon\Carbon::parse($dia->data)->format('d/m/Y') }}</td>
                        <td style="padding: 10px; text-align: center;">{{ $dia->total_pedidos }}</td>
                        <td style="padding: 10px; text-align: right;">R$ {{ number_format($dia->total_emitido, 2, ',', '.') }}</td>
                        <td style="padding: 10px; text-align: right; color: green;">R$ {{ number_format($dia->margem_bruta, 2, ',', '.') }}</td>
                        <td style="padding: 10px; text-align: right; font-weight: bold;">R$ {{ number_format($dia->lucro_real, 2, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align: center; padding: 20px;">Nenhum dado encontrado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection