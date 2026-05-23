<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Fechamento Financeiro</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #020617;
            color: #e2e8f0;
        }

        .container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 24px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .title h1 {
            font-size: 32px;
            font-weight: 700;
            color: #f8fafc;
        }

        .title p {
            margin-top: 6px;
            color: #94a3b8;
            font-size: 14px;
        }

        .filters {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            align-items: stretch;
        }

        .periodo-form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: end;
        }

        .filter-box {
            background: #0f172a;
            border: 1px solid #1e293b;
            border-radius: 14px;
            padding: 12px 16px;
            min-width: 180px;
        }

        .filter-box small,
        .filter-box label {
            display: block;
            color: #64748b;
            margin-bottom: 4px;
            font-size: 12px;
        }

        .filter-box strong {
            color: #f8fafc;
            font-size: 14px;
        }

        .filter-box input[type="date"] {
            width: 100%;
            background: #020617;
            border: 1px solid #334155;
            color: #f8fafc;
            border-radius: 8px;
            padding: 8px 10px;
            outline: none;
            font-size: 14px;
        }

        .filter-box input[type="date"]:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.20);
        }

        .btn-filtrar,
        .btn-limpar,
        .btn-voltar {
            height: 42px;
            border-radius: 10px;
            padding: 0 16px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-filtrar {
            border: 1px solid #2563eb;
            background: #2563eb;
            color: #ffffff;
        }

        .btn-filtrar:hover { background: #1d4ed8; }

        .btn-limpar,
        .btn-voltar {
            border: 1px solid #334155;
            background: #0f172a;
            color: #cbd5e1;
        }

        .btn-limpar:hover,
        .btn-voltar:hover {
            background: #1e293b;
        }

        .hero {
            background: linear-gradient(135deg, #0f172a, #111827);
            border: 1px solid #1e293b;
            border-radius: 22px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 10px 28px rgba(0,0,0,.28);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.3fr .7fr;
            gap: 20px;
            align-items: center;
        }

        .hero small {
            display: block;
            color: #94a3b8;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .hero .resultado {
            font-size: 44px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .hero .resultado.positivo { color: #10b981; }
        .hero .resultado.negativo { color: #ef4444; }

        .hero .descricao {
            color: #cbd5e1;
            font-size: 15px;
            line-height: 1.5;
        }

        .status-principal {
            border-radius: 18px;
            padding: 18px;
            text-align: center;
            font-weight: 800;
            font-size: 22px;
        }

        .status-ok {
            background: rgba(16, 185, 129, 0.12);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.30);
        }

        .status-alerta {
            background: rgba(245, 158, 11, 0.12);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.30);
        }

        .status-risk {
            background: rgba(239, 68, 68, 0.12);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.30);
        }

        .grid-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
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

        .card .label {
            font-size: 13px;
            color: #94a3b8;
            margin-bottom: 10px;
        }

        .card .value {
            font-size: 28px;
            font-weight: 700;
            color: #f8fafc;
        }

        .card .detail {
            margin-top: 8px;
            font-size: 13px;
            color: #64748b;
            line-height: 1.4;
        }

        .card.green { border-left: 4px solid #10b981; }
        .card.blue { border-left: 4px solid #3b82f6; }
        .card.cyan { border-left: 4px solid #06b6d4; }
        .card.violet { border-left: 4px solid #8b5cf6; }
        .card.amber { border-left: 4px solid #f59e0b; }
        .card.red { border-left: 4px solid #ef4444; }

        .grid-main {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 24px;
        }

        .panel {
            background: #0f172a;
            border: 1px solid #1e293b;
            border-radius: 18px;
            padding: 20px;
        }

        .panel h2 {
            font-size: 20px;
            color: #f8fafc;
            margin-bottom: 6px;
        }

        .panel p.sub {
            color: #94a3b8;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .linha-analise {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 12px;
            padding: 14px 0;
            border-bottom: 1px solid #1e293b;
            align-items: center;
        }

        .linha-analise:last-child {
            border-bottom: none;
        }

        .linha-analise span {
            color: #94a3b8;
            font-size: 14px;
        }

        .linha-analise strong {
            color: #f8fafc;
            font-size: 18px;
            text-align: right;
        }

        .text-red { color: #ef4444 !important; }
        .text-orange { color: #f59e0b !important; }
        .text-green { color: #10b981 !important; }
        .text-blue { color: #3b82f6 !important; }
        .text-cyan { color: #06b6d4 !important; }

        .tooltip-card {
            position: relative;
            cursor: help;
        }

        .tooltip-card::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 14px;
            bottom: calc(100% + 10px);
            width: 360px;
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

        .tooltip-card:hover::after {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .decisao {
            margin-top: 16px;
            border-radius: 16px;
            padding: 16px;
            line-height: 1.5;
            font-size: 14px;
        }

        .decisao strong {
            display: block;
            margin-bottom: 6px;
            color: #f8fafc;
        }

        canvas {
            width: 100% !important;
            max-height: 320px !important;
        }

        @media (max-width: 1200px) {
            .grid-cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .hero-grid,
            .grid-main {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 700px) {
            .grid-cards {
                grid-template-columns: 1fr;
            }

            .title h1 {
                font-size: 24px;
            }

            .hero .resultado {
                font-size: 34px;
            }
        }
    </style>
</head>

<body>
@php
    $cards = $dados['cards'];
    $periodo = $dados['periodo'];

    function moeda($valor) {
        $valor = (float) $valor;
        $sinal = $valor < 0 ? '-' : '';

        return $sinal . 'R$ ' . number_format(abs($valor), 2, ',', '.');
    }

    function quantidadeInteira($valor) {
        return number_format((int) ceil((float) $valor), 0, ',', '.');
    }

    $recebimentoProjetado = (float) ($cards['projecao_recebimento_mes'] ?? 0);
    $despesasPrevistas = (float) ($cards['projecao_despesas_mes'] ?? 0);
    $comprasPagas = (float) ($cards['compras_pagas_mes'] ?? 0);
    $contasPagarAberto = (float) ($cards['contas_pagar_aberto'] ?? 0);
    $reposicaoEstimada = (float) ($cards['custo_estimado_reposicao'] ?? 0);
    $despesasTotaisComReposicao = (float) ($cards['despesas_totais_com_reposicao'] ?? 0);

    $resultadoSemReposicao = (float) ($cards['resultado_projetado_mes'] ?? 0);
    $resultadoComReposicao = (float) ($cards['resultado_projetado_com_reposicao'] ?? 0);

    $mediaDiariaRecebimento = (float) ($cards['media_diaria_recebimento'] ?? 0);
    $metaDiariaContasAberto = (float) ($cards['meta_diaria_cobrir_aberto'] ?? 0);
    $diasRestantes = (int) ($periodo['dias_restantes'] ?? 0);

    $recebimentoRestanteProjetado = $mediaDiariaRecebimento * $diasRestantes;
    $saldoProjetadoContasAbertas = $recebimentoRestanteProjetado - $contasPagarAberto;
    $diferencaDiariaContasAbertas = $mediaDiariaRecebimento - $metaDiariaContasAberto;

    $saldoReposicaoAComprar = $cards['saldo_reposicao_a_comprar'] ?? [
        'gas' => [
            'necessidade_prevista' => 0,
            'estoque_atual' => 0,
            'quantidade_a_comprar' => 0,
            'custo_estimado' => 0,
        ],
        'agua' => [
            'necessidade_prevista' => 0,
            'estoque_atual' => 0,
            'quantidade_a_comprar' => 0,
            'custo_estimado' => 0,
        ],
        'total' => [
            'quantidade_a_comprar' => 0,
            'custo_estimado' => 0,
        ],
    ];

    $custoSaldoReposicaoAComprar = (float) ($saldoReposicaoAComprar['total']['custo_estimado'] ?? 0);
    $resultadoComSaldoReposicaoAComprar = round($recebimentoProjetado - $despesasPrevistas - $custoSaldoReposicaoAComprar, 2);

    $analiseMesAnterior = $cards['analise_mes_anterior'] ?? [
        'periodo' => [
            'dias' => 30,
        ],
        'real' => [
            'saidas_total' => 0,
        ],
        'previsao_base_mes_anterior' => [
            'media_diaria_saidas' => 0,
        ],
    ];

    $saidasPagasMesAnterior = (float) ($analiseMesAnterior['real']['saidas_total'] ?? 0);
    $diasMesAnterior = (int) max(($analiseMesAnterior['periodo']['dias'] ?? 30), 1);
    $mediaDiariaSaidasMesAnterior = (float) ($analiseMesAnterior['previsao_base_mes_anterior']['media_diaria_saidas'] ?? 0);

    if ($mediaDiariaSaidasMesAnterior <= 0 && $saidasPagasMesAnterior > 0) {
        $mediaDiariaSaidasMesAnterior = round($saidasPagasMesAnterior / $diasMesAnterior, 2);
    }

    $previsaoSaidasDiasRestantesHistorico = round($mediaDiariaSaidasMesAnterior * $diasRestantes, 2);
    $previsaoFechamentoHistorico = round($saldoProjetadoContasAbertas - $previsaoSaidasDiasRestantesHistorico, 2);

    if ($resultadoComReposicao > 0) {
        $statusClasse = 'status-ok';
        $statusTexto = 'FECHAMENTO POSITIVO';
        $mensagemGestor = 'O ritmo atual indica sobra projetada após considerar despesas previstas, contas em aberto e reposição estimada.';
    } elseif ($resultadoComReposicao == 0) {
        $statusClasse = 'status-alerta';
        $statusTexto = 'FECHAMENTO NO LIMITE';
        $mensagemGestor = 'O período tende a fechar no equilíbrio. Qualquer nova despesa pode comprometer o resultado.';
    } else {
        $statusClasse = 'status-risk';
        $statusTexto = 'RISCO DE FALTA';
        $mensagemGestor = 'O ritmo atual indica falta projetada. É recomendado controlar compras, cobrar recebimentos e evitar novas despesas.';
    }
@endphp

<div class="container">

    <div class="topbar">
        <div class="title">
            <h1>Dashboard de Fechamento Financeiro</h1>
            <p>Projeção de sobra ou falta no final do período com base no ritmo atual de recebimento e despesas previstas</p>
        </div>

        <div class="filters">
            <form method="GET" action="{{ url()->current() }}" class="periodo-form">
                <div class="filter-box">
                    <label for="data_inicio">Data Inicial</label>
                    <input
                        type="date"
                        id="data_inicio"
                        name="data_inicio"
                        value="{{ request('data_inicio', $periodo['inicio_mes']) }}"
                    >
                </div>

                <div class="filter-box">
                    <label for="data_fim">Data Final</label>
                    <input
                        type="date"
                        id="data_fim"
                        name="data_fim"
                        value="{{ request('data_fim', $periodo['fim_mes']) }}"
                    >
                </div>

                <button type="submit" class="btn-filtrar">Filtrar</button>
                <a href="{{ url()->current() }}" class="btn-limpar">Limpar</a>
                <a href="{{ route('dashboard.financeiro') }}" class="btn-voltar">Voltar ao Financeiro</a>
            </form>

            <div class="filter-box">
                <small>Hoje</small>
                <strong>{{ \Carbon\Carbon::parse($periodo['hoje'])->format('d/m/Y') }}</strong>
            </div>
        </div>
    </div>

    <div class="hero">
        <div class="hero-grid">
            <div>
                <small>Sobra/Falta Projetada no Final do Período</small>

                <div class="resultado {{ $resultadoComReposicao >= 0 ? 'positivo' : 'negativo' }}">
                    {{ moeda($resultadoComReposicao) }}
                </div>

                <div class="descricao">
                    Resultado calculado considerando recebimento projetado, despesas previstas,
                    contas a pagar em aberto e custo estimado de reposição.
                </div>
            </div>

            <div class="status-principal {{ $statusClasse }}">
                {{ $statusTexto }}
                <div style="font-size: 13px; font-weight: 500; margin-top: 8px;">
                    {{ $mensagemGestor }}
                </div>
            </div>
        </div>
    </div>

    <div class="grid-cards">
        <div class="card green tooltip-card"
             data-tooltip="Estimativa de quanto deve entrar até o fim do período, mantendo a média diária de recebimento até ontem.">
            <div class="label">Recebimento Projetado</div>
            <div class="value">{{ moeda($recebimentoProjetado) }}</div>
            <div class="detail">Entrada prevista até o final do período.</div>
        </div>

        <div class="card red tooltip-card"
             data-tooltip="Soma das compras pagas no período com as contas a pagar em aberto.">
            <div class="label">Despesas Previstas</div>
            <div class="value">{{ moeda($despesasPrevistas) }}</div>
            <div class="detail">Compras pagas + contas em aberto.</div>
        </div>

        <div class="card amber tooltip-card"
             data-tooltip="Estimativa de compra futura necessária para repor gás e água nos dias restantes, baseada na média de emissão até ontem.">
            <div class="label">Reposição Estimada</div>
            <div class="value">{{ moeda($reposicaoEstimada) }}</div>
            <div class="detail">Previsão de custo para manter o estoque.</div>
        </div>

        <div class="card blue tooltip-card"
             data-tooltip="Resultado após descontar despesas previstas e reposição estimada do recebimento projetado.">
            <div class="label">Resultado Final Projetado</div>
            <div class="value {{ $resultadoComReposicao >= 0 ? 'text-green' : 'text-red' }}">
                {{ moeda($resultadoComReposicao) }}
            </div>
            <div class="detail">Sobra ou falta prevista no fechamento.</div>
        </div>
    </div>

    <div class="grid-cards">
        <div class="card cyan tooltip-card"
             data-tooltip="Mostra quanto gás ainda precisa ser comprado, considerando a previsão de saída até o fim do período menos o estoque atual.">
            <div class="label">Saldo de Gás a Comprar</div>
            <div class="value">
                {{ quantidadeInteira($saldoReposicaoAComprar['gas']['quantidade_a_comprar'] ?? 0) }} un
            </div>
            <div class="detail">
                Necessidade: {{ quantidadeInteira($saldoReposicaoAComprar['gas']['necessidade_prevista'] ?? 0) }} un
                • Estoque: {{ quantidadeInteira($saldoReposicaoAComprar['gas']['estoque_atual'] ?? 0) }} un
                • {{ moeda($saldoReposicaoAComprar['gas']['custo_estimado'] ?? 0) }}
            </div>
        </div>

        <div class="card blue tooltip-card"
             data-tooltip="Mostra quanto de água ainda precisa ser comprado, considerando a previsão de saída até o fim do período menos o estoque atual.">
            <div class="label">Saldo de Água a Comprar</div>
            <div class="value">
                {{ quantidadeInteira($saldoReposicaoAComprar['agua']['quantidade_a_comprar'] ?? 0) }} un
            </div>
            <div class="detail">
                Necessidade: {{ quantidadeInteira($saldoReposicaoAComprar['agua']['necessidade_prevista'] ?? 0) }} un
                • Estoque: {{ quantidadeInteira($saldoReposicaoAComprar['agua']['estoque_atual'] ?? 0) }} un
                • {{ moeda($saldoReposicaoAComprar['agua']['custo_estimado'] ?? 0) }}
            </div>
        </div>

        <div class="card amber tooltip-card"
             data-tooltip="Valor estimado que ainda precisaria ser gasto para comprar gás e água, considerando a previsão de saída e o estoque atual.">
            <div class="label">Total de Reposição a Comprar</div>
            <div class="value">
                {{ moeda($saldoReposicaoAComprar['total']['custo_estimado'] ?? 0) }}
            </div>
            <div class="detail">
                Quantidade total: {{ quantidadeInteira($saldoReposicaoAComprar['total']['quantidade_a_comprar'] ?? 0) }} un
            </div>
        </div>

        <div class="card green tooltip-card"
             data-tooltip="Resultado usando apenas o saldo de reposição ainda a comprar. Esse card é uma leitura complementar e não substitui o resultado final projetado original.">
            <div class="label">Resultado com Saldo a Comprar</div>
            <div class="value {{ $resultadoComSaldoReposicaoAComprar >= 0 ? 'text-green' : 'text-red' }}">
                {{ moeda($resultadoComSaldoReposicaoAComprar) }}
            </div>
            <div class="detail">
                Recebimento - despesas - saldo de reposição.
            </div>
        </div>
    </div>

    <div class="grid-main">
        <div class="panel">
            <h2>Composição do Fechamento</h2>
            <p class="sub">Como o sistema chegou na sobra ou falta projetada</p>

            <div class="linha-analise">
                <span>Recebimento projetado até o fim do período</span>
                <strong class="text-green">{{ moeda($recebimentoProjetado) }}</strong>
            </div>

            <div class="linha-analise">
                <span>Compras pagas no período</span>
                <strong class="text-red">- {{ moeda($comprasPagas) }}</strong>
            </div>

            <div class="linha-analise">
                <span>Contas a pagar em aberto</span>
                <strong class="text-red">- {{ moeda($contasPagarAberto) }}</strong>
            </div>

            <div class="linha-analise">
                <span>Custo estimado de reposição</span>
                <strong class="text-orange">- {{ moeda($reposicaoEstimada) }}</strong>
            </div>

            <div class="linha-analise">
                <span>Resultado projetado sem reposição</span>
                <strong class="{{ $resultadoSemReposicao >= 0 ? 'text-green' : 'text-red' }}">
                    {{ moeda($resultadoSemReposicao) }}
                </strong>
            </div>

            <div class="linha-analise">
                <span>Resultado final com reposição estimada</span>
                <strong class="{{ $resultadoComReposicao >= 0 ? 'text-green' : 'text-red' }}">
                    {{ moeda($resultadoComReposicao) }}
                </strong>
            </div>

            <div class="decisao {{ $statusClasse }}">
                <strong>Leitura de gestor</strong>
                {{ $mensagemGestor }}
            </div>
        </div>

        <div class="panel">
            <h2>Entradas x Saídas Projetadas</h2>
            <p class="sub">Comparação visual entre o que deve entrar e o que deve sair</p>

            <canvas id="graficoFechamento"></canvas>
        </div>
    </div>

    <div class="grid-main">
        <div class="panel">
            <h2>Saldo de Reposição a Comprar</h2>
            <p class="sub">Leitura prática de compra baseada em previsão de saída menos estoque atual</p>

            <div class="linha-analise">
                <span>Gás previsto até o fim do período</span>
                <strong>{{ quantidadeInteira($saldoReposicaoAComprar['gas']['necessidade_prevista'] ?? 0) }} un</strong>
            </div>

            <div class="linha-analise">
                <span>Estoque atual de gás</span>
                <strong class="text-cyan">{{ quantidadeInteira($saldoReposicaoAComprar['gas']['estoque_atual'] ?? 0) }} un</strong>
            </div>

            <div class="linha-analise">
                <span>Saldo de gás a comprar</span>
                <strong class="text-orange">{{ quantidadeInteira($saldoReposicaoAComprar['gas']['quantidade_a_comprar'] ?? 0) }} un • {{ moeda($saldoReposicaoAComprar['gas']['custo_estimado'] ?? 0) }}</strong>
            </div>

            <div class="linha-analise">
                <span>Água prevista até o fim do período</span>
                <strong>{{ quantidadeInteira($saldoReposicaoAComprar['agua']['necessidade_prevista'] ?? 0) }} un</strong>
            </div>

            <div class="linha-analise">
                <span>Estoque atual de água</span>
                <strong class="text-cyan">{{ quantidadeInteira($saldoReposicaoAComprar['agua']['estoque_atual'] ?? 0) }} un</strong>
            </div>

            <div class="linha-analise">
                <span>Saldo de água a comprar</span>
                <strong class="text-orange">{{ quantidadeInteira($saldoReposicaoAComprar['agua']['quantidade_a_comprar'] ?? 0) }} un • {{ moeda($saldoReposicaoAComprar['agua']['custo_estimado'] ?? 0) }}</strong>
            </div>

            <div class="linha-analise">
                <span>Total estimado ainda a comprar</span>
                <strong class="{{ $custoSaldoReposicaoAComprar > 0 ? 'text-orange' : 'text-green' }}">
                    {{ moeda($custoSaldoReposicaoAComprar) }}
                </strong>
            </div>

            <div class="linha-analise">
                <span>Resultado projetado usando saldo a comprar</span>
                <strong class="{{ $resultadoComSaldoReposicaoAComprar >= 0 ? 'text-green' : 'text-red' }}">
                    {{ moeda($resultadoComSaldoReposicaoAComprar) }}
                </strong>
            </div>

            <div class="decisao {{ $custoSaldoReposicaoAComprar > 0 ? 'status-alerta' : 'status-ok' }}">
                <strong>{{ $custoSaldoReposicaoAComprar > 0 ? 'Há reposição estimada a comprar' : 'Estoque suficiente pela projeção atual' }}</strong>
                Este bloco considera a necessidade prevista para os dias restantes e desconta o estoque atual cadastrado na tabela de produtos.
            </div>
        </div>

        <div class="panel">
            <h2>Gráfico da Reposição a Comprar</h2>
            <p class="sub">Comparação entre necessidade prevista, estoque atual e saldo a comprar</p>

            <canvas id="graficoReposicaoComprar"></canvas>
        </div>
    </div>

    <div class="grid-main">
        <div class="panel">
            <h2>Capacidade de Quitar Contas em Aberto</h2>
            <p class="sub">Análise baseada somente no que ainda falta pagar</p>

            <div class="linha-analise">
                <span>Média diária de recebimento até ontem</span>
                <strong class="text-green">{{ moeda($mediaDiariaRecebimento) }}</strong>
            </div>

            <div class="linha-analise">
                <span>Meta diária para quitar contas em aberto</span>
                <strong class="text-orange">{{ moeda($metaDiariaContasAberto) }}</strong>
            </div>

            <div class="linha-analise">
                <span>Diferença diária entre média recebida e meta</span>
                <strong class="{{ $diferencaDiariaContasAbertas >= 0 ? 'text-green' : 'text-red' }}">
                    {{ moeda($diferencaDiariaContasAbertas) }}
                </strong>
            </div>

            <div class="linha-analise">
                <span>Dias restantes</span>
                <strong>{{ $diasRestantes }} dias</strong>
            </div>

            <div class="linha-analise">
                <span>Recebimento projetado para os dias restantes</span>
                <strong class="text-green">{{ moeda($recebimentoRestanteProjetado) }}</strong>
            </div>

            <div class="linha-analise">
                <span>Saldo após quitar contas em aberto</span>
                <strong class="{{ $saldoProjetadoContasAbertas >= 0 ? 'text-green' : 'text-red' }}">
                    {{ moeda($saldoProjetadoContasAbertas) }}
                </strong>
            </div>

            <div class="linha-analise">
                <span>Saídas pagas no mês anterior</span>
                <strong class="text-red">{{ moeda($saidasPagasMesAnterior) }}</strong>
            </div>

            <div class="linha-analise">
                <span>Média diária de saídas do mês anterior</span>
                <strong class="text-orange">{{ moeda($mediaDiariaSaidasMesAnterior) }}</strong>
            </div>

            <div class="linha-analise">
                <span>Previsão de saídas para os dias restantes</span>
                <strong class="text-red">{{ moeda($previsaoSaidasDiasRestantesHistorico) }}</strong>
            </div>

            <div class="linha-analise">
                <span>Previsão de fechamento com base no mês anterior</span>
                <strong class="{{ $previsaoFechamentoHistorico >= 0 ? 'text-green' : 'text-red' }}">
                    {{ moeda($previsaoFechamentoHistorico) }}
                </strong>
            </div>

            <div class="decisao {{ $previsaoFechamentoHistorico >= 0 ? 'status-ok' : 'status-risk' }}">
                <strong>
                    {{ $previsaoFechamentoHistorico >= 0 ? 'Sobra projetada no fechamento' : 'Falta projetada no fechamento' }}
                </strong>

                @if($previsaoFechamentoHistorico >= 0)
                    Após quitar as contas em aberto e considerar a média de saídas do mês anterior para os dias restantes, o período ainda tende a fechar positivo.
                @else
                    Após quitar as contas em aberto e considerar a média de saídas do mês anterior para os dias restantes, o período tende a fechar negativo.
                @endif
            </div>
        </div>

        <div class="panel">
            <h2>Média Diária x Meta Diária</h2>
            <p class="sub">Comparação entre o ritmo atual de entrada e a necessidade mínima diária</p>

            <canvas id="graficoMetaDiaria"></canvas>
        </div>
    </div>

</div>

<script>
    const moedaFormatada = (valor) => {
        return Number(valor).toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        });
    };

    new Chart(document.getElementById('graficoFechamento'), {
        type: 'bar',
        data: {
            labels: [
                'Recebimento Projetado',
                'Despesas Previstas',
                'Reposição Estimada',
                'Resultado Final'
            ],
            datasets: [{
                label: 'Valores',
                data: [
                    {{ $recebimentoProjetado }},
                    {{ $despesasPrevistas }},
                    {{ $reposicaoEstimada }},
                    {{ $resultadoComReposicao }}
                ],
                backgroundColor: [
                    '#10b981',
                    '#ef4444',
                    '#f59e0b',
                    '{{ $resultadoComReposicao >= 0 ? '#3b82f6' : '#ef4444' }}'
                ],
                borderRadius: 8
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return moedaFormatada(context.raw);
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: { color: '#94a3b8' },
                    grid: { color: 'rgba(148,163,184,0.08)' }
                },
                y: {
                    ticks: {
                        color: '#94a3b8',
                        callback: function(value) {
                            return moedaFormatada(value);
                        }
                    },
                    grid: { color: 'rgba(148,163,184,0.08)' }
                }
            }
        }
    });

    new Chart(document.getElementById('graficoReposicaoComprar'), {
        type: 'bar',
        data: {
            labels: ['Gás', 'Água'],
            datasets: [
                {
                    label: 'Necessidade prevista',
                    data: [
                        {{ (int) ($saldoReposicaoAComprar['gas']['necessidade_prevista'] ?? 0) }},
                        {{ (int) ($saldoReposicaoAComprar['agua']['necessidade_prevista'] ?? 0) }}
                    ],
                    backgroundColor: '#3b82f6',
                    borderRadius: 8
                },
                {
                    label: 'Estoque atual',
                    data: [
                        {{ (int) ($saldoReposicaoAComprar['gas']['estoque_atual'] ?? 0) }},
                        {{ (int) ($saldoReposicaoAComprar['agua']['estoque_atual'] ?? 0) }}
                    ],
                    backgroundColor: '#10b981',
                    borderRadius: 8
                },
                {
                    label: 'Saldo a comprar',
                    data: [
                        {{ (int) ($saldoReposicaoAComprar['gas']['quantidade_a_comprar'] ?? 0) }},
                        {{ (int) ($saldoReposicaoAComprar['agua']['quantidade_a_comprar'] ?? 0) }}
                    ],
                    backgroundColor: '#f59e0b',
                    borderRadius: 8
                }
            ]
        },
        options: {
            plugins: {
                legend: {
                    labels: { color: '#94a3b8' }
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

    new Chart(document.getElementById('graficoMetaDiaria'), {
        type: 'bar',
        data: {
            labels: [
                'Média Diária Recebida',
                'Meta Diária Contas em Aberto'
            ],
            datasets: [{
                label: 'Valores por dia',
                data: [
                    {{ $mediaDiariaRecebimento }},
                    {{ $metaDiariaContasAberto }}
                ],
                backgroundColor: [
                    '#10b981',
                    '#f59e0b'
                ],
                borderRadius: 8
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return moedaFormatada(context.raw);
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: { color: '#94a3b8' },
                    grid: { color: 'rgba(148,163,184,0.08)' }
                },
                y: {
                    ticks: {
                        color: '#94a3b8',
                        callback: function(value) {
                            return moedaFormatada(value);
                        }
                    },
                    grid: { color: 'rgba(148,163,184,0.08)' }
                }
            }
        }
    });
</script>

</body>
</html>
