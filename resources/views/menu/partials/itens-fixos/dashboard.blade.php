@php
    $user = auth()->user();

    /*
     * MASTER vê tudo.
     * Os demais usuários obedecem ao perfil/permissões.
     */
    $isMaster = $user && strtoupper($user->tipo ?? '') === 'MASTER';

    /*
     * Dashboard geral/emissão/financeiro
     */
    $podeVerDashboard = $isMaster || $user->temPermissao('dashboard_visualizar');

    /*
     * Relatórios gerenciais.
     * Por enquanto usamos relatorio_financeiro como permissão base,
     * porque esses dashboards mostram resultado, margem e financeiro.
     */
    $podeVerGerencial = $isMaster || $user->temPermissao('relatorio_financeiro');
@endphp


{{-- Dashboard Emissão --}}
@if($podeVerDashboard)
    <a href="#" class="menu-link" id="dashboard-emissao-link">
        Dashboard Emissão
        <img src="{{ asset('images/imagem/contas_a_pagar.png') }}" class="imagem">
        <i class="bi bi-caret-right-fill" style="margin-left:auto"></i>
    </a>

    <div class="dropdown-submenu" id="dashboard-emissao-submenu">
        <a href="{{ url('dashboard/emissao/gas') }}" target="_blank" rel="noopener noreferrer">
            Emissão GÁS
        </a>

        <a href="{{ url('dashboard/emissao/agua') }}" target="_blank" rel="noopener noreferrer">
            Emissão ÁGUA
        </a>
    </div>
@endif


{{-- Gerencial --}}
@if($podeVerGerencial)
    <a href="{{ url('/dashboard') }}" target="_blank" rel="noopener noreferrer">
        Gerencial
        <img src="{{ asset('images/imagem/gerencial.png') }}" class="imagem">
    </a>
@endif


{{-- Gerencial de Resultados --}}
@if($podeVerGerencial)
    <a href="{{ url('relatorios/gerencial/margem') }}" target="_blank" rel="noopener noreferrer">
        Gerencial de Resultados
        <img src="{{ asset('images/imagem/gerencial.png') }}" class="imagem">
    </a>
@endif


{{-- Gerencial por Natureza Financeira --}}
@if($podeVerGerencial)
    <a href="{{ url('relatorios/natureza-financeira') }}" target="_blank" rel="noopener noreferrer">
        Gerencial por Natureza Financeira
        <img src="{{ asset('images/imagem/gerencial.png') }}" class="imagem">
    </a>
@endif


{{-- Dashboard Financeiro --}}
@if($podeVerDashboard)
    <a href="{{ url('dashboard-financeiro') }}" target="_blank" rel="noopener noreferrer">
        Dashboard Financeiro
        <img src="{{ asset('images/imagem/gerencial.png') }}" class="imagem">
    </a>
@endif


{{-- Dashboard Fechamento Financeiro --}}
@if($podeVerDashboard)
    <a href="{{ url('dashboard/fechamento-financeiro') }}" target="_blank" rel="noopener noreferrer">
        Dashboard Fechamento Financeiro
        <img src="{{ asset('images/imagem/gerencial.png') }}" class="imagem">
    </a>
@endif