<div class="dashboard-container">
    <h1 class="title">DASHBOARD GERENCIAL EMISSÃO </h1>

    <form method="GET" action="{{ route('dashboard.emissao') }}" class="mb-4">
        <input type="date" name="data_inicio" value="{{ $inicio }}">
        <input type="date" name="data_fim" value="{{ $fim }}">
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>

    <div class="row">
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h5>Faturamento Bruto</h5>
                    <h2>R$ {{ number_format($faturamento, 2, ',', '.') }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h5>Margem Contribuição</h5>
                    <h2>R$ {{ number_format($margemBruta, 2, ',', '.') }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-dark text-white">
                <div class="card-body text-center">
                    <h5>Despesas Operacionais</h5>
                    <h2>R$ {{ number_format($despesas, 2, ',', '.') }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body text-center">
                    <h5>Rendimento Líquido</h5>
                    <h2>R$ {{ number_format($rendimento, 2, ',', '.') }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <canvas id="graficoResultado" style="max-height: 400px;"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('graficoResultado').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Bruto Emissão', 'Margem', 'Despesas', 'Líquido'],
            datasets: [{
                label: 'Performance Financeira (R$)',
                data: [{{$faturamento}}, {{$margemBruta}}, {{$despesas}}, {{$rendimento}}],
                backgroundColor: ['#28a745', '#17a2b8', '#e71818', '#ffc107']
            }]
        }
    });
</script>