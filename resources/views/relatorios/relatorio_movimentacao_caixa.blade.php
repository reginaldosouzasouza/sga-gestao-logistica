{{-- resources/views/relatorios/relatorio_movimentacao_caixa.blade.php --}}
@extends('layouts.app')

@section('title', 'Relatório de Movimentação do Caixa')

@section('content')
<div style="max-width:1300px; margin:30px auto; padding:0 20px;">

    {{-- Cabeçalho --}}
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:10px;">
        <h2 style="margin:0;">📊 Relatório de Movimentação do Caixa</h2>
        <div style="display:flex; gap:8px;">
            <a href="{{ route('relatorios.movimentacao.exportar', request()->query()) }}"
               style="background:#16a34a; color:#fff; border:none; padding:9px 20px; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; text-decoration:none;">
                📥 Exportar Excel
            </a>
            <button onclick="window.print()" style="background:#1e293b; color:#fff; border:none; padding:9px 20px; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer;">
                🖨️ Imprimir
            </button>
        </div>
    </div>

    {{-- ═══ FILTROS ═══ --}}
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:20px; margin-bottom:24px;">
        <form method="GET" action="{{ route('relatorios.movimentacao') }}">

            <div style="display:flex; gap:8px; margin-bottom:16px;">
                <button type="button" onclick="trocarFiltro('periodo')" id="btn-periodo"
                    style="padding:7px 18px; border-radius:6px; border:none; font-weight:600; font-size:13px; cursor:pointer;
                    background:{{ $filtroTipo==='periodo'?'#1e293b':'#e2e8f0' }};
                    color:{{ $filtroTipo==='periodo'?'#fff':'#374151' }};">
                    📅 Por Período
                </button>
                <button type="button" onclick="trocarFiltro('mes')" id="btn-mes"
                    style="padding:7px 18px; border-radius:6px; border:none; font-weight:600; font-size:13px; cursor:pointer;
                    background:{{ $filtroTipo==='mes'?'#1e293b':'#e2e8f0' }};
                    color:{{ $filtroTipo==='mes'?'#fff':'#374151' }};">
                    🗓️ Por Mês
                </button>
            </div>

            <input type="hidden" name="filtro_tipo" id="filtro_tipo" value="{{ $filtroTipo }}">

            <div style="display:flex; gap:14px; flex-wrap:wrap; align-items:flex-end;">

                {{-- Período --}}
                <div id="filtro-periodo" style="display:{{ $filtroTipo==='periodo'?'flex':'none' }}; gap:10px; align-items:flex-end; flex-wrap:wrap;">
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

                {{-- Mês --}}
                <div id="filtro-mes" style="display:{{ $filtroTipo==='mes'?'flex':'none' }}; gap:10px; align-items:flex-end; flex-wrap:wrap;">
                    <div>
                        <label style="font-size:12px; color:#6b7280; display:block; margin-bottom:3px;">Mês</label>
                        <select name="mes" style="padding:8px 12px; border:1px solid #cbd5e1; border-radius:6px;">
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ (int)$mes === $m ? 'selected' : '' }}>
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

                {{-- Origem --}}
                <div>
                    <label style="font-size:12px; color:#6b7280; display:block; margin-bottom:3px;">Origem</label>
                    <select name="origem" style="padding:8px 12px; border:1px solid #cbd5e1; border-radius:6px; min-width:130px;">
                        <option value="">Todas</option>
                        @foreach($origens as $origem)
                            <option value="{{ $origem }}" {{ $filtroOrigem === $origem ? 'selected' : '' }}>
                                {{ ucfirst($origem) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Forma de pagamento --}}
                <div>
                    <label style="font-size:12px; color:#6b7280; display:block; margin-bottom:3px;">Forma de Pgto</label>
                    <select name="forma_pagamento" style="padding:8px 12px; border:1px solid #cbd5e1; border-radius:6px; min-width:150px;">
                        <option value="">Todas</option>
                        @foreach($formasPagamento as $nome)
                            <option value="{{ $nome }}" {{ $filtroForma === $nome ? 'selected' : '' }}>
                                {{ $nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="submit" style="padding:8px 22px; background:#2563eb; color:#fff; border:none; border-radius:6px; font-size:13px; font-weight:600; cursor:pointer;">
                        🔍 Filtrar
                    </button>
                    <a href="{{ route('relatorios.movimentacao') }}" style="margin-left:8px; font-size:12px; color:#6b7280;">Limpar</a>
                </div>
            </div>
        </form>
    </div>

    {{-- Período --}}
    <div style="text-align:center; margin-bottom:20px; color:#6b7280; font-size:13px;">
        Período: <strong>{{ $inicio->format('d/m/Y') }}</strong> até <strong>{{ $fim->format('d/m/Y') }}</strong>
        — ordenado do mais recente ao mais antigo
    </div>

    {{-- ═══ CARDS ═══ --}}
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin-bottom:28px;">
        <div style="background:#dbeafe; border-radius:10px; padding:16px; border-left:5px solid #3b82f6;">
            <div style="font-size:11px; color:#1e40af; font-weight:700; margin-bottom:6px;">💵 ENTRADAS DINHEIRO</div>
            <div style="font-size:20px; font-weight:700; color:#1d4ed8;">R$ {{ number_format($totalDinheiro, 2, ',', '.') }}</div>
        </div>
        <div style="background:#f0fdf4; border-radius:10px; padding:16px; border-left:5px solid #22c55e;">
            <div style="font-size:11px; color:#166534; font-weight:700; margin-bottom:6px;">💳 ENTRADAS BANCO</div>
            <div style="font-size:20px; font-weight:700; color:#15803d;">R$ {{ number_format($totalPix, 2, ',', '.') }}</div>
        </div>
        <div style="background:#fef2f2; border-radius:10px; padding:16px; border-left:5px solid #ef4444;">
            <div style="font-size:11px; color:#991b1b; font-weight:700; margin-bottom:6px;">⬇ TOTAL SAÍDAS</div>
            <div style="font-size:20px; font-weight:700; color:#dc2626;">R$ {{ number_format($totalSaidas, 2, ',', '.') }}</div>
        </div>
        <div style="background:{{ $saldoGeral>=0?'#eff6ff':'#fef2f2' }}; border-radius:10px; padding:16px; border-left:5px solid {{ $saldoGeral>=0?'#3b82f6':'#ef4444' }};">
            <div style="font-size:11px; color:{{ $saldoGeral>=0?'#1e40af':'#991b1b' }}; font-weight:700; margin-bottom:6px;">💰 SALDO DO PERÍODO</div>
            <div style="font-size:20px; font-weight:700; color:{{ $saldoGeral>=0?'#1d4ed8':'#dc2626' }};">R$ {{ number_format($saldoGeral, 2, ',', '.') }}</div>
        </div>
    </div>

    {{-- ═══ ABAS ═══ --}}
    <div style="display:flex; gap:4px; margin-bottom:0;">
        <button onclick="abrirAba('aba-entradas')" id="btn-aba-entradas"
            style="padding:10px 22px; border:1px solid #e2e8f0; border-bottom:none; border-radius:8px 8px 0 0; font-weight:600; font-size:13px; cursor:pointer; background:#16a34a; color:#fff;">
            ⬆ Entradas ({{ count($entradas) }})
        </button>
        <button onclick="abrirAba('aba-saidas')" id="btn-aba-saidas"
            style="padding:10px 22px; border:1px solid #e2e8f0; border-bottom:none; border-radius:8px 8px 0 0; font-weight:600; font-size:13px; cursor:pointer; background:#f1f5f9; color:#374151;">
            ⬇ Saídas ({{ count($saidas) }})
        </button>
        <button onclick="abrirAba('aba-todos')" id="btn-aba-todos"
            style="padding:10px 22px; border:1px solid #e2e8f0; border-bottom:none; border-radius:8px 8px 0 0; font-weight:600; font-size:13px; cursor:pointer; background:#f1f5f9; color:#374151;">
            📋 Todos ({{ count($todos) }})
        </button>
    </div>

    <div id="aba-entradas" class="aba-content" style="background:#fff; border:1px solid #e2e8f0; border-radius:0 8px 8px 8px; overflow:hidden;">
        @include('relatorios._tabela_movimentacao', ['movimentos' => $entradas, 'cor' => '#15803d'])
    </div>

    <div id="aba-saidas" class="aba-content" style="display:none; background:#fff; border:1px solid #e2e8f0; border-radius:0 8px 8px 8px; overflow:hidden;">
        @include('relatorios._tabela_movimentacao', ['movimentos' => $saidas, 'cor' => '#dc2626'])
    </div>

    <div id="aba-todos" class="aba-content" style="display:none; background:#fff; border:1px solid #e2e8f0; border-radius:0 8px 8px 8px; overflow:hidden;">
        @include('relatorios._tabela_movimentacao', ['movimentos' => $todos, 'cor' => '#374151'])
    </div>

</div>

<script>
function abrirAba(id) {
    document.querySelectorAll('.aba-content').forEach(el => el.style.display = 'none');
    document.querySelectorAll('[id^="btn-aba-"]').forEach(btn => {
        btn.style.background = '#f1f5f9';
        btn.style.color = '#374151';
    });
    document.getElementById(id).style.display = 'block';
    const cores = { 'aba-entradas': '#16a34a', 'aba-saidas': '#dc2626', 'aba-todos': '#1e293b' };
    document.getElementById('btn-' + id).style.background = cores[id];
    document.getElementById('btn-' + id).style.color = '#fff';
}

function trocarFiltro(tipo) {
    document.getElementById('filtro_tipo').value = tipo;
    document.getElementById('filtro-periodo').style.display = tipo === 'periodo' ? 'flex' : 'none';
    document.getElementById('filtro-mes').style.display     = tipo === 'mes' ? 'flex' : 'none';
    document.getElementById('btn-periodo').style.background = tipo === 'periodo' ? '#1e293b' : '#e2e8f0';
    document.getElementById('btn-periodo').style.color      = tipo === 'periodo' ? '#fff' : '#374151';
    document.getElementById('btn-mes').style.background     = tipo === 'mes' ? '#1e293b' : '#e2e8f0';
    document.getElementById('btn-mes').style.color          = tipo === 'mes' ? '#fff' : '#374151';
}
</script>

@push('styles')
<style>
@media print {
    button, a[href*="exportar"], form { display: none !important; }
    .aba-content { display: block !important; margin-bottom: 30px; }
}
</style>
@endpush

@endsection