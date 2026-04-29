@php
    $user = auth()->user();
@endphp



{{-- Itens de Relatórios — comuns a TODOS os módulos --}}


{{-- Controle de Vasilhames --}}
@if($user->temPermissao('relatorio_controle_vasilhames'))
<a href="{{ url('/controle-vasilhames') }}" target="_blank" rel="noopener noreferrer">
   CONTROLE DE VASILHAMES
    <img src="{{ asset('images/imagem/produtos.png') }}" class="imagem">

</a>
@endif


{{-- Estoque --}}
@if($user->temPermissao('relatorio_estoque'))
<a href="#" class="menu-link" id="estoque-link">
    ESTOQUE <img src="{{ asset('images/imagem/clientes.png') }}" class="imagem">
    <i class="bi bi-caret-right-fill" style="margin-left:auto"></i>
</a>

<div class="dropdown-submenu" id="estoque-submenu">
    @if($user->temPermissao('estoque_movimentacao'))
    <a href="{{ url('/estoques') }}" target="_blank" rel="noopener noreferrer">Movimentação do Estoque</a>
    @endif

    <a href="{{ url('/relatorios/saldo-estoque') }}" target="_blank" rel="noopener noreferrer">Saldo do Estoque</a>
</div>
@endif


{{-- Vendas --}}
@if($user->temPermissao('relatorio_vendas'))
<a href="#" class="menu-link" id="vendas-link">
    VENDAS <img src="{{ asset('images/imagem/clientes.png') }}" class="imagem">
    <i class="bi bi-caret-right-fill" style="margin-left:auto"></i>
</a>

<div class="dropdown-submenu" id="vendas-submenu">
    <a href="{{ url('/relatorios/vendas') }}" target="_blank" rel="noopener noreferrer">Vendas</a>

    @if($user->temPermissao('relatorio_vendas_produto'))
    <a href="{{ url('/relatorios/vendas-por-produto') }}" target="_blank" rel="noopener noreferrer">Vendas por Produto</a>
    @endif

    <a href="{{ url('/relatorio-vendas-emissao') }}" target="_blank" rel="noopener noreferrer">Vendas por Emissão</a>

</div>
@endif

{{-- Compras --}}
@if($user->temPermissao('relatorio_compras'))
<a href="#" class="menu-link" id="compras-link">
    COMPRAS <img src="{{ asset('images/imagem/clientes.png') }}" class="imagem">
    <i class="bi bi-caret-right-fill" style="margin-left:auto"></i>
</a>

<div class="dropdown-submenu" id="compras-submenu">
    <a href="{{ url('/relatorios/compras') }}" target="_blank" rel="noopener noreferrer">Rel. de Compras</a>
</div>
@endif

{{-- Financeiro --}}
@if($user->temPermissao('relatorio_financeiro'))
<a href="#" class="menu-link" id="relcontasapagar-link">
    FINANCEIRO
    <img src="{{ asset('images/imagem/contas_a_pagar.png') }}" class="imagem">
    <i class="bi bi-caret-right-fill" style="margin-left:auto"></i>
</a>

<div class="dropdown-submenu" id="relcontasapagar-submenu">
    <a href="{{ url('/relatorio-contas-a-pagar') }}" target="_blank" rel="noopener noreferrer">
        Rel. de Contas a Pagar
    </a>

    <a href="{{ url('/contas_a_receber/relatorio') }}" target="_blank" rel="noopener noreferrer">
        Rel. de Contas a Receber
    </a>
</div>
@endif

{{-- Caixa --}}
@if($user->temPermissao('relatorio_caixa'))
<a href="#" class="menu-link" id="relcaixa-link">
    CAIXA
    <img src="{{ asset('images/imagem/contas_a_pagar.png') }}" class="imagem">
    <i class="bi bi-caret-right-fill" style="margin-left:auto"></i>
</a>

<div class="dropdown-submenu" id="relcaixa-submenu">
    <a href="{{ url('/caixa/consulta') }}" target="_blank" rel="noopener noreferrer">
        Consulta Caixa Aberto
    </a>

    <a href="{{ url('/relatorios/rel-caixa') }}" target="_blank" rel="noopener noreferrer">
        Consulta Diário do Caixa
    </a>

    <a href="{{ url('/caixa/consultas') }}" target="_blank" rel="noopener noreferrer">
        Histórico do Caixa
    </a>

    <a href="{{ url('/relatorios/movimentacao') }}" target="_blank" rel="noopener noreferrer">
        Relatório de Movimentação do Caixa
    </a>
</div>
@endif

<!--{{-- Gerencial --}}
@if($user->temPermissao('relatorio_gerencial'))
<a href="{{ url('/dashboard') }}" target="_blank" rel="noopener noreferrer">
    GERENCIAL
    <img src="{{ asset('images/imagem/gerencial.png') }}" class="imagem">
</a>-->
@endif

