<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Financeiro</title>

    <!-- Bootstrap para responsividade -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/painel.css') }}">
</head>

<body>
    <div class="container">
        <div class="painel text-center">
        <form method="GET" action="{{ route('dashboard') }}" class="mb-4">
            <label for="data_inicio">Data Início:</label>
            <input type="date" name="data_inicio" id="data_inicio" value="{{ request('data_inicio', $dataInicio) }}" required>

            <label for="data_fim">Data Fim:</label>
            <input type="date" name="data_fim" id="data_fim" value="{{ request('data_fim', $dataFim) }}" required>

            <button type="submit">Filtrar</button>
        </form>

        <h2>Painel Financeiro - Período: {{ \Carbon\Carbon::parse($dataInicio)->format('d/m/Y') }} até {{ \Carbon\Carbon::parse($dataFim)->format('d/m/Y') }}</h2>



        </div>

        <div class="row text-center mt-4">
            <!-- Bloco de Entradas(a receber) -->
            <div class="col-md-4">
                <div class="card entrada">
                    <h2>ENTRADAS</h2>
                       <!-- previsao de receitas A RECEBER-->
                    <p>Receitas A RECEBER</p>
                    <h3>R$ {{ number_format($totalEntrada, 2, ',', '.') }}</h3>
                       <!-- receitas já recebido -->
                    <p>Total Recebido (Em Dinheiro)</p>
                    <h3>R$ {{ number_format($totalRecebido, 2, ',', '.') }}</h3>           
                     <!-- receitas já recebido e a receber -->
                    <p>Previsão de Receitas</p>
                    <h3>R$ {{ number_format($previsaoReceitas, 2, ',', '.') }}</h3>
                </div>    
            </div>

             <!-- Bloco de a pagar -->
            <div class="col-md-4">
                <div class="card saida">
                    <h2>SAÍDAS</h2>
                    <p> A PAGAR(Mês Atual)</p>
                    <h3>R$ {{ number_format($previsaoDespesas, 2, ',', '.') }}</h3>
                    <p>Total de Despesas já Pago (em DINHEIRO)</p>
                    <h3>R$ {{ number_format($totalPago, 2, ',', '.') }}</h3>
                    <p>Previsão Despesas (Mês Atual)</p>
                    <h3>R$ {{ number_format($totalSaidas, 2, ',', '.') }}</h3>
                    
                </div>

            </div>

            <!-- Bloco de Saldo Atual -->
            <div class="col-md-4">
                <div class="card saldo-previsao">
                    <h2>SALDO</h2>
                    <!-- saldo atual é o total recebido - total de despesas pago  -->

                    <p>Mensagem...</p>
                    <p> "O Senhor é o meu pastor,<span style="font-weight:bolder">nada me FALTARÁ."</span></p> 

                    <p><span style="font-size:14
                    
                    px">Saldo Atual em DINHEIRO
                    (recebido<span style="font-size:25px;color:red"> - </span>despesas)</span></p>
                    <h3 class="{{ $saldoAtual < 0 ? 'negativo' : 'positivo' }}">
                    R$ {{ number_format($saldoAtual, 2, ',', '.') }}</h3> 

                    </h3> 
                                      
                    <p>Previsão de Saldo (prev.receitas - prev.despesas)</p>
                    <h3 class="{{ $previsaoSaldoMensal < 0 ? 'negativo' : 'positivo' }}">
                        R$ {{ number_format($previsaoSaldoMensal, 2, ',', '.') }}
                    </h3> 
                    
                </div>
            </div>
        </div>
    </div>



    <!--  graficos -->
    <div class="container">
            <div class="painel text-center">
            <h1>GRÁFICOS <span class="data-atual">{{ \Carbon\Carbon::now()->format('d-m-Y') }}</span></h1>
            </div>

            <div class="row  mt-4"> <!--  INICIO -->
                <!-- pRIMEIRO GRAFICO ENTRADAS X SAIDAS  -->
            <div class="col-md-4"> 
                <div class="chart-container">
                    <div class="grafico-header">
                        <h3>Entradas x Saídas (%)</h3>
                    </div>
                    <div class="grafico-wrapper">
                        <canvas id="graficoEntradaSaida"></canvas>        
                    </div>
            </div>            
                
    </div>  <!-- DIV FINAL -->

           










    
    <!-- Bootstrap para melhor responsividade -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   

    <!-- Adicionar a biblioteca Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script>
    // Dados do Laravel passados para o JavaScript
    // Certifique-se de que os dados estão corretos
var totalEntradas = {{ $previsaoReceitas }};
var totalSaidas = {{ $totalSaidas }};
var totalGeral = totalEntradas + totalSaidas;

var percentualEntradas = ((totalEntradas / totalGeral) * 100).toFixed(2);
var percentualSaidas = ((totalSaidas / totalGeral) * 100).toFixed(2);

var ctx = document.getElementById('graficoEntradaSaida').getContext('2d');

var graficoEntradaSaida = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Entradas', 'Saídas'],
        datasets: [{
            data: [percentualEntradas, percentualSaidas],
            backgroundColor: ['#28a745', '#F06E3E'],
            borderColor: ['#1d7a34', '#a71c28'],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // 🔹 Garante que o gráfico se ajuste ao tamanho correto
        plugins: {
            legend: { display: false },
            tooltip: { enabled: true },
            datalabels: {
                anchor: 'end',
                align: 'top',
                color: '#000',
                font: { weight: 'bold', size: 16 },
                formatter: function(value) {
                    return value + "%"; // Adiciona "%" aos valores
                }
            }
        },
        scales: {
            y: { beginAtZero: true, max: 100, ticks: { font: { size: 14 } } },
            x: { ticks: { font: { size: 14 } } }
        }
    },
    plugins: [ChartDataLabels] // 🔹 Certifique-se de que o plugin está ativado corretamente
});

</script>

</body>
</html>
   


