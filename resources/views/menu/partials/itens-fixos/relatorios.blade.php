@php
    $user = auth()->user();

    /*
     * MASTER vê tudo.
     * Os demais usuários obedecem ao perfil/permissões.
     */
    $isMaster = $user && strtoupper($user->tipo ?? '') === 'MASTER';

    $podeRelEstoque    = $isMaster || $user->temPermissao('relatorio_estoque');
    $podeRelVendas     = $isMaster || $user->temPermissao('relatorio_vendas');
    $podeRelFinanceiro = $isMaster || $user->temPermissao('relatorio_financeiro');
    $podeRelCaixa      = $isMaster || $user->temPermissao('relatorio_financeiro');
    $podeRelGerencial  = $isMaster || $user->temPermissao('relatorio_financeiro');

    /*
     * Controle de Vasilhames:
     * Como ainda não temos uma permissão específica,
     * deixei somente MASTER por segurança.
     * Depois podemos criar: vasilhame_visualizar.
     */
    $podeVasilhames = $isMaster;

    /*
     * Compras:
     * Por enquanto, usando relatorio_financeiro como permissão base,
     * porque compras impacta financeiro.
     */
    $podeCompras = $isMaster || $user->temPermissao('relatorio_financeiro');
@endphp



{{-- Estoque --}}
@if($podeRelEstoque)
    <a href="#" class="menu-link" id="estoque-link">
        Estoque
        <img src="{{ asset('images/imagem/clientes.png') }}" class="imagem">
        <i class="bi bi-caret-right-fill" style="margin-left:auto"></i>
    </a>

    <div class="dropdown-submenu" id="estoque-submenu">
        <a href="{{ url('/estoques') }}" target="_blank" rel="noopener noreferrer">
            Movimentação do Estoque
        </a>

        <a href="{{ url('/relatorios/saldo-estoque') }}" target="_blank" rel="noopener noreferrer">
            Saldo do Estoque
        </a>
    </div>
@endif


{{-- Vendas --}}
@if($podeRelVendas)
    <a href="#" class="menu-link" id="vendas-link">
        Vendas
        <img src="{{ asset('images/imagem/clientes.png') }}" class="imagem">
        <i class="bi bi-caret-right-fill" style="margin-left:auto"></i>
    </a>

    <div class="dropdown-submenu" id="vendas-submenu">
        <a href="{{ url('/relatorios/vendas') }}" target="_blank" rel="noopener noreferrer">
            Vendas
        </a>

        <a href="{{ url('/relatorios/vendas-por-produto') }}" target="_blank" rel="noopener noreferrer">
            Vendas por Produto
        </a>

        <a href="{{ url('/relatorio-vendas-emissao') }}" target="_blank" rel="noopener noreferrer">
            Vendas por Emissão
        </a>
    </div>
@endif


{{-- Compras --}}
@if($podeCompras)
    <a href="#" class="menu-link" id="compras-link">
        Compras
        <img src="{{ asset('images/imagem/clientes.png') }}" class="imagem">
        <i class="bi bi-caret-right-fill" style="margin-left:auto"></i>
    </a>

    <div class="dropdown-submenu" id="compras-submenu">
        <a href="{{ url('/relatorios/compras') }}" target="_blank" rel="noopener noreferrer">
            Relatório de Compras
        </a>

       
    </div>
@endif


{{-- Financeiro --}}
@if($podeRelFinanceiro)
    <a href="#" class="menu-link" id="relcontasapagar-link">
        Financeiro
        <img src="{{ asset('images/imagem/contas_a_pagar.png') }}" class="imagem">
        <i class="bi bi-caret-right-fill" style="margin-left:auto"></i>
    </a>

    <div class="dropdown-submenu" id="relcontasapagar-submenu">
        <a href="{{ url('/relatorio-contas-a-pagar') }}" target="_blank" rel="noopener noreferrer">
            Relatório de Contas a Pagar
        </a>

        <a href="{{ url('/contas_a_receber/relatorio') }}" target="_blank" rel="noopener noreferrer">
            Relatório de Contas a Receber
        </a>
    </div>
@endif


{{-- Caixa --}}
@if($podeRelCaixa)
    <a href="#" class="menu-link" id="relcaixa-link">
        Caixa
        <img src="{{ asset('images/imagem/contas_a_pagar.png') }}" class="imagem">
        <i class="bi bi-caret-right-fill" style="margin-left:auto"></i>
    </a>

    <div class="dropdown-submenu" id="relcaixa-submenu">
        <a href="{{ url('/caixa') }}" target="_blank" rel="noopener noreferrer">
            Caixa Aberto
        </a>

        <a href="{{ url('/caixa/consultas') }}" target="_blank" rel="noopener noreferrer">
            Histórico do Caixa
        </a>

        <a href="{{ url('/relatorios/rel-caixa') }}" target="_blank" rel="noopener noreferrer">
            Relatório Diário do Caixa
        </a>

        <a href="{{ url('/relatorios/movimentacao') }}" target="_blank" rel="noopener noreferrer">
            Relatório de Movimentação do Caixa
        </a>
    </div>
@endif


