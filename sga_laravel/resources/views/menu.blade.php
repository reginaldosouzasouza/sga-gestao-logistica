<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Principal </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* Zerar margens e bordas */
        * {
            margin: 0px;
            padding: 0;
            box-sizing: border-box;
        }

        


        body {
            margin-top:150px;
    background: linear-gradient(to right, #4b4747d9, #325679);
    font-family: Arial, sans-serif;
    height: 70vh;
    display: flex;
    justify-content: center;
  
}

 Contêiner externo com borda 
.outer-container {
    background: rgba(255, 255, 255, 0.95);
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    text-align: center;
    width: 720px;
    border: 2px solid #333;
}

        /* Menu principal */
        nav {
            background-color: #333;
            position: relative;
        }

        /* Itens do menu principal */
        nav li {
            display: inline-block;
            position: relative;
        }

        /* Links principais do menu */
        nav li a {
            color: rgb(252, 252, 252);
            padding: 20px 40px;
            text-decoration: none;
            font-size: 20px;
            display: inline-block;
            transition: .2s;
        }

        /* Hover nos links do menu principal */
        nav li a:hover {
            background-color: #c8a52a;
        }

        /* Submenus */
        .dropdown-submenu {
            position: absolute;
            top: 100%;
            left: 0;
            background-color:#333;
            box-shadow: 0 0 2px black;
            display: none;
            z-index: 100;
        }

        /* Sub-submenus, para alinhamento ao lado */
        .dropdown-submenu .dropdown-submenu {
            left: 100%;
            top: 0;
            margin-left: 1px;
        }

        /* Mostrar submenu ao passar o mouse */
        .dropdown:hover > .dropdown-submenu {
            display: block;
        }

      

        /* Hover nos links dos submenus */
        .dropdown-submenu a:hover {
            background-color: #c8a52a;
        }

        /* Imagens nos links */
        .imagem {
            width: 50px;
            height: 50px;
            margin-left: 15px;
        }

        /* Botão de saída */
        .saida {
            width: 30px;
            height: 30px;
            margin-left: 15px;
        }

        .sair a:hover {
            background-color: brown;
        }

        /* Cabeçalho */
        .gestao h1 {
            background-color: #c8a52a;
            margin-left: 10px;
            font-family: Arial, sans-serif;
            display: flex;
            margin: 0;
            padding: 10px;
            color: whitesmoke;
            gap: 20px;
        }

        /* Data e hora */
        #date-time {
            display: flex;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            gap: 20px;
            justify-content: center;
        }

        #date, #time {
            color: rgb(45, 246, 72);
            font-size: 1em;
            margin: 0;
        }

        /* Mostrar o submenu quando a classe 'active' é aplicada ao link */
        .menu-link.active + .dropdown-submenu {
            display: block;
        }

        /* Garantir que os links do submenu não quebrem a linha */
        .dropdown-submenu a {
            white-space: nowrap; /* Impede a quebra de linha */
            max-width: 350px; /* Define um tamanho máximo para garantir consistência */
            overflow: hidden; /* Oculta qualquer conteúdo que ultrapasse a largura */
            text-overflow: ellipsis; /* Adiciona reticências ("...") se o texto for muito longo */
        }


        
    </style> 
