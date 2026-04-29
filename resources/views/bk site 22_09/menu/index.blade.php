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

        /* ── Layout ─────────────────────────────────────────────────── */
        body {
            background: linear-gradient(to right, #4b4747d9, #325679);
            font-family: Arial, sans-serif;
            min-height: 100vh;
        }

        /* ── Navbar ─────────────────────────────────────────────────── */
        nav { background-color: #333; position: relative; }
        nav ul { list-style: none; display: flex; flex-wrap: wrap; align-items: stretch; }
        nav li { display: inline-block; position: relative; }

        nav li a {
            color: #fcfcfc;
            padding: 20px 30px;
            text-decoration: none;
            font-size: 18px;
            display: inline-block;
            transition: background .2s;
        }
        nav li a:hover           { background-color: var(--accent); }
        nav li.sair a:hover      { background-color: brown; }

        /* ── Dropdowns ───────────────────────────────────────────────── */
        .dropdown-submenu {
            position: absolute; top: 100%; left: 0;
            background-color: #333;
            box-shadow: 0 2px 8px rgba(0,0,0,.5);
            display: none; z-index: 200; min-width: 240px;
        }
        /* submenus aninhados abrem para direita */
        .dropdown-submenu .dropdown-submenu { left: 100%; top: 0; }
        .dropdown:hover > .dropdown-submenu { display: block; }
        .dropdown-submenu a {
            display: flex; align-items: center; gap: 8px;
            white-space: nowrap; padding: 10px 16px;
        }
        .dropdown-submenu a:hover { background-color: var(--accent); }

        /* ── Ícones ─────────────────────────────────────────────────── */
        .imagem { width: 36px; height: 36px; margin-left: auto; }
        .saida  { width: 28px; height: 28px; }

        /* ── Barra de título (SGA) ──────────────────────────────────── */
      .gestao {
    display: inline-flex;
    margin-left: auto;
        }

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

        /* ── Item desabilitado ──────────────────────────────────────── */
        .li-desabilitado         { pointer-events: none !important; }
        .menu-desabilitado       { opacity: .35; filter: grayscale(100%); cursor: not-allowed !important; }
        .li-desabilitado > .dropdown-submenu { display: none !important; }

        /* ── Submenu via clique (Relatórios) ────────────────────────── */
        .menu-link.active + .dropdown-submenu { display: block; }
    </style>
</head>

{{-- classe do módulo aplicada ao body ↓ --}}
<body class="{{ $moduloCor }}">

<nav>
    <ul>

        {{-- ════════════════════════════════════════════════════
             BLOCO 1 — ITENS FIXOS (iguais em todos os módulos)
             ════════════════════════════════════════════════════ --}}

        {{-- Cadastro --}}
        <li class="dropdown">
            <a href="#">Cadastro <i class="bi bi-caret-down-fill"></i></a>
            <div class="dropdown-submenu">
                @include('menu.partials.itens-fixos.cadastro')
            </div>
        </li>

        {{-- ════════════════════════════════════════════════════
             BLOCO 2 — ITENS DINÂMICOS DO MÓDULO ATIVO
             Vem de config/modulos.php via $menuExtra
             ════════════════════════════════════════════════════ --}}

        @foreach($menuExtra as $grupo)
            @if(!empty($grupo['filhos']))
                {{-- Grupo com dropdown --}}
                <li class="dropdown">
                    <a href="{{ $grupo['url'] }}">
                        {{ $grupo['label'] }} <i class="bi bi-caret-down-fill"></i>
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
                    <a href="{{ $grupo['url'] }}" target="_blank">{{ $grupo['label'] }}</a>
                </li>
            @endif
        @endforeach

        {{-- ════════════════════════════════════════════════════
             BLOCO 3 — ITENS FIXOS DO FIM (Financeiro, Relatórios, Sair)
             ════════════════════════════════════════════════════ --}}

        {{-- Financeiro --}}
        <li class="dropdown">
            <a href="#">Financeiro <i class="bi bi-caret-down-fill"></i></a>
            <div class="dropdown-submenu">
                @include('menu.partials.itens-fixos.financeiro')
            </div>
        </li>

        {{-- Relatórios --}}
        <li class="dropdown">
            <a href="#">Relatórios <i class="bi bi-caret-down-fill"></i></a>
            <div class="dropdown-submenu">
                @include('menu.partials.itens-fixos.relatorios')
            </div>
        </li>

        {{-- Sair --}}
        <li class="sair">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
            <a href="#" onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                Sair
            </a>
        </li>

        {{-- Barra do módulo com data/hora --}}
       
           <li class="gestao">
                <div class="box-gestao">
                    <div class="titulo-sistema">SGA – {{ $moduloNome }}</div>
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




<div id="btn-chat" onclick="toggleChat()" style="position:fixed; bottom:20px; right:20px; background:#28a745; color:white; width:60px; height:60px; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; box-shadow: 0 4px 8px rgba(0,0,0,0.2); z-index:9999;">
    <i class="fa fa-comments" style="font-size:24px;"></i> 
</div>

<div id="box-chat" style="display:none; position:fixed; bottom:90px; right:20px; width:350px; height:450px; background:white; border-radius:10px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); z-index:9999; flex-direction:column; overflow:hidden; font-family: sans-serif;">
    <div style="background:#28a745; color:white; padding:15px; font-weight:bold; display:flex; justify-content:space-between;">
        <span>Suporte Inteligente S.G.A</span>
        <span onclick="toggleChat()" style="cursor:pointer;">X</span>
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
        document.getElementById('date').innerText = now.toLocaleDateString('pt-BR');
        document.getElementById('time').innerText = now.toLocaleTimeString('pt-BR');
    }
    setInterval(updateDateTime, 1000);
    updateDateTime();

    // Submenus de Relatórios acionados por clique
    document.addEventListener('DOMContentLoaded', function () {
        const menuLinks = document.querySelectorAll('.menu-link');

        menuLinks.forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();

                menuLinks.forEach(function (item) {
                    if (item !== link) {
                        item.classList.remove('active');
                        const sub = item.nextElementSibling;
                        if (sub) sub.style.display = 'none';
                    }
                });

                link.classList.toggle('active');
                const submenu = link.nextElementSibling;
                if (submenu)
                    submenu.style.display = (submenu.style.display === 'block') ? 'none' : 'block';
            });
        });

        // Fecha ao clicar fora
        document.addEventListener('click', function (e) {
            if (!e.target.closest('nav')) {
                menuLinks.forEach(function (link) {
                    link.classList.remove('active');
                    const sub = link.nextElementSibling;
                    if (sub) sub.style.display = 'none';
                });
            }
        });
    });




