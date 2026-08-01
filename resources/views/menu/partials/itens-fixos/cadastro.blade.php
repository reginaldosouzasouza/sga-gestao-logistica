@php
    $user = auth()->user();

    /*
     * MASTER vê tudo.
     * ADMIN, FINANCEIRO, GERENTE, OPERACIONAL etc.
     * obedecem ao perfil/permissões.
     */
    $isMaster = $user && strtoupper($user->tipo ?? '') === 'MASTER';

    $podeVerClientes     = $isMaster || $user->temPermissao('cliente_visualizar');
    $podeVerFornecedores = $isMaster || $user->temPermissao('fornecedor_visualizar');
    $podeVerProdutos     = $isMaster || $user->temPermissao('produto_visualizar');

    /*
     * Veículos e Motoristas
     * Ideal: criar permissões próprias no perfil.
     */
    $podeVerVeiculos   = $isMaster || $user->temPermissao('veiculo_visualizar');
    $podeVerMotoristas = $isMaster || $user->temPermissao('motorista_visualizar');

    /*
     * Compras não apareceu na sua lista antiga como permissão própria.
     * Mantive usando pedido_visualizar porque era o que seu arquivo usava.
     */
    $podeVerCompras = $isMaster || $user->temPermissao('pedido_visualizar');

    /*
     * Naturezas Financeiras fica em configuração/cadastro auxiliar.
     */
    $podeVerNaturezas = $isMaster || $user->temPermissao('config_visualizar');

    /*
     * Empresas deve ser exclusivo do MASTER.
     */
    $podeVerEmpresas = $isMaster;
@endphp



{{-- Clientes --}}
@if($podeVerClientes)
    <a href="{{ url('/clientes') }}" target="_blank">
        Clientes
        <img src="{{ asset('images/imagem/clientes.png') }}" class="imagem">
    </a>

    <a href="{{ route('clientes.aniversariantes') }}" target="_blank">
        Aniversariantes
        <i class="bi bi-cake2" style="margin-left:auto"></i>
    </a>
@endif


{{-- Fornecedores --}}
@if($podeVerFornecedores)
    <a href="{{ url('/fornecedores') }}" target="_blank">
        Fornecedores
        <img src="{{ asset('images/imagem/fornecedor.png') }}" class="imagem">
    </a>
@endif


{{-- Naturezas Financeiras --}}
@if($podeVerNaturezas)
    <a href="{{ url('/naturezas-financeiras') }}" target="_blank">
        Naturezas Financeiras
        <i class="bi bi-diagram-3" style="margin-left:auto"></i>
    </a>
@endif


{{-- Produtos --}}
@if($podeVerProdutos)
    <a href="{{ url('/produtos') }}" target="_blank">
        Produtos
        <img src="{{ asset('images/imagem/produtos.png') }}" class="imagem">
    </a>
@endif


{{-- Veículos --}}
@if($podeVerVeiculos)
    <a href="{{ url('/veiculos') }}" target="_blank">
        Veículos
        <img src="{{ asset('images/imagem/veiculos.png') }}" class="imagem">
    </a>
@endif


{{-- Motoristas --}}
@if($podeVerMotoristas)
    <a href="{{ url('/motoristas') }}" target="_blank">
        Motoristas
        <img src="{{ asset('images/imagem/motorista.png') }}" class="imagem">
    </a>
@endif