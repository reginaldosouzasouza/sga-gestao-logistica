
{{-- Clientes --}}
@if(auth()->user()->temPermissao('cliente_visualizar'))
<a href="/clientes" target="_blank">
Clientes
<img src="{{ asset('images/imagem/clientes.png') }}" class="imagem">
</a>
@endif


{{-- Compras / pedidos --}}
@if(auth()->user()->temPermissao('pedido_visualizar'))
<a href="/compras" target="_blank">
Compras
<img src="{{ asset('images/imagem/compras.png') }}" class="imagem">
</a>
@endif


{{-- fornecedores --}}
@if(auth()->user()->temPermissao('fornecedor_visualizar'))
<a href="#" class="menu-link" id="fornecedor-link">
  FORNECEDOR TESTE
   <img src="{{ asset('images/imagem/fornecedor.png') }}" class="imagem">
    <i class="bi bi-caret-right-fill" style="margin-left:auto"></i>
</a>

<div class="dropdown-submenu" id="usuarios-submenu">
   <a href="/fornecedores" target="_blank">
        Fornecedor
        <img src="{{ asset('images/imagem/fornecedor.png') }}" class="imagem">
    </a>


    <a href="{{ url('/naturezas-financeiras') }}" target="_blank" rel="noopener noreferrer">
      Naturezas Financeiras
    </a>
</div>    
@endif





{{-- Produtos --}}
@if(auth()->user()->temPermissao('produto_visualizar'))
<a href="/produtos" target="_blank">
Produtos
<img src="{{ asset('images/imagem/produtos.png') }}" class="imagem">
</a>
@endif


{{-- Usuários --}}
@if(auth()->check() && auth()->user()->temPermissao('permissao_usuarios'))
<a href="#" class="menu-link" id="usuarios-link">
    USUÁRIOS
    <img src="{{ asset('images/imagem/usuarios.png') }}" class="imagem">
    <i class="bi bi-caret-right-fill" style="margin-left:auto"></i>
</a>

<div class="dropdown-submenu" id="usuarios-submenu">
    <a href="{{ url('/usuarios/create') }}" target="_blank" rel="noopener noreferrer">
        Cadastro de Usuários
    </a>

    <a href="{{ url('/usuarios') }}" target="_blank" rel="noopener noreferrer">
        Usuários/Alteração
    </a>

</div>
@endif



