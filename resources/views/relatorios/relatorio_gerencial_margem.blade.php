@extends('layouts.app')

@section('title', 'Gerencial de Resultados')

@section('content')

<style>
.grid-cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}
@media (max-width: 900px) {
    .grid-cards { grid-template-columns: 1fr; }
}
.card-box {
    border-radius: 12px;
    padding: 20px;
    color: white;
    font-weight: 600;
}
.bg-blue { background:#1976d2; }
.bg-orange { background:#f57c00; }
.bg-green { background:#388e3c; }
.bg-red { background:#d32f2f; }
.bg-purple { background:#7b1fa2; }
.bg-dark { background:#37474f; }
.valor { font-size:22px; font-weight:800; margin-top:5px; }
.sub { font-size:12px; opacity:0.9; }
.section-title {
    margin:35px 0 15px;
    font-weight:800;
    font-size:18px;
}
</style>

<div class="container-fluid" style="max-width:1400px;">

<h2 class="mb-3">📊 Relatório Gerencial de Resultados</h2>


<form method="GET" action="{{ route('relatorios.gerencial.margem') }}" 
      style="margin-bottom:25px; display:flex; gap:15px; align-items:end; flex-wrap:wrap;">

    <div>
        <label>Data Início</label><br>
        <input type="date" name="data_inicio" 
               value="{{ $dataInicio }}" class="form-control">
    </div>

    <div>
        <label>Data Fim</label><br>
        <input type="date" name="data_fim" 
               value="{{ $dataFim }}" class="form-control">
    </div>

    <div>
        <button type="submit" class="btn btn-primary">
            🔎 Filtrar
        </button>
    </div>

</form>

{{-- ============================= --}}
{{-- RESULTADO DA EMPRESA (DRE) --}}
{{-- ============================= --}}
<div class="section-title">📊 Resultado da Empresa (DRE)</div>

<div class="grid-cards">

    <div class="card-box bg-blue">
        Receita Total
        <div class="valor">R$ {{ number_format($totalEmitido,2,',','.') }}</div>
        <div class="sub">{{ number_format($totalQuantidade,0,',','.') }} itens vendidos</div>
    </div>

    <div class="card-box bg-orange">
        CMV - Custo da Mercadoria VENDIDA
        <div class="valor">R$ {{ number_format($totalCustosProd,2,',','.') }}</div>
    </div>

    <div class="card-box bg-red">
        Despesa Operacional
        <div class="valor">R$ {{ number_format($despesaOperacional,2,',','.') }}</div>
    </div>

    <div class="card-box bg-purple">
        Despesa Administrativa
        <div class="valor">R$ {{ number_format($despesaAdministrativa,2,',','.') }}</div>
    </div>

    <div class="card-box {{ $lucroEmpresa >= 0 ? 'bg-green' : 'bg-red' }}">
        Lucro da Empresa
        <div class="valor">
            R$ {{ number_format($lucroEmpresa,2,',','.') }}
        </div>
        <div class="sub">{{ $margemLiquidaPercent }}% margem</div>
    </div>

</div>

{{-- ============================= --}}
{{-- RESULTADO GERAL (FLUXO REAL) --}}
{{-- ============================= --}}
<div class="section-title">💰 Resultado Geral (Fluxo Real)</div>

<div class="grid-cards">

    <div class="card-box bg-blue">
        Entradas Reais ( entrou no caixa)
        <div class="valor">R$ {{ number_format($entradasReais,2,',','.') }}</div>
    </div>

    <div class="card-box bg-red">
        Saídas Reais (foi pago)
        <div class="valor">R$ {{ number_format($saidasReais,2,',','.') }}</div>
    </div>

    <div class="card-box {{ $resultadoGeral >= 0 ? 'bg-green' : 'bg-red' }}">
        Resultado Financeiro (Entradas - Saídas )
        <div class="valor">R$ {{ number_format($resultadoGeral,2,',','.') }}</div>
    </div>

</div>



{{-- ============================= --}}
{{-- PREVISÃO FINANCEIRA --}}
{{-- ============================= --}}

@php
$receitasPotenciais = $caixaAtual + $receberPrevisto + ($vendaPotencialEstoque ?? 0);
$saldoProjetado = $receitasPotenciais - $previsao;
@endphp

<div class="section-title">📅 Previsão Financeira</div>

{{-- ============================= --}}
{{-- LINHA 1 - RECURSOS --}}
{{-- ============================= --}}

    <div class="grid-cards">

        <div class="card-box bg-green">
            💰 Caixa Atual
            <div class="valor">
                R$ {{ number_format($caixaAtual,2,',','.') }}
            </div>
            <div class="sub">Caixa + Banco</div>
        </div>

        <div class="card-box bg-blue">
            Contas a Receber (Pendentes)
            <div class="valor">
                R$ {{ number_format($receberPrevisto,2,',','.') }}
            </div>
        </div>

        <div class="card-box bg-green">
            📦 Venda Potencial do Estoque
            <div class="valor">
                R$ {{ number_format($vendaPotencialEstoque ?? 0,2,',','.') }}
            </div>
        </div>

    </div>


    {{-- ============================= --}}
    {{-- LINHA 2 - RESULTADO --}}
    {{-- ============================= --}}

    <div class="grid-cards">

        <div class="card-box bg-orange">
            Resultado a Receber
            <div class="valor">
                R$ {{ number_format($receitasPotenciais,2,',','.') }}
            </div>
             <div class="sub">Caixa Atual + Contas a Receber + Venda Potencial do Estoque</div>
        </div>

        <div class="card-box bg-dark">
            Contas a Pagar (Pendentes)
            <div class="valor">
                R$ {{ number_format($previsao,2,',','.') }}
            </div>
            
        </div>


        <div class="card-box {{ $saldoProjetado >= 0 ? 'bg-green' : 'bg-red' }}">
            Saldo Futuro Previsto
            <div class="valor">
                R$ {{ number_format($saldoProjetado,2,',','.') }}
            </div>
        </div>

    </div>


</div>    
  
    

@endsection