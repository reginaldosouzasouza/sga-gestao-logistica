@extends('layouts.app')

@section('title', 'Dashboard Gerencial')

@section('content')
<link rel="stylesheet" href="{{ asset('css/gerencial/dashboard.css') }}">

<div class="dashboard-container">

    <div class="dashboard-header">
        <h1>Dashboard Gerencial</h1>
        <input type="date" id="filtroData" value="{{ now()->format('Y-m-d') }}">
    </div>

    <!-- KPIs -->
    <div class="kpi-grid">

        <div class="kpi-card kpi-caixa" id="cardCaixa">
            <span>Caixa (Dinheiro)</span>
            <strong id="kpi-caixa">R$ 0,00</strong>
        </div>

        <div class="kpi-card kpi-banco">
            <div class="kpi-icon">🔵</div>
            <div class="kpi-info">
                <span>Caixa Banco (PIX)</span>
                <strong id="kpiBanco">R$ 0,00</strong>
            </div>
        </div>

        <div class="kpi-card kpi-resultado">
            <div class="kpi-icon">📈</div>
            <div class="kpi-info">
                <span>Resultado do Dia</span>
                <strong id="kpiResultadoDia">
                    R$ 0,00 <small id="kpiResultadoPct"></small>
                </strong>
            </div>
        </div>

    </div>

    <!-- GRÁFICOS -->
    <div class="charts-grid">
        <div class="chart-card">
            <h3>Receita x Despesa</h3>
            <canvas id="chartReceitaDespesa"></canvas>
        </div>

        <div class="chart-card">
            <h3>Formas de Pagamento</h3>
            <canvas id="chartPagamento"></canvas>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
<script src="{{ asset('js/gerencial/dashboard.js') }}"></script>
@endsection
