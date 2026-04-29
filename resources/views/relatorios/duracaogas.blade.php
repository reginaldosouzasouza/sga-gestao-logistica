@extends('layouts.app')

@section('title', 'Relatório de Controle de Gás')

@section('styles')
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    body { background: #f0f2f5; font-family: 'Segoe UI', sans-serif; }

    .gas-wrapper { padding: 24px; max-width: 1400px; margin: 0 auto; }

    /* ── Cabeçalho ── */
    .gas-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .gas-header h2 {
        font-size: 22px;
        color: #1F4E79;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .btn-excel {
        background: #1D6F42;
        color: #fff;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: background .2s;
    }
    .btn-excel:hover { background: #155232; color: #fff; }

    /* ── Cards ── */
    .gas-cards {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }
    .card {
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        color: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,.12);
    }
    .card .card-icon { font-size: 28px; margin-bottom: 6px; }
    .card .card-label { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; opacity: .9; }
    .card .card-value { font-size: 36px; font-weight: 700; margin: 4px 0; }
    .card-red    { background: linear-gradient(135deg, #FF4444, #cc0000); }
    .card-yellow { background: linear-gradient(135deg, #FFC107, #e0a800); color: #333 !important; }
    .card-blue   { background: linear-gradient(135deg, #17A2B8, #117a8b); }
    .card-green  { background: linear-gradient(135deg, #28A745, #1e7e34); }
    .card-yellow .card-label,
    .card-yellow .card-value { color: #333; }

    /* ── Tabela ── */
    .gas-table-wrap {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,.08);
        overflow: hidden;
    }
    .gas-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .gas-table thead tr th {
        padding: 12px 14px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        text-align: center;
        border-bottom: 2px solid #dee2e6;
    }
    .th-cliente  { background: #1F4E79; color: #fff; text-align: left !important; width: 25%; }
    .th-venda    { background: #E97132; color: #fff; }
    .th-atual    { background: #00B0A0; color: #fff; }
    .th-dias     { background: #70AD47; color: #fff; }
    .th-dugas    { background: #BDD7EE; color: #1F4E79; }
    .th-ptroca   { background: #FFFACD; color: #555; }
    .th-status   { background: #1F4E79; color: #fff; }

    .gas-table tbody tr { border-bottom: 1px solid #f0f0f0; transition: background .15s; }
    .gas-table tbody tr:hover { background: #f7fbff; }
    .gas-table tbody tr:nth-child(even) { background: #fafafa; }
    .gas-table tbody tr:nth-child(even):hover { background: #f0f7ff; }
    .gas-table td { padding: 10px 14px; text-align: center; }
    .td-cliente { text-align: left !important; font-weight: 600; color: #1F4E79; }
    .td-venda   { color: #E97132; font-weight: 600; }
    .td-dias    { font-weight: 700; color: #2e7d32; }
    .td-ptroca  { font-weight: 700; }
    .ptroca-neg { color: #cc0000; }
    .ptroca-pos { color: #1D6F42; }

    /* ── Badge Status ── */
    .badge-status {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .4px;
    }
    .badge-atrasado   { background: #FF4444; color: #fff; }
    .badge-hoje       { background: #FF8C00; color: #fff; }
    .badge-urgente    { background: #FFC107; color: #333; }
    .badge-atencao    { background: #17A2B8; color: #fff; }
    .badge-emdia      { background: #28A745; color: #fff; }
    .badge-semDados   { background: #aaa;    color: #fff; }

    /* ── Rodapé ── */
    .gas-footer {
        text-align: center;
        margin-top: 16px;
        font-size: 12px;
        color: #999;
    }

    @media (max-width: 768px) {
        .gas-cards { grid-template-columns: repeat(2, 1fr); }
        .gas-table { font-size: 11px; }
    }
</style>
@endsection

@section('content')
@php
    $atrasados  = $relatorio->filter(fn($r) => $r['p_troca'] !== null && $r['p_troca'] < 0)->count();
    $ate5       = $relatorio->filter(fn($r) => $r['p_troca'] !== null && $r['p_troca'] >= 0 && $r['p_troca'] <= 5)->count();
    $ate10      = $relatorio->filter(fn($r) => $r['p_troca'] !== null && $r['p_troca'] > 5 && $r['p_troca'] <= 10)->count();
    $emDia      = $relatorio->filter(fn($r) => $r['p_troca'] !== null && $r['p_troca'] > 10)->count();
@endphp

<div class="gas-wrapper">

    {{-- Cabeçalho --}}
    <div class="gas-header">
        <h2>🔥 Relatório de Controle de Gás</h2>
        <a href="{{ route('relatorio.gas.excel') }}" class="btn-excel">
            📥 Exportar Excel
        </a>
    </div>

    {{-- Cards --}}
    <div class="gas-cards">
        <div class="card card-red">
            <div class="card-icon">⚠️</div>
            <div class="card-label">Atrasados</div>
            <div class="card-value">{{ $atrasados }}</div>
        </div>
        <div class="card card-yellow">
            <div class="card-icon">⏰</div>
            <div class="card-label">Até 5 dias</div>
            <div class="card-value">{{ $ate5 }}</div>
        </div>
        <div class="card card-blue">
            <div class="card-icon">👀</div>
            <div class="card-label">Até 10 dias</div>
            <div class="card-value">{{ $ate10 }}</div>
        </div>
        <div class="card card-green">
            <div class="card-icon">✅</div>
            <div class="card-label">Em dia</div>
            <div class="card-value">{{ $emDia }}</div>
        </div>
    </div>

    {{-- Tabela --}}
    <div class="gas-table-wrap">
        <table class="gas-table">
            <thead>
                <tr>
                    <th class="th-cliente">Cliente</th>
                    <th class="th-venda">Ult. Venda</th>
                    <th class="th-atual">Data Atual</th>
                    <th class="th-dias">Qtde Dias</th>
                    <th class="th-dugas">D.U.Gas</th>
                    <th class="th-ptroca">Previsão de Troca</th>
                    <th class="th-status">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($relatorio as $row)
                @php
                    if ($row['p_troca'] === null) {
                        $badge = ['class' => 'badge-semDados', 'icon' => '❓', 'label' => 'Sem dados'];
                    } elseif ($row['p_troca'] < 0) {
                        $badge = ['class' => 'badge-atrasado', 'icon' => '⚠️', 'label' => 'Atrasado'];
                    } elseif ($row['p_troca'] == 0) {
                        $badge = ['class' => 'badge-hoje',    'icon' => '🔔', 'label' => 'Trocar hoje'];
                    } elseif ($row['p_troca'] <= 5) {
                        $badge = ['class' => 'badge-urgente', 'icon' => '⏰', 'label' => 'Urgente'];
                    } elseif ($row['p_troca'] <= 10) {
                        $badge = ['class' => 'badge-atencao', 'icon' => '👀', 'label' => 'Atenção'];
                    } else {
                        $badge = ['class' => 'badge-emdia',   'icon' => '✅', 'label' => 'Em dia'];
                    }
                @endphp
                <tr>
                    <td class="td-cliente">{{ $row['cliente'] }}</td>
                    <td class="td-venda">
                        {{ $row['ult_venda'] ? \Carbon\Carbon::parse($row['ult_venda'])->format('d/m/Y') : 'Sem registro' }}
                    </td>
                    <td>{{ $row['data_atual'] }}</td>
                    <td class="td-dias">{{ $row['qtde_dias'] ?? '-' }}</td>
                    <td>{{ $row['duracao'] }}</td>
                    <td class="td-ptroca {{ $row['p_troca'] !== null && $row['p_troca'] < 0 ? 'ptroca-neg' : 'ptroca-pos' }}">
                        {{ $row['p_troca'] !== null ? $row['p_troca'].' dias' : '-' }}
                    </td>
                    <td>
                        <span class="badge-status {{ $badge['class'] }}">
                            {{ $badge['icon'] }} {{ $badge['label'] }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:30px; color:#999;">
                        Nenhum registro encontrado.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="gas-footer">
        Total de clientes: {{ $relatorio->count() }} &nbsp;|&nbsp;
        Gerado em: {{ now()->format('d/m/Y H:i') }}
    </div>

</div>
@endsection