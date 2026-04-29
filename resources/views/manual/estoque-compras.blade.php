<div id="estoque-compras">

<h3>Estoque e Compras</h3>

<p><strong>Objetivo:</strong> controlar a quantidade de produtos disponíveis para venda e registrar entradas de mercadorias no sistema.</p>

<p>
O módulo de estoque está diretamente integrado ao módulo de Movimentação (Pedidos).
</p>

<hr>

<h4>1. Produtos</h4>

<p>
Antes de realizar vendas ou compras, é necessário cadastrar os produtos.
</p>

<p><strong>Menu:</strong> Cadastro → Produtos</p>

<p>Cada produto deve conter:</p>

<ul>
<li>Nome do produto</li>
<li>Valor de venda</li>
<li>Informações adicionais (se aplicável)</li>
</ul>

<hr>

<h4>2. Controle de Estoque</h4>

<p>
O estoque é atualizado automaticamente pelo sistema.
</p>

<ul>
<li>Venda realizada → diminui o estoque</li>
<li>Compra registrada → aumenta o estoque</li>
</ul>

<p>
O controle correto do estoque evita vendas sem disponibilidade e garante relatórios precisos.
</p>

<hr>

<h4>3. Compras</h4>

<p>
As compras registram a entrada de produtos no estoque.
</p>

<p><strong>Menu:</strong> Cadastro → Compras</p>

<p>Ao registrar uma compra, o sistema:</p>

<ul>
<li>Aumenta a quantidade do produto no estoque</li>
<li>Pode gerar conta a pagar (se houver prazo)</li>
<li>Registra movimentação financeira</li>
</ul>

<hr>

<h4>Fluxo de Funcionamento</h4>

<ol>
<li>Cadastrar produto</li>
<li>Registrar compra (entrada no estoque)</li>
<li>Realizar venda (saída do estoque)</li>
<li>Acompanhar saldo no relatório de estoque</li>
</ol>

<hr>

<h4>Boas Práticas</h4>

<ul>
<li>Registrar todas as compras antes de vender.</li>
<li>Evitar alterar estoque manualmente.</li>
<li>Conferir saldo antes de confirmar pedidos grandes.</li>
<li>Manter valores de venda atualizados.</li>
</ul>

<hr>

<h4>Problemas Comuns</h4>

<ul>
<li><strong>Estoque negativo:</strong> verificar se houve venda sem registro de compra.</li>
<li><strong>Quantidade incorreta:</strong> revisar movimentações anteriores.</li>
<li><strong>Produto não aparece:</strong> verificar se está cadastrado corretamente.</li>
</ul>

</div>