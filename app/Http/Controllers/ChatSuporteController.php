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
                'palavras' => ['acessar o sistema', 'login', 'entrar', 'senha', 'conectar', 'acesso', 'como entrar'],
                'titulo' => '🔑 Como Acessar o Sistema',
                'texto'  => '1. Acesse a tela de login.<br>
                             2. Informe o <strong>Cód. Usuário</strong>, <strong>Usuário</strong> e <strong>Senha</strong>.<br>
                             3. Clique em <strong>Entrar</strong> e escolha o módulo desejado.<br>
                             4. <em>Dica: O sistema diferencia maiúsculas de minúsculas!</em>'
            ],

            'clientes' => [
                'palavras' => ['cliente', 'clientes', 'cadastrar cliente', 'novo cliente', 'alterar endereço'],
                'titulo' => '👥 Gestão de Clientes',
                'texto'  => 'Para gerenciar seus clientes, acesse o menu <strong>Cadastro → Clientes</strong>.<br><br>' . 
                 'Lá você pode realizar novos cadastros e buscar registros existentes para edição.<br><br>' . 
                 '<a href="/manual.php?topico=clientes" target="_blank" style="color: #28a745; font-weight: bold; text-decoration: underline;">' .
                 '👉 Clique aqui para ver o manual completo de Clientes</a>'
            ],

            'formulario_cliente' => [
                'palavras' => ['preencher cadastro', 'campos cliente', 'cadastrar novo', 'como cadastrar o cliente', 'salvar cliente', 'aniversário cliente'],
                'titulo' => '📝 Preenchendo o Cadastro de Cliente',
                'texto'  => 'Siga estas orientações para um cadastro perfeito:<br><br>
                             1. <strong>Identificação:</strong> Insira CPF ou CNPJ.<br>
                             2. <strong>Endereço Preciso:</strong> Rua, Número e Bairro separados.<br>
                             3. <strong>Ponto de Referência:</strong> Use o campo <strong>Observação</strong> (ex: ao lado do bar).<br>
                             4. <strong>Finalizar:</strong> Clique em <strong>Salvar</strong>.<br><br>
                             <a href="manual.php?topico=cad_cliente" target="_blank" style="color: #28a745; font-weight: bold;">👉 Clique aqui para ver o manual com fotos</a>'
            ],



            'compras' => [
                        'palavras' => ['cadastrar compras', 'cadastrar compra', 'compra', 'compras', 'entrada de nota', 'lançar nota',
                        'lançar despesa', 'lançar despesas', 'repor estoque', 'entrada de estoque'],
                        'titulo' => '🛒 Entrada de Compras',
                        'texto'  => 'Para registrar a chegada de mercadorias e atualizar seu estoque, acesse <strong>Cadastro → Compras</strong>.<br><br>' . 
                            '<a href="/manual.php?topico=compras" target="_blank" style="color: #28a745; font-weight: bold; text-decoration: underline;">' .
                            '👉 Clique aqui para ver o manual de Compras com as telas</a>'
            ],

                'formulario_fornecedores' => [
                                'palavras' => ['preencher fornecedor', 'dados fornecedor', 'fornecedor',  'cnpj fornecedor', 'cadastro de fornecedor',
                                'cadastro fornecedores', 'cadastro de fornecedores', 
                                'vendedor', 'razão social'],
                                'titulo' => '📝 Cadastro de Fornecedor',
                                'texto'  => 'Preencha as informações chave:<br><br>
                                            1. <strong>ACESSAR:</strong> Cadastro -> Fornecedor.<br>
                                            2. <strong>Importar XML:</strong> Escolha o arquivo para agilizar.<br>
                                            3. <strong>CNPJ:</strong> Mantenha o padrão 00.000.000/000-00.<br>
                                            4. <strong>Vendedor:</strong> Preencha nome e telefone para agilizar pedidos.<br><br>
                                            <a href="/manual.php?topico=fornecedores" target="_blank" style="color: #28a745; font-weight: bold;">' .
                                            '👉 Clique aqui para ver o manual com fotos</a>'
            ],





            'pedidos_coleta' => [
                'palavras' => ['fazer pedido', 'vender gás', 'nova coleta', 'lançar venda', 'forma de pagamento', 'selecionar produto', 'valor total'],
                'titulo' => '📦 Realizando um Pedido de Coleta',
                'texto'  => 'Este módulo é 95% automatizado:<br><br>
                             1. <strong>Busca:</strong> Digite nome/telefone em "PESQUISAR CLIENTE".<br>
                             2. <strong>Confirmação:</strong> O sistema puxa o endereço automático.<br>
                             3. <strong>Produtos:</strong> Selecione o item e a quantidade.<br>
                             4. <strong>Conclusão:</strong> Clique em <strong>Salvar Coleta</strong>.<br><br>
                             <a href="manual.php?topico=vendas" target="_blank" style="color: #28a745; font-weight: bold;">👉 Clique aqui para ver o manual com fotos</a>'
            ],

           'produtos' => [
                'palavras' => ['produto', 'produtos', 'cadastrar produto', 'preço de venda', 'estoque', 'unidade'],
                'titulo' => '📦 Gestão de Produtos e Estoque',
                'texto'  => 'Para gerenciar seus itens de venda, acesse <strong>Cadastro → Produtos</strong>.<br><br>' . 
                            'Lá você define preços, unidades de medida e o estoque mínimo.<br><br>' . 
                            '<a href="/manual.php?topico=produtos" target="_blank" style="color: #28a745; font-weight: bold; text-decoration: underline;">' .
                            '👉 Clique aqui para ver o manual de Produtos com fotos</a>'
            ],

            'formulario_fornecedores' => [
                'palavras' => ['preencher fornecedor', 'dados fornecedor', 'fornecedor',  'cnpj fornecedor', 'cadastro de fornecedor',
                 'cadastro fornecedores', 'cadastro de fornecedores', 
                'vendedor', 'razão social'],
                'titulo' => '📝 Cadastro de Fornecedor',
                'texto'  => 'Preencha as informações chave:<br><br>
                             1. <strong>ACESSAR:</strong> Cadastro -> Fornecedor.<br>
                             2. <strong>Importar XML:</strong> Escolha o arquivo para agilizar.<br>
                             3. <strong>CNPJ:</strong> Mantenha o padrão 00.000.000/000-00.<br>
                             4. <strong>Vendedor:</strong> Preencha nome e telefone para agilizar pedidos.<br><br>
                             <a href="/manual.php?topico=fornecedores" target="_blank" style="color: #28a745; font-weight: bold;">' .
                             '👉 Clique aqui para ver o manual com fotos</a>'
            ],

         

            'formulario_usuario' => [
                'palavras' => [
                    'cadastrar usuario', 'cadastro de usuario',  'cadastro de usuários','criar login', 'novo acesso', 'novo usuario', 'permissão de acesso', 
                    'adicionar funcionario', 'mudar senha', 'tipo de perfil', 'perfil de usuario', 
                ],
                'titulo' => '👤 Criando Acesso de Usuário',
                'texto'  => 'Siga estas orientações para configurar um novo acesso:<br><br>
                            1. <strong>Identificação:</strong> Defina um <strong>Usuário</strong> (login) e o Nome completo.<br>
                            2. <strong>E-mail:</strong> Use um e-mail válido para recuperação de senha.<br>
                            3. <strong>Segurança:</strong> Digite uma senha segura para o funcionário.<br>
                            4. <strong>Nível de Acesso:</strong> Escolha o <strong>Tipo</strong> e o <strong>Perfil</strong> (Adm, Gerente, Operacional ou Financeiro).<br><br>
                            <a href="/manual.php?topico=usuarios" target="_blank" style="color: #28a745; font-weight: bold;">' .
                            '👉 Clique aqui para ver o manual de Usuários com fotos</a>'
            ],

            'movimentacao_pedido' => [
                'palavras' => [ 'Emissao de coleta', 'cadastrar coleta',
                 'cadastrar coletas', 'Consultar Coleta',
                 'cadastrar pedidos', 'pedidos de coleta', 'pedido de coleta', 'fazer pedido', 'lançar coleta',
                  'novo pedido', 'buscar cliente pedido', 'forma de pagamento pedido', 'salvar coleta'],

                'titulo' => '📦 Lançando um Pedido de Coleta - Movimentação -> Pedidos de Coleta',
                'texto'  => 'Para lançar um novo pedido, siga estes dois passos principais:<br><br>
                            1. <strong>Pesquisar Cliente:</strong> Use o campo "Pesquisar Cliente" para puxar os dados automaticamente.
                               digitando o nome ou telefone do cliente o sistema vai buscar tudo que contem. Lembre-se: dados de endereço não podem ser alterados nesta tela.<br>
                            2. <strong>Cadastrar Cliente:</strong> Caso o cliente não é cadastrado pode cadastrá-lo por aqui.<br>
                            3. <strong>Itens e Valores:</strong> Adicione os produtos, escolha a forma de pagamento e o prazo.<br><br>
                            <strong>Importante:</strong> Confira o valor total antes de clicar em <strong>Salvar Coleta</strong>.<br><br>
                            <a href="\manual.php?topico=pedidos_coleta" target="_blank" style="color: #28a745; font-weight: bold;">' .
                            '👉 Clique aqui para ver o passo a passo completo</a>'
            ],

            'financeiro_contas_pagar' => [
                'palavras' => ['contas a pagar', 'pagar conta',  'despesas', 'pagamentos', 'fornecedor a pagar', 'vencimento de conta'],
                'titulo' => '💸 Controle de Contas a Pagar',
                'texto'  => 'Para lançar e acompanhar despesas da empresa, acesse <strong>Financeiro → Contas a Pagar</strong>.<br><br>' .
                            'Nessa tela você encontra as despesas como aluguel, energia, água, impostos e outras despesas.<br><br>' .
                            'Também é possível definir vencimento, consultar contas em aberto e realizar a baixa após o pagamento.<br><br>' .
                            '<a href="/manual.php?topico=financeiro_contas_pagar" target="_blank" style="color: #28a745; font-weight: bold; text-decoration: underline;">' .
                            '👉 Clique aqui para ver o manual completo de Contas a Pagar</a>'
            ],

            'financeiro_contas_receber' => [
                'palavras' => ['contas a receber', 'receber conta', 'recebimentos', 'cobrança', 'cobranca', 'parcelas', 'valor a receber', 'inadimplencia', 'inadimplência'],
                'titulo' => '💰 Controle de Contas a Receber',
                'texto'  => 'Para acompanhar valores que a empresa tem a receber, acesse <strong>Financeiro → Contas a Receber</strong>.<br><br>' .
                            'Essa opção permite registrar vendas a prazo, cobranças pendentes, parcelas e outros recebimentos futuros.<br><br>' .
                            'Você pode consultar títulos em aberto, controlar vencimentos e realizar a baixa quando o cliente efetuar o pagamento.<br><br>' .
                            '<a href="/manual.php?topico=financeiro_contas_receber" target="_blank" style="color: #28a745; font-weight: bold; text-decoration: underline;">' .
                            '👉 Clique aqui para ver o manual completo de Contas a Receber</a>'
            ],

            'financeiro_formas_pagamento' => [
                'palavras' => ['formas de pagamento', 'forma de pagamento', 'cadastrar forma de pagamento', 'pix', 'cartão', 'cartao', 'dinheiro', 'boleto'],
                'titulo' => '💳 Cadastro de Formas de Pagamento',
                'texto'  => 'Para consultar os meios de pagamento usados pela empresa, acesse <strong>Financeiro → Formas de Pagamento</strong>.<br><br>' .
                            'Nessa tela você pode consultar opções como dinheiro, pix, cartão, boleto, transferência e outras modalidades utilizadas na operação.<br><br>' .
                            'Manter esse cadastro atualizado ajuda no lançamento correto das vendas e melhora os relatórios financeiros.<br><br>' .
                            'Precisando acrescentar modalidades de pagamento entre em contato com SUPORTE.<br><br>' .
                            '<a href="/manual.php?topico=financeiro_formas_pagamento" target="_blank" style="color: #28a745; font-weight: bold; text-decoration: underline;">' .
                            '👉 Clique aqui para ver o manual completo de Formas de Pagamento</a>'
            ],

            'financeiro_caixa' => [
                'palavras' => ['caixa', 'movimentação de caixa', 'movimentacao de caixa', 'fechamento de caixa', 'saldo do caixa', 'conferir caixa'],
                'titulo' => '🏦 Movimentação de Caixa',
                'texto'  => 'Para acompanhar a movimentação financeira do dia, acesse <strong>Financeiro → Caixa</strong>.<br><br>' .
                            'Nessa rotina é possível consultar entradas, saídas, suprimentos, sangrias, ajustes e o saldo atual do caixa.<br><br>' .
                            'Essa conferência é importante para validar os valores movimentados durante o expediente e apoiar o fechamento diário.<br><br>' .
                            '<a href="/manual.php?topico=financeiro_caixa" target="_blank" style="color: #28a745; font-weight: bold; text-decoration: underline;">' .
                            '👉 Clique aqui para ver o manual completo de Caixa</a>'
            ],




            'financeiro_previsao_caixa' => [
            'palavras' => ['previsão', 'previsao'],  
            'titulo' => '🗓️ FINANCEIRO -> PREVISÃO DE CAIXA',
            'texto'  => "**Tela de Previsão de Caixa**\n\n" .
            "Esta tela permite visualizar a previsão financeira do caixa em um determinado período,
             apresentando os valores previstos a pagar, a receber e o saldo projetado por dia.\n\n" .                 

               '<a href="/manual.php?topico=financeiro_previsao_caixa" target="_blank" style="color: #28a745; font-weight: bold; text-decoration: underline;">' .
                            '👉 Clique aqui para ver o manual completo de Previsão  Caixa</a>'
        ],


            'financeiro_abrir_caixa' => [
                'palavras' => ['abrir caixa', 'abertura de caixa', 'iniciar caixa', 'valor inicial do caixa', 'abrir o caixa'],
                'titulo' => '🔓 Abertura de Caixa',
                'texto'  => 'Para iniciar as movimentações financeiras do dia, acesse <strong>Financeiro → Abrir Caixa</strong>.<br><br>' .
                            'Nessa opção o usuário registra a abertura do caixa, informa o valor inicial e libera o sistema para recebimentos e lançamentos do período.<br><br>' .
                            'A abertura correta garante mais controle sobre o saldo inicial e melhora a conferência no fechamento.<br><br>' .
                            '<a href="/manual.php?topico=financeiro_abrir_caixa" target="_blank" style="color: #28a745; font-weight: bold; text-decoration: underline;">' .
                            '👉 Clique aqui para ver o manual completo de Abertura de Caixa</a>'
            ],






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
            'resposta' => 'Não encontrei essa informação. Tente perguntar sobre 
            Clientes, Compras, Fornecedores, Pedidos, Cadastrar Coleta, Estoque,
            Cadastro de usuários, Contas a Pagar, Contas a Receber, Formas de Pagamento,
            Caixa, Previsão de Caixa e Abrir o caixa).'
        ]);
    }
}