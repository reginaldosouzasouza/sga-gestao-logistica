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

        /* ─────────────────────────────────────────────────────────────
           RESPONSIVO - VISUAL MOBILE EM CARDS
           ───────────────────────────────────────────────────────────── */
        @media (max-width: 768px) {
            body {
                background: #fff;
                overflow-x: hidden;
            }

            nav {
                background: linear-gradient(135deg, #171717, #2e2e2e) !important;
                padding: 16px 14px 0 !important;
                width: 100% !important;
                box-shadow: 0 8px 20px rgba(0,0,0,.18);
            }

            .mobile-menu-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                color: #fff;
                margin-bottom: 16px;
                padding: 4px 2px;
            }

            .mobile-brand {
                display: flex;
                align-items: center;
                gap: 8px;
                font-weight: 800;
                letter-spacing: .3px;
                font-size: 16px;
                text-transform: uppercase;
            }

            .mobile-brand i {
                color: var(--accent);
                font-size: 28px;
                line-height: 1;
            }

            .mobile-brand .brand-accent {
                color: var(--accent);
            }

            .mobile-hamburger {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 38px;
                height: 38px;
                border-radius: 10px;
                color: #fff;
                font-size: 28px;
            }

            nav ul {
                display: grid !important;
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 10px !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                list-style: none !important;
                align-items: stretch !important;
            }

            nav li {
                display: block !important;
                width: 100% !important;
                min-width: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
                position: relative !important;
            }

            nav li > a {
                width: 100% !important;
                min-height: 112px !important;
                padding: 16px 12px !important;
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 10px !important;
                text-align: center !important;
                color: #fff !important;
                font-size: 16px !important;
                line-height: 1.15 !important;
                text-decoration: none !important;
                background: linear-gradient(145deg, #262626, #363636) !important;
                border: 1px solid rgba(255,255,255,.08) !important;
                border-radius: 10px !important;
                box-shadow: inset 0 1px 0 rgba(255,255,255,.05), 0 6px 14px rgba(0,0,0,.20) !important;
                white-space: normal !important;
                overflow: hidden !important;
            }

            nav li > a:hover,
            nav li.dropdown.open > a {
                background: linear-gradient(145deg, #303030, #424242) !important;
                border-color: rgba(232,176,0,.45) !important;
            }

            nav li > a > .bi-caret-down-fill {
                display: none !important;
            }

            .mobile-icon {
                display: block !important;
                color: var(--accent) !important;
                font-size: 34px !important;
                line-height: 1 !important;
                margin-bottom: 2px !important;
            }

            .mobile-arrow {
                display: inline-flex !important;
                position: absolute !important;
                right: 12px !important;
                top: 50% !important;
                transform: translateY(-50%) !important;
                color: #fff !important;
                opacity: .9 !important;
                font-size: 20px !important;
            }

            .menu-text {
                display: block !important;
                font-weight: 500 !important;
            }

            nav li.sair {
                grid-column: 1 / -1 !important;
            }

            nav li.sair > a {
                min-height: 58px !important;
                flex-direction: row !important;
                justify-content: center !important;
                gap: 12px !important;
                font-size: 17px !important;
            }

            nav li.sair .mobile-icon {
                font-size: 28px !important;
                margin: 0 !important;
            }

            /* Submenus no mobile abrem abaixo do card */
            .dropdown-submenu {
                position: static !important;
                display: none !important;
                grid-column: 1 / -1 !important;
                min-width: 100% !important;
                width: 100% !important;
                margin-top: 6px !important;
                padding: 6px !important;
                background: #202020 !important;
                border: 1px solid rgba(255,255,255,.08) !important;
                border-radius: 10px !important;
                box-shadow: none !important;
            }

            .dropdown.open > .dropdown-submenu {
                display: block !important;
            }

            .dropdown-submenu a {
                min-height: auto !important;
                width: 100% !important;
                display: flex !important;
                flex-direction: row !important;
                align-items: center !important;
                justify-content: space-between !important;
                padding: 12px 14px !important;
                margin: 3px 0 !important;
                border-radius: 8px !important;
                background: #2b2b2b !important;
                border: 0 !important;
                box-shadow: none !important;
                color: #fff !important;
                font-size: 14px !important;
                white-space: normal !important;
                text-align: left !important;
            }

            /* Bloco amarelo ocupa a largura inteira */
            .gestao {
                grid-column: 1 / -1 !important;
                display: block !important;
                width: calc(100% + 28px) !important;
                min-width: calc(100% + 28px) !important;
                max-width: calc(100% + 28px) !important;
                margin: 12px -14px 0 -14px !important;
                padding: 0 !important;
            }

            .box-gestao {
                width: 100% !important;
                min-width: 0 !important;
                max-width: 100% !important;
                background: linear-gradient(135deg, #e8b000, #f3c400) !important;
                color: #111 !important;
                padding: 16px 12px 18px !important;
                margin: 0 !important;
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                justify-content: center !important;
                text-align: center !important;
                border-radius: 8px 8px 0 0 !important;
                box-shadow: inset 0 1px 0 rgba(255,255,255,.25) !important;
            }

            .titulo-sistema {
                width: 100% !important;
                color: #fff !important;
                font-size: 26px !important;
                font-weight: 900 !important;
                letter-spacing: .7px !important;
                text-align: center !important;
                line-height: 1.1 !important;
            }

            .usuario-logado {
                width: 100% !important;
                color: #111 !important;
                font-size: 15px !important;
                font-weight: 800 !important;
                margin-top: 8px !important;
                text-align: center !important;
            }

            #date-time {
                width: 100% !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 10px !important;
                flex-wrap: wrap !important;
                margin-top: 8px !important;
                text-align: center !important;
            }

            #date,
            #time {
                color: rgb(0, 180, 50) !important;
                font-size: 15px !important;
                font-weight: 700 !important;
                line-height: 1.1 !important;
            }

            #conteudo {
                padding: 16px !important;
                color: #222 !important;
                min-height: 55vh !important;
                background: #fff !important;
            }

            /* Suporte inteligente no celular */
            #btn-chat-wrapper {
                right: 14px !important;
                bottom: 14px !important;
                z-index: 9999 !important;
            }

            #btn-chat {
                width: 62px !important;
                height: 62px !important;
                border-width: 3px !important;
            }

            #tooltip-chat {
                display: none !important;
            }

            #box-chat {
                width: calc(100vw - 28px) !important;
                max-width: 380px !important;
                height: 62vh !important;
                max-height: 470px !important;
                right: 14px !important;
                left: auto !important;
                bottom: 88px !important;
                border-radius: 12px !important;
            }
        }

        @media (max-width: 420px) {
            nav {
                padding: 14px 10px 0 !important;
            }

            .mobile-brand {
                font-size: 14px;
            }

            nav ul {
                gap: 8px !important;
            }

            nav li > a {
                min-height: 102px !important;
                padding: 14px 8px !important;
                font-size: 15px !important;
            }

            .mobile-icon {
                font-size: 31px !important;
            }

            .gestao {
                width: calc(100% + 20px) !important;
                min-width: calc(100% + 20px) !important;
                max-width: calc(100% + 20px) !important;
                margin-left: -10px !important;
                margin-right: -10px !important;
            }

            .titulo-sistema {
                font-size: 23px !important;
            }

            .usuario-logado,
            #date,
            #time {
                font-size: 14px !important;
            }
        }


        /* =====================================================
           CORREÇÃO CLIQUE SUBMENU MOBILE
           ===================================================== */
        @media (max-width: 768px) {
            nav .dropdown-submenu,
            nav .dropdown-submenu * {
                pointer-events: auto !important;
            }

            nav .dropdown-submenu a {
                position: relative !important;
                z-index: 10050 !important;
                cursor: pointer !important;
                touch-action: manipulation !important;
                -webkit-tap-highlight-color: rgba(232,176,0,.25) !important;
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

        if (dateEl) dateEl.innerText = now.toLocaleDateString('pt-BR');
        if (timeEl) timeEl.innerText = now.toLocaleTimeString('pt-BR');
    }

    setInterval(updateDateTime, 1000);
    updateDateTime();

    document.addEventListener('DOMContentLoaded', function () {
        const isMobile = () => window.innerWidth <= 768;

        /**
         * Links dos submenus no celular.
         * Esta captura vem antes do clique do grupo, para garantir que
         * Clientes, Fornecedores, Produtos etc. naveguem normalmente.
         */
        function navegarLinkSubmenu(e) {
            const link = e.target.closest('nav .dropdown-submenu a');

            if (!link || !isMobile()) return;

            const href = link.getAttribute('href');

            if (!href || href === '#') return;

            e.preventDefault();
            e.stopPropagation();

            // Pequeno atraso evita conflito com touch/click do navegador mobile.
            setTimeout(function () {
                if (link.getAttribute('target') === '_blank') {
                    window.open(href, '_blank');
                } else {
                    window.location.assign(href);
                }
            }, 30);
        }

        document.addEventListener('click', navegarLinkSubmenu, true);
        document.addEventListener('touchend', navegarLinkSubmenu, true);

        /**
         * Clique nos grupos principais: Cadastro, Financeiro, Relatórios etc.
         * No celular abre/fecha o submenu. No desktop mantém o hover normal.
         */
        document.querySelectorAll('nav li.dropdown > a').forEach(function (link) {
            link.addEventListener('click', function (e) {
                if (!isMobile()) return;

                const item = link.closest('li.dropdown');
                const submenu = item ? item.querySelector('.dropdown-submenu') : null;

                if (!submenu) return;

                e.preventDefault();
                e.stopPropagation();

                document.querySelectorAll('nav li.dropdown.open').forEach(function (aberto) {
                    if (aberto !== item) aberto.classList.remove('open');
                });

                item.classList.toggle('open');
            });
        });

        // Fecha submenu ao clicar fora do menu no celular.
        document.addEventListener('click', function (e) {
            if (!isMobile()) return;
            if (!e.target.closest('nav')) {
                document.querySelectorAll('nav li.dropdown.open').forEach(function (item) {
                    item.classList.remove('open');
                });
            }
        });

        const chatInput = document.getElementById('chat-input');
        if (chatInput) {
            chatInput.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') enviarParaIA();
            });
        }
    });

    function toggleChat() {
        const box = document.getElementById('box-chat');
        if (!box) return;
        box.style.display = (box.style.display === 'none' || box.style.display === '') ? 'flex' : 'none';
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
            if (loading) loading.innerText = "Erro ao falar com o servidor.";
        }
    }
</script>
</body>
</html>
