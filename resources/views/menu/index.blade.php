{{--
    resources/views/menu/index.blade.php
    ─────────────────────────────────────────────────────────────────────
    Recebe do MenuController:
      $modulo     → 'oficina' | 'gas' | 'gerencial' | 'padoca' | 'caixa'
      $moduloNome → 'Oficina' | 'Revenda de Gás' | ...
      $moduloCor  → 'mod-oficina' | 'mod-gas' | ...
      $menuExtra  → array de grupos/itens definidos em config/modulos.php
    ─────────────────────────────────────────────────────────────────────
--}}
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu – {{ $moduloNome }}</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* ── Reset ─────────────────────────────────────────────────── */
        * { margin:0; padding:0; box-sizing:border-box; }

        /* ── Temas por módulo (accent via CSS var) ──────────────────── */
        :root               { --accent: #c8a52a; }
        .mod-oficina        { --accent: #4b4b4b; }
        .mod-gas            { --accent: #e8b000; }
        .mod-gerencial      { --accent: #0d6efd; }
        .mod-padoca         { --accent: #8B4513; }
        .mod-caixa          { --accent: #2f7b0b; }

        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            background: #fff;
        }

        /* ── Navbar desktop ─────────────────────────────────────────── */
        nav { background-color: #333; position: relative; width: 100%; }
        nav ul { list-style: none; display: flex; flex-wrap: wrap; align-items: stretch; }
        nav li { display: inline-block; position: relative; }

        nav li a {
            color: #fcfcfc;
            padding: 20px 30px;
            text-decoration: none;
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background .2s;
        }
        nav li a:hover           { background-color: var(--accent); }
        nav li.sair a:hover      { background-color: brown; }

        .mobile-menu-header,
        .mobile-icon,
        .mobile-arrow {
            display: none;
        }

        /* ── Dropdowns desktop ──────────────────────────────────────── */
        .dropdown-submenu {
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #333;
            box-shadow: 0 2px 8px rgba(0,0,0,.5);
            display: none;
            z-index: 200;
            min-width: 240px;
        }
        .dropdown-submenu .dropdown-submenu { left: 100%; top: 0; }
        .dropdown:hover > .dropdown-submenu { display: block; }
        .dropdown-submenu a {
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            padding: 10px 16px;
            width: 100%;
        }
        .dropdown-submenu a:hover { background-color: var(--accent); }

        .imagem { width: 36px; height: 36px; margin-left: auto; }
        .saida  { width: 28px; height: 28px; }

        /* ── Barra do módulo desktop ───────────────────────────────── */
        .gestao {
            display: inline-flex;
            margin-left: auto;
        }

        .box-gestao {
            background-color: var(--accent);
            color: whitesmoke;
            min-width: 370px;
            padding: 8px 16px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-end;
        }

        .titulo-sistema {
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            line-height: 1.2;
            white-space: nowrap;
        }

        .usuario-logado {
            color: #222;
            font-size: 14px;
            font-weight: bold;
            margin-top: 3px;
            line-height: 1.2;
        }

        #date-time {
            display: flex;
            gap: 16px;
            margin-top: 3px;
        }

        #date, #time {
            color: rgb(45,246,72);
            font-size: .95em;
            margin: 0;
        }

        .li-desabilitado         { pointer-events: none !important; }
        .menu-desabilitado       { opacity: .35; filter: grayscale(100%); cursor: not-allowed !important; }
        .li-desabilitado > .dropdown-submenu { display: none !important; }
        .menu-link.active + .dropdown-submenu { display: block; }

        /* =====================================================
           MENU INTERNO MOBILE - COMPACTO E FUNCIONAL
           Nas telas internas: clientes, produtos, compras etc.
           Fica igual ao modelo aprovado da tela Clientes:
           uma barra horizontal com rolagem.
           ===================================================== */
        @media (max-width: 768px) {
            body {
                background: #fff;
                overflow-x: hidden;
            }

            nav {
                width: 100% !important;
                background: #2f2f2f !important;
                overflow-x: auto !important;
                overflow-y: visible !important;
                white-space: nowrap !important;
                padding: 0 !important;
                margin: 0 !important;
                box-sizing: border-box !important;
                -webkit-overflow-scrolling: touch !important;
                box-shadow: 0 3px 8px rgba(0,0,0,.18) !important;
                position: sticky !important;
                top: 0 !important;
                z-index: 9000 !important;
            }

            nav::-webkit-scrollbar {
                height: 4px !important;
            }

            nav::-webkit-scrollbar-thumb {
                background: #8b8b8b !important;
                border-radius: 10px !important;
            }

            .mobile-menu-header {
                display: none !important;
            }

            nav ul {
                display: flex !important;
                flex-direction: row !important;
                flex-wrap: nowrap !important;
                width: max-content !important;
                min-width: 100% !important;
                margin: 0 !important;
                padding: 7px 8px !important;
                gap: 6px !important;
                align-items: center !important;
                list-style: none !important;
                box-sizing: border-box !important;
            }

            nav li {
                display: inline-flex !important;
                width: auto !important;
                min-width: auto !important;
                max-width: none !important;
                margin: 0 !important;
                padding: 0 !important;
                flex: 0 0 auto !important;
                position: relative !important;
                box-sizing: border-box !important;
            }

            nav li > a {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: auto !important;
                min-width: auto !important;
                height: auto !important;
                min-height: 0 !important;
                padding: 11px 13px !important;
                font-size: 15px !important;
                line-height: 1 !important;
                color: #fff !important;
                text-decoration: none !important;
                white-space: nowrap !important;
                border-radius: 6px !important;
                background: transparent !important;
                border: 0 !important;
                box-shadow: none !important;
                box-sizing: border-box !important;
                gap: 5px !important;
                cursor: pointer !important;
            }

            nav li > a:hover,
            nav li.dropdown.open > a {
                background-color: #444 !important;
            }

            .mobile-icon,
            .mobile-arrow {
                display: none !important;
            }

            .menu-text {
                display: inline !important;
                font-weight: 600 !important;
            }

            nav li.sair {
                grid-column: auto !important;
            }

            nav li.sair > a {
                min-height: 0 !important;
                flex-direction: row !important;
                justify-content: center !important;
                gap: 5px !important;
                font-size: 15px !important;
            }

            /* No celular, escondemos o bloco amarelo nas telas internas */
            .gestao,
            .box-gestao {
                display: none !important;
            }

            /*
               Submenu mobile:
               O painel abre abaixo da barra, sem depender de hover.
            */
            .dropdown-submenu {
                display: none !important;
                position: fixed !important;
                top: 54px !important;
                left: 8px !important;
                right: 8px !important;
                width: auto !important;
                min-width: 220px !important;
                max-width: calc(100vw - 16px) !important;
                max-height: calc(100vh - 72px) !important;
                overflow-y: auto !important;
                background-color: #252525 !important;
                border-radius: 8px !important;
                padding: 8px !important;
                z-index: 99999 !important;
                box-shadow: 0 8px 20px rgba(0,0,0,0.35) !important;
                border: 1px solid rgba(255,255,255,.08) !important;
            }

            .dropdown.open > .dropdown-submenu {
                display: block !important;
            }

            .dropdown-submenu .dropdown-submenu {
                position: static !important;
                display: block !important;
                max-height: none !important;
                width: 100% !important;
                min-width: 100% !important;
                margin: 4px 0 0 !important;
                padding: 0 !important;
                background: transparent !important;
                border: 0 !important;
                box-shadow: none !important;
            }

            .dropdown-submenu a {
                display: flex !important;
                width: 100% !important;
                min-height: 0 !important;
                justify-content: space-between !important;
                align-items: center !important;
                padding: 12px 12px !important;
                margin: 3px 0 !important;
                font-size: 14px !important;
                color: #fff !important;
                white-space: normal !important;
                text-align: left !important;
                border-radius: 6px !important;
                background: #2b2b2b !important;
                border: 0 !important;
                box-shadow: none !important;
                box-sizing: border-box !important;
            }

            .dropdown-submenu a:hover {
                background-color: #3a3a3a !important;
            }

            .dropdown-submenu .imagem {
                max-width: 32px !important;
                max-height: 32px !important;
                object-fit: contain !important;
            }

            #conteudo {
                padding: 12px !important;
                color: #222 !important;
                min-height: 55vh !important;
                background: #fff !important;
            }

            /* Suporte inteligente no celular */
            #btn-chat-wrapper {
                right: 10px !important;
                bottom: 10px !important;
                z-index: 9998 !important;
            }

            #btn-chat {
                width: 54px !important;
                height: 54px !important;
                border-width: 3px !important;
            }

            #tooltip-chat {
                display: none !important;
            }

            #box-chat {
                width: calc(100vw - 20px) !important;
                max-width: 380px !important;
                height: 62vh !important;
                max-height: 470px !important;
                right: 10px !important;
                left: auto !important;
                bottom: 74px !important;
                border-radius: 12px !important;
                z-index: 9999 !important;
            }
        }

        @media (max-width: 420px) {
            nav ul {
                padding: 7px 6px !important;
                gap: 4px !important;
            }

            nav li > a {
                font-size: 14px !important;
                padding: 10px 11px !important;
            }

            .dropdown-submenu {
                top: 52px !important;
            }
        }

    </style>
