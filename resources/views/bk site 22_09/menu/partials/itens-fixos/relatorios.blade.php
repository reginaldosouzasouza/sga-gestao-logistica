{{-- resources/views/menu/partials/itens-fixos/relatorios.blade.php --}}
{{-- Itens de Relatórios — comuns a TODOS os módulos --}}

{{-- Estoque --}}
<a href="#" class="menu-link" id="estoque-link">
    Estoque <img src="{{ asset('images/imagem/clientes.png') }}" class="imagem">
    <i class="bi bi-caret-right-fill" style="margin-left:auto"></i>
</a>
<div class="dropdown-submenu" id="estoque-submenu">
    <a href="/estoques" target="_blank">Movimentação do Estoque</a>
    <a href="/relatorios/saldo-estoque" target="_blank">Saldo do Estoque</a>
</div>

{{-- Vendas --}}
<a href="#" class="menu-link" id="vendas-link">
    VENDAS <img src="{{ asset('images/imagem/clientes.png') }}" class="imagem">
    <i class="bi bi-caret-right-fill" style="margin-left:auto"></i>
</a>
<div class="dropdown-submenu" id="vendas-submenu">
    <a href="/relatorios/vendas" target="_blank">Vendas</a>
    <a href="/relatorios/vendas-por-produto" target="_blank">Vendas por Produto</a>
</div>

{{-- Compras --}}
<a href="#" class="menu-link" id="compras-link">
    COMPRAS <img src="{{ asset('images/imagem/clientes.png') }}" class="imagem">
    <i class="bi bi-caret-right-fill" style="margin-left:auto"></i>
</a>
<div class="dropdown-submenu" id="compras-submenu">
    <a href="/relatorio-compras" target="_blank">Rel. de Compras</a>
</div>

{{-- Contas a Pagar e a Receber --}}
<a href="#" class="menu-link" id="relcontasapagar-link">
    FINANCEIRO<img src="{{ asset('images/imagem/contas_a_pagar.png') }}" class="imagem">
    <i class="bi bi-caret-right-fill" style="margin-left:auto"></i>
</a>
<div class="dropdown-submenu" id="relcontasApagar-submenu">
    <a href="/relatorio-contas-a-pagar" target="_blank">Rel. de Contas a Pagar</a>
    <a href="/contas_a_receber/relatorio" target="_blank">Rel. de Contas a Receber</a>
</div>


{{-- Caixa --}}
<a href="#" class="menu-link" id="relcaixa-link">
    CAIXA <img src="{{ asset('images/imagem/contas_a_pagar.png') }}" class="imagem">
    <i class="bi bi-caret-right-fill" style="margin-left:auto"></i>
</a>
<div class="dropdown-submenu" id="relCaixa-submenu">
    <a href="/caixa/consulta" target="_blank">Consulta Caixa Aberto</a>
    <a href="/relatorios/rel-caixa" target="_blank">Consulta Diário do Caixa</a>
     <a href="/caixa/consultas" target="_blank">Histórico do Caixa</a>
      <a href="/relatorios/movimentacao" target="_blank">Relatório de Movimentacao do Caixa</a>

</div>

{{-- Gerencial --}}
<a href="/dashboard" target="_blank">
    GERENCIAL <img src="{{ asset('images/imagem/gerencial.png') }}" class="imagem">
</a>
