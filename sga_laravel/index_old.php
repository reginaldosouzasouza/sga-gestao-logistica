<?php

// Redireciona tudo para o Laravel corretamente
$path = "core/public/index.php";

if (file_exists($path)) {
    require $path;
} else {
    echo "Laravel não encontrado.";
}