</head>

@php
    $moduloAtual = session('modulo_atual', 'gas');

    $modulosConfig = config('modulos');

    if (!array_key_exists($moduloAtual, $modulosConfig)) {
        $moduloAtual = 'gas';
    }

    $cfgModulo = config("modulos.$moduloAtual");

    $modulo = $modulo ?? $moduloAtual;
    $moduloNome = $moduloNome ?? ($cfgModulo['label'] ?? 'Revenda de Gás');
    $moduloCor = $moduloCor ?? ($cfgModulo['cor'] ?? 'mod-gas');

    /*
     * Mantém itens dinâmicos do config/modulos.php,
     * mas como a Movimentação foi movida para partial fixo,
     * ela pode ficar comentada no config/modulos.php.
     */
    $menuExtra = $menuExtra ?? ($cfgModulo['menu'] ?? []);

    $user = auth()->user();

    $isMaster = $user && strtoupper(trim($user->tipo ?? '')) === 'MASTER';

     $nomeEmpresaLogada = $nomeEmpresaLogada ?? ($user->empresa->nome ?? $moduloNome ?? 'Empresa não identificada');




    /*
     * Menu Movimentação / Coletas.
     * MASTER vê sempre.
     * Outros usuários só veem se tiverem permissão.
     */
    $podeVerMenuMovimentacao =
        $isMaster ||        
        ($user && $user->temPermissao('pedido_visualizar')) ||
        ($user && $user->temPermissao('pedido_criar')) ||
        ($user && $user->temPermissao('pedido_editar')) ||
        ($user && $user->temPermissao('pedido_cancelar')) ||
        ($user && $user->temPermissao('estoque_visualizar'));
