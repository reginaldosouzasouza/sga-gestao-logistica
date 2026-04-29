<div id="pedidos">

<h3>Pedidos de Coleta (Movimentação)</h3>

<p><strong>Objetivo:</strong> registrar vendas realizadas aos clientes, controlar estoque automaticamente e gerar movimentações financeiras.</p>

<p>
Este é o módulo mais importante do sistema, pois integra:
</p>

<ul>
<li>Estoque</li>
<li>Contas a Receber</li>
<li>Controle de Caixa</li>
<li>Histórico de Vendas</li>
</ul>

<h4>Como acessar</h4>

<p><strong>Menu Movimentação → Pedidos de Coleta</strong></p>

<h4>Estrutura do Pedido</h4>

<p>O pedido é composto por duas partes:</p>

<ul>
<li><strong>Dados Gerais (movimentacao)</strong></li>
<li><strong>Itens do Pedido (movimentacao_itens)</strong></li>
</ul>

<h4>Dados Gerais do Pedido</h4>

<ul>
<li><strong>Data da Coleta:</strong> data da venda.</li>
<li><strong>Cliente:</strong> cliente vinculado ao pedido.</li>
<li><strong>Endereço:</strong> preenchido automaticamente ao selecionar cliente.</li>
<li><strong>Observação:</strong> informações adicionais da entrega.</li>
<li><strong>Forma de Pagamento:</strong> define como será recebido( se for PIX ou dinheiro gera o caixa automaticamente,
                                                         for cartão, fatura ou nota assinada gera contas a receber).</li>
<li><strong>Prazo:</strong> condição de pagamento.</li>
<li><strong>Valor Total:</strong> soma automática dos itens.</li>
</ul>

<h4>Itens do Pedido</h4>

<p>Cada pedido pode conter um ou mais produtos.</p>

<ul>
<li><strong>Produto:</strong> item vendido (ex: Gás, Água).</li>
<li><strong>Quantidade:</strong> quantidade vendida.</li>
<li><strong>Valor Unitário:</strong> valor individual do produto.</li>
<li><strong>Total do Item:</strong> calculado automaticamente.</li>
</ul>

<p>
Ao clicar em <strong>Adicionar Produto</strong>, o item é incluído no pedido.
</p>

<h4>Processos Automáticos do Sistema</h4>

<p>Ao salvar o pedido, o sistema executa automaticamente:</p>

<ul>
<li>Baixa no estoque dos produtos vendidos</li>
<li>Geração de conta a receber (se houver prazo)</li>
<li>Registro no caixa (somente se a forma de pagamento for Dinheiro ou PIX).</li>
<li>Registro completo da movimentação para relatórios</li>
</ul>

<h4>Como registrar um pedido</h4>

<ol>
<li>Pesquisar ou selecionar cliente(Pesquisa pode ser feita pelo nome ou telefone do cliente).</li>
<li>Confirmar dados de endereço</li>
<li>Adicionar produtos e quantidades</li>
<li>Selecionar forma de pagamento</li>
<li>Conferir valor total</li>
<li>Clicar em <strong>Salvar Coleta</strong></li>
</ol>

<h4>Boas Práticas</h4>

<ul>
<li>Conferir estoque antes de confirmar venda.</li>
<li>Revisar forma de pagamento corretamente.</li>
<li>Evitar alterar pedidos já fechados.</li>
<li>Verificar valor total antes de salvar.</li>
</ul>

<h4>Problemas Comuns</h4>

<ul>
<li><strong>Estoque insuficiente:</strong> verificar quantidade disponível.</li>
<li><strong>Valor incorreto:</strong> conferir valor unitário do produto.</li>
<li><strong>Pedido não aparece no financeiro:</strong> verificar forma de pagamento selecionada.</li>
</ul>

</div>04