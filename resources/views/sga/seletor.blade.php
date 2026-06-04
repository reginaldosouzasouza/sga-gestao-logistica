{{-- resources/views/sga/seletor.blade.php --}}
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>SGA – Seletor de Módulos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f5f6fa;
        }

        header {
            background: #2b3035;
            color: #fff;
            padding: 14px 20px;
            font-weight: bold;
            font-size: 18px;
        }

        .header-inner {
            display: grid;
            grid-template-columns: 1fr 1.6fr 1.2fr;
            align-items: center;
            gap: 20px;
        }

        .header-left {
            text-align: left;
            font-size: 18px;
            font-weight: bold;
        }

        .header-center {
            text-align: center;
        }

        .empresa-contexto {
            background: #ffffff;
            color: #1f2937;
            padding: 8px 18px;
            border-radius: 12px;
            text-align: center;
            display: inline-block;
            min-width: 380px;
            box-shadow: 0 4px 12px rgba(0,0,0,.18);
        }

        .empresa-label {
            display: block;
            font-size: 11px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 2px;
        }

        .empresa-contexto strong {
            display: block;
            font-size: 16px;
            color: #111827;
            margin-bottom: 5px;
        }

        .empresa-badge {
            display: inline-block;
            padding: 3px 11px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: bold;
        }

        .badge-teste {
            background: #fff3cd;
            color: #856404;
        }

        .badge-ativo {
            background: #d1e7dd;
            color: #0f5132;
        }

        .badge-bloqueado {
            background: #f8d7da;
            color: #842029;
        }

        .badge-inativo {
            background: #e2e3e5;
            color: #41464b;
        }

        .header-right {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 22px;
        }

        .usuario-contexto {
            text-align: right;
            line-height: 1.25;
            font-size: 14px;
            font-weight: normal;
        }

        .usuario-contexto strong {
            font-weight: bold;
        }

        .usuario-contexto small {
            color: #d1d5db;
            font-weight: bold;
        }

        #date-time {
            display: flex;
            flex-direction: column;
            gap: 2px;
            min-width: 92px;
            text-align: right;
        }

        #date, 
        #time {
            color: rgb(45,246,72);
            font-size: .95em;
            margin: 0;
            font-weight: bold;
        }

        .btn-sair {
            background: brown;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
        }

        .btn-sair:hover {
            background: #8b1f1f;
        }

        /* Grid dos módulos */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 22px;
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 6px 18px rgba(0,0,0,.08);
            text-align: center;
            padding: 26px 10px;
            text-decoration: none;
            color: #222;
            transition: all 0.3s ease;
            cursor: pointer;
            display: block;
        }

        .icon {
            font-size: 58px;
            line-height: 1.2;
            margin-bottom: 10px;
            display: block;
            transition: transform 0.3s ease;
        }

        h4 {
            margin: 10px 0 0;
            font-size: 18px;
            font-weight: 600;
        }

        @keyframes pulse {
            0%   { box-shadow: 0 0 0 0 rgba(0,0,0,.2); }
            70%  { box-shadow: 0 0 20px 10px rgba(0,0,0,.05); }
            100% { box-shadow: 0 0 0 0 rgba(0,0,0,.2); }
        }

        .card:hover .icon {
            transform: scale(1.1) rotate(-3deg);
        }

        .card:hover {
            transform: scale(1.04);
            animation: pulse 1.6s infinite;
        }

        .card.oficina:hover   { background: rgba(28,28,28,.1); }
        .card.gas:hover       { background: rgba(232,176,0,.1); }
        .card.gerencial:hover { background: rgba(13,110,253,.1); }
        .card.padoca:hover    { background: rgba(139,69,19,.1); }
        .card.caixa:hover     { background: rgba(47,123,11,.1); }


    

    .card.bloqueado:hover {
    outline: 2px solid #dc3545;
    box-shadow: 0 6px 18px rgba(220,53,69,.25);
}



        /* RESPONSIVO - CELULAR */
        @media (max-width: 900px) {
            .header-inner {
                grid-template-columns: 1fr;
                gap: 12px;
                text-align: left;
            }

            .header-left,
            .header-center,
            .header-right {
                width: 100%;
                text-align: left;
            }

            .empresa-contexto {
                min-width: auto;
                width: 100%;
                box-sizing: border-box;
                padding: 8px 12px;
            }

            .empresa-contexto strong {
                font-size: 14px;
            }

            .header-right {
                justify-content: space-between;
                gap: 12px;
                flex-wrap: wrap;
            }

            .usuario-contexto {
                text-align: left;
                font-size: 13px;
            }

            #date-time {
                text-align: left;
                min-width: auto;
            }
        }

        @media (max-width: 768px) {
            header {
                padding: 12px 14px;
                font-size: 16px;
            }

            .header-left {
                font-size: 17px;
                line-height: 1.2;
            }

            #date,
            #time {
                font-size: 14px;
            }

            .btn-sair {
                padding: 7px 14px;
                font-size: 14px;
                white-space: nowrap;
            }

            .grid {
                grid-template-columns: 1fr;
                gap: 18px;
                margin: 24px auto;
                padding: 0 16px 24px;
            }

            .card {
                padding: 24px 10px;
                border-radius: 12px;
            }

            .icon {
                font-size: 52px;
            }

            h4 {
                font-size: 17px;
            }
        }

        /* CELULARES BEM ESTREITOS */
        @media (max-width: 420px) {
            .header-left {
                font-size: 16px;
            }

            .empresa-badge {
                font-size: 10px;
                padding: 3px 9px;
            }

            #date-time {
                flex-direction: column;
                gap: 2px;
            }

            .btn-sair {
                padding: 7px 12px;
                font-size: 13px;
            }
        }
    </style>
