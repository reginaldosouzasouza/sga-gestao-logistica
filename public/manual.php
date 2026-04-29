<?php
// Captura o tópico da URL. Ex: manual.php?topico=clientes
$topico = $_GET['topico'] ?? 'inicio';

// Configurações de títulos e conteúdos
$conteudo = [
    'inicio' => [
        'titulo' => 'Bem-vindo ao Manual do SGA',
        'texto'  => 'Selecione um tópico no chat para ver as instruções detalhadas.'
    ],
   
    'clientes' => [
        'titulo' => '📁 CADASTRO -> CLIENTES',
        'texto'  => "O cadastro de clientes é a base para suas vendas e entregas. Siga as instruções abaixo:\n\n" .
                    "**1. Localização e Busca:**\n" .
                    "• Utilize a barra de pesquisa no topo da tela para encontrar clientes rapidamente.\n\n" .
                    "**2. Novo Cadastro:**\n" .
                    "• Clique no botão verde **'Cadastrar Cliente'** para abrir o formulário.\n\n" .
                    "**3. Preenchimento:**\n" .
                    "• Nome, Endereço Detalhado e WhatsApp são cruciais para o entregador.\n\n" .
                    "**4. Finalização:**\n" .
                    "• Clique em salvar para gravar o registro.",
        'imagens' => [
            'images/imagem/manual_telas/cad_clientes/Tutorial_clientes.png',
        ]
    ],

    'compras' => [
        'titulo' => '🛒 MOVIMENTAÇÃO -> COMPRAS',
        'texto'  => "Alimenta seu estoque e gera contas a pagar automaticamente.\n\n" .
                    "**ATENÇÃO:** Pagamentos em DINHEIRO ou PIX geram saída imediata do caixa. Outras modalidades geram Contas a Pagar.",
        'imagens' => [
            'images/imagem/manual_telas/cad_compras/Tutorial_compras.png',
             'images/imagem/manual_telas/cad_compras/Tutorial1_compras.png'
           
        ]
    ],

    'fornecedores' => [
        'titulo' => '🤝 CADASTRO -> FORNECEDOR',
        'texto'  => "Módulo para registro de fornecedores de Gás, Água e Vasilhames.\n\n" .
                    "**1. Importação XML:** Use o botão para agilizar o cadastro.\n" .
                    "**2. Natureza Financeira:** Defina como 'Estoque (CMV)' para o balanço correto.",
        'imagens' => [
            'images/imagem/manual_telas/cad_fornecedor/Tutorial_fornecedor.png',
            'images/imagem/manual_telas/cad_fornecedor/Tutorial_fornecedor_1.png'
        ]
    ],



    'produtos' => [
        'titulo' => '📦 Cadastro de Produtos',
        'texto'  => "Nesta tela você define preços de custo, venda e estoque mínimo. Confira os detalhes nas imagens abaixo:",
        'imagens' => [
            'images/imagem/manual_telas/cad_produtos/tutorial_produtos.png',
            'images/imagem/manual_telas/cad_produtos/tutorial_produtos_1.png',
            'images/imagem/manual_telas/cad_produtos/tutorial_produtos_2.png'
        ]
    ],

    
   

    'usuarios' => [
        'titulo' => '👤 CADASTRO -> USUÁRIOS',
        'texto'  => "Este módulo permite gerenciar quem acessa o sistema e o que cada pessoa pode fazer. Uma configuração correta garante a segurança dos seus dados financeiros e de estoque.\n\n" .
                    "**1. Dados de Identificação:**\n" .
                    "• **Usuário:** Defina um login curto (ex: joao) para o acesso rápido.\n" .
                    "• **Nome Completo:** Facilita a identificação em logs de atividades e relatórios.\n" .
                    "• **E-mail:** Essencial para comunicações oficiais e recuperação de acesso.\n\n" .
                    "**2. Segurança:**\n" .
                    "• **Senha:** Defina uma senha segura para cada novo funcionário.\n\n" .
                    "**3. Níveis de Acesso (Tipo e Perfil):**\n" .
                    "• **Administrador:** Acesso total a todas as funções, inclusive exclusões e financeiro.\n" .
                    "• **Gerente:** Acesso amplo, mas com restrições em configurações críticas.\n" .
                    "• **Financeiro:** Focado apenas em contas a pagar/receber e fluxo de caixa.\n" .
                    "• **Operacional:** Ideal para quem faz vendas, entregas e consulta de estoque.\n\n" .
                    "**DICA:** Sempre selecione o perfil que mais se adequa à função real do funcionário para evitar erros operacionais.",
        'imagens' => [
            'images/imagem/manual_telas/cad_usuarios/Tutorial_usuario_1.png',
            'images/imagem/manual_telas/cad_usuarios/Tutorial_usuario_2.png'
        ]
    ],

    'pedidos_coleta' => [
        'titulo' => '📦 MOVIMENTAÇÃO -> PEDIDOS DE COLETA',
        'texto'  => "Este módulo é o coração da sua operação de entrega. Ele une os dados do cliente aos produtos vendidos.\n\n" .
                    "**PARTE 1: Identificação do Cliente (Busca)**\n" .
                    "• **Pesquisar Cliente:** Digite o nome ou telefone. O sistema buscará os dados cadastrados automaticamente.\n" .
                    "• **Dados Bloqueados:** Campos como CPF, Nome e Endereço são preenchidos pelo sistema para garantir a segurança. Se houver erro no endereço, você deve corrigi-lo no menu *Cadastro -> Clientes*.\n" .
                    "• **Data e Controle:** A data da coleta e o número do controle são gerados automaticamente para facilitar o rastreio.\n\n" .
                    "**PARTE 2: Itens, Pagamentos e Prazos**\n" .
                    "• **Produtos:** Selecione o item, a quantidade e o valor unitário. Clique em **Adicionar Produto** para somar ao pedido.\n" .
                    "• **Pagamentos:** Defina a **Forma de Pagamento** (Dinheiro, PIX, Cartão) e o **Prazo** combinado.\n" .
                    "• **Finalização:** Verifique o **Valor Total do Pedido** e clique em **Salvar Coleta** para enviar o pedido para a expedição.",
        'imagens' => [
            'images/imagem/manual_telas/mov_pedidos/tutorial_Movimentacao.png',
            'images/imagem/manual_telas/mov_pedidos/tutorial1_Movimentacao.png',
            'images/imagem/manual_telas/mov_pedidos/tutorial2_Movimentacao.png',
            'images/imagem/manual_telas/mov_pedidos/tutorial3_Movimentacao.png'
        ]
    ],





        'financeiro_contas_pagar' => [
        'titulo' => '💸 FINANCEIRO -> CONTAS A PAGAR',
        'texto'  => "Esta rotina é usada para registrar e acompanhar todas as despesas da empresa.\n\n" .
                    "**1. Lembrando que o lançamento de todas as  Despesas é feito pelo <strong>COMPRAS</strong> (Cadastro -> COMPRAS) **\n" .
                    "• Consulte contas como fornecedores, aluguel, energia, água, impostos e outras obrigações financeiras.\n\n" .
                    "**2. Controle de Vencimento:**\n" .
                    "• Informe corretamente a data de vencimento para manter a organização dos pagamentos.\n\n" .
                    "**3. Baixa de Pagamento:**\n" .
                    "• Após o pagamento realizado, registre a baixa para manter o financeiro atualizado.\n\n" .
                    "**4. Acompanhamento:**\n" .
                    "• Utilize esta tela para consultar contas em aberto e títulos vencidos.",
        'imagens' => [
            'images/imagem/manual_telas/contas_a_pagar/tutorial_contas_a_pagar.png',
            'images/imagem/manual_telas/contas_a_pagar/tutorial1_contas_a_pagar.png'
        ]
    ],

    'financeiro_contas_receber' => [
        'titulo' => '💰 FINANCEIRO -> CONTAS A RECEBER',
        'texto'  => "Esta rotina permite controlar todos os valores que a empresa ainda tem para receber.\n\n" .
                    "**1. Registro de Recebimentos:**\n" .
                    "• Cadastre valores de vendas a prazo, cobranças pendentes, parcelas e demais recebimentos futuros.\n\n" .
                    "**2. Controle por Cliente:**\n" .
                    "• Vincule corretamente o lançamento ao cliente para facilitar consultas e cobranças.\n\n" .
                    "**3. Baixa de Recebimento:**\n" .
                    "• Após o pagamento do cliente, faça a baixa do título para manter o saldo atualizado.\n\n" .
                    "**4. Acompanhamento:**\n" .
                    "• Consulte contas em aberto, vencimentos e títulos em atraso.",
        'imagens' => [
            'images/imagem/manual_telas/contas_a_receber/tutorial_contas_a_receber.png',
            'images/imagem/manual_telas/contas_a_receber/tutorial1_contas_a_receber.png',
            'images/imagem/manual_telas/contas_a_receber/tutorial2_contas_a_receber.png'
        ]
    ],

    'financeiro_formas_pagamento' => [
        'titulo' => '💳 FINANCEIRO -> FORMAS DE PAGAMENTO',
        'texto'  => "Nesta tela você cadastra e organiza os meios de pagamento utilizados pela empresa.\n\n" .
                    "**1. Cadastro de Formas:**\n" .
                    "• Registre opções como dinheiro, pix, cartão de débito, cartão de crédito, boleto e transferência.\n\n" .
                    "**2. Padronização:**\n" .
                    "• Mantenha os nomes organizados para facilitar o uso nas vendas e relatórios.\n\n" .
                    "**3. Manutenção do Cadastro:**\n" .
                    "• Precisando acrescentar modalidades de pagamento entre em contato com SUPORTE.\n\n" .
                    "**4. Importância Operacional:**\n" .
                    "• O cadastro correto melhora o lançamento das vendas e a análise financeira do sistema.",
        'imagens' => [
            'images/imagem/manual_telas/Formas_de_Pagamento/Tutorial_formas_de_pagamento.png'
        ]
    ],

        'financeiro_caixa' => [
    'titulo' => '🏦 FINANCEIRO -> CAIXA',
    'texto'  => "**Tela de Controle de Caixa**\n\n" .
        "**1. Objetivo da Tela**\n" .
        "A Tela de Controle de Caixa tem a finalidade de permitir o acompanhamento e a conferência das movimentações financeiras realizadas no dia, separando os valores por Caixa em Dinheiro e Caixa Banco (PIX).\n\n" .
        "Além disso, a tela apresenta o saldo geral consolidado, facilitando o controle operacional e o fechamento diário do caixa.\n\n" .

        "**2. Finalidade de Uso**\n" .
        "Esta tela deve ser utilizada para:\n" .
        "• acompanhar as entradas e saídas do caixa em tempo real;\n" .
        "• visualizar os saldos atualizados por tipo de movimentação;\n" .
        "• consultar os lançamentos realizados no dia;\n" .
        "• estornar movimentações registradas de forma incorreta;\n" .
        "• realizar o fechamento diário do caixa.\n\n" .

        "**3. Informações Apresentadas na Tela**\n" .
        "**3.1 Status do Caixa**\n" .
        "Na parte superior da tela é exibida a informação \"Caixa Aberto\", acompanhada da data de referência.\n\n" .
        "Essa informação indica que o caixa do dia está em operação e apto a receber novos lançamentos.\n\n" .

        "**3.2 Resumo dos Saldos**\n" .
        "Logo abaixo do título principal, a tela apresenta três quadros de resumo financeiro:\n\n" .

        "**Caixa (Dinheiro)**\n" .
        "Apresenta o saldo atual disponível em dinheiro.\n" .
        "Também informa:\n" .
        "• total de entradas;\n" .
        "• total de saídas.\n\n" .

        "**Caixa Banco (PIX)**\n" .
        "Apresenta o saldo atual das movimentações realizadas por banco ou PIX.\n" .
        "Também informa:\n" .
        "• total de entradas;\n" .
        "• total de saídas.\n\n" .

        "**Saldo Geral**\n" .
        "Exibe a soma do saldo do Caixa (Dinheiro) com o saldo do Caixa Banco (PIX), permitindo uma visão consolidada do total movimentado ou disponível no caixa.\n\n" .

        "**4. Botão Fechar Caixa**\n" .
        "O botão Fechar Caixa deve ser utilizado ao final do expediente, após a conferência de todas as movimentações do dia.\n\n" .
        "Ao realizar o fechamento, o usuário encerra o caixa diário, concluindo oficialmente as operações daquele período.\n\n" .
        "Importante: antes de fechar o caixa, recomenda-se verificar se todos os lançamentos foram registrados corretamente.\n\n" .

        "**5. Detalhamento das Movimentações**\n" .
        "Na parte inferior da tela, o sistema apresenta duas áreas de consulta de lançamentos:\n\n" .

        "**5.1 Caixa (Dinheiro)**\n" .
        "Esta seção lista todas as movimentações registradas em dinheiro.\n\n" .
        "Para cada lançamento, são exibidas as seguintes informações:\n" .
        "• Data: data em que a movimentação foi registrada;\n" .
        "• Tipo: identifica se o lançamento é uma entrada ou uma saída;\n" .
        "• Valor: valor financeiro da movimentação;\n" .
        "• Origem: informa a origem do lançamento;\n" .
        "• Descrição: apresenta detalhes complementares da operação;\n" .
        "• Ações: opções disponíveis para tratamento do registro.\n\n" .

        "**5.2 Caixa Banco (PIX)**\n" .
        "Esta seção apresenta os lançamentos realizados por meio de banco ou PIX.\n\n" .
        "Os campos exibidos seguem o mesmo padrão do caixa em dinheiro:\n" .
        "• Data: data da movimentação;\n" .
        "• Tipo: entrada ou saída;\n" .
        "• Valor: valor registrado;\n" .
        "• Origem: origem do lançamento;\n" .
        "• Descrição: detalhamento da operação;\n" .
        "• Ações: recursos disponíveis para o registro.\n\n" .

        "**6. Ações Disponíveis**\n" .
        "Cada lançamento pode apresentar ações operacionais, conforme as permissões e regras do sistema.\n\n" .
        "Entre as ações disponíveis, destacam-se:\n\n" .

        "**Excluir**\n" .
        "Permite remover um lançamento, quando aplicável.\n\n" .

        "**Estornar**\n" .
        "Permite desfazer uma movimentação registrada incorretamente, garantindo maior segurança e confiabilidade no controle do caixa.\n\n" .
        "O uso do estorno é recomendado sempre que houver necessidade de correção sem comprometer o histórico das operações.\n\n" .

        "**7. Regras de Utilização**\n" .
        "Para o uso correto da tela, o usuário deve observar as seguintes regras:\n" .
        "• conferir se o caixa está aberto antes de realizar movimentações;\n" .
        "• verificar se o lançamento está sendo registrado no caixa correto;\n" .
        "• acompanhar separadamente os valores de dinheiro e banco/PIX;\n" .
        "• utilizar o estorno em caso de lançamento incorreto;\n" .
        "• fechar o caixa somente após revisar todas as entradas e saídas do dia.\n\n" .

        "**8. Benefícios da Tela**\n" .
        "A utilização desta tela proporciona os seguintes benefícios:\n" .
        "• maior controle das movimentações financeiras;\n" .
        "• organização dos lançamentos por tipo de recebimento;\n" .
        "• conferência rápida dos saldos;\n" .
        "• redução de erros operacionais;\n" .
        "• apoio ao fechamento diário do caixa;\n" .
        "• mais segurança no controle financeiro da empresa.\n\n" .

        "**9. Observações Importantes**\n" .
        "• Os valores apresentados nos quadros superiores são atualizados de acordo com os lançamentos realizados.\n" .
        "• As movimentações ficam separadas por tipo de caixa para facilitar a conferência.\n" .
        "• O fechamento do caixa deve ser feito com atenção, preferencialmente após a revisão completa dos registros do dia.\n\n" .

        "**10. Resumo**\n" .
        "A Tela de Controle de Caixa é uma ferramenta essencial para o gerenciamento financeiro diário,
        pois permite acompanhar entradas, saídas e saldos de forma clara, organizada e segura.
        Sua principal função é garantir o controle das operações de caixa e facilitar o 
        processo de conferência e fechamento diário.",

    'imagens' => [
            'images/imagem/manual_telas/caixa/tutorial_caixa.png'
        ]
],

                    'financeiro_previsao_caixa' => [
                'titulo' => '🏦 FINANCEIRO -> CAIXA',
                'texto'  => "**Tela de Previsão do Caixa**\n\n" .
            "Esta tela permite visualizar a previsão financeira do caixa em um determinado período, apresentando os valores previstos a pagar, a receber e o saldo projetado por dia.\n\n" .

            "**1. Objetivo**\n" .
            "• Consultar a previsão do caixa por período.\n" .
            "• Acompanhar despesas previstas e valores a receber.\n" .
            "• Analisar o saldo projetado de cada dia.\n\n" .

            "**2. Filtro por Período**\n" .
            "• A tela permite consultar a previsão utilizando períodos rápidos, como 7 dias e 15 dias.\n" .
            "• Também é possível informar manualmente a data inicial e a data final para realizar a pesquisa.\n" .
            "• Após definir o período, basta clicar no botão Filtrar.\n\n" .

            "**3. Resumo da Previsão**\n" .
            "Na parte superior da tela são apresentados os totais do período consultado:\n" .
            "• Total a Pagar: soma de todas as despesas previstas no período.\n" .
            "• Total a Receber: soma de todos os valores previstos para recebimento.\n" .
            "• Saldo Projetado: resultado da previsão financeira considerando os valores a pagar e a receber.\n\n" .

            "**4. Detalhamento por Dia**\n" .
            "A tela apresenta a previsão organizada por data, permitindo visualizar diariamente as movimentações previstas.\n\n" .
            "Para cada dia, o sistema exibe:\n" .
            "• contas a pagar previstas;\n" .
            "• contas a receber previstas;\n" .
            "• saldo projetado do dia.\n\n" .

            "**5. Contas a Pagar**\n" .
            "Na coluna de contas a pagar são listadas as despesas previstas para a data selecionada.\n" .
            "Esses lançamentos podem incluir compras, parcelas, pagamentos operacionais e outras obrigações financeiras.\n\n" .

            "**6. Contas a Receber**\n" .
            "Na coluna de contas a receber são exibidos os valores previstos de entrada para cada data.\n" .
            "Esses recebimentos podem ser originados de vendas, coletas, depósitos, entregas ou outros lançamentos financeiros previstos.\n\n" .

            "**7. Saldo Projetado**\n" .
            "Ao lado de cada data, o sistema apresenta o saldo projetado, permitindo ao usuário acompanhar a situação financeira prevista dia a dia.\n" .
            "Esse saldo auxilia na análise do caixa futuro, mostrando se haverá disponibilidade financeira ou necessidade de atenção em determinadas datas.\n\n" .

            "**8. Regras de Utilização**\n" .
            "• Defina corretamente o período da consulta antes de filtrar.\n" .
            "• Analise os valores a pagar e a receber em conjunto.\n" .
            "• Observe o saldo projetado de cada dia para antecipar possíveis faltas ou sobras de caixa.\n" .
            "• Utilize essa tela como apoio no planejamento financeiro e na tomada de decisão.\n\n" .

            "**9. Benefícios da Tela**\n" .
            "• Melhor planejamento financeiro do período.\n" .
            "• Visão antecipada das despesas e receitas.\n" .
            "• Acompanhamento diário do saldo projetado.\n" .
            "• Apoio ao controle e à organização do caixa da empresa.\n\n" .

            "**Resumo**\n" .         
            "A Tela de Previsão de Caixa é utilizada para acompanhar a previsão financeira por período, 
            mostrando tudo o que a empresa tem a pagar, a receber e o saldo projetado por dia, facilitando o
             planejamento e o controle do caixa." ,

              'imagens' => [
            'images/imagem/manual_telas/caixa/tutorial_Previsao_CAIXA.png'
        ]

             

        ],             












    'financeiro_abrir_caixa' => [
        'titulo' => '🔓 FINANCEIRO -> ABRIR CAIXA',
        'texto'  => "Esta opção deve ser utilizada no início do expediente para liberar o caixa para movimentação.\n\n" .
                    "**1. Abertura do Caixa:**\n" .
                    "• Registre a abertura do caixa antes de iniciar vendas e recebimentos.\n\n" .
                    "**2. Valor Inicial:**\n" .
                    "• Informe corretamente o valor de abertura para garantir a conferência do saldo.\n\n" .
                    "**3. Identificação da Operação:**\n" .
                    "• Verifique usuário, data e hora da abertura.\n\n" .
                    "**4. Importância:**\n" .
                    "• A abertura correta permite rastrear toda a movimentação do período com mais segurança.",
        'imagens' => [
            'images/imagem/manual_telas/financeiro/abrir_caixa/tutorial_abrir_caixa.png'
        ]
    ],



];