</head>
<body>

    <!-- Menu principal -->
    <nav>
        <ul>
            <li class="dropdown">
                <a href="#">Cadastro<i class="bi bi-caret-down-fill"></i></a>
                <div class="dropdown-submenu">
                    <a href="http://127.0.0.1:8001/clientes" target="_blank">Clientes<img src="images/imagem/clientes.png" class="imagem"></a>
                    <a href="http://127.0.0.1:8001/compras" target="_blank">Compras<img src="images/imagem/compras.png" class="imagem"></a>
                    <a href="http://127.0.0.1:8001/formas_de_pagamento" target="_blank">Formas de Pagamento<img src="images/imagem/formasdepagamento.png" class="imagem"></a>
                    <a href="http://127.0.0.1:8001/fornecedores" target="_blank">Fornecedor<img src="images/imagem/fornecedor.png" class="imagem"></a>
                    <a href="http://127.0.0.1:8001/produtos" target="_blank">Produtos<img src="images/imagem/produtos.png" class="imagem"></a>
                    <a href="http://127.0.0.1:8001/usuarios" target="_blank">Usuários<img src="images/imagem/usuarios.png" class="imagem"></a>
                </div>
            </li>

            <li class="dropdown">
                <a href="#">Movimentação<i class="bi bi-caret-down-fill"></i></a>
                <div class="dropdown-submenu">
                    <a href="http://127.0.0.1:8001/movimentacao" target="_blank">Consultar Coletas<img src="images/imagem/detalhes_coleta.png" class="imagem"></a>
                    <a href="http://127.0.0.1:8001/movimentacao" target="_blank">Listagem de Coleta<img src="images/imagem/detalhes_coleta.png" class="imagem"></a>
                    <a href="http://127.0.0.1:8001/movimentacao/create" target="_blank">Pedidos de Coleta<img src="images/imagem/pedido_coleta.png" class="imagem"></a>
                    <a href="http://127.0.0.1:8001/compras/create" target="_blank">Ordens de Serviços<img src="images/imagem/ordem_de_serviços.png" class="imagem"></a>
                </div>
            </li>

    

            <li class="dropdown">
                <a href="#">Financeiro<i class="bi bi-caret-down-fill"></i></a>
                <div class="dropdown-submenu">
                    <a href="http://127.0.0.1:8001/contas-a-pagar" target="_blank">Contas a Pagar<img src="images/imagem/contas_a_pagar.png" class="imagem"></a>
                    <a href="http://127.0.0.1:8001/contas_a_receber" target="_blank">Contas aReceber<img src="images/imagem/contas_a_receber.png" class="imagem"></a>
                    <a href="http://127.0.0.1:8001/formas_de_pagamento" target="_blank">Formas de Pagamento<img src="images/imagem/formasdepagamento.png" class="imagem"></a>
                    <a href="http://127.0.0.1:8001/fornecedores" target="_blank">Fornecedor<img src="images/imagem/fornecedor.png" class="imagem"></a>
                    <a href="http://127.0.0.1:8001/produtos" target="_blank">Produtos de beleza<img src="images/imagem/produtos.png" class="imagem"></a>
                    <a href="http://127.0.0.1:8001/caixa" target="_blank">CAIXA<img src="images/imagem/caixaregistradora.png" class ="imagem"></a>
                </div>
            </li>


            <!-- Menu Relatórios -->
            <li class="dropdown">
                <a href="#">Relatórios<i class="bi bi-caret-down-fill"></i></a>
                <div class="dropdown-submenu">
                    <a href="#" class="menu-link" id="estoque-link">Estoque<img src="images/imagem/clientes.png" class="imagem">
                        <i class="bi bi-caret-down-fill"></i></a>
                    <!-- Submenu de Estoque -->
                    <div class="dropdown-submenu" id="estoque-submenu">
                        <a href="http://127.0.0.1:8001/estoques" target="_blank">Movimentação do Estoque</a>
                        <a href="http://127.0.0.1:8001/relatorios/saldo-estoque" target="_blank">Saldo do Estoque</a>
                    </div>

                    <a href="#" class="menu-link" id="vendas-link">VENDAS<img src="images/imagem/clientes.png" class="imagem">
                        <i class="bi bi-caret-down-fill"></i></a>
                    <!-- Submenu de Estoque -->
                    <div class="dropdown-submenu" id="vendas-submenu">
                        <a href="http://127.0.0.1:8001/relatorios/vendas" target="_blank">Vendas</a>
                        <a href="http://127.0.0.1:8001/relatorios/vendas-por-produto" target="_blank">Vendas por Produto</a>
                        
                    </div> 
                    
                    <a href="#" class="menu-link" id="vendas-link">COMPRAS<img src="images/imagem/clientes.png" class="imagem">
                        <i class="bi bi-caret-down-fill"></i></a>
                    <!-- Submenu de Compras -->
                    <div class="dropdown-submenu" id="vendas-submenu">
                        <a href="http://127.0.0.1:8001/relatorio-compras" target="_blank">Rel. de Compras</a>
                                               
                    </div> 

           
                 
                    <a href="#" class="menu-link" id="relcontasapagar-link">CONTAS A PAGAR<img src="images/imagem/contas_a_pagar.png" class="imagem">
                        <i class="bi bi-caret-down-fill"></i></a>
                    <!-- Submenu de Compras -->
                    <div class="dropdown-submenu" id="relcontasApagar-submenu">
                        <a href="http://127.0.0.1:8001/relatorio-contas-a-pagar" target="_blank">Rel. de Contas a Pagar</a>
                                            
                    </div> 


                    <a href="http://127.0.0.1:8001/dashboard" target="_blank">GERENCIAL<img src="images/imagem/gerencial.png"  class='imagem'></a>
                    <a href="http://127.0.0.1:8001/fornecedores" target="_blank">Fornecedor<img src="images/imagem/fornecedor.png"  class='imagem'></a>
                    <a href="http://127.0.0.1:8001/produtos" target="_blank">Produtos<img src="images/imagem/produtos.png"  class='imagem'></a>
                    <a href="http://127.0.0.1:8001/compras/create" target="_blank">Usuários<img src="images/imagem/usuarios.png"  class='imagem'></a>
                               
                </div>
            </li>

            <li class="sair">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
                </form>

                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Sair
                </a>

            <!--    <a href="https://www.reginaldosouza.com.br/" target="_blank">Sair<img src="./imagem/saida.png" class="saida"></a> -->
            </li>

            <li>
                <div class="gestao">
                    <h1>
                        RA - Sistema de Gestão Aplicada - Projeto GÁS
                        <div id="date-time">
                            <p id="date"></p>
                            <p id="time"></p>
                        </div>
                    </h1>
                </div>
            </li>
        </ul>
    </nav>

    <script>

         // Atualizar Data e Hora
         function updateDateTime() {
            const now = new Date();
            document.getElementById("date").innerText = now.toLocaleDateString();
            document.getElementById("time").innerText = now.toLocaleTimeString();
        }
        setInterval(updateDateTime, 1000);
        updateDateTime();




        document.addEventListener('DOMContentLoaded', function () {
    // Adicionar eventos para os submenus
    const submenuLinks = document.querySelectorAll('.menu-link');

    submenuLinks.forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            // Fecha todos os submenus antes de abrir o clicado
            submenuLinks.forEach(function (item) {
                if (item !== link) {
                    item.classList.remove('active');
                    item.nextElementSibling.style.display = 'none';
                }
            });

            // Alterna a visibilidade do submenu clicado
            link.classList.toggle('active');
            const submenu = link.nextElementSibling;
            submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
        });
    });

    // Fechar submenus ao clicar fora deles
    document.addEventListener('click', function (e) {
        if (!e.target.closest('nav')) {
            submenuLinks.forEach(function (link) {
                link.classList.remove('active');
                link.nextElementSibling.style.display = 'none';
            });
        }
    });
});

     
    </script>

</body> 
</html>
