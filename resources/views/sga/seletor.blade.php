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
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-left {
            width: 35%;
            text-align: left;
        }

        .header-center {
            width: 30%;
            text-align: center;
            color: #ffffff;
            font-size: 18px;
            font-weight: bold;
        }

        .header-right {
            width: 35%;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 30px;
        }

        #date-time {
            display: flex;
            gap: 16px;
        }

        #date, #time {
            color: rgb(45,246,72);
            font-size: .95em;
            margin: 0;
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
    </style>
</head>
<body>

@php
    $nomeUsuario = Auth::user()->nome_completo ?? Auth::user()->usuario ?? 'Usuário';
    $primeiroNome = explode(' ', trim($nomeUsuario))[0];
@endphp

<header>
    <div class="header-inner">
        <div class="header-left">
            <span>SGA – Seletor de Módulos</span>
        </div>

        <div class="header-center">
            Bem-vindo, {{ $primeiroNome }}
        </div>

        <div class="header-right">
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

<div class="grid">
    <a class="card oficina" href="{{ route('menu.index', 'oficina') }}" target="_blank">
        <span class="icon">🧰</span>
        <h4>Oficina</h4>
    </a>

    <a class="card gas" href="{{ route('menu.index', 'gas') }}" target="_blank">
        <span class="icon">🧯</span>
        <h4>Revenda de Gás</h4>
    </a>

    <a class="card gerencial" href="{{ route('menu.index', 'gerencial') }}" target="_blank">
        <span class="icon">📊</span>
        <h4>Gerencial</h4>
    </a>

    <a class="card padoca" href="{{ route('menu.index', 'padoca') }}" target="_blank">
        <span class="icon">🥐</span>
        <h4>Padoca</h4>
    </a>

    <a class="card caixa" href="{{ route('menu.index', 'caixa') }}" target="_blank">
        <span class="icon">🎰</span>
        <h4>Financeiro</h4>
    </a>
</div>

<script>
    function updateDateTime() {
        const now = new Date();
        document.getElementById('date').innerText = now.toLocaleDateString('pt-BR');
        document.getElementById('time').innerText = now.toLocaleTimeString('pt-BR');
    }

    setInterval(updateDateTime, 1000);
    updateDateTime();
</script>

</body>
</html>