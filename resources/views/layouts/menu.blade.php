<!-- resources/views/layouts/menu.blade.php -->

@php
    $user = auth()->user();

    $podeVerCadastros =
        $user->temPermissao('cliente_visualizar') ||
        $user->temPermissao('usuario_visualizar') ||
        $user->temPermissao('venda_visualizar') ||
        $user->temPermissao('fornecedor_visualizar') ||
        $user->temPermissao('produto_visualizar') ||
        $user->temPermissao('config_visualizar');

    $podeVerMovimentos =
        $user->temPermissao('pedido_visualizar') ||
        $user->temPermissao('pedido_criar') ||
        $user->temPermissao('venda_visualizar') ||
        $user->temPermissao('venda_criar') ||
        $user->temPermissao('estoque_visualizar') ||
        $user->temPermissao('estoque_movimentacao');

    $podeVerFinanceiro =
        $user->temPermissao('caixa_visualizar') ||
        $user->temPermissao('caixa_abrir') ||
        $user->temPermissao('caixa_fechar') ||
        $user->temPermissao('conta_pagar_visualizar') ||
        $user->temPermissao('conta_receber_visualizar');

    $podeVerRelatorios =
        $user->temPermissao('relatorio_vendas') ||
        $user->temPermissao('relatorio_financeiro') ||
        $user->temPermissao('relatorio_estoque') ||
        $user->temPermissao('relatorio_clientes') ||
        $user->temPermissao('relatorio_entregas');

    $podeVerUtilitarios =
        $user->temPermissao('config_visualizar') ||
        $user->temPermissao('config_editar') ||
        $user->temPermissao('perfil_visualizar') ||
        $user->temPermissao('usuario_visualizar');
@endphp

<div class="menu-principal">

    @if($podeVerCadastros)
        <div class="menu-item">
            <a href="#">Cadastros</a>
        </div>
    @endif

    @if($podeVerMovimentos)
        <div class="menu-item">
            <a href="#">Movimentos</a>
        </div>
    @endif

    @if($podeVerFinanceiro)
        <div class="menu-item">
            <a href="#">Financeiro</a>
        </div>
    @endif

    @if($podeVerRelatorios)
        <div class="menu-item">
            <a href="#">Relatórios</a>
        </div>
    @endif

    @if($podeVerUtilitarios)
        <div class="menu-item">
            <a href="#">Utilitários</a>
        </div>
    @endif

</div>


@if($podeVerCadastros)
    <!-- Submenu de Cadastros -->
    <div class="menu-dropdown">
        <div class="submenu">

            @if($user->temPermissao('cliente_visualizar'))
                <a href="{{ route('clientes.index') }}">Clientes</a>
            @endif

            @if($user->temPermissao('usuario_visualizar'))
                <a href="{{ route('usuarios.index') }}">Usuários</a>
            @endif

            @if($user->temPermissao('venda_visualizar'))
                <a href="{{ route('vendas.index') }}">Vendas</a>
            @endif

            @if($user->temPermissao('fornecedor_visualizar'))
                <a href="{{ route('fornecedores.index') }}">Fornecedores</a>
            @endif

            @if($user->temPermissao('produto_visualizar'))
                <a href="{{ route('produtos.index') }}">Produtos</a>
            @endif

            @if($user->temPermissao('config_visualizar'))
                <a href="{{ route('formas_de_pagamento.index') }}">Formas de Pagamento</a>
            @endif

        </div>
    </div>
@endif