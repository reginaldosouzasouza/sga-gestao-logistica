@php
    $user = auth()->user();
@endphp



{{-- Itens de Relatórios — comuns a TODOS os módulos --}}




{{-- Dashboard Emissão --}}
@if($user->temPermissao('relatorio_caixa'))
<a href="#" class="menu-link" id="relcaixa-link">
  Dashboard Emissão
    <img src="{{ asset('images/imagem/contas_a_pagar.png') }}" class="imagem">
    <i class="bi bi-caret-right-fill" style="margin-left:auto"></i>
</a>

<div class="dropdown-submenu" id="relcaixa-submenu">
    <a href="{{ url('dashboard/emissao/gas') }}" target="_blank" rel="noopener noreferrer">
      Emissao GÁS
    </a>

    <a href="{{ url('dashboard/emissao/agua') }}" target="_blank" rel="noopener noreferrer">
        Emissão ÁGUA
    </a>

  
</div>
@endif

{{-- Gerencial --}}
@if($user->temPermissao('relatorio_gerencial'))
<a href="{{ url('/dashboard') }}" target="_blank" rel="noopener noreferrer">
    GERENCIAL
    <img src="{{ asset('images/imagem/gerencial.png') }}" class="imagem">
</a>
@endif


{{-- Gerencial de Resultados --}}
@if($user->temPermissao('relatorio_gerencial'))
<a href="{{ url('relatorios/gerencial/margem') }}" target="_blank" rel="noopener noreferrer">
    GERENCIAL de RESULTADOS
    <img src="{{ asset('images/imagem/gerencial.png') }}" class="imagem">
</a>
@endif

{{-- Gerencial de Resultados por Natureza Financeira --}}
@if($user->temPermissao('relatorio_gerencial'))
<a href="{{ url('relatorios/natureza-financeira') }}" target="_blank" rel="noopener noreferrer">
    GERENCIAL por NATUREZA FINANCEIRA
    <img src="{{ asset('images/imagem/gerencial.png') }}" class="imagem">
</a>
@endif


{{-- Gerencial de Resultados Financeiro --}}
@if($user->temPermissao('relatorio_gerencial'))
<a href="{{ url('dashboard-financeiro') }}" target="_blank" rel="noopener noreferrer">
    GERENCIAL DASHBOARD FINANCEIRO
    <img src="{{ asset('images/imagem/gerencial.png') }}" class="imagem">
</a>
@endif

