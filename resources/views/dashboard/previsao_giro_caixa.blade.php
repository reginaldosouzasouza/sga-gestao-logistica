@extends('layouts.app')

@section('title', 'Previsão de Giro e Caixa')

@section('content')

<style>
    .giro-caixa-page {
        padding: 24px;
        background: #f5f7fb;
        min-height: 100vh;
    }

    .giro-caixa-page h1 {
        font-weight: 800;
        margin-bottom: 6px;
        color: #111827;
    }

    .subtitulo {
        color: #64748b;
        margin-bottom: 22px;
    }

    .filtros {
        display: flex;
        gap: 12px;
        align-items: end;
        margin-bottom: 22px;
        flex-wrap: wrap;
    }

    .filtros label {
        font-weight: 700;
        font-size: 13px;
        color: #334155;
        display: block;
        margin-bottom: 5px;
    }

    .filtros input {
        padding: 9px 10px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
    }

    .btn-filtrar {
        background: #2563eb;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 10px 16px;
        font-weight: 700;
        cursor: pointer;
    }

    .cards-resumo {
        display: grid;
        grid-template-columns: repeat(3, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .card {
        background: white;
        border-radius: 14px;
        padding: 18px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    .card .label {
        color: #64748b;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .card .valor {
        font-size: 28px;
        font-weight: 800;
        color: #111827;
    }

    .positivo {
        color: #059669 !important;
    }

    .negativo {
        color: #dc2626 !important;
    }

    .alerta-box {
        background: #fff7ed;
        border: 1px solid #fed7aa;
        border-left: 5px solid #f97316;
        color: #7c2d12;
        padding: 14px 16px;
        border-radius: 10px;
        margin-bottom: 24px;
        line-height: 1.5;
    }

    .produto-card {
        background: white;
        border-radius: 14px;
        padding: 18px;
        margin-bottom: 16px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    .produto-card h2 {
        margin-bottom: 14px;
        color: #111827;
    }

    .grid-produto {
        display: grid;
        grid-template-columns: repeat(4, minmax(160px, 1fr));
        gap: 14px;
    }

    .item-info span {
        color: #64748b;
        font-size: 13px;
    }

    .item-info strong {
        display: block;
        font-size: 19px;
        color: #111827;
        margin-top: 3px;
    }

    .ajustes {
        margin-top: 14px;
        background: #f8fafc;
        border-radius: 10px;
        padding: 12px;
    }


    .tooltip-label {
    position: relative;
    cursor: help;
    display: inline-block;
    color: #475569;
    font-size: 13px;
}

.tooltip-label .tooltip-text {
    visibility: hidden;
    opacity: 0;
    transition: opacity 0.2s ease;
    width: 320px;
    background: #111827;
    color: #ffffff;
    text-align: left;
    border-radius: 8px;
    padding: 10px 12px;
    position: absolute;
    z-index: 9999;
    bottom: 130%;
    left: 0;
    font-size: 12px;
    line-height: 1.4;
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
}

.tooltip-label:hover .tooltip-text {
    visibility: visible;
    opacity: 1;
}

    @media (max-width: 900px) {
        .cards-resumo,
        .grid-produto {
            grid-template-columns: repeat(2, minmax(160px, 1fr));
        }
    }

    @media (max-width: 600px) {
        .cards-resumo,
        .grid-produto {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="giro-caixa-page">

    <h1>Previsão de Giro e Caixa</h1>
    <p class="subtitulo">
        Relatório integrado de venda prevista, reposição recomendada e impacto financeiro.
    </p>

    <form method="GET" action="{{ route('dashboard.previsao-giro-caixa') }}" class="filtros">
        <div>
            <label>Data Inicial</label>
            <input type="date" name="data_inicio" value="{{ $dataInicio }}">
        </div>

        <div>
            <label>Data Final</label>
            <input type="date" name="data_fim" value="{{ $dataFim }}">
        </div>

        <button type="submit" class="btn-filtrar">Filtrar</button>
    </form>

    <div class="alerta-box">
        <strong>Leitura gerencial:</strong>
        este relatório separa o que é previsão de venda, necessidade de compra e impacto no caixa.
        Se a compra for paga depois do período filtrado, ela deve ser tratada como compromisso futuro, não como saída imediata.
    </div>

    <div class="cards-resumo">
        <div class="card">
            <div class="label">Recebimento Projetado Restante</div>
            <div class="valor">
                R$ {{ number_format($recebimentoProjetadoRestante, 2, ',', '.') }}
            </div>
        </div>

        <div class="card">
            <div class="label">Contas a Pagar até o Final</div>
            <div class="valor negativo">
                R$ {{ number_format($contasPagarAberto, 2, ',', '.') }}
            </div>
        </div>

        <div class="card">
            <div class="label">Resultado sem Reposição</div>
            <div class="valor {{ $resultadoSemReposicao >= 0 ? 'positivo' : 'negativo' }}">
                R$ {{ number_format($resultadoSemReposicao, 2, ',', '.') }}
            </div>
        </div>

        <div class="card">
            <div class="label">Compra Mínima Prevista</div>
            <div class="valor">
                R$ {{ number_format($totalCompraMinima, 2, ',', '.') }}
            </div>
        </div>

          <div class="card">
            <div class="label">Resultado com Compra Mínima</div>
            <div class="valor {{ $resultadoComCompraMinima >= 0 ? 'positivo' : 'negativo' }}">
                R$ {{ number_format($resultadoComCompraMinima, 2, ',', '.') }}
            </div>
        </div>

        <div class="card">
            <div class="label">Compra Recomendada</div>
            <div class="valor">
                R$ {{ number_format($totalCompraRecomendada, 2, ',', '.') }}
            </div>
        </div>
       

        <div class="card">
            <div class="label">Resultado com Compra Recomendada</div>
            <div class="valor {{ $resultadoComCompraRecomendada >= 0 ? 'positivo' : 'negativo' }}">
                R$ {{ number_format($resultadoComCompraRecomendada, 2, ',', '.') }}
            </div>
        </div>


       

    </div>

    <h2 style="margin-bottom: 14px;">Produtos e Reposição Recomendada</h2>

    @foreach($previsoesProdutos as $item)
        <div class="produto-card">
            <h2>{{ $item['produto'] }}</h2>

            <div class="grid-produto">
                <div class="item-info">
                    <span>Estoque atual</span>
                    <strong>{{ number_format($item['estoque'], 0, ',', '.') }} un</strong>
                </div>

                <div class="item-info">
                    <span>Vendido no período</span>
                    <strong>{{ number_format($item['vendido_periodo'], 0, ',', '.') }} un</strong>
                </div>

                <div class="item-info">
                    <span>Dias restantes até o fechamento</span>
                    <strong>{{ number_format($diasRestantesAteFim, 0, ',', '.') }} dias</strong>
                </div>

                <div class="item-info">
                    <span class="tooltip-label">
                        Venda prevista até o fechamento ⓘ
                        <span class="tooltip-text">
                            Estimativa de venda até a data final do filtro.
                            O sistema calcula: base de cálculo e multiplicada pelos dias restantes
                            até o fechamento.
                        </span>
                    </span>
                    <strong>{{ number_format($item['venda_prevista'], 2, ',', '.') }} un</strong>
                </div>

                <div class="item-info">
                    <span class="tooltip-label">
                        Compra mínima até o fechamento ⓘ
                        <span class="tooltip-text">
                            Quantidade mínima sugerida para atender a venda prevista até o fechamento,
                            O sistema calcula: Base de cálculo multiplacado pelo dias restantes - Estoque atual
                        </span>
                    </span>
                    <strong>{{ number_format($item['compra_minima'], 0, ',', '.') }} un</strong>
                </div>

                <div class="item-info">
                    <span class="tooltip-label">
                        Compra recomendada até o fechamento ⓘ
                        <span class="tooltip-text">
                            Quantidade sugerida para cobrir a venda prevista até o fechamento do período,
                            Média de 1 dia a mais.
                            O sistema calcula Compra mínima até o fechamento + base de cáculo.
                        </span>
                    </span>
                    <strong>{{ number_format($item['compra_recomendada'], 0, ',', '.') }} un</strong>
                </div>

                <div class="item-info">
                    <span>Custo da compra recomendada</span>
                    <strong>R$ {{ number_format($item['custo_compra_recomendada'], 2, ',', '.') }}</strong>
                </div>

                <div class="item-info">
                    <span class="tooltip-label">
                        Base do cálculo ⓘ
                        <span class="tooltip-text">
                            A média base vem das vendas reais do período filtrado.
                            A média ajustada aplica as regras configuradas, como sazonalidade,
                            fim de mês e outros parâmetros da previsão.
                        </span>
                    </span>
                    <strong>
                        {{ number_format($item['media_base'], 2, ',', '.') }} → 
                        {{ number_format($item['media_ajustada'], 2, ',', '.') }} un/dia
                    </strong>
                </div>
            </div>

            <div class="ajustes">
                <strong>Ajustes aplicados:</strong>

                @if(!empty($item['ajustes_aplicados']))
                    <ul style="margin-top: 8px;">
                        @foreach($item['ajustes_aplicados'] as $ajuste)
                            <li>
                                {{ $ajuste['tipo'] }}
                                @if(isset($ajuste['percentual']) && $ajuste['percentual'] !== null)
                                    ({{ number_format($ajuste['percentual'], 2, ',', '.') }}%)
                                @endif
                                - {{ $ajuste['descricao'] ?? '' }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p style="margin-top: 8px;">Nenhum ajuste aplicado.</p>
                @endif
            </div>
        </div>
    @endforeach

    
          