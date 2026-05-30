@php
    $user = auth()->user();

    /*
     * MASTER vê tudo.
     * ADMIN, FINANCEIRO, GERENTE, OPERACIONAL etc.
     * devem obedecer ao perfil/permissões.
     */
    $isMaster = $user && strtoupper($user->tipo ?? '') === 'MASTER';

    $podeVerClientes = $isMaster || $user->temPermissao('cliente_visualizar');

    /*
     * Compras não apareceu na sua lista antiga como permissão própria.
     * Mantive usando pedido_visualizar porque era o que seu arquivo usava.
     * Se você tiver uma permissão específica de compras depois,
     * podemos trocar para compra_visualizar.
     */
    $podeVerCompras = $isMaster || $user->temPermissao('pedido_visualizar');

    $podeVerFornecedores = $isMaster || $user->temPermissao('fornecedor_visualizar');
    $podeVerProdutos     = $isMaster || $user->temPermissao('produto_visualizar');

    /*
     * Naturezas Financeiras fica em configuração/cadastro auxiliar.
     * Usei config_visualizar para controlar a exibição.
     */
    $podeVerNaturezas = $isMaster || $user->temPermissao('config_visualizar');

    /*
     * Empresas deve ser exclusivo do MASTER.
     */
    $podeVerEmpresas = $isMaster;
@endphp


{{-- Clientes --}}
@if($podeVerClientes)
    <a href="/clientes" target="_blank">
        Clientes
        <img src="{{ asset('images/imagem/clientes.png') }}" class="imagem">
    </a>
@endif


{{-- Fornecedores / Naturezas Financeiras --}}
@if($podeVerFornecedores || $podeVerNaturezas)
    <a href="#" class="menu-link" id="fornecedor-link">
        Fornecedores
        <img src="{{ asset('images/imagem/fornecedor.png') }}" class="imagem">
        <i class="bi bi-caret-right-fill" style="margin-left:auto"></i>
    </a>

    <div class="dropdown-submenu" id="fornecedor-submenu">

        @if($podeVerFornecedores)
            <a href="/fornecedores" target="_blank">
                Fornecedores
                <img src="{{ asset('images/imagem/fornecedor.png') }}" class="imagem">
            </a>
        @endif

        @if($podeVerNaturezas)
            <a href="{{ url('/naturezas-financeiras') }}" target="_blank" rel="noopener noreferrer">
                Naturezas Financeiras
            </a>
        @endif

    </div>
@endif


{{-- Produtos --}}
@if($podeVerProdutos)
    <a href="/produtos" target="_blank">
        Produtos
        <img src="{{ asset('images/imagem/produtos.png') }}" class="imagem">
    </a>
@endif
