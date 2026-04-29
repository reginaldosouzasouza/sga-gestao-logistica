<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatSuporteController extends Controller
{
   public function perguntar(Request $request)
{
    $pergunta = strtolower(trim($request->input('mensagem')));

    $intencoes = [

            'acesso' => [
            'palavras' => [
                'acessar', 'login', 'entrar', 'senha', 'usuario', 'conectar', 'acesso', 'como entrar'
            ],
            'titulo' => '🔑 Como Acessar o Sistema',  '🔑 Como entrar no Sistema',
            'texto'  => '1. Acesse a tela de login.<br>
                        2. Informe o <strong>Cód. Usuário</strong>, <strong>Usuário</strong> e <strong>Senha</strong>.<br>
                        3. Clique em <strong>Entrar</strong> e escolha o módulo desejado.<br>
                        4. <em>Dica: O sistema diferencia maiúsculas de minúsculas!</em>'
        ],


                'clientes' => [
            'palavras' => [
                'cliente', 'clientes', 'cadastrar cliente', 'novo cliente', 
                'alterar cliente', 'mudar endereço', 'achar cliente', 'buscar cliente'
            ],
            'titulo' => '👥 Gestão de Clientes',
            'texto'  => 'Para gerenciar seus clientes, siga o fluxo:<br><br>
                        1. Vá em <strong>Cadastro → Clientes</strong>.<br>
                        2. <strong>Para Novo:</strong> Clique no botão "Novo" e preencha os dados (CPF/CNPJ, Telefone e Endereço são fundamentais).<br>
                        3. <strong>Para Buscar:</strong> Use o campo de pesquisa por Nome ou Telefone.<br>
                        4. <strong>Dica de Ouro:</strong> Mantenha o telefone atualizado para facilitar o rastreio da entrega!'
        ],


'consulta_clientes' => [
    'palavras' => [
        'listar clientes', 'ver clientes', 'procurar cliente', 
        'editar cliente', 'excluir cliente', 'lista de clientes'
    ],
    'titulo' => '🔍 Consulta e Gestão de Clientes',
    'texto'  => 'Nesta tela você gerencia sua base de dados:<br><br>
                 1. <strong>Pesquisa Rápida:</strong> Digite o Nome ou Telefone no campo superior para filtrar instantaneamente.<br>
                 2. <strong>Consultar/Alterar:</strong> Clique no botão azul para ver detalhes ou atualizar o endereço do cliente.<br>
                 3. <strong>Excluir:</strong> Use o botão vermelho apenas se desejar remover o registro permanentemente.<br>
                 4. <strong>Novo Registro:</strong> Use o botão verde "Cadastrar Cliente" para abrir o formulário em branco.'
],


'formulario_cliente' => [
    'palavras' => [
        'preencher cadastro', 'campos cliente', 'cadastrar novo', 
        'como cadastrar o cliente', 'salvar cliente', 'aniversário cliente'
    ],
    'titulo' => '📝 Preenchendo o Cadastro de Cliente',
    'texto'  => 'Siga estas orientações para um cadastro perfeito:  tela cadastro -> Clientes<br><br>
                 1. <strong>Identificação:</strong> Insira o CPF ou CNPJ para segurança fiscal.<br>
                 2. <strong>Endereço Preciso:</strong> Preencha Rua, Número e Bairro separadamente. Isso ajuda na organização das rotas de entrega.<br>
                 3. <strong>Ponto de Referência:</strong> Use o campo <strong>Observação</strong> para detalhes que facilitam a vida do entregador (ex: cor da casa, comércio próximo).<br>
                 4. <strong>Aniversário:</strong> Útil para você enviar promoções ou brindes e fidelizar o cliente.<br>
                 5. <strong>Finalizar:</strong> Clique no botão verde <strong>Salvar</strong> ao final da página.'
],


'pedidos_coleta' => [
    'palavras' => [
        'fazer pedido', 'vender gás', 'nova coleta', 'lançar venda', 
        'forma de pagamento', 'selecionar produto', 'valor total'
    ],
    'titulo' => '📦 Realizando um Pedido de Coleta',
    'texto'  => 'Este módulo é 95% automatizado para sua agilidade:<br><br>
                 1. <strong>Busca:</strong> Digite o nome ou telefone no campo "PESQUISAR CLIENTE" e selecione o cadastro correto.<br>
                 2. <strong>Confirmação:</strong> O sistema preencherá o endereço e observações automaticamente. Verifique se estão corretos.<br>
                 3. <strong>Produtos:</strong> Selecione o produto e a quantidade. O sistema calculará o valor total instantaneamente.<br>
                 4. <strong>Pagamento:</strong> Escolha a Forma de Pagamento e o Prazo desejado.<br>
                 5. <strong>Conclusão:</strong> Clique em <strong>Salvar Coleta</strong> para registrar a venda e gerar o controle.'
],


'consultar_coletas' => [
    'palavras' => [
        'ver pedidos', 'consultar vendas', 'alterar pedido', 
        'excluir venda', 'lista de coletas', 'historico de pedidos'
    ],
    'titulo' => '🔍 Consultar e Gerenciar Coletas',
    'texto'  => 'Aqui você acompanha todas as vendas realizadas:<br><br>
                 1. <strong>Filtro de Data:</strong> Use o campo de data no topo para buscar pedidos de dias específicos.<br>
                 2. <strong>Resumo da Lista:</strong> Você verá o Cliente, Produto, Valor e a Forma de Pagamento de cada venda.<br>
                 3. <strong>Alterações:</strong> Clique no botão azul <strong>Alterar</strong> se precisar mudar o produto ou o valor de uma venda já salva.<br>
                 4. <strong>Exclusão:</strong> O botão vermelho <strong>Excluir</strong> remove a venda e estorna o produto ao estoque.<br>
                 5. <strong>Dica:</strong> Ótima tela para conferir o fechamento do caixa no final do dia!'
],

'produtos' => [
    'palavras' => [
        'produto', 'produtos', 'cadastrar produto', 'preço', 'como cadastrar o produto',
        'estoque', 'água', 'gás', 'mudar preço', 'itens'
    ],
    'titulo' => '📦 Cadastro de Produtos (Venda)',
    'texto'  => 'Esta tela é exclusiva para os produtos que você comercializa:<br><br>
                 1. <strong>O que cadastrar:</strong> Registre aqui o conteúdo (ex: Gás P-13, Água 20L) que será vendido ao cliente.<br>
                 2. <strong>Preço de Venda:</strong> Defina o valor que aparecerá automaticamente na tela de Pedidos.<br>
                 3. <strong>Unidade:</strong> Geralmente utiliza-se "UN" para unidades de botijões ou galões.<br>
                 4. <strong>Estoque de Venda:</strong> Informe a quantidade de produtos prontos para entrega.<br>
                 5. <strong>Observação:</strong> O controle de vasilhames (cascos vazios) é feito em um módulo separado para não misturar com suas vendas.'
],




'formulario_fornecedor' => [
    'palavras' => [
        'preencher fornecedor', 'dados fornecedor', 'cnpj fornecedor', 'cadastro de fornecedores', 'cadastro de fornecedor',
        'vendedor', 'razão social', 'cadastrar empresa fornecedora'
    ],
    'titulo' => '📝 Detalhes do Cadastro de Fornecedor',
    'texto'  => 'Ao cadastrar um fornecedor, preencha as informações chave:<br><br>
                 1. <strong>Importar XML:</strong> Escolher o arqivo e improtar.<br>
                 2. <strong>CNPJ:</strong> Insira o CNPJ e mantem o padrão 00.000.000/000-00 a Inscrição Estadual para fins de nota fiscal.<br>
                 3. <strong>Nomes:</strong> Nome COMPLETO para facilitar a busca.<br>
                 4. <strong>Endereço:</strong> Preste bem aten~]ao no endereço  deixa complettinho.<br>
                 3. <strong>Contato Comercial:</strong> Não esqueça de preencher o nome e o telefone do <strong>Vendedor</strong>. Isso agiliza seus pedidos de compra!<br>
                 4. <strong>Localização:</strong> O endereço completo ajuda a calcular prazos de entrega da sua carga.<br>
                 5. <strong>Salvar:</strong> Clique no botão verde ao final para confirmar os dados.
                 6. <strong>Natureza Financeira:</strong> Conforme o plano contabil da emrpesa.<br>'
],



'compras_estoque' => [
    'palavras' => [
        'comprar', 'compra', 'compras', 'entrada de estoque', 'registrar compra', 'repor gás', 'cadastrar comrpas', 'cadastrar compra',
        'pagar fornecedor', 'entrada de produto', 'fechar compra'
    ],
    'titulo' => '📦 Registro de Compras e Entrada de Estoque',
    'texto'  => 'Este módulo alimenta seu estoque e seu financeiro de forma automática:<br><br>
                 1. <strong>Fornecedor e Produto:</strong> Selecione quem forneceu e qual item está entrando.<br>
                 2. <strong>Estoque:</strong> A quantidade informada será <strong>somada</strong> ao seu estoque atual automaticamente.<br>
                 3. <strong>Regras Financeiras:</strong><br>
                    - <strong>Dinheiro:</strong> Gera saída direta no seu CAIXA.<br>
                    - <strong>PIX:</strong> Gera saída direta no seu CAIXA_BANCO.<br>
                    - <strong>Cartão/Nota:</strong> Gera um registro no seu CONTAS A PAGAR.<br>
                 4. <strong>Conclusão:</strong> Clique em salvar para que o sistema atualize seus saldos e inventário instantaneamente.'
],

'compras_estoque' => [
    'palavras' => ['comprar', 'entrada', 'estoque'],
    'titulo' => '📦 Registro de Compras',
    'texto'  => 'Esta tela soma produtos ao estoque e organiza o financeiro.<br><br>' . 
                 '<a href="manual.php?topico=compras" target="_blank" style="color: #28a745; font-weight: bold; text-decoration: underline;">' .
                 '👉 Clique aqui para abrir o manual com fotos</a>'
],


    /*   'clientes' => [
            'palavras' => [
                'cliente',
                'clientes',
                'cadastrar cliente',
                'criar cliente',
                'novo cliente',
                'incluir cliente',
                'registro de cliente'
            ],
            'titulo' => 'Cadastro de Clientes',
            'texto'  => 'Vá em Cadastro → Clientes.
                         Preencha Nome, Telefone, Endereço, Número, Bairro e Cidade.
                         Clique em Salvar.'
        ],*/

        'pedidos' => [
            'palavras' => [
                'pedido',
                'pedidos',
                'coleta',
                'venda',
                'vender',
                'novo pedido',
                'registrar venda'
            ],
            'titulo' => 'Pedidos de Coleta',
            'texto'  => 'Acesse Movimentação → Pedidos de Coleta.
                         Selecione o cliente, adicione produtos e escolha forma de pagamento.
                         Clique em Salvar Coleta.'
        ],


         'consulta coleta' => [
            'palavras' => [
                'consultar',
                'consulta',
                'alteração',
                'exclusao',
                
            ],
            'titulo' => 'Consultar Coletas',
            'texto'  => 'Acesse Movimentação → Consultar Coleta.
                         Selecione a coleta e escolha entre alterar ou excluir.'
                      
        ],

        'estoque' => [
            'palavras' => [
                'estoque',
                'produto em estoque',
                'quantidade disponível',
                'entrada de produto'
            ],
            'titulo' => 'Controle de Estoque',
            'texto'  => 'O estoque é atualizado automaticamente ao salvar um Pedido.
                         Entradas vêm de Compras.
                         Saídas vêm de Pedidos.'
        ],

        'financeiro' => [
            'palavras' => [
                'contas',
                'contas a receber',
                'financeiro',
                'pagamento',
                'receber'
            ],
            'titulo' => 'Contas a Receber',
            'texto'  => 'Geradas automaticamente ao salvar um Pedido a prazo.
                         Consulte em Financeiro → Contas a Receber.'
        ]
    ];

    foreach ($intencoes as $intencao) {
        foreach ($intencao['palavras'] as $palavra) {
            if (str_contains($pergunta, $palavra)) {
                return response()->json([
                    'resposta' => "<strong>{$intencao['titulo']}</strong><br>{$intencao['texto']}"
                ]);
            }
        }
    }

    return response()->json([
        'resposta' => 'Não encontrei essa informação.
                       Tente perguntar sobre Clientes, Pedidos, Estoque ou Financeiro.'
    ]);
}
}