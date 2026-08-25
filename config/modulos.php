<?php

/**
 * config/modulos.php
 *
 * Cada módulo declara:
 * - label  : nome exibido no title e na barra
 * - cor    : classe CSS
 * - accent : cor hex usada no JS de fallback
 * - menu   : array de grupos/itens que aparecem na navegação
 */

return [

    // ------------------------------------------------------------------ OFICINA
    'oficina' => [
        'label'  => 'Oficina',
        'cor'    => 'mod-oficina',
        'accent' => '#4b4b4b',

        'menu' => [
            [
                'label'  => 'Movimentação',
                'url'    => '#',
                'icone'  => '',
                'filhos' => [
                    [
                        'label' => 'Ordens de Serviço',
                        'url'   => '/oficina-link/ordens-servico',
                    ],
                    [
                        'label' => 'Criar Ordem de Serviço',
                        'url'   => '/oficina-link/ordens-servico-create',
                    ],
                    [
                        'label' => 'Pedidos de Coleta',
                        'url'   => '/oficina-link/movimentacao-create',
                    ],
                    [
                        'label' => 'Consultar Coletas',
                        'url'   => '/oficina-link/movimentacao',
                    ],
                ],
            ],

            [
                'label'  => 'Oficina',
                'url'    => '#',
                'icone'  => '',
                'filhos' => [
                    [
                        'label' => 'Ordens de Serviço',
                        'url'   => '/oficina-link/ordens-servico',
                    ],
                    [
                        'label' => 'Criar Ordem de Serviço',
                        'url'   => '/oficina-link/ordens-servico-create',
                    ],
                    [
                        'label' => 'Cad. Mecânicos',
                        'url'   => '/oficina-link/mecanicos',
                    ],
                    [
                        'label' => 'Cad. Veículos',
                        'url'   => '/oficina-link/veiculos',
                    ],
                ],
            ],
        ],
    ],

    // -------------------------------------------------------------------- GÁS
    'gas' => [
        'label'  => 'Revenda de Gás',
        'cor'    => 'mod-gas',
        'accent' => '#e8b000',
        'menu'   => [
            /*
            [
                'label'  => 'Movimentação',
                'url'    => '#',
                'icone'  => '',
                'filhos' => [
                    ['label' => 'Consultar Coletas',   'url' => '/movimentacao'],
                    ['label' => 'Listagem de Coleta',  'url' => '/movimentacao'],
                    ['label' => 'Pedidos de Coleta',   'url' => '/movimentacao/create'],
                    ['label' => 'Vale Gás',            'url' => '/vale-gas'],
                    ['label' => 'Controle Vasilhames', 'url' => '/controle-vasilhames'],
                ],
            ],

            [
                'label'  => 'Dashboard',
                'url'    => '#',
                'icone'  => '',
                'filhos' => [
                    ['label' => 'Dashboard Financeiro', 'url' => '/dashboard/financeiro'],
                    ['label' => 'Dashboard Gerencial',  'url' => '/dashboard'],
                ],
            ],

            [
                'label'  => 'Configurações',
                'url'    => '#',
                'icone'  => '',
                'filhos' => [
                    ['label' => 'Usuários',             'url' => '/usuarios'],
                    ['label' => 'Perfis',               'url' => '/perfis'],
                    ['label' => 'Empresas',             'url' => '/empresas'],
                    ['label' => 'Formas de Pagamento',  'url' => '/formas-de-pagamento'],
                ],
            ],
            */
        ],
    ],

    // --------------------------------------------------------------- GERENCIAL
    'gerencial' => [
        'label'  => 'Gerencial',
        'cor'    => 'mod-gerencial',
        'accent' => '#0d6efd',
        'menu'   => [
            [
                'label'  => 'Relatórios',
                'url'    => '#',
                'icone'  => '',
                'filhos' => [
                    ['label' => 'Dashboard Gerencial',   'url' => '/dashboard'],
                    ['label' => 'Rel. de Vendas',        'url' => '/relatorios/vendas'],
                    ['label' => 'Vendas por Produto',    'url' => '/relatorios/vendas-por-produto'],
                    ['label' => 'Rel. de Compras',       'url' => '/relatorio-compras'],
                    ['label' => 'Rel. Contas a Pagar',   'url' => '/relatorio-contas-a-pagar'],
                    ['label' => 'Saldo do Estoque',      'url' => '/relatorios/saldo-estoque'],
                    ['label' => 'Movimentação Estoque',  'url' => '/estoques'],
                    ['label' => 'Consulta Caixa',        'url' => '/caixa/consulta'],
                    ['label' => 'Rel. do Caixa',         'url' => '/relatorios/rel-caixa'],
                ],
            ],
        ],
    ],

    // ------------------------------------------------------------------ PADOCA
    'padoca' => [
        'label'  => 'Padaria',
        'cor'    => 'mod-padoca',
        'accent' => '#8B4513',
        'menu'   => [
            [
                'label'  => 'Padaria',
                'url'    => '#',
                'icone'  => '',
                'filhos' => [
                    ['label' => 'Cadastrar Encomenda', 'url' => '/padoca/encomendas/create'],
                    ['label' => 'Consultar / Alterar', 'url' => '/padoca/encomendas'],
                ],
            ],
        ],
    ],

    // ------------------------------------------------------------------- CAIXA
    'caixa' => [
        'label'  => 'Financeiro / Caixa',
        'cor'    => 'mod-caixa',
        'accent' => '#2f7b0b',
        'menu'   => [],
    ],

];