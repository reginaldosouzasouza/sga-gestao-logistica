@extends('layouts.app')

@section('title', 'Comparativo Mensal de Fluxo de Caixa')

@section('content')

<style>
    .fluxo-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    .titulo-pagina {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
    }

    .filtros-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .filtros-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 15px;
        align-items: end;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
        color: #374151;
    }

    .form-control {
        width: 100%;
        padding: 9px 10px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
    }

    .btn-filtrar {
        background: #2563eb;
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
    }

    .cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .card-info {
        border-radius: 12px;
        padding: 18px;
        color: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.10);
        min-height: 105px;
    }

    .card-info small {
        display: block;
        font-size: 13px;
        opacity: 0.95;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .card-info strong {
        font-size: 25px;
        display: block;
    }

    .card-azul {
        background: #2563eb;
    }

    .card-verde {
        background: #16a34a;
    }

    .card-vermelho {
        background: #dc2626;
    }

    .card-cinza {
        background: #374151;
    }

    .analise-card {
        background: #fff7ed;
        border-left: 5px solid #f97316;
        border-radius: 10px;
        padding: 16px 20px;
        margin-bottom: 24px;
        color: #7c2d12;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .analise-card h3 {
        margin: 0 0 8px 0;
        font-size: 18px;
    }

    .analise-card p {
        margin: 4px 0;
        font-size: 15px;
    }

    .tabela-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 18px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 15px;
    }

    thead {
        background: #0d6efd;
        color: white;
    }

    th, td {
        padding: 13px 10px;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
    }

    th.valor,
    td.valor {
        text-align: right;
        white-space: nowrap;
    }

    .positivo {
        color: #16a34a;
        font-weight: 700;
    }

    .negativo {
        color: #dc2626;
        font-weight: 700;
    }

    .neutro {
        color: #374151;
        font-weight: 700;
    }

    @media (max-width: 900px) {
        .cards-grid,
        .filtros-grid {
            grid-template-columns: 1fr;
        }

        .titulo-pagina {
            font-size: 23px;
        }
    }
</style>

@php
    $moeda = function($valor) {
        return 'R$ ' . number_format($valor ?? 0, 2, ',', '.');
    };

    $percentual = function($valorBase, $valorComparacao) {
        if ($valorBase == 0) {
            return $valorComparacao > 0 ? '100,00%' : '0,00%';
        }

        return number_format((($valorComparacao - $valorBase) / $valorBase) * 100, 2, ',', '.') . '%';
    };

    $classeResultadoBase = $base['resultado'] >= 0 ? 'card-verde' : 'card-vermelho';
    $classeResultadoComparacao = $comparacao['resultado'] >= 0 ? 'card-verde' : 'card-vermelho';
    $classeDiferencaResultado = $diferencaResultado >= 0 ? 'card-verde' : 'card-vermelho';

    $classeTexto = function($valor) {
        if ($valor > 0) return 'positivo';
        if ($valor < 0) return 'negativo';
        return 'neutro';
    };
@endphp

<div class="fluxo-container">

    <h1 class="titulo-pagina">💰 Comparativo Mensal de Fluxo de Caixa</h1>

    <div class="filtros-card">
        <form method="GET" action="{{ route('relatorios.comparativo-fluxo') }}">
            <div class="filtros-grid">

                <div class="form-group">
                    <label>Mês Base</label>
                    <select name="mes_base" class="form-control">
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ (int)$mesBase === $m ? 'selected' : '' }}>
                                {{ str_pad($m, 2, '0', STR_PAD_LEFT) }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="form-group">
                    <label>Ano Base</label>
                    <input type="number" name="ano_base" class="form-control" value="{{ $anoBase }}">
                </div>

                <div class="form-group">
                    <label>Mês Comparação</label>
                    <select name="mes_comparacao" class="form-control">
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ (int)$mesComparacao === $m ? 'selected' : '' }}>
                                {{ str_pad($m, 2, '0', STR_PAD_LEFT) }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="form-group">
                    <label>Ano Comparação</label>
                    <input type="number" name="ano_comparacao" class="form-control" value="{{ $anoComparacao }}">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-filtrar">🔍 Comparar</button>
                </div>

            </div>
        </form>
    </div>

    <div class="cards-grid">

        <div class="card-info {{ $classeResultadoBase }}">
            <small>Resultado Mês Base</small>
            <strong>{{ $moeda($base['resultado']) }}</strong>
            <small>{{ str_pad($mesBase, 2, '0', STR_PAD_LEFT) }}/{{ $anoBase }}</small>
        </div>

        <div class="card-info {{ $classeResultadoComparacao }}">
            <small>Resultado Mês Comparação</small>
            <strong>{{ $moeda($comparacao['resultado']) }}</strong>
            <small>{{ str_pad($mesComparacao, 2, '0', STR_PAD_LEFT) }}/{{ $anoComparacao }}</small>
        </div>

        <div class="card-info {{ $classeDiferencaResultado }}">
            <small>Variação do Resultado</small>
            <strong>{{ $moeda($diferencaResultado) }}</strong>
            <small>
                @if($diferencaResultado >= 0)
                    Melhorou
                @else
                    Piorou
                @endif
            </small>
        </div>

    </div>

    <div class="analise-card">
        <h3>🧠 Análise automática</h3>

        @if($comparacao['resultado'] >= 0)
            <p>
                O mês de comparação fechou positivo em
                <strong>{{ $moeda($comparacao['resultado']) }}</strong>.
            </p>
        @else
            <p>
                O mês de comparação fechou negativo em
                <strong>{{ $moeda(abs($comparacao['resultado'])) }}</strong>.
            </p>
        @endif

        @if($diferencaEntradas < 0)
            <p>
                As entradas caíram
                <strong>{{ $moeda(abs($diferencaEntradas)) }}</strong>
                em relação ao mês base.
            </p>
        @elseif($diferencaEntradas > 0)
            <p>
                As entradas aumentaram
                <strong>{{ $moeda($diferencaEntradas) }}</strong>
                em relação ao mês base.
            </p>
        @else
            <p>As entradas ficaram iguais entre os dois meses.</p>
        @endif

        @if($diferencaSaidas < 0)
            <p>
                As saídas reduziram
                <strong>{{ $moeda(abs($diferencaSaidas)) }}</strong>.
            </p>
        @elseif($diferencaSaidas > 0)
            <p>
                As saídas aumentaram
                <strong>{{ $moeda($diferencaSaidas) }}</strong>.
            </p>
        @else
            <p>As saídas ficaram iguais entre os dois meses.</p>
        @endif

        @if($diferencaEntradas < 0 && abs($diferencaEntradas) > abs($diferencaSaidas))
            <p>
                <strong>Leitura crítica:</strong>
                mesmo que as despesas tenham reduzido, a queda nas entradas foi maior. Por isso o caixa pode continuar negativo.
            </p>
        @elseif($diferencaSaidas > 0)
            <p>
                <strong>Leitura crítica:</strong>
                o caixa foi pressionado principalmente pelo aumento das saídas.
            </p>
        @else
            <p>
                <strong>Leitura crítica:</strong>
                houve melhora no controle de saídas, mas é necessário verificar se as entradas foram suficientes para sustentar o mês.
            </p>
        @endif
    </div>

    <div class="tabela-card">
        <table>
            <thead>
                <tr>
                    <th>Indicador</th>
                    <th class="valor">Mês Base</th>
                    <th class="valor">Mês Comparação</th>
                    <th class="valor">Diferença R$</th>
                    <th class="valor">Diferença %</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td><strong>Entradas</strong></td>
                    <td class="valor">{{ $moeda($base['entradas']) }}</td>
                    <td class="valor">{{ $moeda($comparacao['entradas']) }}</td>
                    <td class="valor {{ $classeTexto($diferencaEntradas) }}">
                        {{ $diferencaEntradas >= 0 ? '+' : '-' }}
                        {{ $moeda(abs($diferencaEntradas)) }}
                    </td>
                    <td class="valor {{ $classeTexto($diferencaEntradas) }}">
                        {{ $percentual($base['entradas'], $comparacao['entradas']) }}
                    </td>
                </tr>

                <tr>
                    <td><strong>Saídas</strong></td>
                    <td class="valor">{{ $moeda($base['saidas']) }}</td>
                    <td class="valor">{{ $moeda($comparacao['saidas']) }}</td>
                    <td class="valor {{ $diferencaSaidas > 0 ? 'negativo' : ($diferencaSaidas < 0 ? 'positivo' : 'neutro') }}">
                        {{ $diferencaSaidas >= 0 ? '+' : '-' }}
                        {{ $moeda(abs($diferencaSaidas)) }}
                    </td>
                    <td class="valor {{ $diferencaSaidas > 0 ? 'negativo' : ($diferencaSaidas < 0 ? 'positivo' : 'neutro') }}">
                        {{ $percentual($base['saidas'], $comparacao['saidas']) }}
                    </td>
                </tr>

                <tr style="background: #f3f4f6;">
                    <td><strong>Resultado</strong></td>
                    <td class="valor {{ $classeTexto($base['resultado']) }}">{{ $moeda($base['resultado']) }}</td>
                    <td class="valor {{ $classeTexto($comparacao['resultado']) }}">{{ $moeda($comparacao['resultado']) }}</td>
                    <td class="valor {{ $classeTexto($diferencaResultado) }}">
                        {{ $diferencaResultado >= 0 ? '+' : '-' }}
                        {{ $moeda(abs($diferencaResultado)) }}
                    </td>
                    <td class="valor {{ $classeTexto($diferencaResultado) }}">
                        {{ $percentual($base['resultado'], $comparacao['resultado']) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

@endsection