@endphp
{{-- classe do módulo aplicada ao body ↓ --}}
<body class="{{ $moduloCor }}">

<nav>
    <div class="mobile-menu-header">
        <div class="mobile-brand">
            <i class="bi bi-fire"></i>
            <span>{{ strtoupper($moduloNome) }}</span>
        </div>
        <div class="mobile-hamburger"><i class="bi bi-list"></i></div>
    </div>

    <ul>

        {{-- ════════════════════════════════════════════════════
             BLOCO 1 — ITENS FIXOS (iguais em todos os módulos)
             ════════════════════════════════════════════════════ --}}

        {{-- Cadastro --}}
        <li class="dropdown">
            <a href="#"><span class="mobile-icon"><i class="bi bi-person-vcard"></i></span><span class="menu-text">Cadastro</span> <i class="bi bi-caret-down-fill"></i><span class="mobile-arrow"><i class="bi bi-chevron-right"></i></span></a>
            <div class="dropdown-submenu">
                @include('menu.partials.itens-fixos.cadastro')
            </div>
        </li>


                {{-- Movimentação / Coletas --}}
        @if($podeVerMenuMovimentacao)
            <li class="dropdown">
                <a href="#">
                    Movimentação <i class="bi bi-caret-down-fill"></i>
                </a>

                <div class="dropdown-submenu">
                    @include('menu.partials.itens-fixos.movimentacao')
                </div>
            </li>
        @endif

        {{-- ════════════════════════════════════════════════════
             BLOCO 2 — ITENS DINÂMICOS DO MÓDULO ATIVO
             Vem de config/modulos.php via $menuExtra
             ════════════════════════════════════════════════════ --}}

        @foreach($menuExtra as $grupo)
            @if(!empty($grupo['filhos']))
                {{-- Grupo com dropdown --}}
                <li class="dropdown">
                    <a href="{{ $grupo['url'] }}">
                        <span class="mobile-icon"><i class="bi bi-arrow-repeat"></i></span><span class="menu-text">{{ $grupo['label'] }}</span> <i class="bi bi-caret-down-fill"></i><span class="mobile-arrow"><i class="bi bi-chevron-right"></i></span>
                    </a>
                    <div class="dropdown-submenu">
                        @foreach($grupo['filhos'] as $filho)
                            <a href="{{ $filho['url'] }}" target="_blank">
                                {{ $filho['label'] }}
                                @if(!empty($filho['icone']))
                                    <img src="{{ asset($filho['icone']) }}" class="imagem">
                                @endif
                            </a>
                        @endforeach
                    </div>
                </li>
            @else
                {{-- Link simples sem dropdown --}}
                <li>
                    <a href="{{ $grupo['url'] }}" target="_blank"><span class="mobile-icon"><i class="bi bi-arrow-repeat"></i></span><span class="menu-text">{{ $grupo['label'] }}</span><span class="mobile-arrow"><i class="bi bi-chevron-right"></i></span></a>
                </li>
            @endif
        @endforeach

        {{-- ════════════════════════════════════════════════════
             BLOCO 3 — ITENS FIXOS DO FIM (Financeiro, Relatórios, Sair)
             ════════════════════════════════════════════════════ --}}

        {{-- Financeiro --}}
        <li class="dropdown">
            <a href="#"><span class="mobile-icon"><i class="bi bi-currency-dollar"></i></span><span class="menu-text">Financeiro</span> <i class="bi bi-caret-down-fill"></i><span class="mobile-arrow"><i class="bi bi-chevron-right"></i></span></a>
            <div class="dropdown-submenu">
                @include('menu.partials.itens-fixos.financeiro')
            </div>
        </li>

       
       
       
        {{-- Relatórios --}}
        <li class="dropdown">
            <a href="#"><span class="mobile-icon"><i class="bi bi-bar-chart-line"></i></span><span class="menu-text">Relatórios</span> <i class="bi bi-caret-down-fill"></i><span class="mobile-arrow"><i class="bi bi-chevron-right"></i></span></a>
            <div class="dropdown-submenu">
                @include('menu.partials.itens-fixos.relatorios')
            </div>
        </li>



          {{-- Dashboard --}}
        <li class="dropdown">
            <a href="#"><span class="mobile-icon"><i class="bi bi-speedometer2"></i></span><span class="menu-text">Dashboard</span> <i class="bi bi-caret-down-fill"></i><span class="mobile-arrow"><i class="bi bi-chevron-right"></i></span></a>
            <div class="dropdown-submenu">
                @include('menu.partials.itens-fixos.dashboard')
            </div>
        </li>


           {{-- Configurações --}}
        <li class="dropdown">
            <a href="#"><span class="mobile-icon"><i class="bi bi-gear"></i></span><span class="menu-text">Configurações</span> <i class="bi bi-caret-down-fill"></i><span class="mobile-arrow"><i class="bi bi-chevron-right"></i></span></a>
            <div class="dropdown-submenu">
               @include('menu.partials.itens-fixos.configuracoes')
            </div>
        </li>

        {{-- Sair --}}
        <li class="sair">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
            <a href="#" onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                <span class="mobile-icon"><i class="bi bi-box-arrow-right"></i></span><span class="menu-text">Sair</span><span class="mobile-arrow"><i class="bi bi-chevron-right"></i></span>
            </a>
        </li>

        {{-- Barra do módulo com data/hora --}}
        <li class="gestao">
            <div class="box-gestao">
                <div class="titulo-sistema">
                 Empresa: {{ $nomeEmpresaLogada ?? (Auth::user()->empresa->nome ?? $moduloNome ?? 'Empresa não identificada') }}
                </div>

                <div class="usuario-logado">
                    Usuário: {{ Auth::user()->nome_completo ?? Auth::user()->usuario ?? 'Usuário' }}
                </div>

                <div id="date-time">
                    <p id="date"></p>
                    <p id="time"></p>
                </div>
            </div>
        </li>
        
    </ul>
