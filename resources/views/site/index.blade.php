<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S.G.A. - Sistema para Revendas de Gás e Água</title>
    <meta name="description" content="Sistema de gestão para revendas de gás e água. Controle clientes, vendas, estoque, caixa, contas a pagar, contas a receber e relatórios em um só lugar.">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            width: 100%;
            overflow-x: hidden;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7fb;
            color: #1f2937;
            line-height: 1.6;
        }

        a {
            text-decoration: none;
        }

        .topo {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .topo-container {
            max-width: 1180px;
            margin: 0 auto;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .logo {
            font-size: 24px;
            font-weight: 800;
            color: #111827;
        }

        .logo span {
            color: #ff7a00;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 700;
            transition: 0.2s;
            text-align: center;
        }

        .btn-principal {
            background: #ff7a00;
            color: #ffffff;
        }

        .btn-principal:hover {
            background: #e86f00;
        }

        .btn-secundario {
            border: 1px solid #d1d5db;
            color: #1f2937;
            background: #ffffff;
        }

        .btn-secundario:hover {
            background: #f3f4f6;
        }

        .hero {
            background: linear-gradient(135deg, #26394f, #456987);
            color: #ffffff;
            padding: 72px 24px;
        }

        .hero-container {
            max-width: 1180px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 36px;
            align-items: center;
        }

        .badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.25);
            padding: 8px 12px;
            border-radius: 999px;
            font-size: 14px;
            margin-bottom: 18px;
        }

        .hero h1 {
            font-size: 44px;
            line-height: 1.15;
            margin-bottom: 18px;
        }

        .hero p {
            font-size: 19px;
            color: #e5eef7;
            margin-bottom: 26px;
        }

        .acoes {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .card-hero {
            background: #ffffff;
            color: #1f2937;
            border-radius: 16px;
            padding: 26px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.22);
        }

        .card-hero h3 {
            font-size: 22px;
            margin-bottom: 14px;
            color: #111827;
        }

        .lista-check {
            list-style: none;
        }

        .lista-check li {
            padding: 9px 0;
            border-bottom: 1px solid #eef2f7;
        }

        .lista-check li::before {
            content: "✓";
            color: #ff7a00;
            font-weight: 800;
            margin-right: 8px;
        }

        .secao {
            padding: 64px 24px;
        }

        .container {
            width: 100%;
            max-width: 1180px;
            margin: 0 auto;
        }

        .titulo-secao {
            text-align: center;
            margin-bottom: 34px;
        }

        .titulo-secao h2 {
            font-size: 34px;
            color: #111827;
            margin-bottom: 10px;
        }

        .titulo-secao p {
            font-size: 18px;
            color: #6b7280;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 22px;
            width: 100%;
        }

        .card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.06);
            min-width: 0;
        }

        .card h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #111827;
        }

        .card p {
            color: #4b5563;
        }

        .origem-box {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            padding: 34px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
            margin-bottom: 28px;
        }

        .origem-box h2 {
            font-size: 34px;
            line-height: 1.2;
            color: #111827;
            margin-bottom: 14px;
            text-align: center;
        }

        .origem-box .subtitulo-origem {
            max-width: 860px;
            margin: 0 auto 20px auto;
            text-align: center;
            font-size: 18px;
            color: #4b5563;
        }

        .origem-destaque {
            background: #fff7ed;
            border-left: 5px solid #ff7a00;
            border-radius: 12px;
            padding: 20px 22px;
            margin-top: 22px;
            color: #374151;
            font-size: 17px;
        }

        .origem-destaque strong {
            color: #111827;
        }

        .faixa {
            background: #111827;
            color: #ffffff;
            padding: 54px 24px;
            text-align: center;
        }

        .faixa h2 {
            font-size: 34px;
            margin-bottom: 12px;
        }

        .faixa p {
            max-width: 760px;
            margin: 0 auto 24px auto;
            color: #d1d5db;
            font-size: 18px;
        }

        .observacao {
            background: #fff7ed;
            border: 1px solid #fed7aa;
            color: #7c2d12;
            border-radius: 12px;
            padding: 18px;
            margin-top: 24px;
            font-size: 15px;
        }

        .whatsapp-fixo {
            position: fixed;
            left: 18px;
            bottom: 18px;
            z-index: 999999;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #16a34a;
            color: #ffffff;
            padding: 14px 20px;
            border-radius: 999px;
            font-weight: 800;
            font-size: 15px;
            text-decoration: none;
            box-shadow: 0 14px 32px rgba(22, 163, 74, 0.42);
            border: 2px solid #ffffff;
            transform-origin: center;
            animation: whatsappPulseElegante 1.8s infinite ease-in-out;
        }

        .whatsapp-fixo:hover {
            background: #15803d;
            color: #ffffff;
            transform: translateY(-2px) scale(1.02);
            animation-play-state: paused;
        }

        .whatsapp-fixo:hover .icone-whats {
            animation-play-state: paused;
        }

        .whatsapp-fixo .icone-whats {
            display: inline-block;
            animation: whatsappIconeElegante 3.8s infinite ease-in-out;
        }

        @keyframes whatsappPulseElegante {
            0% {
                transform: scale(1);
                box-shadow: 0 14px 32px rgba(22, 163, 74, 0.42), 0 0 0 0 rgba(34, 197, 94, 0.00);
            }
            8% {
                transform: scale(1.035);
                box-shadow: 0 16px 36px rgba(22, 163, 74, 0.46), 0 0 0 8px rgba(34, 197, 94, 0.16);
            }
            16% {
                transform: scale(1);
                box-shadow: 0 14px 32px rgba(22, 163, 74, 0.42), 0 0 0 0 rgba(34, 197, 94, 0.00);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 14px 32px rgba(22, 163, 74, 0.42), 0 0 0 0 rgba(34, 197, 94, 0.00);
            }
        }

        @keyframes whatsappIconeElegante {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            6% {
                transform: translateY(-1px) rotate(-8deg);
            }
            10% {
                transform: translateY(0) rotate(8deg);
            }
            14% {
                transform: translateY(0) rotate(0deg);
            }
        }

        .mini-info {
            margin-top: 14px;
            color: #e5eef7;
            font-size: 15px;
        }

        .rodape {
            background: #ffffff;
            border-top: 1px solid #e5e7eb;
            padding: 28px 24px;
            text-align: center;
            color: #6b7280;
        }

        .rodape strong {
            color: #ff7a00;
        }

        @media (max-width: 900px) {
            .hero-container {
                grid-template-columns: 1fr;
            }

            .hero h1 {
                font-size: 34px;
            }

            .topo-container {
                flex-direction: column;
            }
        }

        @media (max-width: 640px) {
            .topo-container {
                padding: 14px 16px;
            }

            .logo {
                font-size: 22px;
            }

            .hero {
                padding: 48px 18px;
            }

            .hero h1 {
                font-size: 30px;
            }

            .hero p,
            .titulo-secao p,
            .origem-box .subtitulo-origem,
            .faixa p {
                font-size: 16px;
            }

            .secao {
                padding: 44px 18px;
            }

            .titulo-secao h2,
            .origem-box h2,
            .faixa h2 {
                font-size: 28px;
            }

            .origem-box {
                padding: 24px 18px;
            }

            .grid {
                grid-template-columns: 1fr;
            }

            .whatsapp-fixo {
                left: 14px;
                right: 14px;
                bottom: 14px;
                justify-content: center;
                width: auto;
            }

            .rodape {
                padding-bottom: 82px;
            }
        }
    </style>
