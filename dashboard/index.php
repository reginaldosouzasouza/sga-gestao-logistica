<?php
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Gerencial Financeiro</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <header class="topbar">
            <div>
                <h1>Dashboard Inteligente</h1>
                <p>Previsão financeira e análise gerencial</p>
            </div>
            <div class="badge">PHP + MySQL + Python</div>
        </header>

        <section class="kpis" id="kpis">
            <div class="card">
                <span>Receita Prevista</span>
                <strong id="kpiReceita">R$ 0,00</strong>
            </div>
            <div class="card">
                <span>Custo Previsto</span>
                <strong id="kpiCusto">R$ 0,00</strong>
            </div>
            <div class="card">
                <span>Lucro Projetado</span>
                <strong id="kpiLucro">R$ 0,00</strong>
            </div>
            <div class="card">
                <span>Margem Média</span>
                <strong id="kpiMargem">0%</strong>
            </div>
        </section>

        <section class="grid">
            <div class="panel">
                <h3>Receita Real x Previsão</h3>
                <canvas id="receitaChart"></canvas>
            </div>
            <div class="panel">
                <h3>Margem por Produto</h3>
                <canvas id="margemChart"></canvas>
            </div>
        </section>

        <section class="grid">
            <div class="panel">
                <h3>Lucro Projetado Mensal</h3>
                <canvas id="lucroChart"></canvas>
            </div>
            <div class="panel">
                <h3>Resumo da Previsão</h3>
                <table class="summary-table">
                    <thead>
                        <tr>
                            <th>Mês</th>
                            <th>Receita</th>
                            <th>Custo</th>
                            <th>Lucro</th>
                            <th>Margem</th>
                        </tr>
                    </thead>
                    <tbody id="summaryBody"></tbody>
                </table>
            </div>
        </section>
    </div>

    <script src="js/dashboard.js"></script>
</body>
</html>
