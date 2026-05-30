@php
    $user = auth()->user();

    $isMaster = $user && strtoupper($user->tipo ?? '') === 'MASTER';

    $podeVerColetas = $isMaster || ($user && $user->temPermissao('pedido_visualizar'));
    $podeCriarColeta = $isMaster || ($user && $user->temPermissao('pedido_criar'));

    /*
     * Por enquanto Vale Gás e Vasilhames ficam ligados ao estoque.
     * Depois podemos criar permissões próprias.
     */
    $podeVerValeGas = $isMaster || ($user && $user->temPermissao('estoque_visualizar'));
    $podeVerVasilhames = $isMaster || ($user && $user->temPermissao('estoque_visualizar'));
@endphp


@if($podeVerColetas)
    <a href="/movimentacao" target="_blank">
        Consultar Coletas
    </a>

    <a href="/movimentacao" target="_blank">
        Listagem de Coleta
    </a>
@endif


@if($podeCriarColeta)
    <a href="/movimentacao/create" target="_blank">
        Pedidos de Coleta
    </a>
@endif


@if($podeVerValeGas)
    <a href="/vale-gas" target="_blank">
        Vale Gás
    </a>
@endif


@if($podeVerVasilhames)
    <a href="/controle-vasilhames" target="_blank">
        Controle Vasilhames
    </a>
@endif