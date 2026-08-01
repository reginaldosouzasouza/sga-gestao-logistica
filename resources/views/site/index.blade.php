<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>S.G.A. Sistemas - Gestão para Gás, Oficina, Salão e Barbearia</title>
    <meta name="description" content="Soluções de gestão para revendas de gás e água, oficinas mecânicas, salões de beleza e barbearias. Organize clientes, financeiro, estoque, serviços e agendamentos em um só lugar.">

    <style>
        :root {
            --cor-primaria: #ff7a00;
            --cor-primaria-escura: #e66f00;
            --cor-texto: #172033;
            --cor-texto-suave: #64748b;
            --cor-fundo: #f5f7fb;
            --cor-borda: #e2e8f0;
            --cor-branca: #ffffff;
            --cor-gas: #1976d2;
            --cor-oficina: #e85d04;
            --cor-salao: #c2185b;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        html,
        body {
            width: 100%;
            overflow-x: hidden;
        }

        body {
            width: 100%;
            overflow-x: hidden;
            font-family: Arial, Helvetica, sans-serif;
            background: var(--cor-fundo);
            color: var(--cor-texto);
            line-height: 1.6;
            padding-top: 66px;
        }

        a {
            text-decoration: none;
        }

        .container {
            width: 100%;
            max-width: 1180px;
            margin: 0 auto;
        }

       .topo {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.96);
            border-bottom: 1px solid var(--cor-borda);
            backdrop-filter: blur(12px);
            box-shadow: 0 6px 20px rgba(15, 23, 42, 0.06);
        }       

        .topo-container {
            min-height: 76px;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 22px;
        }

        .logo {
            display: flex;
            flex-direction: column;
            color: #111827;
            line-height: 1.05;
        }

        .logo strong {
            font-size: 25px;
            font-weight: 900;
            letter-spacing: -0.8px;
        }

        .logo strong span {
            color: var(--cor-primaria);
        }

        .logo small {
            margin-top: 5px;
            color: var(--cor-texto-suave);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.6px;
            text-transform: uppercase;
        }

        .menu {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 24px;
        }

        .menu a {
            color: #334155;
            font-size: 15px;
            font-weight: 700;
            transition: 0.2s;
        }

        .menu a:hover {
            color: var(--cor-primaria);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 46px;
            padding: 12px 20px;
            border: 1px solid transparent;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 800;
            text-align: center;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-principal {
            background: var(--cor-primaria);
            color: var(--cor-branca);
            box-shadow: 0 12px 26px rgba(255, 122, 0, 0.25);
        }

        .btn-principal:hover {
            background: var(--cor-primaria-escura);
        }

        .btn-claro {
            background: var(--cor-branca);
            color: #1e293b;
            border-color: rgba(255, 255, 255, 0.45);
        }

        .btn-claro:hover {
            background: #f8fafc;
        }

        .btn-secundario {
            color: #1e293b;
            background: var(--cor-branca);
            border-color: #cbd5e1;
        }

        .btn-secundario:hover {
            background: #f8fafc;
        }

        .hero {
            position: relative;
            overflow: hidden;
            padding: 92px 24px 84px;
            color: var(--cor-branca);
            background:
                radial-gradient(circle at 90% 10%, rgba(255, 122, 0, 0.28), transparent 28%),
                linear-gradient(135deg, #17253a 0%, #294766 52%, #17253a 100%);
        }

        .hero::after {
            content: "";
            position: absolute;
            width: 360px;
            height: 360px;
            right: -130px;
            bottom: -160px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
        }

        .hero-container {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1.12fr 0.88fr;
            gap: 48px;
            align-items: center;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            padding: 8px 13px;
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            color: #f8fafc;
            font-size: 14px;
            font-weight: 700;
        }

        .hero h1 {
            max-width: 720px;
            margin-bottom: 20px;
            font-size: clamp(38px, 5vw, 60px);
            line-height: 1.06;
            letter-spacing: -1.8px;
        }

        .hero h1 span {
            color: #ffb35f;
        }

        .hero p {
            max-width: 700px;
            margin-bottom: 28px;
            color: #dbe8f5;
            font-size: 19px;
        }

        .acoes {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }

        .mini-info {
            margin-top: 16px;
            color: #cbd5e1;
            font-size: 14px;
        }

        .painel-hero {
            padding: 28px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.24);
            backdrop-filter: blur(12px);
        }

        .painel-hero h3 {
            margin-bottom: 18px;
            font-size: 22px;
        }

        .resumo-sistemas {
            display: grid;
            gap: 13px;
        }

        .resumo-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 15px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.1);
        }

        .resumo-icone {
            width: 46px;
            height: 46px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 23px;
            background: rgba(255, 255, 255, 0.15);
        }

        .resumo-item strong {
            display: block;
            margin-bottom: 2px;
            font-size: 16px;
        }

        .resumo-item span {
            color: #dbe8f5;
            font-size: 13px;
        }

        .secao {
            padding: 76px 24px;
        }

        .secao-branca {
            background: var(--cor-branca);
        }

        .titulo-secao {
            max-width: 760px;
            margin: 0 auto 42px;
            text-align: center;
        }

        .titulo-secao .etiqueta {
            display: inline-block;
            margin-bottom: 10px;
            color: var(--cor-primaria);
            font-size: 13px;
            font-weight: 900;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .titulo-secao h2 {
            margin-bottom: 12px;
            color: #111827;
            font-size: clamp(30px, 4vw, 42px);
            line-height: 1.15;
            letter-spacing: -0.8px;
        }

        .titulo-secao p {
            color: var(--cor-texto-suave);
            font-size: 18px;
        }

        .sistemas-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 24px;
        }

        .sistema-card {
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100%;
            padding: 28px;
            border: 1px solid var(--cor-borda);
            border-radius: 20px;
            background: var(--cor-branca);
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.07);
            transition: 0.25s ease;
        }

        .sistema-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 22px 46px rgba(15, 23, 42, 0.12);
        }

        .sistema-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: var(--cor-card);
        }

        .sistema-gas {
            --cor-card: var(--cor-gas);
        }

        .sistema-oficina {
            --cor-card: var(--cor-oficina);
        }

        .sistema-salao {
            --cor-card: var(--cor-salao);
        }

        .sistema-icone {
            width: 58px;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            border-radius: 17px;
            color: var(--cor-card);
            background: color-mix(in srgb, var(--cor-card) 12%, white);
            font-size: 29px;
        }

        .sistema-card h3 {
            margin-bottom: 10px;
            color: #111827;
            font-size: 24px;
        }

        .sistema-card > p {
            margin-bottom: 18px;
            color: #64748b;
        }

        .lista-recursos {
            list-style: none;
            margin-bottom: 24px;
        }

        .lista-recursos li {
            position: relative;
            padding: 7px 0 7px 23px;
            color: #475569;
            font-size: 15px;
        }

        .lista-recursos li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: var(--cor-card);
            font-weight: 900;
        }

        .sistema-card .btn-card {
            width: 100%;
            margin-top: auto;
            color: var(--cor-card);
            background: color-mix(in srgb, var(--cor-card) 9%, white);
            border-color: color-mix(in srgb, var(--cor-card) 28%, white);
        }

        .sistema-card .btn-card:hover {
            color: #ffffff;
            background: var(--cor-card);
        }

        .beneficios-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
        }

        .beneficio-card {
            padding: 24px;
            border: 1px solid var(--cor-borda);
            border-radius: 16px;
            background: #ffffff;
        }

        .beneficio-card .icone {
            display: inline-flex;
            width: 44px;
            height: 44px;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
            border-radius: 12px;
            background: #fff7ed;
            font-size: 21px;
        }

        .beneficio-card h3 {
            margin-bottom: 8px;
            color: #111827;
            font-size: 19px;
        }

        .beneficio-card p {
            color: #64748b;
            font-size: 15px;
        }

        .origem-box {
            display: grid;
            grid-template-columns: 0.9fr 1.1fr;
            gap: 38px;
            align-items: center;
            padding: 42px;
            border: 1px solid var(--cor-borda);
            border-radius: 24px;
            background: #ffffff;
            box-shadow: 0 18px 42px rgba(15, 23, 42, 0.08);
        }

        .origem-destaque-visual {
            min-height: 320px;
            padding: 30px;
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            color: #ffffff;
            background:
                linear-gradient(180deg, transparent, rgba(15, 23, 42, 0.86)),
                linear-gradient(135deg, #ff7a00, #26394f);
        }

        .origem-destaque-visual span {
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .origem-destaque-visual strong {
            font-size: 28px;
            line-height: 1.2;
        }

        .origem-conteudo h2 {
            margin-bottom: 16px;
            color: #111827;
            font-size: 36px;
            line-height: 1.2;
        }

        .origem-conteudo p {
            margin-bottom: 15px;
            color: #56647a;
            font-size: 17px;
        }

        .origem-nota {
            margin-top: 20px;
            padding: 18px 20px;
            border-left: 5px solid var(--cor-primaria);
            border-radius: 12px;
            background: #fff7ed;
            color: #475569;
        }

        .faixa {
            padding: 72px 24px;
            color: #ffffff;
            text-align: center;
            background:
                radial-gradient(circle at 20% 20%, rgba(255, 122, 0, 0.2), transparent 24%),
                #111827;
        }

        .faixa h2 {
            margin-bottom: 14px;
            font-size: clamp(30px, 4vw, 42px);
        }

        .faixa p {
            max-width: 760px;
            margin: 0 auto 28px;
            color: #cbd5e1;
            font-size: 18px;
        }

        .whatsapp-fixo {
            position: fixed;
            right: 18px;
            bottom: 18px;
            z-index: 9999;
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 14px 20px;
            border: 2px solid #ffffff;
            border-radius: 999px;
            background: #16a34a;
            color: #ffffff;
            font-size: 15px;
            font-weight: 900;
            box-shadow: 0 14px 32px rgba(22, 163, 74, 0.38);
            transition: 0.2s;
        }

        .whatsapp-fixo:hover {
            background: #15803d;
            transform: translateY(-3px);
        }

        .rodape {
            padding: 42px 24px 30px;
            border-top: 1px solid var(--cor-borda);
            background: #ffffff;
        }

        .rodape-grid {
            display: grid;
            grid-template-columns: 1.25fr 0.75fr 0.75fr;
            gap: 32px;
            margin-bottom: 28px;
        }

        .rodape h3 {
            margin-bottom: 10px;
            color: #111827;
            font-size: 19px;
        }

        .rodape p,
        .rodape a {
            color: #64748b;
            font-size: 14px;
        }

        .rodape a:hover {
            color: var(--cor-primaria);
        }

        .rodape-links {
            display: grid;
            gap: 8px;
        }

        .rodape-final {
            padding-top: 20px;
            border-top: 1px solid var(--cor-borda);
            color: #64748b;
            text-align: center;
            font-size: 13px;
        }

        @media (max-width: 980px) {
            .menu {
                display: none;
            }

            .hero-container,
            .origem-box {
                grid-template-columns: 1fr;
            }

            .sistemas-grid,
            .beneficios-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .rodape-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 680px) {
            .topo-container {
                min-height: auto;
                padding: 12px 16px;
            }

            .logo small {
                display: none;
            }

            .topo .btn {
                min-height: 42px;
                padding: 10px 14px;
                font-size: 13px;
            }

            .hero {
                padding: 58px 18px 54px;
            }

            .hero h1 {
                letter-spacing: -1px;
            }

            .hero p {
                font-size: 17px;
            }

            .acoes .btn {
                width: 100%;
            }

            .painel-hero {
                padding: 20px;
            }

            .secao {
                padding: 54px 18px;
            }

            .titulo-secao {
                margin-bottom: 30px;
            }

            .titulo-secao p {
                font-size: 16px;
            }

            .sistemas-grid,
            .beneficios-grid,
            .rodape-grid {
                grid-template-columns: 1fr;
            }

            .origem-box {
                padding: 22px;
            }

            .origem-destaque-visual {
                min-height: 240px;
            }

            .origem-conteudo h2 {
                font-size: 30px;
            }

            .faixa {
                padding: 58px 18px;
            }

            .faixa .btn {
                width: 100%;
                max-width: 360px;
            }

            .whatsapp-fixo {
                left: 14px;
                right: 14px;
                bottom: 14px;
                justify-content: center;
            }

            .rodape {
                padding-bottom: 92px;
            }
        }
    </style>
</head>
<body>
    <header class="topo">
        <div class="container topo-container">
            <a href="{{ route('site.index') }}" class="logo" aria-label="Página inicial S.G.A. Sistemas">
                <strong>S.G.A. <span>Sistemas</span></strong>
                <small>Gestão simples para negócios reais</small>
            </a>

            <nav class="menu" aria-label="Menu principal">
                <a href="#sistemas">Sistemas</a>
                <a href="#beneficios">Benefícios</a>
                <a href="#sobre">Sobre</a>
                <a href="#contato">Contato</a>
            </nav>

            <a href="{{ route('abrir.sistema') }}" class="btn btn-secundario">Acessar sistema</a>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container hero-container">
                <div>
                    <div class="badge">Soluções desenvolvidas para o seu negócio</div>

                    <h1>
                        Gestão simples para o seu negócio <span>crescer com organização</span>
                    </h1>

                    <p>
                        Sistemas para revendas de gás e água, oficinas mecânicas, salões de beleza
                        e barbearias. Controle clientes, financeiro, estoque, serviços e agendamentos
                        com mais clareza e segurança.
                    </p>

                    <div class="acoes">
                        <a href="#sistemas" class="btn btn-principal">Conhecer os sistemas</a>

                        <a
                            href="https://wa.me/5544999995767?text=Ol%C3%A1%2C%20Reginaldo.%20Quero%20conhecer%20melhor%20os%20sistemas%20S.G.A."
                            class="btn btn-claro"
                            target="_blank"
                            rel="noopener"
                        >
                            Solicitar demonstração
                        </a>
                    </div>

                    <div class="mini-info">
                        Atendimento direto com o desenvolvedor e implantação acompanhada.
                    </div>
                </div>

                <div class="painel-hero">
                    <h3>Uma plataforma, diferentes segmentos</h3>

                    <div class="resumo-sistemas">
                        <div class="resumo-item">
                            <div class="resumo-icone">🔥</div>
                            <div>
                                <strong>Revendas de Gás e Água</strong>
                                <span>Vendas, estoque, financeiro, clientes e entregas.</span>
                            </div>
                        </div>

                        <div class="resumo-item">
                            <div class="resumo-icone">🔧</div>
                            <div>
                                <strong>Oficinas Mecânicas Carros e Motos</strong>
                                <span>Veículos, Motos, serviços, produtos e histórico do cliente.</span>
                            </div>
                        </div>

                        <div class="resumo-item">
                            <div class="resumo-icone">✂️</div>
                            <div>
                                <strong>Salões e Barbearias</strong>
                                <span>Agendamentos, profissionais, caixa e atendimento.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="secao secao-branca" id="sistemas">
            <div class="container">
                <div class="titulo-secao">
                    <span class="etiqueta">Escolha sua solução</span>
                    <h2>Um sistema pensado para cada tipo de negócio</h2>
                    <p>
                        Cada solução possui recursos específicos para a rotina do segmento,
                        mantendo a mesma proposta: simplicidade, organização e visão financeira.
                    </p>
                </div>

                <div class="sistemas-grid">
                    <article class="sistema-card sistema-gas">
                        <div class="sistema-icone">🔥</div>
                        <h3>Gás e Água</h3>
                        <p>
                            Para revendas que precisam controlar toda a operação em um só lugar.
                        </p>

                        <ul class="lista-recursos">
                            <li>Clientes, pedidos e entregas</li>
                            <li>Produtos, estoque e vasilhames</li>
                            <li>Caixa, PIX e movimentações</li>
                            <li>Contas a pagar e receber</li>
                            <li>Veículos, motoristas e relatórios</li>
                        </ul>

                        <a
                            href="{{ route('site.sistemas.gas') }}"
                            class="btn btn-card"
                        >
                            Conhecer sistema de Gás
                        </a>
                    </article>

                    <article class="sistema-card sistema-oficina">
                        <div class="sistema-icone">🔧</div>
                        <h3>Oficina</h3>
                        <p>
                            Para oficinas de <strong>carros e motos</strong> que desejam organizar clientes, veículos, serviços e financeiro.
                        </p>

                        <ul class="lista-recursos">
                            <li>Cadastro de clientes e veículos</li>
                            <li>Categorias, modelos e serviços</li>
                            <li>Produtos e controle operacional</li>
                            <li>Histórico de atendimentos</li>
                            <li>Financeiro e relatórios</li>
                        </ul>

                        <a
                            href="{{ route('site.sistemas.oficina') }}"
                            class="btn btn-card"
                        >
                            Conhecer sistema de Oficina
                        </a>
                    </article>

                    <article class="sistema-card sistema-salao">
                        <div class="sistema-icone">✂️</div>
                        <h3>Salão e Barbearia</h3>
                        <p>
                            Para estabelecimentos que precisam facilitar agendamentos e controlar a rotina.
                        </p>

                        <ul class="lista-recursos">
                            <li>Agendamento público pelo celular</li>
                            <li>Clientes, profissionais e serviços</li>
                            <li>Horários e disponibilidade</li>
                            <li>Caixa e controle financeiro</li>
                            <li>Personalização por estabelecimento</li>
                        </ul>

                        <a
                            href="{{ route('site.sistemas.salao') }}"
                            class="btn btn-card"
                        >
                            Conhecer sistema de Salão
                        </a>
                    </article>
                </div>
            </div>
        </section>

        <section class="secao" id="beneficios">
            <div class="container">
                <div class="titulo-secao">
                    <span class="etiqueta">Benefícios</span>
                    <h2>Mais organização para tomar decisões melhores</h2>
                    <p>
                        O sistema ajuda a reduzir controles espalhados, esquecimentos e falta de clareza
                        sobre o que realmente acontece no negócio.
                    </p>
                </div>

                <div class="beneficios-grid">
                    <div class="beneficio-card">
                        <div class="icone">📊</div>
                        <h3>Visão financeira</h3>
                        <p>Acompanhe entradas, saídas, contas pendentes e resultados com mais clareza.</p>
                    </div>

                    <div class="beneficio-card">
                        <div class="icone">👥</div>
                        <h3>Clientes organizados</h3>
                        <p>Mantenha cadastro, histórico e informações importantes sempre acessíveis.</p>
                    </div>

                    <div class="beneficio-card">
                        <div class="icone">🔒</div>
                        <h3>Usuários e permissões</h3>
                        <p>Defina acessos de acordo com o perfil e a responsabilidade de cada usuário.</p>
                    </div>

                    <div class="beneficio-card">
                        <div class="icone">🧾</div>
                        <h3>Histórico confiável</h3>
                        <p>Registre movimentações e atendimentos para consultar quando precisar.</p>
                    </div>

                    <div class="beneficio-card">
                        <div class="icone">⚙️</div>
                        <h3>Rotina mais simples</h3>
                        <p>Centralize tarefas que antes ficavam espalhadas em papéis ou planilhas.</p>
                    </div>

                    <div class="beneficio-card">
                        <div class="icone">📈</div>
                        <h3>Evolução contínua</h3>
                        <p>Novos recursos são desenvolvidos com base em necessidades reais dos usuários.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="secao secao-branca" id="sobre">
            <div class="container">
                <div class="origem-box">
                    <div class="origem-destaque-visual">
                        <span>Experiência prática</span>
                        <strong>Desenvolvido por quem conhece a rotina real de um pequeno negócio.</strong>
                    </div>

                    <div class="origem-conteudo">
                        <h2>O S.G.A. nasceu para resolver problemas reais</h2>

                        <p>
                            O projeto começou dentro de uma revenda de gás e água, a partir da necessidade
                            de organizar clientes, pedidos, estoque, caixa e financeiro de forma simples.
                        </p>

                        <p>
                            Com a evolução do sistema, a mesma experiência prática foi aplicada na criação
                            de soluções para oficinas mecânicas, salões de beleza e barbearias.
                        </p>

                        <p>
                            O objetivo não é apenas cadastrar informações, mas ajudar o empreendedor a
                            entender melhor sua operação, reduzir falhas e tomar decisões com mais segurança.
                        </p>

                        <div class="origem-nota">
                            <strong>Sistemas em constante evolução:</strong>
                            cada melhoria é construída a partir da realidade e das necessidades dos usuários.
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="faixa" id="contato">
            <div class="container">
                <h2>Descubra qual sistema combina com o seu negócio</h2>
                <p>
                    Fale diretamente com o desenvolvedor, conheça os recursos disponíveis
                    e veja como o S.G.A. pode ajudar na organização da sua empresa.
                </p>

                <a
                    href="https://wa.me/5544999995767?text=Ol%C3%A1%2C%20Reginaldo.%20Quero%20conhecer%20melhor%20os%20sistemas%20S.G.A."
                    class="btn btn-principal"
                    target="_blank"
                    rel="noopener"
                >
                    Falar pelo WhatsApp
                </a>
            </div>
        </section>
    </main>

    <a
        href="https://wa.me/5544999995767?text=Ol%C3%A1%2C%20Reginaldo.%20Quero%20conhecer%20melhor%20os%20sistemas%20S.G.A."
        class="whatsapp-fixo"
        target="_blank"
        rel="noopener"
        aria-label="Falar pelo WhatsApp"
    >
        <span>💬</span>
        <span>Fale no WhatsApp</span>
    </a>

    <footer class="rodape">
        <div class="container">
            <div class="rodape-grid">
                <div>
                    <h3>S.G.A. Sistemas</h3>
                    <p>
                        Soluções de gestão para revendas de gás e água, oficinas,
                        salões de beleza e barbearias.
                    </p>
                </div>

                <div>
                    <h3>Sistemas</h3>
                    <div class="rodape-links">
                        <a href="{{ route('site.sistemas.gas') }}">Gás e Água</a>
                        <a href="{{ route('site.sistemas.oficina') }}">Oficina</a>
                        <a href="{{ route('site.sistemas.salao') }}">Salão e Barbearia</a>
                    </div>
                </div>

                <div>
                    <h3>Acesso</h3>
                    <div class="rodape-links">
                        <a href="{{ route('abrir.sistema') }}">Acessar sistema</a>
                        <a
                            href="https://wa.me/5544999995767"
                            target="_blank"
                            rel="noopener"
                        >
                            WhatsApp: (44) 9 9999-5767
                        </a>
                    </div>
                </div>
            </div>

            <div class="rodape-final">
                <p>Desenvolvido por Reginaldo Souza • S.G.A. Sistemas</p>
            </div>
        </div>
    </footer>
</body>
</html>