</head>

<body>

@php
    $usuario = Auth::user();

    $nomeUsuario = $usuario->nome_completo ?? $usuario->usuario ?? 'Usuário';
    $primeiroNome = explode(' ', trim($nomeUsuario))[0];

    $empresa = $usuario?->empresa;

    $nomeEmpresa = $empresa?->nome_fantasia ?? 'Empresa não identificada';
    $statusEmpresa = strtolower($empresa?->status ?? '');

    $ambiente = match ($statusEmpresa) {
        'teste' => 'PILOTO / TESTE',
        'ativo' => 'CLIENTE ATIVO',
        'bloqueado' => 'CLIENTE BLOQUEADO',
        'inativo' => 'CLIENTE INATIVO',
        default => 'AMBIENTE NÃO DEFINIDO',
    };

    $modoAcesso = strtoupper($usuario?->tipo ?? 'USUÁRIO');

    $isMaster = $usuario && strtoupper(trim($usuario->tipo ?? '')) === 'MASTER';


@endphp






<header>
    <div class="header-inner">

        <div class="header-left">
            <span>SGA – Seletor de Módulos</span>
        </div>

        <div class="header-center">
            <div class="empresa-contexto">
                <span class="empresa-label">Empresa Ativa</span>

                <strong>{{ $nomeEmpresa }}</strong>

                <span class="empresa-badge
                    {{ $statusEmpresa === 'teste' ? 'badge-teste' : '' }}
                    {{ $statusEmpresa === 'ativo' ? 'badge-ativo' : '' }}
                    {{ $statusEmpresa === 'bloqueado' ? 'badge-bloqueado' : '' }}
                    {{ $statusEmpresa === 'inativo' ? 'badge-inativo' : '' }}
                ">
                    {{ $ambiente }}
                </span>
            </div>
        </div>

        <div class="header-right">
            <div class="usuario-contexto">
                <strong>Usuário:</strong> {{ $primeiroNome }}
                <br>
                <small>Modo: {{ $modoAcesso }}</small>
            </div>

            <div id="date-time">
                <p id="date"></p>
                <p id="time"></p>
            </div>

            <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" class="btn-sair">Sair</button>
            </form>
        </div>

    </div>
</header>

<main>
    <div class="grid">

        @if($isMaster)
            <a href="{{ url('/menu/oficina') }}" class="card oficina">
                <span class="icon">🧰</span>
                <h4>Oficina</h4>
            </a>
        @else
            <a href="#" class="card oficina bloqueado" onclick="return moduloNaoAutorizado();">
                <span class="icon">🧰</span>
                <h4>Oficina</h4>
            </a>
        @endif

        <a href="{{ url('/menu/gas') }}" class="card gas" target="_blank" rel="noopener noreferrer">
            <span class="icon">🧯</span>
            <h4>Revenda de Gás</h4>
        </a>

        @if($isMaster)
            <a href="{{ url('/menu/gerencial') }}" class="card gerencial">
                <span class="icon">📊</span>
                <h4>Gerencial</h4>
            </a>
        @else
            <a href="#" class="card gerencial bloqueado" onclick="return moduloNaoAutorizado();">
                <span class="icon">📊</span>
                <h4>Gerencial</h4>
            </a>
        @endif

        @if($isMaster)
            <a href="{{ url('/menu/padoca') }}" class="card padoca">
                <span class="icon">🥐</span>
                <h4>Padoca</h4>
            </a>
        @else
            <a href="#" class="card padoca bloqueado" onclick="return moduloNaoAutorizado();">
                <span class="icon">🥐</span>
                <h4>Padoca</h4>
            </a>
        @endif

        @if($isMaster)
            <a href="{{ url('/menu/caixa') }}" class="card caixa">
                <span class="icon">🎰</span>
                <h4>Financeiro</h4>
            </a>
        @else
            <a href="#" class="card caixa bloqueado" onclick="return moduloNaoAutorizado();">
                <span class="icon">🎰</span>
                <h4>Financeiro</h4>
            </a>
        @endif

    </div>
</main>

<script>

    function moduloNaoAutorizado() {
        alert('ACESSO NÃO AUTORIZADO, contate o suporte.');
    }

    function updateDateTime() {
        const now = new Date();

        const dateOptions = {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        };

        const timeOptions = {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };

        const dateElement = document.getElementById('date');
        const timeElement = document.getElementById('time');

        if (dateElement) {
            dateElement.textContent = now.toLocaleDateString('pt-BR', dateOptions);
        }

        if (timeElement) {
            timeElement.textContent = now.toLocaleTimeString('pt-BR', timeOptions);
        }
    }

        
    updateDateTime();
    setInterval(updateDateTime, 1000);
</script>

</body>
</html>