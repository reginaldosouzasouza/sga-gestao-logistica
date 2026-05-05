<nav>
    <ul>

        {{-- Cadastro --}}
        <li class="dropdown">
            <a href="#">Cadastro <i class="bi bi-caret-down-fill"></i></a>
            <div class="dropdown-submenu">
                @include('menu.partials.itens-fixos.cadastro')
            </div>
        </li>

        {{-- Itens dinâmicos do módulo ativo --}}
        @foreach(($menuExtra ?? []) as $grupo)
            @if(!empty($grupo['filhos']))
                <li class="dropdown">
                    <a href="{{ $grupo['url'] ?? '#' }}">
                        {{ $grupo['label'] ?? 'Menu' }} <i class="bi bi-caret-down-fill"></i>
                    </a>

                    <div class="dropdown-submenu">
                        @foreach($grupo['filhos'] as $filho)
                            <a href="{{ $filho['url'] ?? '#' }}">
                                {{ $filho['label'] ?? 'Item' }}

                                @if(!empty($filho['icone']))
                                    <img src="{{ asset($filho['icone']) }}" class="imagem">
                                @endif
                            </a>
                        @endforeach
                    </div>
                </li>
            @else
                <li>
                    <a href="{{ $grupo['url'] ?? '#' }}">
                        {{ $grupo['label'] ?? 'Menu' }}
                    </a>
                </li>
            @endif
        @endforeach

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

        {{-- Dashboard --}}
        <li class="dropdown">
            <a href="#">Dashboard <i class="bi bi-caret-down-fill"></i></a>
            <div class="dropdown-submenu">
                @include('menu.partials.itens-fixos.dashboard')
            </div>
        </li>

        {{-- Configurações --}}
        <li class="dropdown">
            <a href="#">Configurações <i class="bi bi-caret-down-fill"></i></a>
            <div class="dropdown-submenu">
                @include('menu.partials.itens-fixos.configuracoes')
            </div>
        </li>

        {{-- Sair --}}
        <li class="sair">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>

            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Sair
            </a>
        </li>

        {{-- Barra do módulo com data/hora --}}
        <li class="gestao">
            <div class="box-gestao">
                <div class="titulo-sistema">
                    {{ $moduloNome ?? 'MARIGÁS' }}
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

{{-- Botão do suporte inteligente --}}
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

{{-- Janela do chat --}}
<div id="box-chat" style="display:none; position:fixed; bottom:110px; right:20px; width:350px; height:450px; background:white; border-radius:10px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); z-index:9999; flex-direction:column; overflow:hidden; font-family: sans-serif;">

    <div style="background:#28a745; color:white; padding:12px 15px; display:flex; align-items:center; justify-content:space-between;">
        <div style="display:flex; align-items:center; gap:10px;">
            <img src="{{ asset('images/imagem/agente.png') }}" alt="Agente" style="width:42px; height:42px; border-radius:50%; object-fit:cover; border: 2px solid white;">
            <div>
                <div style="font-weight:bold; font-size:14px;">Suporte Inteligente S.G.A</div>
                <div style="font-size:11px; opacity:0.85;">🟢 Online agora</div>
            </div>
        </div>

        <span onclick="toggleChat()" style="cursor:pointer; font-size:18px;">✕</span>
    </div>

    <div id="chat-content" style="flex:1; padding:15px; overflow-y:auto; background:#f8f9fa; font-size:14px;">
        <div style="margin-bottom:10px; color:#555;">
            Olá! Sou o assistente do S.G.A. Como posso te ajudar hoje?
        </div>
    </div>

    <div style="padding:10px; border-top:1px solid #ddd; display:flex;">
        <input type="text" id="chat-input" placeholder="Digite sua dúvida..." style="flex:1; padding:8px; border:1px solid #ddd; border-radius:5px; outline:none;">
        <button onclick="enviarParaIA()" style="margin-left:5px; background:#28a745; color:white; border:none; padding:8px 15px; border-radius:5px; cursor:pointer;">Ir</button>
    </div>
</div>