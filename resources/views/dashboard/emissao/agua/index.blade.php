@extends('layouts.app')

@section('title', 'Dashboard emissao ÁGUA')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard/emissao.css') }}">

<!-- Tooltip flutuante Meta Cumulativa -->
<div id="legend-tooltip" style="
    display: none;
    position: fixed;
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 13px;
    max-width: 300px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    pointer-events: none;
    z-index: 9999;
    color: #333;
    line-height: 1.7;
">
    📌 <strong>Meta Cumulativa</strong><br>
    Cálculo: sistema busca a <strong>meta do mês ÷ 30</strong>,<br>
    multiplicado pela <strong>quantidade de dias</strong>.<br>
    
</div>

<div class="dashboard-wrap">
    <h1 class="dashboard-title">
        {{ $titulo }} - {{ $subtipo }}
        <span class="dashboard-date">• {{ now()->format('d/m/Y') }}</span>
    </h1>

    <div class="kpi-grid">
        <div class="kpi-card card-blue">
            <div class="kpi-label">Emissões hoje (parcial)</div>
            <div class="kpi-value">{{ number_format($emissoesHoje, 0, ',', '.') }}</div>
        </div>

        <div class="kpi-card">
            <div class="kpi-label">Emissões ontem</div>
            <div class="kpi-value">{{ number_format($emissoesOntem, 0, ',', '.') }}</div>
        </div>

        <div class="kpi-card card-soft">
            <div class="kpi-label">Média por dia</div>
            <div class="kpi-value">{{ number_format($mediaDia, 1, ',', '.') }}</div>
            <div class="kpi-sub">Base nos dias fechados</div>
        </div>

        <div class="kpi-card">
            <div class="kpi-label">Acumulado até ontem</div>
            <div class="kpi-value">{{ number_format($acumuladoAteOntem, 0, ',', '.') }}</div>
            <div class="kpi-sub">{{ number_format($percentualMeta, 1, ',', '.') }}% da meta</div>
        </div>

        <div class="kpi-card card-warning">
            <div class="kpi-label">Projeção do mês</div>
            <div class="kpi-value">{{ number_format($projecaoMes, 0, ',', '.') }}</div>
            <div class="kpi-sub">{{ number_format($percentualProjecao, 1, ',', '.') }}% da meta</div>
        </div>

        <div class="kpi-card">
            <div class="kpi-label">Meta do mês</div>
            <div class="kpi-value">{{ number_format($metaMensal, 0, ',', '.') }}</div>
            <div class="kpi-sub">Meta atingida em {{ number_format($percentualMeta, 1, ',', '.') }}%</div>
            <div class="kpi-sub">Faltam {{ number_format($faltamMeta, 0, ',', '.') }}</div>
            <div class="progress-line">
                <span style="width: {{ min($percentualMeta, 100) }}%"></span>
            </div>
        </div>
    </div>

    <div class="chart-card">
        <div class="chart-title">Emissões diárias no mês</div>
        <div class="chart-info">
            Hoje aparece como parcial. A projeção do mês é calculada com base nos dias fechados até ontem.
        </div>

        <div class="chart-box">
            <canvas id="graficoEmissoes"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = @json($dias);
    const realizado = @json($totais);
    const metaLinha = @json($metaLinha);
    const projecaoLinha = @json($projecaoLinha);

    const ctx = document.getElementById('graficoEmissoes');

    new Chart(ctx, {
        data: {
            labels: labels,
            datasets: [
                {
                    type: 'bar',
                    label: 'Emissão do dia',
                    data: realizado,
                    borderRadius: 6,
                    maxBarThickness: 26
                },
                {
                    type: 'line',
                    label: 'Meta para o Dia',
                    data: metaLinha,
                    tension: 0.35,
                    pointRadius: 0,
                    borderWidth: 2,
                    yAxisID: 'y'
                },
                {
                    type: 'line',
                    label: 'Está com',
                    data: projecaoLinha,
                    yAxisID: 'y1',
                    tension: 0.35,
                    pointRadius: 0,
                    borderWidth: 2,
                    borderDash: [6, 6]
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    onHover: function(event, legendItem) {
                        if (legendItem.text === 'Meta Cumulativa') {
                            const tooltip = document.getElementById('legend-tooltip');
                            tooltip.style.display = 'block';
                            tooltip.style.left = (event.native.clientX + 12) + 'px';
                            tooltip.style.top  = (event.native.clientY - 90) + 'px';
                        }
                    },
                    onLeave: function(event, legendItem) {
                        if (legendItem.text === 'Meta Cumulativa') {
                            document.getElementById('legend-tooltip').style.display = 'none';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    position: 'left'
                },
                y1: {
                    beginAtZero: true,
                    position: 'right',
                    grid: {
                        drawOnChartArea: false
                    }
                }
            }
        }
    });
</script>
@endsection