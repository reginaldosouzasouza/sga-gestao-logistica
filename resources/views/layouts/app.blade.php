<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Meu Sistema')</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @yield('styles')

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --accent: #c8a52a;
        }

        .mod-oficina {
            --accent: #4b4b4b;
        }

        .mod-gas {
            --accent: #e8b000;
        }

        .mod-gerencial {
            --accent: #0d6efd;
        }

        .mod-padoca {
            --accent: #8B4513;
        }

        .mod-caixa {
            --accent: #2f7b0b;
        }

        body {
            /*background: linear-gradient(to right, #4b4747d9, #325679);*/
            background: #FFFFF;
            min-height: 100vh;
            padding-top: 78px;
        }

        nav {
            background-color: #333;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 9998;
        }

        nav ul {
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            align-items: stretch;
        }

        nav li {
            display: inline-block;
            position: relative;
        }

        nav li a {
            color: #fcfcfc;
            padding: 20px 30px;
            text-decoration: none;
            font-size: 18px;
            display: inline-block;
            transition: background .2s;
        }

        nav li a:hover {
            background-color: var(--accent);
        }

        nav li.sair a:hover {
            background-color: brown;
        }

        .dropdown-submenu {
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #333;
            box-shadow: 0 2px 8px rgba(0,0,0,.5);
            display: none;
            z-index: 9999;
            min-width: 240px;
        }

        .dropdown-submenu .dropdown-submenu {
            left: 100%;
            top: 0;
        }

        .dropdown:hover > .dropdown-submenu {
            display: block;
        }

        .dropdown-submenu a {
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            padding: 10px 16px;
        }

        .dropdown-submenu a:hover {
            background-color: var(--accent);
        }

        .imagem {
            width: 36px;
            height: 36px;
            margin-left: auto;
        }

        .saida {
            width: 28px;
            height: 28px;
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

        #date,
        #time {
            color: rgb(45,246,72);
            font-size: .95em;
            margin: 0;
        }

        .li-desabilitado {
            pointer-events: none !important;
        }

        .menu-desabilitado {
            opacity: .35;
            filter: grayscale(100%);
            cursor: not-allowed !important;
        }

        .li-desabilitado > .dropdown-submenu {
            display: none !important;
        }

        .menu-link.active + .dropdown-submenu {
            display: block;
        }

        .conteudo-principal {
            padding: 20px;
            min-height: calc(100vh - 78px);
        }

        @keyframes pulsar {
            0% {
                box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
            }

            70% {
                box-shadow: 0 0 0 18px rgba(40, 167, 69, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
            }
        }
    </style>
</head>

<body class="{{ $moduloCor ?? 'mod-gas' }}">

       @include('menu.fixo')

    <main class="conteudo-principal">
        @yield('content')
    </main>

    @yield('scripts')

    <script>
        function updateDateTime() {
            const now = new Date();

            const date = document.getElementById('date');
            const time = document.getElementById('time');

            if (date && time) {
                date.innerText = now.toLocaleDateString('pt-BR');
                time.innerText = now.toLocaleTimeString('pt-BR');
            }
        }

        setInterval(updateDateTime, 1000);
        updateDateTime();

        document.addEventListener('DOMContentLoaded', function () {
            const menuLinks = document.querySelectorAll('.menu-link');

            menuLinks.forEach(function (link) {
                link.addEventListener('click', function (e) {
                    e.preventDefault();

                    menuLinks.forEach(function (item) {
                        if (item !== link) {
                            item.classList.remove('active');
                            const sub = item.nextElementSibling;
                            if (sub) {
                                sub.style.display = 'none';
                            }
                        }
                    });

                    link.classList.toggle('active');

                    const submenu = link.nextElementSibling;

                    if (submenu) {
                        submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
                    }
                });
            });

            document.addEventListener('click', function (e) {
                if (!e.target.closest('nav')) {
                    menuLinks.forEach(function (link) {
                        link.classList.remove('active');

                        const sub = link.nextElementSibling;

                        if (sub) {
                            sub.style.display = 'none';
                        }
                    });
                }
            });
        });

        function toggleChat() {
            const box = document.getElementById('box-chat');

            if (!box) {
                return;
            }

            box.style.display = box.style.display === 'none' ? 'flex' : 'none';
        }

        async function enviarParaIA() {
            const input = document.getElementById('chat-input');
            const content = document.getElementById('chat-content');

            if (!input || !content) {
                return;
            }

            const msg = input.value.trim();

            if (!msg) {
                return;
            }

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
                    body: JSON.stringify({
                        mensagem: msg
                    })
                });

                const data = await response.json();

                const loading = document.getElementById(loadingId);

                if (loading) {
                    loading.remove();
                }

                content.innerHTML += `<div style="margin-bottom:10px;"><b>SGA:</b> <div style="background:#eee; padding:8px; border-radius:10px;">${data.resposta}</div></div>`;
                content.scrollTop = content.scrollHeight;

            } catch (error) {
                const loading = document.getElementById(loadingId);

                if (loading) {
                    loading.innerText = "Erro ao falar com o servidor.";
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const chatInput = document.getElementById('chat-input');

            if (chatInput) {
                chatInput.addEventListener('keypress', function (e) {
                    if (e.key === 'Enter') {
                        enviarParaIA();
                    }
                });
            }
        });
    </script>

</body>
</html>