</nav>

{{-- ════ Conteúdo da página (iframe ou div de cada módulo) ════ --}}
<div id="conteudo" style="padding:20px; color:#eee;">
    {{-- Aqui você @yield('conteudo') se este arquivo virar layout,
         ou deixa em branco por enquanto --}}
</div>




<!-- Botão com tooltip estilizado -->
 <!-- Botão com tooltip e animação -->


<style>
    @keyframes pulsar {
        0%   { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7); }
        70%  { box-shadow: 0 0 0 18px rgba(40, 167, 69, 0); }
        100% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
    }
</style>

<div id="btn-chat-wrapper" style="position:fixed; bottom:20px; right:20px; z-index:9999;">

    <div id="tooltip-chat" style="display:none; position:absolute; bottom:90px; right:0; background:#28a745; color:white; padding:8px 14px; border-radius:8px; white-space:nowrap; font-size:13px; font-family:sans-serif; box-shadow: 0 3px 8px rgba(0,0,0,0.2);">
        💬 Fale comigo, estou pronto a te Ajudar.
        <div style="position:absolute; bottom:-6px; right:28px; width:12px; height:12px; background:#28a745; transform:rotate(45deg);"></div>
    </div>

    <div id="btn-chat" onclick="toggleChat()"
         onmouseenter="document.getElementById('tooltip-chat').style.display='block'"
         onmouseleave="document.getElementById('tooltip-chat').style.display='none'"
         style="width:80px; height:80px; border-radius:50%; cursor:pointer; border: 3px solid #28a745; animation: pulsar 2s infinite;">
        
        <div style="width:100%; height:100%; border-radius:50%; overflow:hidden;">
            <img src="{{ asset('images/imagem/agente.png') }}" alt="Suporte" style="width:100%; height:100%; object-fit:cover;">
        </div>
    </div>

