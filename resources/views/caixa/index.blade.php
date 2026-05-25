@extends('layouts.app')

@section('title', 'Caixa')

@section('content')
<link rel="stylesheet" href="{{ asset('css/caixa.css') }}">

<style>
    .link-origem-caixa {
        color: #0d6efd;
        font-weight: 600;
        text-decoration: underline;
        cursor: pointer;
    }

    .link-origem-caixa:hover {
        color: #084298;
        text-decoration: none;
    }
</style>


<div class="caixa-container">

    <div style="text-align:center; margin-bottom:20px">
       @if($caixaAbertoHoje)
            <h1 style="color:#198754;">
                🔓 Caixa Aberto - {{ \Carbon\Carbon::parse($caixaAbertoHoje->data_caixa)->format('d/m/Y') }}
            </h1>
        @else
            <h1>📦 Caixa Geral</h1>
       @endif
    </div>

  @if(isset($caixaAbertoHoje) && $caixaAbertoHoje === null)
        <div style="margin:15px 0; padding:12px; background:#ffecec; border-left:6px solid #d63031;">
            🔒 <strong>CAIXA FECHADO</strong> em
            {{ \Carbon\Carbon::parse($caixaFechadoHoje->data)->format('d/m/Y') }} |
            Saldo final:
            <strong>R$ {{ number_format($caixaFechadoHoje->saldo_final, 2, ',', '.') }}</strong>
        </div>
    @endif

    {{-- RESUMO --}}
    <div class="resumo-grid">
        <div class="card azul">
            <span>Caixa (Dinheiro)</span>
            <strong class="{{ $saldoCaixa < 0 ? 'negativo' : '' }}">
                R$ {{ number_format($saldoCaixa, 2, ',', '.') }}
            </strong>
            <small>
                Entradas: R$ {{ number_format($entradasCaixaHoje, 2, ',', '.') }}<br>
                Saídas: R$ {{ number_format($saidasCaixaHoje, 2, ',', '.') }}
            </small>
        </div>

        <div class="card verde">
            <span>Caixa Banco (PIX - CARTÃO - FATURA)</span>
            <strong class="{{ $saldoBanco < 0 ? 'negativo' : '' }}">
                R$ {{ number_format($saldoBanco, 2, ',', '.') }}
            </strong>
            <small>
                Entradas: R$ {{ number_format($entradasBancoHoje, 2, ',', '.') }}<br>
                Saídas: R$ {{ number_format($saidasBancoHoje, 2, ',', '.') }}
            </small>
        </div>

        <div class="card roxo">
            <span>Saldo Geral</span>
            <strong>R$ {{ number_format($saldoGeral, 2, ',', '.') }}</strong>
            <small>Caixa + Banco</small>
        </div>
    </div>

    {{-- FECHAR CAIXA --}}
    @if($caixaAbertoHoje)
    <form action="{{ route('caixa.fechar') }}" method="POST">
        @csrf

       <input type="hidden" name="data" value="{{ $dataAtual ?? $dataCaixa ?? now()->toDateString() }}">


       <input
            type="text"
            name="observacao"
            placeholder="Observação do fechamento (opcional)"
            class="form-control"
            style="max-width:300px"
        >

        <button
            type="submit"
            class="btn btn-danger"
            onclick="return confirm('Confirma o FECHAMENTO do caixa?')"
        >
            🔒 Fechar Caixa
        </button>
    </form>
    @endif


    {{-- TABELAS --}}
    <div class="tabelas-grid">

        {{-- CAIXA DINHEIRO --}}
        <div class="box box-caixa">
            <h3>💵 Caixa (Dinheiro)</h3>
            <table>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Tipo</th>
                        <th>Valor</th>
                        <th>Origem</th>
                        <th>Descrição</th>
                        @if($caixaAbertoHoje)
                            <th>Excluir</th>
                        @endif
                        <th>Estornar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($caixa as $mov)
                        <tr class="{{ $mov->tipo }}">
                            <td>{{ \Carbon\Carbon::parse($mov->data_movimentacao)->format('d/m/Y') }}</td>
                            <td class="tipo-mov">
                                {!! $mov->tipo === 'entrada' ? '⬆ Entrada' : '⬇ Saída' !!}
                            </td>
                            <td>R$ {{ number_format($mov->valor, 2, ',', '.') }}</td>
                            <td>{{ $mov->origem }}</td>
                            <td>
                                @php
                                    $descricaoLower = strtolower($mov->descricao ?? '');
                                @endphp

                                @if(str_contains($descricaoLower, 'conta a receber') && !empty($mov->referencia_id))
                                    <a href="{{ url('/contas-a-receber/' . $mov->referencia_id . '/edit') }}"
                                       class="link-origem-caixa"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       title="Abrir conta a receber #{{ $mov->referencia_id }}">
                                        {{ $mov->descricao }}
                                    </a>

                                @elseif(str_contains($descricaoLower, 'conta a pagar') && !empty($mov->referencia_id))
                                    <a href="{{ url('/contas-a-pagar/' . $mov->referencia_id . '/edit') }}"
                                       class="link-origem-caixa"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       title="Abrir conta a pagar #{{ $mov->referencia_id }}">
                                        {{ $mov->descricao }}
                                    </a>

                                @else
                                    {{ $mov->descricao }}
                                @endif
                            </td>

                            @if($caixaAbertoHoje)
                            <td>
                                <form action="{{ route('caixa.destroy', $mov->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Excluir lançamento do CAIXA?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">🗑</button>
                                </form>
                            </td>
                            @endif

                            <td>
                                @if($mov->origem !== 'ajuste')
                                    <form action="{{ route('caixa.estornar', $mov->id) }}" 
                                        method="POST" 
                                        style="display:inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning"
                                            onclick="return confirm('Confirma o ESTORNO deste lançamento?')">
                                            🔁 Estornar
                                        </button>
                                    </form>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr><td colspan="7">Nenhum registro</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- CAIXA BANCO --}}
        <div class="box box-banco">
            <h3>🏦 Caixa Banco (PIX - CARTÃO - FATURA)</h3>
            <table>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Tipo</th>
                        <th>Valor</th>
                        <th>Origem</th>
                        <th>Descrição</th>
                        @if($caixaAbertoHoje)
                            <th>Excluir</th>
                        @endif
                        <th>Estornar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($caixaBanco as $mov)
                        <tr class="{{ $mov->tipo }}">
                            <td>{{ \Carbon\Carbon::parse($mov->data_movimentacao)->format('d/m/Y') }}</td>
                            <td class="tipo-mov">
                                {!! $mov->tipo === 'entrada' ? '⬆ Entrada' : '⬇ Saída' !!}
                            </td>
                            <td>R$ {{ number_format($mov->valor, 2, ',', '.') }}</td>
                            <td>{{ $mov->origem }}</td>
                            <td>
                                @php
                                    $descricaoLower = strtolower($mov->descricao ?? '');
                                @endphp

                                @if(str_contains($descricaoLower, 'conta a receber') && !empty($mov->referencia_id))
                                    <a href="{{ url('/contas-a-receber/' . $mov->referencia_id . '/edit') }}"
                                       class="link-origem-caixa"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       title="Abrir conta a receber #{{ $mov->referencia_id }}">
                                        {{ $mov->descricao }}
                                    </a>

                                @elseif(str_contains($descricaoLower, 'conta a pagar') && !empty($mov->referencia_id))
                                    <a href="{{ url('/contas-a-pagar/' . $mov->referencia_id . '/edit') }}"
                                       class="link-origem-caixa"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       title="Abrir conta a pagar #{{ $mov->referencia_id }}">
                                        {{ $mov->descricao }}
                                    </a>

                                @else
                                    {{ $mov->descricao }}
                                @endif
                            </td>

                            @if($caixaAbertoHoje)
                            <td>
                                <form action="{{ route('caixa.banco.destroy', $mov->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Excluir lançamento do BANCO?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">🗑</button>
                                </form>
                            </td>
                            @endif
                            <td>
                                @if($mov->origem !== 'ajuste')
                                    <form action="{{ route('caixa.banco.estornar', $mov->id) }}" 
                                        method="POST" 
                                        style="display:inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning"
                                            onclick="return confirm('Confirma o ESTORNO deste lançamento?')">
                                            🔁 Estornar
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7">Nenhum registro</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

                    {{--
                    =====================================================================
                    ADICIONE este bloco no arquivo resources/views/caixa/index.blade.php
                    Cole ANTES da tag </div> final que fecha o .caixa-container
                    =====================================================================
                --}}

                {{--
            =====================================================================
            SUBSTITUA a seção de previsão no resources/views/caixa/index.blade.php
            (substitui o bloco @if(isset($previsao)) ... @endif anterior)
            =====================================================================
        --}}

        @if(isset($previsao))
        <div class="previsao-container" style="margin-top: 40px;">

            {{-- Cabeçalho --}}
            <div style="
                display: flex;
                align-items: center;
                justify-content: space-between;
                background: #1e293b;
                color: #fff;
                padding: 14px 20px;
                border-radius: 10px 10px 0 0;
                cursor: pointer;
            " onclick="togglePrevisao()">
                <h3 style="margin:0; font-size:16px;">
                    📅 Previsão de Caixa —
                    {{ \Carbon\Carbon::parse($previsao['data_inicio'])->format('d/m/Y') }}
                    até
                    {{ \Carbon\Carbon::parse($previsao['data_fim'])->format('d/m/Y') }}
                </h3>
                <span id="previsao-toggle-icon" style="font-size:18px;">▼</span>
            </div>

            <div id="previsao-body">

                {{-- FILTRO DE PERÍODO --}}
                <form method="GET" action="{{ route('caixa.index') }}" style="
                    background: #f8fafc;
                    padding: 14px 20px;
                    border: 1px solid #e2e8f0;
                    border-top: none;
                    display: flex;
                    gap: 10px;
                    flex-wrap: wrap;
                    align-items: center;
                ">
                    {{-- Atalhos rápidos --}}
                    <a href="{{ route('caixa.index', ['prev_inicio' => now()->toDateString(), 'prev_fim' => now()->addDays(7)->toDateString()]) }}"
                    style="padding:6px 14px; background:{{ request('prev_fim') == now()->addDays(7)->toDateString() && !request()->has('prev_inicio') || (request('prev_fim') == now()->addDays(7)->toDateString()) ? '#1e293b' : '#e2e8f0' }}; color:{{ request('prev_fim') == now()->addDays(7)->toDateString() ? '#fff' : '#374151' }}; border-radius:6px; text-decoration:none; font-size:13px; font-weight:600;">
                        7 dias
                    </a>
                    <a href="{{ route('caixa.index', ['prev_inicio' => now()->toDateString(), 'prev_fim' => now()->addDays(15)->toDateString()]) }}"
                    style="padding:6px 14px; background:{{ request('prev_fim') == now()->addDays(15)->toDateString() ? '#1e293b' : '#e2e8f0' }}; color:{{ request('prev_fim') == now()->addDays(15)->toDateString() ? '#fff' : '#374151' }}; border-radius:6px; text-decoration:none; font-size:13px; font-weight:600;">
                        15 dias
                    </a>

                    {{-- Separador --}}
                    <span style="color:#9ca3af; font-size:13px;">ou escolha:</span>

                    {{-- Período personalizado --}}
                    <input type="date" name="prev_inicio"
                        value="{{ $previsao['data_inicio'] }}"
                        style="padding:5px 10px; border:1px solid #d1d5db; border-radius:6px; font-size:13px;">
                    <span style="color:#6b7280; font-size:13px;">até</span>
                    <input type="date" name="prev_fim"
                        value="{{ $previsao['data_fim'] }}"
                        style="padding:5px 10px; border:1px solid #d1d5db; border-radius:6px; font-size:13px;">

                    <button type="submit" style="
                        padding:6px 16px;
                        background:#2563eb;
                        color:#fff;
                        border:none;
                        border-radius:6px;
                        font-size:13px;
                        font-weight:600;
                        cursor:pointer;
                    ">🔍 Filtrar</button>
                </form>

                {{-- Cards de resumo --}}
                <div style="
                    display: grid;
                    grid-template-columns: repeat(3, 1fr);
                    gap: 12px;
                    padding: 16px;
                    background: #f8fafc;
                    border: 1px solid #e2e8f0;
                    border-top: none;
                ">
                    <div style="background:#fff3cd; border-radius:8px; padding:14px; text-align:center; border-left:4px solid #f59e0b;">
                        <small style="color:#92400e; font-weight:600;">TOTAL A PAGAR</small>
                        <div style="font-size:22px; font-weight:700; color:#b45309;">
                            R$ {{ number_format($previsao['total_pagar'], 2, ',', '.') }}
                        </div>
                    </div>
                    <div style="background:#dcfce7; border-radius:8px; padding:14px; text-align:center; border-left:4px solid #22c55e;">
                        <small style="color:#166534; font-weight:600;">TOTAL A RECEBER</small>
                        <div style="font-size:22px; font-weight:700; color:#15803d;">
                            R$ {{ number_format($previsao['total_receber'], 2, ',', '.') }}
                        </div>
                    </div>
                    <div style="background:{{ $previsao['saldo_projetado_final'] >= 0 ? '#eff6ff' : '#fef2f2' }}; border-radius:8px; padding:14px; text-align:center; border-left:4px solid {{ $previsao['saldo_projetado_final'] >= 0 ? '#3b82f6' : '#ef4444' }};">
                        <small style="color:{{ $previsao['saldo_projetado_final'] >= 0 ? '#1e40af' : '#991b1b' }}; font-weight:600;">SALDO PROJETADO</small>
                        <div style="font-size:22px; font-weight:700; color:{{ $previsao['saldo_projetado_final'] >= 0 ? '#1d4ed8' : '#dc2626' }};">
                            R$ {{ number_format($previsao['saldo_projetado_final'], 2, ',', '.') }}
                        </div>
                    </div>
                </div>

                {{-- Tabela dia a dia --}}
                <div style="border:1px solid #e2e8f0; border-top:none; border-radius:0 0 10px 10px; overflow:hidden;">
                    @php $temItens = collect($previsao['dias'])->filter(fn($d) => count($d['pagar']) > 0 || count($d['receber']) > 0)->count(); @endphp

                    @foreach($previsao['dias'] as $dia)
                        @if(count($dia['pagar']) > 0 || count($dia['receber']) > 0)
                        <div style="border-bottom:1px solid #e2e8f0;">
                            <div style="display:flex; align-items:center; justify-content:space-between; padding:10px 16px; background:#f1f5f9; font-weight:600; font-size:14px;">
                                <span>
                                    📆 {{ \Carbon\Carbon::parse($dia['data'])->format('d/m/Y') }}
                                    ({{ \Carbon\Carbon::parse($dia['data'])->locale('pt_BR')->translatedFormat('l') }})
                                </span>
                                <span style="color:{{ $dia['saldo_projetado'] >= 0 ? '#15803d' : '#dc2626' }}; font-size:13px;">
                                    Saldo projetado: R$ {{ number_format($dia['saldo_projetado'], 2, ',', '.') }}
                                </span>
                            </div>

                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:0;">
                                {{-- A PAGAR --}}
                                <div style="padding:10px 16px; border-right:1px solid #e2e8f0;">
                                    @if(count($dia['pagar']) > 0)
                                        <div style="font-size:12px; color:#b45309; font-weight:600; margin-bottom:6px;">
                                            ⬇ A PAGAR — R$ {{ number_format($dia['total_pagar'], 2, ',', '.') }}
                                        </div>
                                        @foreach($dia['pagar'] as $c)
                                        <div style="display:flex; justify-content:space-between; font-size:13px; padding:4px 0; border-bottom:1px dashed #fde68a;">
                                            <span style="color:#374151;">{{ Str::limit($c->descricao, 35) }}</span>
                                            <span style="color:#b45309; font-weight:600; white-space:nowrap; margin-left:8px;">
                                                R$ {{ number_format($c->valor, 2, ',', '.') }}
                                            </span>
                                        </div>
                                        @endforeach
                                    @else
                                        <span style="font-size:12px; color:#9ca3af;">Nenhuma conta a pagar</span>
                                    @endif
                                </div>

                                {{-- A RECEBER --}}
                                <div style="padding:10px 16px;">
                                    @if(count($dia['receber']) > 0)
                                        <div style="font-size:12px; color:#15803d; font-weight:600; margin-bottom:6px;">
                                            ⬆ A RECEBER — R$ {{ number_format($dia['total_receber'], 2, ',', '.') }}
                                        </div>
                                        @foreach($dia['receber'] as $c)
                                        <div style="display:flex; justify-content:space-between; font-size:13px; padding:4px 0; border-bottom:1px dashed #bbf7d0;">
                                            <span style="color:#374151;">{{ Str::limit($c->descricao, 35) }}</span>
                                            <span style="color:#15803d; font-weight:600; white-space:nowrap; margin-left:8px;">
                                                R$ {{ number_format($c->valor, 2, ',', '.') }}
                                            </span>
                                        </div>
                                        @endforeach
                                    @else
                                        <span style="font-size:12px; color:#9ca3af;">Nenhuma conta a receber</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach

                    @if($temItens === 0)
                        <div style="padding:30px; text-align:center; color:#6b7280;">
                            ✅ Nenhum vencimento no período selecionado.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <script>
        function togglePrevisao() {
            const body = document.getElementById('previsao-body');
            const icon = document.getElementById('previsao-toggle-icon');
            if (body.style.display === 'none') {
                body.style.display = 'block';
                icon.textContent = '▼';
            } else {
                body.style.display = 'none';
                icon.textContent = '▶';
            }
        }
        </script>
@endif





        </div>
        @endsection