function toggleChat() {
    const box = document.getElementById('box-chat');
    box.style.display = box.style.display === 'none' ? 'flex' : 'none';
}

async function enviarParaIA() {
    const input = document.getElementById('chat-input');
    const content = document.getElementById('chat-content');
    const msg = input.value.trim();

    if (!msg) return;

    // Exibe a mensagem do usuário na tela
    content.innerHTML += `<div style="text-align:right; margin-bottom:10px;"><b>Você:</b> <span style="background:#e2f3ff; padding:5px 10px; border-radius:10px; display:inline-block;">${msg}</span></div>`;
    input.value = '';
    content.scrollTop = content.scrollHeight;

    // Efeito de "Digitando..."
    const loadingId = 'loading-' + Date.now();
    content.innerHTML += `<div id="${loadingId}" style="margin-bottom:10px; color:#888;"><i>SGA está pensando...</i></div>`;

    try {
        const response = await fetch('/chat-suporte', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Obrigatório no Laravel
            },
            body: JSON.stringify({ mensagem: msg })
        });

        const data = await response.json();
        document.getElementById(loadingId).remove();

        // Exibe a resposta da IA
        content.innerHTML += `<div style="margin-bottom:10px;"><b>SGA:</b> <div style="background:#eee; padding:8px; border-radius:10px;">${data.resposta}</div></div>`;
        content.scrollTop = content.scrollHeight;

    } catch (error) {
        document.getElementById(loadingId).innerText = "Erro ao falar com o servidor.";
    }
}

// Enviar ao apertar "Enter"
document.getElementById('chat-input').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') enviarParaIA();
});
</script>    





</body>
</html>
