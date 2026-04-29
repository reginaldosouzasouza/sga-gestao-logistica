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
      box-shadow: 0 6px 18px rgba(0, 0, 0, .08);
      text-align: center;
      padding: 26px 10px;
      text-decoration: none;
      color: #222;
      transition: all 0.3s ease;
      position: relative;
      cursor: pointer;
    }

    .icon {
      font-size: 58px;
      line-height: 1.2;
      margin-bottom: 10px;
      transition: transform 0.3s ease;
    }

    h4 {
      margin: 10px 0 0 0;
      font-size: 18px;
      font-weight: 600;
    }

    /* ====== Animação de pulsar ====== */
    @keyframes pulse {
      0%   { box-shadow: 0 0 0 0 rgba(0,0,0,0.2); }
      70%  { box-shadow: 0 0 20px 10px rgba(0,0,0,0.05); }
      100% { box-shadow: 0 0 0 0 rgba(0,0,0,0.2); }
    }

    /* ====== Cores de hover por módulo ====== */
    .card.oficina:hover {
      background: rgba(28, 28, 28, 0.1);
      animation: pulse 1.6s infinite;
      transform: scale(1.04);
    }

    .card.gas:hover {
      background: rgba(232, 176, 0, 0.1);
      animation: pulse 1.6s infinite;
      transform: scale(1.04);
    }

    .card.gerencial:hover {
      background: rgba(13, 110, 253, 0.1);
      animation: pulse 1.6s infinite;
      transform: scale(1.04);
    }

    .card.padoca:hover {
      background: rgba(139, 69, 19, 0.1);
      animation: pulse 1.6s infinite;
      transform: scale(1.04);
    }

    .card.caixa:hover {
      background: rgba(47, 123, 11, 0.1);
      animation: pulse 1.6s infinite;
      transform: scale(1.04);
    }

    /* Ícone gira levemente ao hover */
    .card:hover .icon {
      transform: scale(1.1) rotate(-3deg);
    }

    /* Remove o símbolo > das âncoras */
    .card::before {
      content: "";
    }

/* Cabeçalho (título SGA) */
        .gestao{ display:inline-block; vertical-align:middle;text-align:center;}
        .gestao h1 {
            background-color:var(--accent);  /* cor do módulo */
            font-family:Arial, sans-serif;
            display:flex; 
           /* align-items:center;*/
             gap:15px;
            margin:0; padding:10px 20px;
            color:#808080; 
            font-size:20px; height:100%;
           
        }

        

        /* Data e hora */
        #date-time{ display:flex; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.1); gap:20px; justify-content:center; }
        #date, #time{ color:rgb(45,246,72); font-size:1em; margin:0; }

  </style>
</head>

<body>
  <header>SGA – Seletor de Módulos</header>


  <div class="gestao">
    <h1>
      SGA - Sistema de Gestão Aplicada
    
      <div id="date-time">
        <p id="date"></p>
        <p id="time"></p>
      </div>
    </h1>
  </div>

  <div class="grid">

    <a class="card oficina" href="{{ route('menu.index', 'oficina') }}" target="_blank" rel="noopener">
      <div class="icon">🧰</div>
      <h4>Oficina</h4>
    </a>

    <a class="card gas" href="{{ route('menu.index', 'gas') }}" target="_blank" rel="noopener">
      <div class="icon">🧯</div>
      <h4>Revenda de Gás</h4>
    </a>

    <a class="card gerencial" href="{{ route('menu.index', 'gerencial') }}" target="_blank" rel="noopener">
      <div class="icon">📊</div>
      <h4>Gerencial</h4>
    </a>

    <a class="card padoca" href="{{ route('menu.index', 'padoca') }}" target="_blank" rel="noopener">
      <div class="icon">🥐</div>
      <h4>Padoca</h4>
    </a>

    <a class="card caixa" href="{{ route('menu.index', 'caixa') }}" target="_blank" rel="noopener">
      <div class="icon">🎰</div>
      <h4>Financeiro</h4>
    </a>

  </div>

     

    <script>
        // Data e hora
        function updateDateTime(){
            const now = new Date();
            document.getElementById("date").innerText = now.toLocaleDateString();
            document.getElementById("time").innerText = now.toLocaleTimeString();
        }
        setInterval(updateDateTime, 1000);
        updateDateTime();

        // Submenus por clique
        document.addEventListener('DOMContentLoaded', function(){
            const submenuLinks = document.querySelectorAll('.menu-link');

            submenuLinks.forEach(function(link){
                link.addEventListener('click', function(e){
                    e.preventDefault();

                    submenuLinks.forEach(function(item){
                        if(item !== link){
                            item.classList.remove('active');
                            if(item.nextElementSibling) item.nextElementSibling.style.display = 'none';
                        }
                    });

                    link.classList.toggle('active');
                    const submenu = link.nextElementSibling;
                    if(submenu){
                        submenu.style.display = (submenu.style.display === 'block') ? 'none' : 'block';
                    }
                });
            });

            document.addEventListener('click', function(e){
                if(!e.target.closest('nav')){
                    submenuLinks.forEach(function(link){
                        link.classList.remove('active');
                        if(link.nextElementSibling) link.nextElementSibling.style.display = 'none';
                    });
                }
            });
        });
    </script>

</body>
</html>

