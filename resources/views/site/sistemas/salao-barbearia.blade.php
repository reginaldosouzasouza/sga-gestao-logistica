<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>S.G.A. Salão e Barbearia - Gestão e agendamento</title>
    <meta name="description" content="Sistema para salões de beleza e barbearias. Controle clientes, profissionais, serviços, agenda, horários, caixa, financeiro e agendamento público pelo celular.">

    <style>
        :root {
            --rosa: #c2185b;
            --rosa-escuro: #8e1042;
            --rosa-claro: #fff0f6;
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
            color: var(--rosa);
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
            color: var(--rosa);
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

        .btn-rosa {
            background: var(--rosa);
            color: var(--branco);
            box-shadow: 0 12px 26px rgba(194, 24, 91, 0.24);
        }

        .btn-rosa:hover {
            background: var(--rosa-escuro);
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
                linear-gradient(135deg, #54102d 0%, #8e1042 48%, #c2185b 100%);
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
            color: #ffd3e4;
        }

        .hero p {
            max-width: 700px;
            margin-bottom: 28px;
            color: #fde9f1;
            font-size: 19px;
        }

        .acoes {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }

        .mini-info {
            margin-top: 16px;
            color: #f8dce8;
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
            width: 46px;
            height: 46px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border-radius: 13px;
            background: rgba(255, 255, 255, 0.16);
            font-size: 23px;
        }

        .painel-item strong {
            display: block;
            margin-bottom: 2px;
            font-size: 16px;
        }

        .painel-item span {
            color: #f9e0ea;
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
            color: var(--rosa);
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
            background: var(--rosa-claro);
            font-size: 24px;
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
                linear-gradient(135deg, var(--rosa), #54102d);
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
            color: var(--rosa);
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
            background: var(--rosa);
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
                radial-gradient(circle at 20% 20%, rgba(194, 24, 91, 0.22), transparent 25%),
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
            color: var(--rosa);
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
                <strong>S.G.A. <span>Salão e Barbearia</span></strong>
                <small>Gestão e agendamento em um só lugar</small>
            </a>

            <nav class="menu" aria-label="Menu da página">
                <a href="#recursos">Recursos</a>
                <a href="#diferenciais">Diferenciais</a>
                <a href="#implantacao">Implantação</a>
            </nav>

            <div class="acoes-topo">
                <a href="{{ route('site.index') }}" class="btn btn-claro">Voltar ao site</a>
                <a href="{{ route('abrir.sistema') }}" class="btn btn-rosa">Acessar sistema</a>
            </div>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container hero-container">
                <div>
                    <div class="badge">✂️ Para salões de beleza e barbearias</div>

                    <h1>
                        Agendamentos e gestão <span>em um só sistema</span>
                    </h1>

                    <p>
                        Organize clientes, profissionais, serviços, horários, agenda,
                        caixa e financeiro. Seus clientes também podem agendar pelo celular.
                    </p>

                    <div class="acoes">
                        <a
                            href="https://wa.me/5544999995767?text=Ol%C3%A1%2C%20Reginaldo.%20Quero%20conhecer%20melhor%20o%20S.G.A.%20para%20sal%C3%A3o%20ou%20barbearia."
                            class="btn btn-rosa"
                            target="_blank"
                            rel="noopener"
                        >
                            Solicitar demonstração
                        </a>

                        <a href="#recursos" class="btn btn-claro">Ver recursos</a>
                    </div>

                    <div class="mini-info">
                        Página pública de agendamento personalizada para cada estabelecimento.
                    </div>
                </div>

                <div class="painel">
                    <h3>O que você organiza no sistema</h3>

                    <div class="painel-lista">
                        <div class="painel-item">
                            <div class="painel-icone">📅</div>
                            <div>
                                <strong>Agenda e horários</strong>
                                <span>Visualize agendamentos, datas e disponibilidade.</span>
                            </div>
                        </div>

                        <div class="painel-item">
                            <div class="painel-icone">👥</div>
                            <div>
                                <strong>Clientes e profissionais</strong>
                                <span>Cadastros, histórico e informações importantes.</span>
                            </div>
                        </div>

                        <div class="painel-item">
                            <div class="painel-icone">✂️</div>
                            <div>
                                <strong>Serviços</strong>
                                <span>Valores, duração, categorias e profissionais.</span>
                            </div>
                        </div>

                        <div class="painel-item">
                            <div class="painel-icone">💰</div>
                            <div>
                                <strong>Caixa e financeiro</strong>
                                <span>Entradas, saídas, contas a pagar e receber.</span>
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
                    <h2>Mais organização para o atendimento e para o financeiro</h2>
                    <p>
                        Centralize informações importantes da rotina do estabelecimento
                        e ofereça uma experiência mais simples para seus clientes.
                    </p>
                </div>

                <div class="grid-recursos">
                    <article class="recurso-card">
                        <div class="recurso-icone">📱</div>
                        <h3>Agendamento público</h3>
                        <p>O cliente escolhe profissional, serviço, data e horário diretamente pelo celular.</p>
                    </article>

                    <article class="recurso-card">
                        <div class="recurso-icone">📅</div>
                        <h3>Agenda interna</h3>
                        <p>Consulte agendamentos por data ou período e acompanhe os próximos atendimentos.</p>
                    </article>

                    <article class="recurso-card">
                        <div class="recurso-icone">👥</div>
                        <h3>Clientes</h3>
                        <p>Cadastro com telefone, nascimento, observações e histórico de atendimentos.</p>
                    </article>

                    <article class="recurso-card">
                        <div class="recurso-icone">💇</div>
                        <h3>Profissionais</h3>
                        <p>Organize profissionais, especialidades, horários e situação de atendimento.</p>
                    </article>

                    <article class="recurso-card">
                        <div class="recurso-icone">✂️</div>
                        <h3>Serviços</h3>
                        <p>Cadastre categorias, valores, duração e disponibilidade por profissional.</p>
                    </article>

                    <article class="recurso-card">
                        <div class="recurso-icone">🕘</div>
                        <h3>Horários e disponibilidade</h3>
                        <p>Defina a agenda de cada profissional e evite conflitos de horários.</p>
                    </article>

                    <article class="recurso-card">
                        <div class="recurso-icone">💵</div>
                        <h3>Caixa diário</h3>
                        <p>Registre entradas, saídas, formas de pagamento e fechamento do dia.</p>
                    </article>

                    <article class="recurso-card">
                        <div class="recurso-icone">🧾</div>
                        <h3>Contas a pagar e receber</h3>
                        <p>Acompanhe compromissos, recebimentos, pendências e movimentações financeiras.</p>
                    </article>

                    <article class="recurso-card">
                        <div class="recurso-icone">🎨</div>
                        <h3>Personalização</h3>
                        <p>Use cores, nome e logotipo próprios na experiência de cada estabelecimento.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="secao" id="diferenciais">
            <div class="container">
                <div class="destaque">
                    <div class="destaque-visual">
                        <span>Experiência do cliente</span>
                        <strong>Agendamento simples pelo celular, sem complicação.</strong>
                    </div>

                    <div class="destaque-conteudo">
                        <h2>Facilite o agendamento e organize melhor sua rotina</h2>

                        <p>
                            O cliente pode acessar uma página personalizada, escolher o profissional,
                            o serviço, a data e o horário disponível.
                        </p>

                        <p>
                            Ao mesmo tempo, o estabelecimento mantém clientes, serviços, agenda,
                            caixa e informações financeiras centralizados.
                        </p>

                        <ul class="destaque-lista">
                            <li>Agendamento público adaptado para celular</li>
                            <li>Agenda organizada por profissional e período</li>
                            <li>Cadastro de serviços com valor e duração</li>
                            <li>Controle de caixa e financeiro</li>
                            <li>Identidade visual personalizada por empresa</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="secao secao-branca" id="implantacao">
            <div class="container">
                <div class="titulo-secao">
                    <span class="etiqueta">Implantação acompanhada</span>
                    <h2>Configure o estabelecimento e comece a receber agendamentos</h2>
                    <p>
                        A implantação é feita de forma simples, respeitando os horários,
                        serviços e profissionais do seu negócio.
                    </p>
                </div>

                <div class="etapas-grid">
                    <article class="etapa">
                        <div class="etapa-numero">1</div>
                        <h3>Configuração</h3>
                        <p>Definimos nome, cores, logotipo e informações do estabelecimento.</p>
                    </article>

                    <article class="etapa">
                        <div class="etapa-numero">2</div>
                        <h3>Cadastros</h3>
                        <p>Organizamos profissionais, serviços, valores, duração e horários disponíveis.</p>
                    </article>

                    <article class="etapa">
                        <div class="etapa-numero">3</div>
                        <h3>Divulgação</h3>
                        <p>Você recebe o link público para compartilhar com os clientes e receber agendamentos.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="faixa">
            <div class="container">
                <h2>Quer facilitar os agendamentos do seu negócio?</h2>
                <p>
                    Fale diretamente com o desenvolvedor, conheça o S.G.A. Salão e Barbearia
                    e veja como o sistema pode ajudar no atendimento e na organização.
                </p>

                <a
                    href="https://wa.me/5544999995767?text=Ol%C3%A1%2C%20Reginaldo.%20Quero%20conhecer%20melhor%20o%20S.G.A.%20para%20sal%C3%A3o%20ou%20barbearia."
                    class="btn btn-rosa"
                    target="_blank"
                    rel="noopener"
                >
                    Falar pelo WhatsApp
                </a>
            </div>
        </section>
    </main>

    <a
        href="https://wa.me/5544999995767?text=Ol%C3%A1%2C%20Reginaldo.%20Tenho%20interesse%20no%20S.G.A.%20para%20sal%C3%A3o%20ou%20barbearia."
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
                <p><strong>S.G.A. Salão e Barbearia</strong></p>
                <p>Sistema de gestão e agendamento.</p>
            </div>

            <div>
                <p>Desenvolvido por Reginaldo Souza</p>
                <p><a href="{{ route('site.index') }}">Voltar para S.G.A. Sistemas</a></p>
            </div>
        </div>
    </footer>
</body>
</html>