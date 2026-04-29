@extends('layouts.app')

@section('title', 'Relatório por Natureza Financeira')

@section('content')
<div style="max-width:1300px; margin:30px auto; padding:0 20px;">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:10px;">
        <h2 style="margin:0;">📊 Despesas por Natureza Financeira</h2>

        <button onclick="window.print()"
            style="background:#1e293b; color:#fff; border:none; padding:9px 20px; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer;">
            🖨️ Imprimir
        </button>
    </div>

    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:20px; margin-bottom:24px;">
        <form method="GET" action="{{ route('relatorios.natureza-financeira') }}">

            <div style="display:flex; gap:8px; margin-bottom:16px;">
                <button type="button" onclick="trocarFiltro('periodo')" id="btn-periodo"
                    style="padding:7px 18px; border-radius:6px; border:none; font-weight:600; font-size:13px; cursor:pointer;
                    background:{{ $filtroTipo === 'periodo' ? '#1e293b' : '#e2e8f0' }};
                    color:{{ $filtroTipo === 'periodo' ? '#fff' : '#374151' }};">
                    📅 Por Período
                </button>

                <button type="button" onclick="trocarFiltro('mes')" id="btn-mes"
                    style="padding:7px 18px; border-radius:6px; border:none; font-weight:600; font-size:13px; cursor:pointer;
                    background:{{ $filtroTipo === 'mes' ? '#1e293b' : '#e2e8f0' }};
                    color:{{ $filtroTipo === 'mes' ? '#fff' : '#374151' }};">
                    🗓️ Por Mês
                </button>
            </div>

            <input type="hidden" name="filtro_tipo" id="filtro_tipo" value="{{ $filtroTipo }}">

            <div style="display:flex; gap:14px; flex-wrap:wrap; align-items:flex-end;">

                <div id="filtro-periodo" style="display:{{ $filtroTipo === 'periodo' ? 'flex' : 'none' }}; gap:10px; flex-wrap:wrap;">
                    <div>
                        <label style="font-size:12px; color:#6b7280; display:block; margin-bottom:3px;">Data Início</label>
                        <input type="date" name="data_inicio" value="{{ request('data_inicio', $inicio->format('Y-m-d')) }}"
                            style="padding:8px 12px; border:1px solid #cbd5e1; border-radius:6px;">
                    </div>

                    <div>
                        <label style="font-size:12px; color:#6b7280; display:block; margin-bottom:3px;">Data Fim</label>
                        <input type="date" name="data_fim" value="{{ request('data_fim', $fim->format('Y-m-d')) }}"
                            style="padding:8px 12px; border:1px solid #cbd5e1; border-radius:6px;">
                    </div>
                </div>

                <div id="filtro-mes" style="display:{{ $filtroTipo === 'mes' ? 'flex' : 'none' }}; gap:10px; flex-wrap:wrap;">
                    <div>
                        <label style="font-size:12px; color:#6b7280; display:block; margin-bottom:3px;">Mês</label>
                        <select name="mes" style="padding:8px 12px; border:1px solid #cbd5e1; border-radius:6px;">
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ (int) $mes === $m ? 'selected' : '' }}>
                                    {{ str_pad($m, 2, '0', STR_PAD_LEFT) }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label style="font-size:12px; color:#6b7280; display:block; margin-bottom:3px;">Ano</label>
                        <input type="number" name="ano" value="{{ $ano }}"
                            style="padding:8px 12px; border:1px solid #cbd5e1; border-radius:6px; width:100px;">
                    </div>
                </div>

                <div>
                    <label style="font-size:12px; color:#6b7280; display:block; margin-bottom:3px;">Natureza Financeira</label>
                    <select name="natureza_financeira" style="padding:8px 12px; border:1px solid #cbd5e1; border-radius:6px; min-width:190px;">
                        <option value="">Todas</option>
                        @foreach($naturezasDisponiveis as $natureza)
                            <option value="{{ $natureza }}" {{ $filtroNatureza === $natureza ? 'selected' : '' }}>
                                {{ ucfirst($natureza) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="font-size:12px; color:#6b7280; display:block; margin-bottom:3px;">Fornecedor</label>
                    <select name="fornecedor_id" style="padding:8px 12px; border:1px solid #cbd5e1; border-radius:6px; min-width:220px;">
                        <option value="">Todos</option>
                        @foreach($fornecedoresDisponiveis as $fornecedor)
                            <option value="{{ $fornecedor->id }}" {{ (string) $filtroFornecedor === (string) $fornecedor->id ? 'selected' : '' }}>
                                {{ $fornecedor->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="submit"
                        style="padding:8px 22px; background:#2563eb; color:#fff; border:none; border-radius:6px; font-size:13px; font-weight:600; cursor:pointer;">
                        🔍 Filtrar
                    </button>

                    <a href="{{ route('relatorios.natureza-financeira') }}"
                        style="margin-left:8px; font-size:12px; color:#6b7280;">
                        Limpar
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div style="text-align:center; margin-bottom:20px; color:#6b7280; font-size:13px;">
        Período:
        <strong>{{ $inicio->format('d/m/Y') }}</strong>
        até
        <strong>{{ $fim->format('d/m/Y') }}</strong>
    </div>

    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin-bottom:28px;">
        <div style="background:#fef2f2; border-radius:10px; padding:16px; border-left:5px solid #ef4444;">
            <div style="font-size:11px; color:#991b1b; font-weight:700; margin-bottom:6px;">💸 TOTAL DE DESPESAS</div>
            <div style="font-size:20px; font-weight:700; color:#dc2626;">
                R$ {{ number_format($totalGeral, 2, ',', '.') }}
            </div>
        </div>

        <div style="background:#eff6ff; border-radius:10px; padding:16px; border-left:5px solid #3b82f6;">
            <div style="font-size:11px; color:#1e40af; font-weight:700; margin-bottom:6px;">📂 NATUREZAS FINANCEIRAS</div>
            <div style="font-size:20px; font-weight:700; color:#1d4ed8;">
                {{ $totalNaturezas }}
            </div>
        </div>

        <div style="background:#f0fdf4; border-radius:10px; padding:16px; border-left:5px solid #22c55e;">
            <div style="font-size:11px; color:#166534; font-weight:700; margin-bottom:6px;">🏪 FORNECEDORES</div>
            <div style="font-size:20px; font-weight:700; color:#15803d;">
                {{ $totalFornecedores }}
            </div>
        </div>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:28px;">
        <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:18px;">
            <h3 style="margin-top:0; font-size:16px;">📊 Despesas por Natureza Financeira</h3>
            <canvas id="graficoNaturezas" height="170"></canvas>
        </div>

        <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:18px;">
            <h3 style="margin-top:0; font-size:16px;">🏪 Top 10 Fornecedores</h3>
            <canvas id="graficoFornecedores" height="170"></canvas>
        </div>
    </div>

    {{-- RESUMO PERCENTUAL POR NATUREZA --}}
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:18px; margin-bottom:28px;">
        <h3 style="margin-top:0; font-size:17px;">📌 Resumo percentual por Natureza Financeira</h3>

        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; font-size:13px; margin-bottom:18px;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th style="padding:10px; text-align:left; border-bottom:1px solid #e2e8f0;">Natureza</th>
                        <th style="padding:10px; text-align:center; border-bottom:1px solid #e2e8f0;">Qtd.</th>
                        <th style="padding:10px; text-align:right; border-bottom:1px solid #e2e8f0;">Total</th>
                        <th style="padding:10px; text-align:right; border-bottom:1px solid #e2e8f0;">%</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($agrupado as $grupo)
                        <tr>
                            <td style="padding:10px; border-bottom:1px solid #f1f5f9; font-weight:600;">
                                {{ ucfirst($grupo['natureza_financeira']) }}
                            </td>

                            <td style="padding:10px; text-align:center; border-bottom:1px solid #f1f5f9;">
                                {{ $grupo['quantidade'] }}
                            </td>

                            <td style="padding:10px; text-align:right; border-bottom:1px solid #f1f5f9; color:#dc2626; font-weight:700;">
                                R$ {{ number_format($grupo['total'], 2, ',', '.') }}
                            </td>

                            <td style="padding:10px; text-align:right; border-bottom:1px solid #f1f5f9; font-weight:700;">
                                {{ number_format($grupo['percentual'], 2, ',', '.') }}%
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding:20px; text-align:center; color:#64748b;">
                                Nenhuma natureza encontrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

                <tfoot>
                    <tr style="background:#fef2f2;">
                        <th colspan="2" style="padding:10px; text-align:left;">
                            Total Geral
                        </th>

                        <th style="padding:10px; text-align:right; color:#dc2626;">
                            R$ {{ number_format($totalGeral, 2, ',', '.') }}
                        </th>

                        <th style="padding:10px; text-align:right;">
                            {{ $totalGeral > 0 ? '100,00%' : '0,00%' }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>

        @foreach($agrupado as $grupo)
            <div style="margin-bottom:14px;">
                <div style="display:flex; justify-content:space-between; gap:10px; margin-bottom:5px;">
                    <strong>{{ ucfirst($grupo['natureza_financeira']) }}</strong>
                    <span>
                        {{ number_format($grupo['percentual'], 2, ',', '.') }}%
                        —
                        R$ {{ number_format($grupo['total'], 2, ',', '.') }}
                    </span>
                </div>

                <div style="height:18px; background:#e5e7eb; border-radius:999px; overflow:hidden;">
                    <div style="height:18px; width:{{ min($grupo['percentual'], 100) }}%; background:#2563eb;"></div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- DETALHAMENTO POR NATUREZA --}}
    @forelse($agrupado as $grupo)
        <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; margin-bottom:18px; overflow:hidden;">

            <div style="background:#1e293b; color:#fff; padding:13px 16px; display:flex; justify-content:space-between; gap:10px; flex-wrap:wrap;">
                <div style="font-weight:700;">
                    📂 {{ ucfirst($grupo['natureza_financeira']) }}
                    <span style="font-size:12px; font-weight:400; color:#cbd5e1;">
                        — {{ number_format($grupo['percentual'], 2, ',', '.') }}% do total
                    </span>
                </div>

                <div style="font-weight:700;">
                    Total: R$ {{ number_format($grupo['total'], 2, ',', '.') }}
                    — {{ $grupo['quantidade'] }} lançamento(s)
                </div>
            </div>

            <table style="width:100%; border-collapse:collapse; font-size:13px;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th style="padding:10px; text-align:left; border-bottom:1px solid #e2e8f0;">Fornecedor</th>
                        <th style="padding:10px; text-align:center; border-bottom:1px solid #e2e8f0;">Qtd.</th>
                        <th style="padding:10px; text-align:right; border-bottom:1px solid #e2e8f0;">Total Pago</th>
                        <th style="padding:10px; text-align:right; border-bottom:1px solid #e2e8f0;">% Geral</th>
                        <th style="padding:10px; text-align:right; border-bottom:1px solid #e2e8f0;">% na Natureza</th>
                        <th style="padding:10px; text-align:center; border-bottom:1px solid #e2e8f0;">Detalhes</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($grupo['fornecedores'] as $fornecedor)
                        @php
                            $idDetalhe = md5($grupo['natureza_financeira'] . $fornecedor['fornecedor']);
                        @endphp

                        <tr>
                            <td style="padding:10px; border-bottom:1px solid #f1f5f9;">
                                {{ $fornecedor['fornecedor'] }}
                            </td>

                            <td style="padding:10px; text-align:center; border-bottom:1px solid #f1f5f9;">
                                {{ $fornecedor['quantidade'] }}
                            </td>

                            <td style="padding:10px; text-align:right; border-bottom:1px solid #f1f5f9; color:#dc2626; font-weight:700;">
                                R$ {{ number_format($fornecedor['total'], 2, ',', '.') }}
                            </td>

                            <td style="padding:10px; text-align:right; border-bottom:1px solid #f1f5f9;">
                                {{ number_format($fornecedor['percentual_geral'], 2, ',', '.') }}%
                            </td>

                            <td style="padding:10px; text-align:right; border-bottom:1px solid #f1f5f9;">
                                {{ number_format($fornecedor['percentual_natureza'], 2, ',', '.') }}%
                            </td>

                            <td style="padding:10px; text-align:center; border-bottom:1px solid #f1f5f9;">
                                <button type="button"
                                    onclick="toggleDetalhes('{{ $idDetalhe }}')"
                                    style="background:#e2e8f0; border:none; border-radius:6px; padding:5px 10px; cursor:pointer; font-size:12px;">
                                    Ver lançamentos
                                </button>
                            </td>
                        </tr>

                        <tr id="detalhes-{{ $idDetalhe }}" style="display:none;">
                            <td colspan="6" style="padding:0; background:#f8fafc;">
                                <table style="width:100%; border-collapse:collapse; font-size:12px;">
                                    <thead>
                                        <tr style="background:#e2e8f0;">
                                            <th style="padding:8px; text-align:left;">Data Mov.</th>
                                            <th style="padding:8px; text-align:left;">Data Compra</th>
                                            <th style="padding:8px; text-align:left;">Meio</th>
                                            <th style="padding:8px; text-align:left;">Origem</th>
                                            <th style="padding:8px; text-align:left;">Descrição</th>
                                            <th style="padding:8px; text-align:right;">Valor</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($fornecedor['lancamentos'] as $lancamento)
                                            <tr>
                                                <td style="padding:8px; border-bottom:1px solid #e2e8f0;">
                                                    {{ $lancamento['data'] }}
                                                </td>

                                                <td style="padding:8px; border-bottom:1px solid #e2e8f0;">
                                                    {{ $lancamento['data_compra'] ?? '-' }}
                                                </td>

                                                <td style="padding:8px; border-bottom:1px solid #e2e8f0;">
                                                    {{ $lancamento['meio'] }}
                                                </td>

                                                <td style="padding:8px; border-bottom:1px solid #e2e8f0;">
                                                    {{ $lancamento['origem'] }}
                                                </td>

                                                <td style="padding:8px; border-bottom:1px solid #e2e8f0;">
                                                    {{ $lancamento['descricao'] }}
                                                </td>

                                                <td style="padding:8px; border-bottom:1px solid #e2e8f0; text-align:right; color:#dc2626; font-weight:600;">
                                                    R$ {{ number_format($lancamento['valor'], 2, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr style="background:#fef2f2;">
                        <td colspan="2" style="padding:10px; font-weight:700;">
                            Total da Natureza
                        </td>

                        <td style="padding:10px; text-align:right; font-weight:700; color:#dc2626;">
                            R$ {{ number_format($grupo['total'], 2, ',', '.') }}
                        </td>

                        <td style="padding:10px; text-align:right; font-weight:700;">
                            {{ number_format($grupo['percentual'], 2, ',', '.') }}%
                        </td>

                        <td style="padding:10px; text-align:right; font-weight:700;">
                            100,00%
                        </td>

                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @empty
        <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:30px; text-align:center; color:#64748b;">
            Nenhuma despesa encontrada para o período informado.
        </div>
    @endforelse

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const graficoNaturezas = @json($graficoNaturezas);
const graficoFornecedores = @json($graficoFornecedores);

new Chart(document.getElementById('graficoNaturezas'), {
    type: 'doughnut',
    data: {
        labels: graficoNaturezas.map(item => item.natureza + ' (' + item.percentual.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }) + '%)'),
        datasets: [{
            data: graficoNaturezas.map(item => item.total)
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const valor = context.raw || 0;
                        return context.label + ': R$ ' + valor.toLocaleString('pt-BR', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    }
                }
            }
        }
    }
});

new Chart(document.getElementById('graficoFornecedores'), {
    type: 'bar',
    data: {
        labels: graficoFornecedores.map(item => item.fornecedor),
        datasets: [{
            label: 'Total pago',
            data: graficoFornecedores.map(item => item.total)
        }]
    },
    options: {
        responsive: true,
        indexAxis: 'y',
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const valor = context.raw || 0;
                        return 'R$ ' + valor.toLocaleString('pt-BR', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    }
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    callback: function(value) {
                        return 'R$ ' + value.toLocaleString('pt-BR');
                    }
                }
            }
        }
    }
});

function trocarFiltro(tipo) {
    document.getElementById('filtro_tipo').value = tipo;

    document.getElementById('filtro-periodo').style.display = tipo === 'periodo' ? 'flex' : 'none';
    document.getElementById('filtro-mes').style.display = tipo === 'mes' ? 'flex' : 'none';

    document.getElementById('btn-periodo').style.background = tipo === 'periodo' ? '#1e293b' : '#e2e8f0';
    document.getElementById('btn-periodo').style.color = tipo === 'periodo' ? '#fff' : '#374151';

    document.getElementById('btn-mes').style.background = tipo === 'mes' ? '#1e293b' : '#e2e8f0';
    document.getElementById('btn-mes').style.color = tipo === 'mes' ? '#fff' : '#374151';
}

function toggleDetalhes(id) {
    const linha = document.getElementById('detalhes-' + id);

    if (linha.style.display === 'none') {
        linha.style.display = 'table-row';
    } else {
        linha.style.display = 'none';
    }
}
</script>

@push('styles')
<style>
@media print {
    form,
    button {
        display: none !important;
    }

    canvas {
        max-height: 260px !important;
    }

    body {
        background: #fff !important;
    }
}
</style>
@endpush

@endsection