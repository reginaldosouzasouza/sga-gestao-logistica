<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Financeiro</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, Helvetica, sans-serif; background: #020617; color: #e2e8f0; }
        .container { max-width: 1600px; margin: 0 auto; padding: 24px; }

        .topbar {
            display: flex; justify-content: space-between; align-items: center;
            gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
        }

        .title h1 { font-size: 32px; font-weight: 700; color: #f8fafc; }
        .title p { margin-top: 6px; color: #94a3b8; font-size: 14px; }

        .filters { display: flex; gap: 12px; flex-wrap: wrap; }
        .filter-box {
            background: #0f172a; border: 1px solid #1e293b; border-radius: 14px;
            padding: 12px 16px; min-width: 180px;
        }
        .filter-box small { display: block; color: #64748b; margin-bottom: 4px; }
        .filter-box strong { color: #f8fafc; font-size: 14px; }

        .grid-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .card {
            background: #0f172a;
            border: 1px solid #1e293b;
            border-radius: 18px;
            padding: 18px;
            box-shadow: 0 8px 20px rgba(0,0,0,.25);
        }

        .card .label { font-size: 13px; color: #94a3b8; margin-bottom: 10px; }
        .card .value { font-size: 30px; font-weight: 700; color: #f8fafc; }
        .card .detail { margin-top: 8px; font-size: 13px; color: #64748b; }

        .card.green { border-left: 4px solid #10b981; }
        .card.blue { border-left: 4px solid #3b82f6; }
        .card.cyan { border-left: 4px solid #06b6d4; }
        .card.violet { border-left: 4px solid #8b5cf6; }
        .card.amber { border-left: 4px solid #f59e0b; }

        .grid-main {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 16px;
            margin-bottom: 24px;
        }

        .panel {
            background: #0f172a;
            border: 1px solid #1e293b;
            border-radius: 18px;
            padding: 20px;
        }

        .panel h2 { font-size: 20px; color: #f8fafc; margin-bottom: 6px; }
        .panel p.sub { color: #94a3b8; font-size: 13px; margin-bottom: 16px; }

        .grid-bottom {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .kpi-list { display: grid; gap: 12px; margin-top: 16px; }
        .kpi-item {
            background: #111827; border: 1px solid #1f2937;
            border-radius: 14px; padding: 14px;
        }
        .kpi-item small { color: #94a3b8; display: block; margin-bottom: 6px; }
        .kpi-item strong { font-size: 20px; color: #f8fafc; }
        .kpi-item.highlight strong { color: #10b981; }

        .text-red { color: #ef4444 !important; }
        .text-orange { color: #f59e0b !important; }
        .text-green { color: #10b981 !important; }

        .tooltip-card {
            position: relative;
            cursor: help;
        }

        .tooltip-card::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 14px;
            bottom: calc(100% + 10px);
            width: 340px;
            background: #0b1220;
            color: #e2e8f0;
            border: 1px solid #334155;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 12px;
            line-height: 1.5;
            box-shadow: 0 10px 25px rgba(0,0,0,.35);
            opacity: 0;
            visibility: hidden;
            transform: translateY(6px);
            transition: all .18s ease;
            z-index: 50;
            pointer-events: none;
            white-space: normal;
        }

        .tooltip-card::before {
            content: "";
            position: absolute;
            left: 24px;
            bottom: calc(100% + 4px);
            border-width: 6px;
            border-style: solid;
            border-color: #334155 transparent transparent transparent;
            opacity: 0;
            visibility: hidden;
            transform: translateY(6px);
            transition: all .18s ease;
            z-index: 51;
        }

        .tooltip-card:hover::after,
        .tooltip-card:hover::before {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .status-box {
            margin-top: 16px; border-radius: 14px; padding: 14px;
            font-size: 14px; font-weight: 700; line-height: 1.4;
        }
        .status-ok {
            background: rgba(16, 185, 129, 0.12);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.25);
        }
        .status-risk {
            background: rgba(239, 68, 68, 0.12);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.25);
        }

        .insights { display: grid; gap: 12px; margin-top: 16px; }
        .insight {
            background: #111827; border: 1px solid #1f2937;
            border-radius: 14px; padding: 14px;
        }
        .insight strong { display: block; color: #f8fafc; margin-bottom: 4px; }
        .insight span { color: #94a3b8; font-size: 14px; }

        .products {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 12px; margin-top: 16px;
        }
        .product-box {
            background: #111827; border: 1px solid #1f2937;
            border-radius: 14px; padding: 14px;
        }
        .product-box small { display: block; color: #94a3b8; margin-bottom: 6px; }
        .product-box strong { color: #f8fafc; font-size: 22px; }

        canvas { width: 100% !important; max-height: 320px !important; }

        @media (max-width: 1200px) {
            .grid-cards { grid-template-columns: repeat(2, 1fr); }
            .grid-main, .grid-bottom { grid-template-columns: 1fr; }
        }

        @media (max-width: 700px) {
            .grid-cards { grid-template-columns: 1fr; }
            .products { grid-template-columns: 1fr; }
            .title h1 { font-size: 24px; }
        }
    </style>
</head>
<body>
    @php
        $cards = $dados['cards'];
        $comparativo = $dados['comparativo_semanal'];
        $graficos = $dados['graficos'];

        function moeda($valor) {
            $valor = (float) $valor;
            $sinal = $valor < 0 ? '-' : '';

            return $sinal . 'R$ ' . number_format(abs($valor), 2, ',', '.');
        }
    @endphp

    <div class="container">
        <div class="topbar">
            <div class="title">
                <h1>Dashboard Financeiro</h1>
                <p>Revenda de gás e água • visão atual, metas e projeção mensal</p>
            </div>

            <div class="filters">
                <div class="filter-box">
                    <small>Período</small>
                    <strong>{{ \Carbon\Carbon::parse($dados['periodo']['inicio_mes'])->format('d/m/Y') }} até {{ \Carbon\Carbon::parse($dados['periodo']['fim_mes'])->format('d/m/Y') }}</strong>
                </div>

                <div class="filter-box">
                    <small>Hoje</small>
                    <strong>{{ \Carbon\Carbon::parse($dados['periodo']['hoje'])->format('d/m/Y') }}</strong>
                </div>
            </div>
        </div>

        <div class="grid-cards">
            <div class="card green">
                <div class="label">Vendido Ontem</div>
                <div class="value">{{ moeda($cards['vendido_ontem']['total']) }}</div>
                <div class="detail">
                    Gás {{ moeda($cards['vendido_ontem']['gas']) }} • Água {{ moeda($cards['vendido_ontem']['agua']) }}
                </div>
            </div>

            <div class="card blue">
                <div class="label">Acumulado do Mês</div>
                <div class="value">{{ moeda($cards['acumulado_mes']['total']) }}</div>
                <div class="detail">
                    Emissão / vendas registradas • Gás {{ moeda($cards['acumulado_mes']['gas']) }} • Água {{ moeda($cards['acumulado_mes']['agua']) }}
                </div>
            </div>

            <div class="card cyan">
                <div class="label">Recebido no Mês até Ontem</div>
                <div class="value">{{ moeda($cards['recebido_ate_ontem']) }}</div>
                <div class="detail">
                    Entradas efetivas em caixa e banco considerando somente os dias fechados
                </div>
            </div>

            <div class="card green">
                <div class="label">Contas a Receber Pendentes</div>
                <div class="value">{{ moeda($cards['contas_receber_pendentes_mes']) }}</div>
                <div class="detail">
                    Valores pendentes da tabela contas_a_receber no mês atual
                </div>
            </div>

            <div class="card violet">
                <div class="label">Compras Pagas no Mês</div>
                <div class="value">{{ moeda($cards['compras_pagas_mes']) }}</div>
                <div class="detail">
                    Total efetivamente pago em caixa e caixa_banco
                </div>
            </div>

            <div class="card amber">
                <div class="label">Contas a Pagar em Aberto</div>
                <div class="value" style="color: red;">{{ moeda($cards['contas_pagar_aberto']) }}</div>
                <div class="detail">
                    Valores pendentes da tabela contas_a_pagar
                </div>
            </div>
        </div>

        <div class="grid-main">
            <div class="panel">
                <h2>Faturamento diário do mês</h2>
                <p class="sub">Acompanhamento do ritmo de vendas</p>
                <canvas id="graficoVendasDiarias"></canvas>
            </div>

            <div class="panel">
                <h2>Meta e projeção</h2>
                <p class="sub">Situação financeira do mês</p>

                <div class="kpi-list">
                    <div class="kpi-item tooltip-card"
                         data-tooltip="Soma de tudo que já foi pago no mês com o que ainda falta pagar. Fórmula: Compras Pagas no Mês + Contas a Pagar em Aberto.">
                        <small>Despesas Totais Previstas</small>
                        <strong class="text-red">{{ moeda($cards['projecao_despesas_mes']) }}</strong>
                    </div>

                    <div class="kpi-item highlight tooltip-card"
                         data-tooltip="Estimativa de quanto deve entrar até o fim do mês, mantendo o ritmo médio de recebimento dos dias já fechados. Fórmula: Média Diária de Recebimento até Ontem × total de dias do mês.">
                        <small>Recebimento Projetado até o Fim do Mês</small>
                        <strong>{{ moeda($cards['projecao_recebimento_mes']) }}</strong>
                    </div>

                    <div class="kpi-item tooltip-card"
                         data-tooltip="Mostra a sobra ou a falta projetada para o fechamento do mês. Fórmula: Recebimento Projetado até o Fim do Mês - Despesas Totais Previstas. Valor negativo indica que o mês tende a fechar descoberto.">
                        <small>Resultado Projetado do Mês</small>
                        <strong class="{{ $cards['resultado_projetado_mes'] >= 0 ? 'text-green' : 'text-red' }}">{{ moeda($cards['resultado_projetado_mes']) }}</strong>
                    </div>

                    <div class="kpi-item tooltip-card"
                         data-tooltip="Mostra quanto ainda falta receber, a partir de hoje, para que o mês cubra toda a despesa prevista. Fórmula: Despesas Totais Previstas - Recebido no Mês até Ontem.">
                        <small>Valor que falta a Receber para Cobrir Despesas do Mês</small>
                        <strong>{{ moeda($cards['falta_receber_para_cobrir_mes']) }}</strong>
                    </div>


                      <div class="kpi-item tooltip-card"
                         data-tooltip="Meta diária necessária para o mês terminar cobrindo toda a despesa prevista. Fórmula: Valor que falta a Receber para Cobrir Despesas do Mês ÷ Dias Restantes.">
                        <small>Meta Diária - devo vender Cobrir o Mês</small>
                        <strong>{{ moeda($cards['meta_diaria_fechar_mes']) }}</strong>
                    </div>

                    <div class="kpi-item tooltip-card"
                         data-tooltip="Meta mínima diária para quitar apenas o que ainda está pendente no contas a pagar. Fórmula: Contas a Pagar em Aberto ÷ Dias Restantes.">
                        <small>Meta Diária para Quitar Contas em Aberto</small>
                        <strong class="text-orange">{{ moeda($cards['meta_diaria_cobrir_aberto']) }}</strong>
                    </div>

                    

                    <div class="kpi-item tooltip-card"
                         data-tooltip="Média do que entrou por dia considerando somente os dias completos já fechados do mês. Fórmula: Recebido até Ontem ÷ Dias Completos.">
                        <small>Média Diária de Recebimento até Ontem</small>
                        <strong>{{ moeda($cards['media_diaria_recebimento']) }}</strong>
                    </div>
                </div>

                <div class="status-box {{ $cards['status_meta'] === 'VAI ATINGIR' ? 'status-ok' : 'status-risk' }}">
                    Status: {{ $cards['status_meta'] }}<br>
                    Se o Resultado Projetado do Mês for positivo ou zero, o mês tende a fechar coberto.
                </div>
            </div>
        </div>

        <div class="grid-bottom">
            <div class="panel">
                <h2>Comparação semanal</h2>
                <p class="sub">Comparação proporcional até ontem</p>
                <canvas id="graficoSemanal"></canvas>

                <div class="status-box {{ $comparativo['variacao_percentual'] >= 0 ? 'status-ok' : 'status-risk' }}" style="margin-top: 18px;">
                    @if($comparativo['variacao_percentual'] >= 0)
                        Crescimento de {{ number_format($comparativo['variacao_percentual'], 2, ',', '.') }}% comparando {{ $comparativo['dias_comparados'] }} dia(s)
                    @else
                        Queda de {{ number_format(abs($comparativo['variacao_percentual']), 2, ',', '.') }}% comparando {{ $comparativo['dias_comparados'] }} dia(s)
                    @endif
                </div>
            </div>

            <div class="panel">
                <h2>Leitura gerencial</h2>
                <p class="sub">Resumo operacional e financeiro</p>

                <div class="insights">
                    <div class="insight">
                        <strong>Pago em Dinheiro</strong>
                        <span>{{ moeda($cards['pago_dinheiro_mes']) }}</span>
                    </div>

                    <div class="insight">
                        <strong>Pago em PIX / Banco</strong>
                        <span>{{ moeda($cards['pago_pix_mes']) }}</span>
                    </div>

                    <div class="insight">
                        <strong>Dias Restantes</strong>
                        <span>{{ $dados['periodo']['dias_restantes'] }} dias</span>
                    </div>
                </div>

                <div class="products">
                    <div class="product-box">
                        <small>Vendas de Gás no Mês</small>
                        <strong>{{ moeda($cards['acumulado_mes']['gas']) }}</strong>
                    </div>

                    <div class="product-box">
                        <small>Vendas de Água no Mês</small>
                        <strong>{{ moeda($cards['acumulado_mes']['agua']) }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const vendasDiarias = @json($graficos['vendas_diarias']);
        const comparativo = @json($comparativo);

        const labelsDiarias = vendasDiarias.map(item => {
            const data = new Date(item.data + 'T00:00:00');
            return data.toLocaleDateString('pt-BR');
        });

        const dadosDiarias = vendasDiarias.map(item => Number(item.total));

        new Chart(document.getElementById('graficoVendasDiarias'), {
            type: 'bar',
            data: {
                labels: labelsDiarias,
                datasets: [{
                    label: 'Vendas por dia',
                    data: dadosDiarias,
                    backgroundColor: '#3b82f6',
                    borderRadius: 8
                }]
            },
            options: {
                plugins: {
                    legend: {
                        labels: { color: '#cbd5e1' }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: '#94a3b8' },
                        grid: { color: 'rgba(148,163,184,0.08)' }
                    },
                    y: {
                        ticks: { color: '#94a3b8' },
                        grid: { color: 'rgba(148,163,184,0.08)' }
                    }
                }
            }
        });

        new Chart(document.getElementById('graficoSemanal'), {
            type: 'line',
            data: {
                labels: ['Semana Atual', 'Semana Anterior'],
                datasets: [{
                    label: 'Total semanal',
                    data: [
                        Number(comparativo.semana_atual),
                        Number(comparativo.semana_anterior)
                    ],
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.15)',
                    fill: true,
                    tension: 0.35
                }]
            },
            options: {
                plugins: {
                    legend: {
                        labels: { color: '#cbd5e1' }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: '#94a3b8' },
                        grid: { color: 'rgba(148,163,184,0.08)' }
                    },
                    y: {
                        ticks: { color: '#94a3b8' },
                        grid: { color: 'rgba(148,163,184,0.08)' }
                    }
                }
            }
        });
    </script>
</body>
</html>