</head>
<body>
    <header class="topo">
        <div class="topo-container">
            <div class="logo">S.G.A. <span>Sistema</span></div>
            <a href="{{ route('abrir.sistema') }}" class="btn btn-secundario">Acessar Sistema</a>
        </div>
    </header>

    <section class="hero">
        <div class="hero-container">
            <div>
                <div class="badge">Feito para revendas pequenas e médias</div>
                <h1>Sistema de gestão para revendas de gás e água</h1>
                <p>
                    Controle clientes, pedidos, estoque, caixa, contas a pagar, contas a receber
                    e relatórios da sua revenda em um só lugar.
                </p>
                <div class="acoes">
                    <a href="https://wa.me/5544999995767?text=Ol%C3%A1%2C%20Reginaldo.%20Tenho%20uma%20revenda%20de%20g%C3%A1s%20e%20%C3%A1gua%20e%20quero%20saber%20mais%20sobre%20o%20teste%20gratuito%20do%20S.G.A." class="btn btn-principal" target="_blank" rel="noopener">
                        Quero testar gratuitamente
                    </a>
                    <a href="{{ route('abrir.sistema') }}" class="btn btn-secundario">Já sou cliente</a>
                </div>
                <div class="mini-info">Teste gratuito por 60 dias para revendas selecionadas.</div>
            </div>

            <div class="card-hero">
                <h3>O S.G.A. ajuda sua revenda a controlar:</h3>
                <ul class="lista-check">
                    <li>Vendas e pedidos do dia</li>
                    <li>Clientes e contas a receber</li>
                    <li>Contas a pagar e fornecedores</li>
                    <li>Estoque de gás, água e produtos</li>
                    <li>Caixa em dinheiro e PIX</li>
                    <li>Relatórios para tomada de decisão</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="secao">
        <div class="container">
            <div class="origem-box">
                <h2>Criado por quem vive a rotina de uma revenda</h2>
                <p class="subtitulo-origem">
                    O S.G.A. não nasceu de uma ideia distante da realidade do comércio.
                    Ele foi criado a partir da experiência real de uma revenda de gás e água
                    com <strong>10 anos de atuação</strong>, enfrentando na prática os mesmos desafios que muitos donos
                    vivem todos os dias.
                </p>

                <div class="origem-destaque">
                    <strong>Por isso, cada módulo foi pensado para resolver problemas práticos da revenda:</strong>
                    controlar clientes, pedidos, estoque, caixa, contas a pagar, contas a receber, vendas no dinheiro,
                    PIX, fiado e relatórios para entender melhor a situação da empresa.
                </div>
            </div>

            <div class="grid">
                <div class="card">
                    <h3>Dor real do financeiro</h3>
                    <p>Veja contas a pagar, contas a receber, recebimentos, pendências e movimentações de caixa com mais clareza.</p>
                </div>

                <div class="card">
                    <h3>Dor real da operação</h3>
                    <p>Registre pedidos, acompanhe clientes e mantenha o histórico de movimentações da sua revenda organizado.</p>
                </div>

                <div class="card">
                    <h3>Dor real do estoque</h3>
                    <p>Acompanhe produtos, entradas, saídas e reduza o risco de perder venda por falta de controle.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="secao" style="background:#ffffff;">
        <div class="container">
            <div class="titulo-secao">
                <h2>Principais módulos do S.G.A.</h2>
                <p>Uma plataforma simples para a rotina da revenda de gás e água.</p>
            </div>

            <div class="grid">
                <div class="card">
                    <h3>Clientes</h3>
                    <p>Cadastro, telefone, endereço, histórico e acompanhamento de compras.</p>
                </div>

                <div class="card">
                    <h3>Produtos e Estoque</h3>
                    <p>Controle de produtos, preços, estoque mínimo e movimentações.</p>
                </div>

                <div class="card">
                    <h3>Financeiro</h3>
                    <p>Contas a pagar, contas a receber, caixa, PIX e relatórios financeiros.</p>
                </div>

                <div class="card">
                    <h3>Pedidos</h3>
                    <p>Emissão de pedidos/coletas e controle das vendas realizadas.</p>
                </div>

                <div class="card">
                    <h3>Relatórios</h3>
                    <p>Informações para entender melhor as vendas, recebimentos, despesas e resultados.</p>
                </div>

                <div class="card">
                    <h3>Usuários</h3>
                    <p>Controle de acesso por usuário, perfil e permissões do sistema.</p>
                </div>
            </div>

            <div class="observacao">
                O S.G.A. já está em funcionamento e segue evoluindo com base na realidade de revendas parceiras.
                No momento, o uso é mais indicado em computador ou notebook. A versão para celular está em evolução.
            </div>
        </div>
    </section>

    <section class="secao">
        <div class="container">
            <div class="titulo-secao">
                <h2>Como funciona o teste gratuito?</h2>
                <p>Uma forma simples de conhecer o S.G.A. antes de decidir continuar.</p>
            </div>

            <div class="grid">
                <div class="card">
                    <h3>1. Conversa inicial</h3>
                    <p>Entendemos como sua revenda trabalha hoje e quais controles você mais precisa melhorar.</p>
                </div>

                <div class="card">
                    <h3>2. Liberação do acesso</h3>
                    <p>A revenda selecionada recebe acesso ao sistema para testar na rotina, preferencialmente pelo computador ou notebook.</p>
                </div>

                <div class="card">
                    <h3>3. Validação na prática</h3>
                    <p>Durante 60 dias, você usa o S.G.A. e ajuda com opiniões reais para evoluir uma ferramenta feita para o segmento.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="faixa">
        <h2>Teste gratuito para revendas selecionadas</h2>
        <p>
            Estamos selecionando revendas pequenas e médias de gás e água para testar o S.G.A.
            gratuitamente por 60 dias e ajudar na evolução do sistema.
        </p>
        <a href="https://wa.me/5544999995767?text=Ol%C3%A1%2C%20Reginaldo.%20Quero%20saber%20mais%20sobre%20o%20teste%20gratuito%20do%20S.G.A.%20para%20minha%20revenda." class="btn btn-principal" target="_blank" rel="noopener">
            Falar pelo WhatsApp
        </a>
    </section>

    <a href="https://wa.me/5544999995767?text=Ol%C3%A1%2C%20Reginaldo.%20Tenho%20interesse%20no%20S.G.A.%20para%20minha%20revenda." class="whatsapp-fixo" target="_blank" rel="noopener"><span class="icone-whats">💬</span> <span>Fale no WhatsApp</span></a>

    <footer class="rodape">
        <p><strong>S.G.A. — Sistema para Revendas de Gás e Água</strong></p>
        <p>Criado por quem conhece a rotina real de uma revenda.</p>
        <p>Desenvolvido por <strong>Reginaldo Souza</strong></p>
        <p>WhatsApp: <a href="https://wa.me/5544999995767?text=Ol%C3%A1%2C%20Reginaldo.%20Tenho%20interesse%20no%20S.G.A.%20para%20minha%20revenda." target="_blank" rel="noopener">(44) 9 9999-5767</a></p>
        <p><a href="{{ route('abrir.sistema') }}">Acessar sistema</a></p>
    </footer>
</body>
</html>
