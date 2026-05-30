<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGA - Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="outer-container"> 
        <h1 class="system-title">
            Sistema de Gestão Aplicada - <span class="highlight">SGA</span>
        </h1>
        <div class="login-box">
            <div class="login-form">
                <h2>Bem-vindo ao Sistema</h2>
                <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label>Cód. Usuário:</label>
                    <input type="text" id="codigo_usuario" name="codigo_usuario" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Usuário:</label>
                    <input type="text" id="usuario" name="usuario" class="form-control" readonly>
                </div>

                <div class="mb-3">
                    <label>Senha:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Entrar</button>    
                
                </form>
            </div>
            <p class="developer">
                SISTEMA DESENVOLVIDO POR: <p><span class="dev-highlight">REGINALDO SOUZA</span></p>
                <span class='contato'>(44) 9 9999-5767</span>
                
            </p>
        </div>
    </div>

  <script>
        document.addEventListener("DOMContentLoaded", function () {
            const codigoInput = document.getElementById("codigo_usuario");
            const usuarioInput = document.getElementById("usuario");

            if (!codigoInput || !usuarioInput) {
                return;
            }

            codigoInput.addEventListener("input", function () {
                let userId = this.value.trim();

                if (!userId) {
                    usuarioInput.value = "";
                    return;
                }

                fetch(`/buscar-usuario/${userId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("Erro HTTP: " + response.status);
                        }

                        return response.json();
                    })
                    .then(data => {
                        usuarioInput.value = data.usuario || "";
                    })
                    .catch(error => {
                        console.log("Erro ao buscar usuário:", error);
                        usuarioInput.value = "";
                    });
            });
        });
</script>

 
</body>
</html>

