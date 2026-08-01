<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>S.G.A. Oficina - Gestão para oficinas de carros e motos</title>
    <meta name="description" content="Sistema de gestão para oficinas de carros e motos. Controle clientes, veículos, serviços, produtos, histórico de atendimentos, financeiro e relatórios.">
    <style>
        :root {
            --laranja: #e85d04;
            --laranja-escuro: #b94700;
            --laranja-claro: #fff1e8;
            --texto: #172033;
            --texto-suave: #64748b;
            --fundo: #f5f7fb;
            --branco: #ffffff;
            --borda: #e2e8f0;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            width: 100%;
            overflow-x: hidden;
            font-family: Arial, Helvetica, sans-serif;
            background: var(--fundo);
            color: var(--texto);
            line-height: 1.6;
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
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.97);
            border-bottom: 1px solid var(--borda);
            backdrop-filter: blur(10px);
        }

        .topo-container {
            min-height: 76px;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .logo {
            color: #111827;
            display: flex;
            flex-direction: column;
            line-height: 1.05;
        }

        .logo strong {
            font-size: 24px;
            font-weight: 900;
            letter-spacing: -0.8px;
        }

        .logo strong span {
            color: var(--laranja);
        }

        .logo small {
            margin-top: 5px;
            color: var(--texto-suave);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.6px;
            text-transform: uppercase;
        }

        .menu {
            display: flex;
            align-items: center;
            gap: 22px;
        }

        .menu a {
            color: #334155;
            font-size: 14px;
            font-weight: 800;
        }

        .menu a:hover {
            color: var(--laranja);
        }

        .acoes-topo {
            display: flex;
            align-items: center;
            gap: 10px;
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

        .btn-laranja {
            background: var(--laranja);
            color: var(--branco);
            box-shadow: 0 12px 26px rgba(232, 93, 4, 0.24);
        }

        .btn-laranja:hover {
            background: var(--laranja-escuro);
        }

        .btn-claro {
            background: var(--branco);
            color: #1e293b;
            border-color: #cbd5e1;
        }

        .btn-claro:hover {
            background: #f8fafc;
        }

        .hero {
            position: relative;
            overflow: hidden;
            padding: 92px 24px 84px;
            color: var(--branco);
            background:
                radial-gradient(circle at 88% 12%, rgba(255, 255, 255, 0.11), transparent 25%),
                linear-gradient(135deg, #242424 0%, #4b2d1d 45%, #e85d04 100%);
        }

        .hero::after {
            content: "";
            position: absolute;
            width: 360px;
            height: 360px;
            right: -130px;
            bottom: -160px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
        }

        .hero-container {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1.08fr 0.92fr;
            gap: 48px;
            align-items: center;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
            padding: 8px 13px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            font-size: 14px;
            font-weight: 800;
        }

        .hero h1 {
            max-width: 720px;
            margin-bottom: 20px;
            font-size: clamp(38px, 5vw, 60px);
            line-height: 1.06;
            letter-spacing: -1.8px;
        }

        .hero h1 span {
            color: #ffd2b8;
        }

        .hero p {
            max-width: 700px;
            margin-bottom: 28px;
            color: #f7e7dc;
            font-size: 19px;
        }

        .acoes {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }

        .mini-info {
            margin-top: 16px;
            color: #ead7ca;
            font-size: 14px;
        }

        .painel {
            padding: 28px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.11);
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.22);
            backdrop-filter: blur(12px);
        }

        .painel h3 {
            margin-bottom: 18px;
            font-size: 22px;
        }

        .painel-lista {
            display: grid;
            gap: 13px;
        }

        .painel-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 15px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.1);
        }

        .painel-icone {
            width: 58px;
            height: 46px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border-radius: 13px;
            background: rgba(255, 255, 255, 0.16);
            font-size: 18px;
            white-space: nowrap;
        }       

        .painel-item strong {
            display: block;
            margin-bottom: 2px;
            font-size: 16px;
        }

        .painel-item span {
            color: #f3ded1;
            font-size: 13px;
        }

        .secao {
            padding: 76px 24px;
        }

        .secao-branca {
            background: var(--branco);
        }

        .titulo-secao {
            max-width: 780px;
            margin: 0 auto 42px;
            text-align: center;
        }

        .titulo-secao .etiqueta {
            display: inline-block;
            margin-bottom: 10px;
            color: var(--laranja);
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
            color: var(--texto-suave);
            font-size: 18px;
        }

        .grid-recursos {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 22px;
        }

        .recurso-card {
            padding: 26px;
            border: 1px solid var(--borda);
            border-radius: 18px;
            background: var(--branco);
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
            transition: 0.22s ease;
        }

        .recurso-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 18px 38px rgba(15, 23, 42, 0.1);
        }

        .recurso-icone {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            border-radius: 14px;
            background: var(--laranja-claro);
            font-size: 24px;
        }

        .recurso-icone-veiculos {
            width: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            font-size: 18px;
            white-space: nowrap;
        }

        .recurso-card h3 {
            margin-bottom: 8px;
            color: #111827;
            font-size: 20px;
        }

        .recurso-card p {
            color: #64748b;
            font-size: 15px;
        }

        .destaque {
            display: grid;
            grid-template-columns: 0.95fr 1.05fr;
            gap: 38px;
            align-items: center;
            padding: 42px;
            border: 1px solid var(--borda);
            border-radius: 24px;
            background: var(--branco);
            box-shadow: 0 18px 42px rgba(15, 23, 42, 0.08);
        }

        .destaque-visual {
            min-height: 320px;
            padding: 30px;
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            color: var(--branco);
            background:
                linear-gradient(180deg, transparent, rgba(17, 24, 39, 0.9)),
                linear-gradient(135deg, var(--laranja), #292929);
        }

        .destaque-visual span {
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 900;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }

        .destaque-visual strong {
            font-size: 29px;
            line-height: 1.2;
        }

        .destaque-conteudo h2 {
            margin-bottom: 16px;
            color: #111827;
            font-size: 36px;
            line-height: 1.2;
        }

        .destaque-conteudo p {
            margin-bottom: 15px;
            color: #56647a;
            font-size: 17px;
        }

        .destaque-lista {
            list-style: none;
            display: grid;
            gap: 10px;
            margin-top: 20px;
        }

        .destaque-lista li {
            position: relative;
            padding-left: 26px;
            color: #475569;
        }

        .destaque-lista li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: var(--laranja);
            font-weight: 900;
        }

        .etapas-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 22px;
        }

        .etapa {
            padding: 30px 24px 24px;
            border: 1px solid var(--borda);
            border-radius: 18px;
            background: var(--branco);
        }

        .etapa-numero {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            border-radius: 50%;
            background: var(--laranja);
            color: var(--branco);
            font-size: 18px;
            font-weight: 900;
        }

        .etapa h3 {
            margin-bottom: 8px;
            font-size: 20px;
            color: #111827;
        }

        .etapa p {
            color: #64748b;
            font-size: 15px;
        }

        .faixa {
            padding: 72px 24px;
            color: var(--branco);
            text-align: center;
            background:
                radial-gradient(circle at 20% 20%, rgba(232, 93, 4, 0.22), transparent 25%),
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
            padding: 36px 24px 28px;
            border-top: 1px solid var(--borda);
            background: var(--branco);
        }

        .rodape-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .rodape p,
        .rodape a {
            color: #64748b;
            font-size: 14px;
        }

        .rodape strong {
            color: var(--laranja);
        }

        @media (max-width: 980px) {
            .menu {
                display: none;
            }

            .hero-container,
            .destaque {
                grid-template-columns: 1fr;
            }

            .grid-recursos,
            .etapas-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
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

            .acoes-topo .btn-claro {
                display: none;
            }

            .acoes-topo .btn {
                min-height: 42px;
                padding: 10px 14px;
                font-size: 13px;
            }

            .hero {
                padding: 58px 18px 54px;
            }

            .hero p {
                font-size: 17px;
            }

            .acoes .btn {
                width: 100%;
            }

            .painel {
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

            .grid-recursos,
            .etapas-grid {
                grid-template-columns: 1fr;
            }

            .destaque {
                padding: 22px;
            }

            .destaque-visual {
                min-height: 240px;
            }

            .destaque-conteudo h2 {
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

            .rodape-container {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <header class="topo">
        <div class="container topo-container">
            <a href="{{ route('site.index') }}" class="logo" aria-label="Voltar para a página inicial">
                <strong>S.G.A. <span>Oficina</span></strong>
                <small>Gestão simples para oficinas</small>
            </a>

            <nav class="menu" aria-label="Menu da página">
                <a href="#recursos">Recursos</a>
                <a href="#diferenciais">Diferenciais</a>
                <a href="#implantacao">Implantação</a>
            </nav>

            <div class="acoes-topo">
                <a href="{{ route('site.index') }}" class="btn btn-claro">Voltar ao site</a>
                <a href="{{ route('abrir.sistema') }}" class="btn btn-laranja">Acessar sistema</a>
            </div>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container hero-container">
                <div>
                    <div class="badge">🔧 Desenvolvido para oficinas de carros e motos</div>

                    <h1>
                        Clientes, veículos e serviços <span>em um só sistema</span>
                    </h1>

                    <p>
                        Organize carros, motos, clientes, categorias, modelos, serviços,
                        produtos, histórico de atendimentos, financeiro e relatórios com mais clareza.
                    </p>

                    <div class="acoes">
                        <a
                            href="https://wa.me/5544999995767?text=Ol%C3%A1%2C%20Reginaldo.%20Quero%20conhecer%20melhor%20o%20S.G.A.%20Oficina."
                            class="btn btn-laranja"
                            target="_blank"
                            rel="noopener"
                        >
                            Solicitar demonstração
                        </a>

                        <a href="#recursos" class="btn btn-claro">Ver recursos</a>
                    </div>

                    <div class="mini-info">
                        Atendimento direto com o desenvolvedor e implantação acompanhada.
                    </div>
                </div>

                <div class="painel">
                    <h3>O que você organiza no sistema</h3>

                    <div class="painel-lista">
                        <div class="painel-item">
                            <div class="painel-icone">👥</div>
                            <div>
                                <strong>Clientes</strong>
                                <span>Cadastro completo e histórico de atendimentos.</span>
                            </div>
                        </div>

                        <div class="painel-item">
                            <div class="painel-icone">🚗 🏍️</div>
                            <div>
                                <strong>Carros e motos</strong>
                                <span>Modelos, categorias e informações de cada veículo.</span>
                            </div>
                        </div>

                        <div class="painel-item">
                            <div class="painel-icone">🧰</div>
                            <div>
                                <strong>Serviços e produtos</strong>
                                <span>Organize o que foi realizado e os itens utilizados.</span>
                            </div>
                        </div>

                        <div class="painel-item">
                            <div class="painel-icone">📊</div>
                            <div>
                                <strong>Financeiro e relatórios</strong>
                                <span>Acompanhe movimentações, resultados e histórico.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="secao secao-branca" id="recursos">
            <div class="container">
                <div class="titulo-secao">
                    <span class="etiqueta">Recursos principais</span>
                    <h2>Mais controle para a operação da sua oficina</h2>
                    <p>
                        Centralize informações importantes e reduza a dependência de papéis,
                        anotações e controles espalhados.
                    </p>
                </div>

                <div class="grid-recursos">
                    <article class="recurso-card">
                        <div class="recurso-icone">👥</div>
                        <h3>Clientes</h3>
                        <p>Cadastro com telefone, endereço, observações e histórico de atendimentos.</p>
                    </article>

                    <article class="recurso-card">
                        <div class="recurso-icone recurso-icone-veiculos">
                            <span>🚗</span>
                            <span>🏍️</span>
                        </div>

                        <h3>Carros e motos</h3>

                        <p>
                            Cadastre os veículos vinculados aos clientes e mantenha
                            modelos, categorias e informações importantes organizados.
                        </p>
                    </article>

                    <article class="recurso-card">
                        <div class="recurso-icone">🗂️</div>
                        <h3>Categorias e modelos</h3>
                        <p>Organize carros e motos por categoria, marca, modelo e demais informações importantes.</p>
                    </article>

                    <article class="recurso-card">
                        <div class="recurso-icone">🧰</div>
                        <h3>Serviços</h3>
                        <p>Cadastre os serviços realizados e mantenha um padrão de atendimento.</p>
                    </article>

                    <article class="recurso-card">
                        <div class="recurso-icone">📦</div>
                        <h3>Produtos</h3>
                        <p>Controle itens, peças e produtos utilizados na rotina da oficina.</p>
                    </article>

                    <article class="recurso-card">
                        <div class="recurso-icone">🕘</div>
                        <h3>Histórico</h3>
                        <p>Consulte os serviços e movimentações relacionados ao cliente e ao veículo.</p>
                    </article>

                    <article class="recurso-card">
                        <div class="recurso-icone">💰</div>
                        <h3>Financeiro</h3>
                        <p>Acompanhe entradas, saídas, contas e movimentações da empresa.</p>
                    </article>

                    <article class="recurso-card">
                        <div class="recurso-icone">🔐</div>
                        <h3>Usuários e permissões</h3>
                        <p>Defina acessos conforme a responsabilidade de cada usuário.</p>
                    </article>

                    <article class="recurso-card">
                        <div class="recurso-icone">📈</div>
                        <h3>Dashboards e relatórios</h3>
                        <p>Tenha uma visão mais clara da operação, do histórico e dos resultados.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="secao" id="diferenciais">
            <div class="container">
                <div class="destaque">
                    <div class="destaque-visual">
                        <span>Organização prática</span>
                        <strong>Uma visão mais clara de clientes, veículos e serviços.</strong>
                    </div>

                    <div class="destaque-conteudo">
                        <h2>Menos informação perdida, mais controle da rotina</h2>

                        <p>
                            O sistema ajuda a reunir em um só lugar os dados do cliente,
                            do veículo e dos serviços realizados.
                        </p>

                        <p>
                            Isso reduz a dependência de anotações soltas e facilita consultas futuras,
                            acompanhamentos e decisões sobre a operação.
                        </p>

                        <ul class="destaque-lista">
                            <li>Histórico organizado por cliente e veículo</li>
                            <li>Mais facilidade para localizar informações</li>
                            <li>Serviços e produtos cadastrados de forma padronizada</li>
                            <li>Controle financeiro integrado à rotina</li>
                            <li>Evolução contínua conforme o uso real</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="secao secao-branca" id="implantacao">
            <div class="container">
                <div class="titulo-secao">
                    <span class="etiqueta">Implantação acompanhada</span>
                    <h2>Comece com organização desde o primeiro acesso</h2>
                    <p>
                        A implantação é feita de forma simples, respeitando a realidade da sua oficina.
                    </p>
                </div>

                <div class="etapas-grid">
                    <article class="etapa">
                        <div class="etapa-numero">1</div>
                        <h3>Conversa inicial</h3>
                        <p>Entendemos como sua oficina trabalha e quais controles você utiliza atualmente.</p>
                    </article>

                    <article class="etapa">
                        <div class="etapa-numero">2</div>
                        <h3>Configuração</h3>
                        <p>Preparamos o acesso, usuários, permissões e cadastros principais.</p>
                    </article>

                    <article class="etapa">
                        <div class="etapa-numero">3</div>
                        <h3>Acompanhamento</h3>
                        <p>Você recebe orientação para começar a utilizar o sistema com segurança.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="faixa">
            <div class="container">
                <h2>Quer organizar melhor sua oficina?</h2>
                <p>
                    Fale diretamente com o desenvolvedor, conheça o S.G.A. Oficina
                    e veja como o sistema pode ajudar no dia a dia da sua empresa.
                </p>

                <a
                    href="https://wa.me/5544999995767?text=Ol%C3%A1%2C%20Reginaldo.%20Quero%20conhecer%20melhor%20o%20S.G.A.%20Oficina."
                    class="btn btn-laranja"
                    target="_blank"
                    rel="noopener"
                >
                    Falar pelo WhatsApp
                </a>
            </div>
        </section>
    </main>

    <a
        href="https://wa.me/5544999995767?text=Ol%C3%A1%2C%20Reginaldo.%20Tenho%20interesse%20no%20S.G.A.%20Oficina."
        class="whatsapp-fixo"
        target="_blank"
        rel="noopener"
        aria-label="Falar pelo WhatsApp"
    >
        <span>💬</span>
        <span>Fale no WhatsApp</span>
    </a>

    <footer class="rodape">
        <div class="container rodape-container">
            <div>
                <p><strong>S.G.A. Oficina</strong></p>
                <p>Sistema de gestão para oficinas mecânicas.</p>
            </div>

            <div>
                <p>Desenvolvido por Reginaldo Souza</p>
                <p><a href="{{ route('site.index') }}">Voltar para S.G.A. Sistemas</a></p>
            </div>
        </div>
    </footer>
</body>
</html>