</div>
 

<!-- Janela do chat -->
<div id="box-chat" style="display:none; position:fixed; bottom:110px; right:20px; width:350px; height:450px; background:white; border-radius:10px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); z-index:9999; flex-direction:column; overflow:hidden; font-family: sans-serif;">
    
    <!-- Cabeçalho com foto do agente -->
    <div style="background:#28a745; color:white; padding:12px 15px; display:flex; align-items:center; justify-content:space-between;">
        <div style="display:flex; align-items:center; gap:10px;">
            <img src="{{ asset('images\imagem\agente.png') }}" alt="Agente" style="width:42px; height:42px; border-radius:50%; object-fit:cover; border: 2px solid white;">
            <div>
                <div style="font-weight:bold; font-size:14px;">Suporte Inteligente S.G.A</div>
                <div style="font-size:11px; opacity:0.85;">🟢 Online agora</div>
            </div>
        </div>
        <span onclick="toggleChat()" style="cursor:pointer; font-size:18px;">✕</span>
    </div>

    <div id="chat-content" style="flex:1; padding:15px; overflow-y:auto; background:#f8f9fa; font-size:14px;">
        <div style="margin-bottom:10px; color:#555;">Olá! Sou o assistente do S.G.A. Como posso te ajudar hoje?</div>
    </div>
    <div style="padding:10px; border-top:1px solid #ddd; display:flex;">
        <input type="text" id="chat-input" placeholder="Digite sua dúvida..." style="flex:1; padding:8px; border:1px solid #ddd; border-radius:5px; outline:none;">
        <button onclick="enviarParaIA()" style="margin-left:5px; background:#28a745; color:white; border:none; padding:8px 15px; border-radius:5px; cursor:pointer;">Ir</button>
    </div>