$dados = $conteudo[$topico] ?? $conteudo['inicio'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manual SGA - <?php echo $dados['titulo']; ?></title>
    <style>
        /* Estilos da Página */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px; line-height: 1.6; color: #333; background-color: #f0f2f5; margin: 0; }
        .container { max-width: 900px; margin: 20px auto; border: 1px solid #ddd; padding: 40px; border-radius: 12px; background: #fff; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        h1 { color: #28a745; border-bottom: 3px solid #28a745; padding-bottom: 15px; margin-top: 0; }
        p { white-space: pre-wrap; font-size: 16px; }

        /* Estilo das miniaturas no Manual */
        .img-container { text-align: center; margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px; }
        .aviso-zoom { font-size: 14px; color: #28a745; font-weight: bold; margin-bottom: 10px; }
        .img-manual { 
            max-width: 100%; 
            height: auto; 
            border: 2px solid #ddd; 
            border-radius: 8px; 
            cursor: zoom-in; 
            transition: 0.3s; 
        }
        .img-manual:hover { transform: scale(1.02); box-shadow: 0 5px 15px rgba(0,0,0,0.2); }

        /* MODAL DE ZOOM (O SEGREDO PARA IMAGENS LONGAS) */
        #modalZoom {
            display: none; 
            position: fixed; 
            z-index: 9999; 
            top: 0; left: 0; 
            width: 100%; height: 100%; 
            background-color: rgba(0,0,0,0.95); 
            overflow-y: auto; /* PERMITE ROLAR A IMAGEM PARA BAIXO */
            padding: 40px 0;
            cursor: zoom-out;
        }
        #imgAmpliada { 
            margin: auto; 
            display: block; 
            width: 95%; /* FORÇA A LARGURA PARA FICAR GRANDE E LER AS LETRAS */
            max-width: 1100px; 
            height: auto; 
            border: 4px solid white; 
            border-radius: 5px; 
        }
        .fechar-modal {
            position: fixed;
            top: 10px; right: 25px;
            color: #fff; font-size: 50px; font-weight: bold;
            cursor: pointer; z-index: 10000;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1><?php echo $dados['titulo']; ?></h1>
        <p><?php echo $dados['texto']; ?></p>
        
        <?php if(isset($dados['imagens'])): ?>
            <?php foreach($dados['imagens'] as $img): ?>
                <div class="img-container">
                    <div class="aviso-zoom">🔍 Clique na imagem para ver em tamanho real e ler os detalhes</div>
                    <img src="<?php echo $img; ?>" class="img-manual" onclick="abrirZoom(this)">
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div id="modalZoom" onclick="this.style.display='none'">
        <span class="fechar-modal">&times;</span>
        <img id="imgAmpliada">
    </div>

    <script>
        function abrirZoom(elemento) {
            var modal = document.getElementById('modalZoom');
            var imagemGrande = document.getElementById('imgAmpliada');
            
            imagemGrande.src = elemento.src;
            modal.style.display = 'block'; // Usamos block para habilitar o scroll do overflow-y
            
            // Garante que o zoom comece pelo topo da imagem
            modal.scrollTop = 0;
        }
    </script>

</body>
</html>