<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Meu Sistema')</title> <!-- Alterável por views específicas -->
    
    <!-- Incluindo estilos globais -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> 
    @yield('styles') <!-- Para incluir os estilos das views específicas -->
</head>
<body>
    <div class="container">
        @yield('content') <!-- Onde o conteúdo principal das views será renderizado -->
    </div>
    
    @yield('scripts') <!-- Para incluir os scripts das views específicas -->
</body>
</html>