</div>


<script>
    // Data e hora
    function updateDateTime() {
        const now = new Date();

        const dateEl = document.getElementById('date');
        const timeEl = document.getElementById('time');

        if (dateEl) {
            dateEl.innerText = now.toLocaleDateString('pt-BR');
        }

        if (timeEl) {
            timeEl.innerText = now.toLocaleTimeString('pt-BR');
        }
    }

    setInterval(updateDateTime, 1000);
    updateDateTime();

    document.addEventListener('DOMContentLoaded', function () {

        /*
         * MENU MOBILE
         * - No desktop, continua funcionando por hover.
         * - No celular, o clique no grupo abre/fecha o submenu.
         * - Links dentro do submenu navegam naturalmente.
         */
        const dropdownLinks = document.querySelectorAll('nav li.dropdown > a');

        dropdownLinks.forEach(function (link) {
            link.addEventListener('click', function (e) {
                if (window.innerWidth > 768) {
                    return;
                }

                const item = link.closest('li.dropdown');
                const submenu = item ? item.querySelector(':scope > .dropdown-submenu') : null;

                if (!submenu) {
                    return;
                }

                e.preventDefault();
                e.stopPropagation();

                const jaEstavaAberto = item.classList.contains('open');

                document.querySelectorAll('nav li.dropdown.open').forEach(function (aberto) {
                    aberto.classList.remove('open');
                });

                if (!jaEstavaAberto) {
                    item.classList.add('open');
                }
            });
        });

        /*
         * Importante:
         * Não interceptamos os links internos do submenu.
         * Assim o navegador abre normalmente /clientes, /produtos, /compras etc.
         */
        document.querySelectorAll('nav .dropdown-submenu a').forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        });

        /*
         * Fecha submenus quando clicar fora do menu.
         */
        document.addEventListener('click', function (e) {
            if (!e.target.closest('nav')) {
                document.querySelectorAll('nav li.dropdown.open').forEach(function (item) {
                    item.classList.remove('open');
                });
            }
        });

        /*
         * Ao mudar o tamanho da tela, remove submenus abertos.
         */
        window.addEventListener('resize', function () {
            document.querySelectorAll('nav li.dropdown.open').forEach(function (item) {
                item.classList.remove('open');
            });
        });
    });

    function toggleChat() {
        const box = document.getElementById('box-chat');
        if (!box) return;

        box.style.display = box.style.display === 'none' || box.style.display === '' ? 'flex' : 'none';
    }

    async function enviarParaIA() {
        const input = document.getElementById('chat-input');
        const content = document.getElementById('chat-content');

        if (!input || !content) return;

        const msg = input.value.trim();

        if (!msg) return;

        content.innerHTML += `<div style="text-align:right; margin-bottom:10px;"><b>Você:</b> <span style="background:#e2f3ff; padding:5px 10px; border-radius:10px; display:inline-block;">${msg}</span></div>`;
        input.value = '';
        content.scrollTop = content.scrollHeight;

        const loadingId = 'loading-' + Date.now();
        content.innerHTML += `<div id="${loadingId}" style="margin-bottom:10px; color:#888;"><i>SGA está pensando...</i></div>`;

        try {
            const response = await fetch('/chat-suporte', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ mensagem: msg })
            });

            const data = await response.json();

            const loading = document.getElementById(loadingId);
            if (loading) loading.remove();

            content.innerHTML += `<div style="margin-bottom:10px;"><b>SGA:</b> <div style="background:#eee; padding:8px; border-radius:10px;">${data.resposta}</div></div>`;
            content.scrollTop = content.scrollHeight;

        } catch (error) {
            const loading = document.getElementById(loadingId);
            if (loading) {
                loading.innerText = "Erro ao falar com o servidor.";
            }
        }
    }

    const chatInput = document.getElementById('chat-input');

    if (chatInput) {
        chatInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                enviarParaIA();
            }
        });
    }
</script>    





</body>
</html>
