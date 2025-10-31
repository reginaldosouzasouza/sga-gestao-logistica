<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        // oficina | gas | gerencial | padoca | principal (fallback)
        $mod = strtolower(session('modulo_atual', 'principal'));
        $modulo = ucfirst(session('modulo_atual', 'Principal'));
    @endphp

    <title>Menu Principal - {{ $modulo }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* Reset básico */
        * { margin:0; padding:0; box-sizing:border-box; }

        /* ===== Tema por módulo (accent) ===== */
        :root { --accent: #c8a52a; }            /* fallback dourado */

        .mod-oficina   { --accent: #4b4b4b; }   /* cinza */
        .mod-gas       { --accent: #e8b000; }   /* amarelo */
        .mod-gerencial { --accent: #0d6efd; }   /* azul */
        .mod-padoca    { --accent: #8B4513; }   /* marrom */

        /* Plano de fundo geral */
        body{
            margin-top:0;
            background: linear-gradient(to right, #4b4747d9, #325679);
            font-family: Arial, sans-serif;
            height:95vh;
            display:flex;
            justify-content:center;
        }

        /* Contêiner externo com borda */
        /* .outer-container {
            background: rgba(255,255,255,0.95);
            padding:30px;
            border-radius:15px;
            box-shadow:0 4px 12px rgba(0,0,0,0.3);
            text-align:center;
            width:720px;
            border:2px solid #333;
        } */

        /* ===== Menu ===== */
        nav { background-color:#333; position:relative; }
        nav li { display:inline-block; position:relative; }

        nav li a{
            color:#fcfcfc;
            padding:20px 40px;
            text-decoration:none;
            font-size:20px;
            display:inline-block;
            transition:.2s;
        }

        /* hovers usando a cor do módulo */
        nav li a:hover{ background-color:var(--accent); }

        /* Submenus */
        .dropdown-submenu{
            position:absolute; top:100%; left:0;
            background-color:#333; box-shadow:0 0 2px black;
            display:none; z-index:100;
        }
        .dropdown-submenu .dropdown-submenu{ left:100%; top:0; margin-left:1px; }
        .dropdown:hover > .dropdown-submenu{ display:block; }
        .dropdown-submenu a:hover{ background-color:var(--accent); }

        /* Ícones/imagens */
        .imagem{ width:50px; height:50px; margin-left:15px; }
        .saida{ width:30px; height:30px; margin-left:15px; }
        .sair a:hover{ background-color:brown; }

        /* Cabeçalho (título SGA) */
        .gestao{ display:inline-block; vertical-align:middle; }
        .gestao h1{
            background-color:var(--accent);  /* cor do módulo */
            font-family:Arial, sans-serif;
            display:flex; align-items:center; gap:15px;
            margin:0; padding:10px 20px;
            color:whitesmoke; font-size:20px; height:100%;
        }

        /* Data e hora */
        #date-time{ display:flex; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.1); gap:20px; justify-content:center; }
        #date, #time{ color:rgb(45,246,72); font-size:1em; margin:0; }

        /* Submenus que abrem por clique */
        .menu-link.active + .dropdown-submenu{ display:block; }
        .dropdown-submenu a{
            white-space:nowrap; max-width:350px; overflow:hidden; text-overflow:ellipsis;
        }
    </style>
</head>

<body class="mod-{{ $mod }}">
    <!-- Menu principal -->
    <nav>
        <ul>
            <li class="dropdown">
                <a href="#">Cadastro<i class="bi bi-caret-down-fill"></i></a>
                <div class="dropdown-submenu">
                    <a href="http://127.0.0.1:8001/clientes" target="_blank">
                        Clientes <img src="{{ asset('images/imagem/clientes.png') }}" class="imagem">
                    </a>
                    <a href="http://127.0.0.1:8001/compras" target="_blank">
                        Compras <img src="{{ asset('images/imagem/compras.png') }}" class="imagem">
                    </a>
                    <a href="http://127.0.0.1:8001/formas_de_pagamento" target="_blank">
                        Formas de Pagamento <img src="{{ asset('images/imagem/formasdepagamento.png') }}" class="imagem">
                    </a>
                    <a href="http://127.0.0.1:8001/fornecedores" target="_blank">
                        Fornecedor <img src="{{ asset('images/imagem/fornecedor.png') }}" class="imagem">
                    </a>
                    <a href="http://127.0.0.1:8001/produtos" target="_blank">
                        Produtos <img src="{{ asset('images/imagem/produtos.png') }}" class="imagem">
                    </a>
                    <a href="http://127.0.0.1:8001/veiculos" target="_blank">
                        Veículos <img src="{{ asset('images/imagem/veiculos.png') }}" class="imagem">
                    </a>
                    <a href="http://127.0.0.1:8001/usuarios" target="_blank">
                        Usuários <img src="{{ asset('images/imagem/usuarios.png') }}" class="imagem">
                    </a>
                </div>
            </li>

            <li class="dropdown">
                <a href="#">Movimentação<i class="bi bi-caret-down-fill"></i></a>
                <div class="dropdown-submenu">
                    <a href="http://127.0.0.1:8001/movimentacao" target="_blank">
                        Consultar Coletas <img src="{{ asset('images/imagem/detalhes_coleta.png') }}" class="imagem">
                    </a>
                    <a href="http://127.0.0.1:8001/movimentacao" target="_blank">
                        Listagem de Coleta <img src="{{ asset('images/imagem/detalhes_coleta.png') }}" class="imagem">
                    </a>
                    <a href="http://127.0.0.1:8001/movimentacao/create" target="_blank">
                        Pedidos de Coleta <img src="{{ asset('images/imagem/pedido_coleta.png') }}" class="imagem">
                    </a>
                    <a href="http://127.0.0.1:8001/compras/create" target="_blank">
                        Ordens de Serviços <img src="{{ asset('images/imagem/ordem_de_serviços.png') }}" class="imagem">
                    </a>
                </div>
            </li>

            <li class="dropdown">
                <a href="#">Financeiro<i class="bi bi-caret-down-fill"></i></a>
                <div class="dropdown-submenu">
                    <a href="http://127.0.0.1:8001/contas-a-pagar" target="_blank">
                        Contas a Pagar <img src="{{ asset('images/imagem/contas_a_pagar.png') }}" class="imagem">
                    </a>
                    <a href="http://127.0.0.1:8001/contas_a_receber" target="_blank">
                        Contas a Receber <img src="{{ asset('images/imagem/contas_a_receber.png') }}" class="imagem">
                    </a>
                    <a href="http://127.0.0.1:8001/formas_de_pagamento" target="_blank">
                        Formas de Pagamento <img src="{{ asset('images/imagem/formasdepagamento.png') }}" class="imagem">
                    </a>
                    <a href="http://127.0.0.1:8001/fornecedores" target="_blank">
                        Fornecedor <img src="{{ asset('images/imagem/fornecedor.png') }}" class="imagem">
                    </a>
                    <a href="http://127.0.0.1:8001/produtos" target="_blank">
                        Produtos de beleza <img src="{{ asset('images/imagem/produtosdebeleza.png') }}" class="imagem">
                    </a>
                    <a href="http://127.0.0.1:8001/caixa" target="_blank">
                        CAIXA <img src="{{ asset('images/imagem/caixaregistradora.png') }}" class="imagem">
                    </a>
                </div>
            </li>

            <!-- Relatórios -->
            <li class="dropdown">
                <a href="#">Relatórios<i class="bi bi-caret-down-fill"></i></a>
                <div class="dropdown-submenu">
                    <a href="#" class="menu-link" id="estoque-link">
                        Estoque <img src="{{ asset('images/imagem/clientes.png') }}" class="imagem">
                        <i class="bi bi-caret-down-fill"></i>
                    </a>
                    <div class="dropdown-submenu" id="estoque-submenu">
                        <a href="http://127.0.0.1:8001/estoques" target="_blank">Movimentação do Estoque</a>
                        <a href="http://127.0.0.1:8001/relatorios/saldo-estoque" target="_blank">Saldo do Estoque</a>
                    </div>

                    <a href="#" class="menu-link" id="vendas-link">
                        VENDAS <img src="{{ asset('images/imagem/clientes.png') }}" class="imagem">
                        <i class="bi bi-caret-down-fill"></i>
                    </a>
                    <div class="dropdown-submenu" id="vendas-submenu">
                        <a href="http://127.0.0.1:8001/relatorios/vendas" target="_blank">Vendas</a>
                        <a href="http://127.0.0.1:8001/relatorios/vendas-por-produto" target="_blank">Vendas por Produto</a>
                    </div>

                    <a href="#" class="menu-link" id="compras-link">
                        COMPRAS <img src="{{ asset('images/imagem/clientes.png') }}" class="imagem">
                        <i class="bi bi-caret-down-fill"></i>
                    </a>
                    <div class="dropdown-submenu" id="compras-submenu">
                        <a href="http://127.0.0.1:8001/relatorio-compras" target="_blank">Rel. de Compras</a>
                    </div>

                    <a href="#" class="menu-link" id="relcontasapagar-link">
                        CONTAS A PAGAR <img src="{{ asset('images/imagem/contas_a_pagar.png') }}" class="imagem">
                        <i class="bi bi-caret-down-fill"></i>
                    </a>
                    <div class="dropdown-submenu" id="relcontasApagar-submenu">
                        <a href="http://127.0.0.1:8001/relatorio-contas-a-pagar" target="_blank">Rel. de Contas a Pagar</a>
                    </div>

                    <a href="http://127.0.0.1:8001/dashboard" target="_blank">
                        GERENCIAL <img src="{{ asset('images/imagem/gerencial.png') }}" class="imagem">
                    </a>
                    <a href="http://127.0.0.1:8001/fornecedores" target="_blank">
                        Fornecedor <img src="{{ asset('images/imagem/fornecedor.png') }}" class="imagem">
                    </a>
                    <a href="http://127.0.0.1:8001/produtos" target="_blank">
                        Produtos <img src="{{ asset('images/imagem/produtos.png') }}" class="imagem">
                    </a>
                    <a href="http://127.0.0.1:8001/compras/create" target="_blank">
                        Usuários <img src="{{ asset('images/imagem/usuarios.png') }}" class="imagem">
                    </a>
                </div>
            </li>

            <!-- Oficina -->
            <li class="dropdown">
                <a href="#">Oficina<i class="bi bi-caret-down-fill"></i></a>
                <div class="dropdown-submenu">
                    <a href="http://127.0.0.1:8001/ordens-servico" target="_blank">
                        Ordens de Serviço
                        <img src="{{ asset('images/imagem/ordem_de_serviços.png') }}" class="imagem">
                    </a>
                    <a href="http://127.0.0.1:8001/ordens-servico/create" target="_blank">
                        Criar Ordens de Serviços
                        <img src="{{ asset('images/imagem/nova_ordem_servicos.png') }}" class="imagem">
                    </a>
                    <a href="http://127.0.0.1:8001/mecanicos" target="_blank">
                        Cad. Mecânicos
                        <img src="{{ asset('images/imagem/mecanico.png') }}" class="imagem">
                    </a>
                </div>
            </li>

            <!-- Padaria -->
            <li class="dropdown">
                <a href="#">Padaria<i class="bi bi-caret-down-fill"></i></a>
                <div class="dropdown-submenu">
                    <a href="http://127.0.0.1:8001/padoca/encomendas/create" target="_blank">
                        Cadastrar Encomenda
                        <img src="{{ asset('images/imagem/padaria_cadastrar.png') }}" class="imagem">
                    </a>
                    <a href="http://127.0.0.1:8001/padoca/encomendas" target="_blank">
                        Consultar/Visualizar/alterar
                        <img src="{{ asset('images/imagem/padaria_consulta.png') }}" class="imagem">
                    </a>
                </div>
            </li>

            <!-- Sair -->
            <li class="sair">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Sair
                </a>
            </li>

            <!-- Título/Barra -->
            <div class="gestao">
                <h1>
                    SGA - Sistema de Gestão Aplicada
                    <div id="date-time">
                        <p id="date"></p>
                        <p id="time"></p>
                    </div>
                </h1>
            </div>
        </ul>
    </nav>

    <script>
        // Data e hora
        function updateDateTime(){
            const now = new Date();
            document.getElementById("date").innerText = now.toLocaleDateString();
            document.getElementById("time").innerText = now.toLocaleTimeString();
        }
        setInterval(updateDateTime, 1000);
        updateDateTime();

        // Submenus por clique
        document.addEventListener('DOMContentLoaded', function(){
            const submenuLinks = document.querySelectorAll('.menu-link');

            submenuLinks.forEach(function(link){
                link.addEventListener('click', function(e){
                    e.preventDefault();

                    submenuLinks.forEach(function(item){
                        if(item !== link){
                            item.classList.remove('active');
                            if(item.nextElementSibling) item.nextElementSibling.style.display = 'none';
                        }
                    });

                    link.classList.toggle('active');
                    const submenu = link.nextElementSibling;
                    if(submenu){
                        submenu.style.display = (submenu.style.display === 'block') ? 'none' : 'block';
                    }
                });
            });

            document.addEventListener('click', function(e){
                if(!e.target.closest('nav')){
                    submenuLinks.forEach(function(link){
                        link.classList.remove('active');
                        if(link.nextElementSibling) link.nextElementSibling.style.display = 'none';
                    });
                }
            });
        });
    </script>
</body>
</html>

