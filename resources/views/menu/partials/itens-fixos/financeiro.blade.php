@php
    $user = auth()->user();

    /*
     * MASTER vê tudo.
     * Os demais usuários obedecem ao perfil/permissões.
     */
    $isMaster = $user && strtoupper($user->tipo ?? '') === 'MASTER';

     $podeVerCompras = $isMaster || $user->temPermissao('pedido_visualizar');

    $podeVerContasPagar   = $isMaster || $user->temPermissao('conta_pagar_visualizar');
    $podeLancarContasPagar = $isMaster || $user->temPermissao('conta_pagar_lancar');
    $podeBaixarContasPagar = $isMaster || $user->temPermissao('conta_pagar_baixar');

    $podeVerContasReceber   = $isMaster || $user->temPermissao('conta_receber_visualizar');
    $podeLancarContasReceber = $isMaster || $user->temPermissao('conta_receber_lancar');
    $podeBaixarContasReceber = $isMaster || $user->temPermissao('conta_receber_baixar');

    $podeVerCaixa    = $isMaster || $user->temPermissao('caixa_visualizar');
    $podeAbrirCaixa  = $isMaster || $user->temPermissao('caixa_abrir');
    $podeFecharCaixa = $isMaster || $user->temPermissao('caixa_fechar');

    /*
     * Formas de Pagamento fica como configuração financeira.
     * Usei config_visualizar como base.
     */
    $podeVerFormasPagamento = $isMaster || $user->temPermissao('config_visualizar');
@endphp

{{-- Compras --}}
@if($podeVerCompras)
    <a href="/compras" target="_blank">
        Compras
        <img src="{{ asset('images/imagem/compras.png') }}" class="imagem">
    </a>
@endif


{{-- Contas a Pagar --}}
@if($podeVerContasPagar)
    <a href="/contas-a-pagar" target="_blank">
        Contas a Pagar
        <img src="{{ asset('images/imagem/contas_a_pagar.png') }}" class="imagem">
    </a>
@endif


{{-- Contas a Receber --}}
@if($podeVerContasReceber)
    <a href="/contas_a_receber" target="_blank">
        Contas a Receber
        <img src="{{ asset('images/imagem/contas_a_receber.png') }}" class="imagem">
    </a>
@endif


{{-- Caixa --}}
@if($podeVerCaixa)
    <a href="/caixa" target="_blank">
        Caixa
        <img src="{{ asset('images/imagem/caixaregistradora.png') }}" class="imagem">
    </a>
@endif


{{-- Abrir Caixa --}}
@if($podeAbrirCaixa)
    <a href="/caixa/abrir" target="_blank">
        Abrir Caixa
        <img src="{{ asset('images/imagem/caixaregistradora.png') }}" class="imagem">
    </a>
@endif


{{-- Fechar Caixa --}}
@if($podeFecharCaixa)
    <a href="/caixa/fechar" target="_blank">
        Fechar Caixa
        <img src="{{ asset('images/imagem/caixaregistradora.png') }}" class="imagem">
    </a>
@endif


{{-- Consulta Caixa --}}
@if($podeVerCaixa)
    <a href="/caixa/consultas" target="_blank">
        Consulta Caixa
        <img src="{{ asset('images/imagem/caixaregistradora.png') }}" class="imagem">
    </a>
@endif




{{-- Formas de Pagamento --}}
@if($podeVerFormasPagamento)
    <a href="/formas_de_pagamento" target="_blank">
        Formas de Pagamento
        <img src="{{ asset('images/imagem/formasdepagamento.png') }}" class="imagem">
    </a>
@endif