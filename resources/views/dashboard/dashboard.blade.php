@extends('layouts.app')

@section('title', 'Dashboard Financeiro')

@section('content')
<div class="container">
    <h2>Dashboard Financeiro</h2>

    <form method="GET" action="{{ route('dashboard') }}" class="mb-4">
        <label for="data_inicio">Data Início:</label>
        <input type="date" name="data_inicio" id="data_inicio" value="{{ request('data_inicio') }}" required>

        <label for="data_fim">Data Fim:</label>
        <input type="date" name="data_fim" id="data_fim" value="{{ request('data_fim') }}" required>

        <button type="submit">Filtrar</button>
    </form>


    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total de Receitas (Mês Atual)</div>
                <div class="card-body">
                    <h3>R$ {{ number_format($totalEntrada, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Recebido (Mês Atual)</div>
                <div class="card-body">
                    <h3>R$ {{ number_format($totalRecebido, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Saldo Atual</div>
                <div class="card-body">
                    <h3>R$ {{ number_format($saldoAtual, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <h3>Evolução de Saldo por Mês</h3>
    <canvas id="graficoSaldo"></canvas>
</div>

<!-- Gráfico -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('graficoSaldo').getContext('2d');
    var graficoSaldo = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($evolucaoSaldo->toArray())) !!},
            datasets: [{
                label: 'Saldo por Mês',
                data: {!! json_encode(array_values($evolucaoSaldo->toArray())) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection

