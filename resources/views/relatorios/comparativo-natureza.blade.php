@extends('layouts.app')

@section('title', 'Comparativo Mensal por Natureza')

@section('content')

<style>
    .comparativo-container {
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

    .btn-filtrar:hover {
        background: #1d4ed8;
    }

    .cards-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
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
        font-size: 23px;
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

    .card-laranja {
        background: #f97316;
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
        font-size: 14px;
    }

    thead {
        background: #0d6efd;
        color: white;
    }

    th, td {
        padding: 12px 10px;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
    }

    th.valor,
    td.valor {
        text-align: right;
        white-space: nowrap;
    }

    tbody tr:hover {
        background: #f9fafb;
    }

    .badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
    }

    .badge-aumentou {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge-reduziu {
        background: #dcfce7;
        color: #166534;
    }

    .badge-estavel {
        background: #e5e7eb;
        color: #374151;
    }

    .valor-positivo {
        color: #dc2626;
        font-weight: 700;
    }

    .valor-negativo {
        color: #16a34a;
        font-weight: 700;
    }

    .valor-neutro {
        color: #374151;
        font-weight: 700;
    }

    .rodape-info {
        margin-top: 16px;
        color: #6b7280;
        font-size: 13px;
    }

    @media (max-width: 1100px) {
        .cards-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .filtros-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 700px) {
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
    function formatarMoedaComparativo($valor) {
        return 'R$ ' . number_format($valor ?? 0, 2, ',', '.');
    }

    function formatarPercentualComparativo($valor) {
        return number_format($valor ?? 0, 2, ',', '.') . '%';
    }

    $classeDiferencaGeral = $diferencaGeral > 0 ? 'card-vermelho' : ($diferencaGeral < 0 ? 'card-verde' : 'card-cinza');
    $textoDiferencaGeral = $diferencaGeral > 0 ? 'Aumento de despesas' : ($diferencaGeral < 0 ? 'Redução de despesas' : 'Sem variação');
@endphp

<div class="comparativo-container">

    <h1 class="titulo-pagina">📊 Comparativo Mensal por Natureza Financeira</h1>

    <div class="filtros-card">
        <form method="GET" action="{{ route('relatorios.comparativo-natureza') }}">
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
                    <input type="number"
                           name="ano_base"
                           class="form-control"
                           value="{{ $anoBase }}">
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
                    <input type="number"
                           name="ano_comparacao"
                           class="form-control"
                           value="{{ $anoComparacao }}">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-filtrar">
                        🔍 Comparar
                    </button>
                </div>

            </div>
        </form>
    </div>

    <div class="cards-grid">

        <div class="card-info card-azul">
            <small>Total Mês Base</small>
            <strong>{{ formatarMoedaComparativo($totalBase) }}</strong>
            <small>{{ str_pad($mesBase, 2, '0', STR_PAD_LEFT) }}/{{ $anoBase }}</small>
        </div>

        <div class="card-info card-azul">
            <small>Total Mês Comparação</small>
            <strong>{{ formatarMoedaComparativo($totalComparacao) }}</strong>
            <small>{{ str_pad($mesComparacao, 2, '0', STR_PAD_LEFT) }}/{{ $anoComparacao }}</small>
        </div>

        <div class="card-info {{ $classeDiferencaGeral }}">
            <small>{{ $textoDiferencaGeral }}</small>
            <strong>{{ formatarMoedaComparativo(abs($diferencaGeral)) }}</strong>
            <small>
                @if($totalBase > 0)
                    {{ formatarPercentualComparativo(($diferencaGeral / $totalBase) * 100) }}
                @else
                    0,00%
                @endif
            </small>
        </div>

        <div class="card-info card-vermelho">
            <small>Maior Aumento</small>
            <strong style="font-size: 17px;">
                {{ $maiorAumento['natureza'] ?? 'Nenhum' }}
            </strong>
            <small>
                {{ isset($maiorAumento['diferenca']) ? formatarMoedaComparativo($maiorAumento['diferenca']) : 'R$ 0,00' }}
            </small>
        </div>

        <div class="card-info card-verde">
            <small>Maior Redução</small>
            <strong style="font-size: 17px;">
                {{ $maiorReducao['natureza'] ?? 'Nenhuma' }}
            </strong>
            <small>
                {{ isset($maiorReducao['diferenca']) ? formatarMoedaComparativo(abs($maiorReducao['diferenca'])) : 'R$ 0,00' }}
            </small>
        </div>

    </div>

    <div class="analise-card">
        <h3>🧠 Análise automática</h3>

        @if($diferencaGeral > 0)
            <p>
                As despesas aumentaram em
                <strong>{{ formatarMoedaComparativo($diferencaGeral) }}</strong>
                no mês de comparação.
            </p>
        @elseif($diferencaGeral < 0)
            <p>
                As despesas reduziram em
                <strong>{{ formatarMoedaComparativo(abs($diferencaGeral)) }}</strong>
                no mês de comparação.
            </p>
        @else
            <p>As despesas ficaram estáveis entre os dois meses.</p>
        @endif

        @if($maiorAumento)
            <p>
                O maior ponto de atenção foi
                <strong>{{ $maiorAumento['natureza'] }}</strong>,
                com aumento de
                <strong>{{ formatarMoedaComparativo($maiorAumento['diferenca']) }}</strong>.
            </p>
        @endif

        @if($maiorReducao)
            <p>
                A maior redução ocorreu em
                <strong>{{ $maiorReducao['natureza'] }}</strong>,
                com queda de
                <strong>{{ formatarMoedaComparativo(abs($maiorReducao['diferenca'])) }}</strong>.
            </p>
        @endif
    </div>

    <div class="tabela-card">
        <table>
            <thead>
                <tr>
                    <th>Natureza Financeira</th>
                    <th class="valor">Mês Base</th>
                    <th class="valor">Mês Comparação</th>
                    <th class="valor">Diferença R$</th>
                    <th class="valor">Diferença %</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($linhas as $linha)
                    @php
                        $classeStatus = 'badge-estavel';
                        $classeValor = 'valor-neutro';

                        if ($linha['diferenca'] > 0) {
                            $classeStatus = 'badge-aumentou';
                            $classeValor = 'valor-positivo';
                        } elseif ($linha['diferenca'] < 0) {
                            $classeStatus = 'badge-reduziu';
                            $classeValor = 'valor-negativo';
                        }
                    @endphp

                    <tr>
                        <td>
                            <strong>{{ $linha['natureza'] }}</strong>
                        </td>

                        <td class="valor">
                            {{ formatarMoedaComparativo($linha['valor_base']) }}
                        </td>

                        <td class="valor">
                            {{ formatarMoedaComparativo($linha['valor_comparacao']) }}
                        </td>

                        <td class="valor {{ $classeValor }}">
                            @if($linha['diferenca'] > 0)
                                + {{ formatarMoedaComparativo($linha['diferenca']) }}
                            @elseif($linha['diferenca'] < 0)
                                - {{ formatarMoedaComparativo(abs($linha['diferenca'])) }}
                            @else
                                {{ formatarMoedaComparativo(0) }}
                            @endif
                        </td>

                        <td class="valor {{ $classeValor }}">
                            @if($linha['percentual'] > 0)
                                + {{ formatarPercentualComparativo($linha['percentual']) }}
                            @elseif($linha['percentual'] < 0)
                                - {{ formatarPercentualComparativo(abs($linha['percentual'])) }}
                            @else
                                {{ formatarPercentualComparativo(0) }}
                            @endif
                        </td>

                        <td>
                            <span class="badge {{ $classeStatus }}">
                                {{ $linha['status'] }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px;">
                            Nenhum dado encontrado para comparação.
                        </td>
                    </tr>
                @endforelse
            </tbody>

            <tfoot>
                <tr style="font-weight: 700; background: #f3f4f6;">
                    <td>Total Geral</td>
                    <td class="valor">{{ formatarMoedaComparativo($totalBase) }}</td>
                    <td class="valor">{{ formatarMoedaComparativo($totalComparacao) }}</td>
                    <td class="valor">
                        @if($diferencaGeral > 0)
                            + {{ formatarMoedaComparativo($diferencaGeral) }}
                        @elseif($diferencaGeral < 0)
                            - {{ formatarMoedaComparativo(abs($diferencaGeral)) }}
                        @else
                            {{ formatarMoedaComparativo(0) }}
                        @endif
                    </td>
                    <td class="valor">
                        @if($totalBase > 0)
                            {{ formatarPercentualComparativo(($diferencaGeral / $totalBase) * 100) }}
                        @else
                            0,00%
                        @endif
                    </td>
                    <td>-</td>
                </tr>
            </tfoot>
        </table>

        <div class="rodape-info">
            Base de cálculo: saídas reais das tabelas <strong>caixa</strong> e <strong>caixa_banco</strong>,
            vinculadas às contas a pagar e classificadas pela natureza financeira do fornecedor.
        </div>
    </div>

</div>

@endsection