<!-- resources/views/layouts/menu.blade.php -->
<div class="menu-principal">
    <div class="menu-item"><a href="#">Cadastros</a></div>
    <div class="menu-item"><a href="#">Movimentos</a></div>
    <div class="menu-item"><a href="#">Financeiro</a></div>
    <div class="menu-item"><a href="#">Relatórios</a></div>
    <div class="menu-item"><a href="#">Utilitários</a></div>
</div>

<!-- Submenu de Cadastros -->
<div class="menu-dropdown">
    <div class="submenu">
        <a href="{{ route('clientes.index') }}">Clientes</a>
        <a href="{{ route('usuarios.index') }}">Usuários</a>
        <a href="{{ route('vendas.index') }}">Vendas</a>
        <a href="{{ route('fornecedores.index') }}">Fornecedores</a>
        <a href="{{ route('produtos.index') }}">Produtos</a>
        <a href="{{ route('formas_de_pagamento.index') }}">Formas de Pagamento</a>
    </div>
</div>
