<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca de Clientes</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Busca de Clientes</h1>

    <!-- Campo de busca -->
    <input type="text" id="buscaCliente" placeholder="Digite o nome ou telefone do cliente">

    <!-- Div para exibir os resultados da busca -->
    <div id="opcoesCliente"></div>

    <!-- Script JS para buscar os clientes -->
    <script>
        $('#buscaCliente').on('input', function(event) {
            event.preventDefault(); // Previne o envio do formulário

            var query = $(this).val(); // Pega o valor digitado

            if (query === '') {
                $('#opcoesCliente').html(''); // Limpa os resultados se o campo estiver vazio
                return;
            }

            // Faz a requisição AJAX
            $.ajax({
                url: '/pedidos-de-coleta/search', // Ajuste conforme a rota correta no seu Laravel
                type: 'GET',
                data: { query: query }, // Envia o valor digitado
                success: function(response) {
                    // Se encontrar clientes
                    if (response.status === 'found') {
                        var clientes = response.clientes;
                        var listaClientes = '<ul>';
                        
                        clientes.forEach(function(cliente) {
                            listaClientes += '<li>' + cliente.nome + ' - ' + cliente.telefone + '</li>';
                        });
                        
                        listaClientes += '</ul>';
                        $('#opcoesCliente').html(listaClientes); // Mostra a lista de clientes
                    } else {
                        $('#opcoesCliente').html('<p>Cliente não encontrado.</p>'); // Mensagem de não encontrado
                    }
                },
                error: function() {
                    $('#opcoesCliente').html('<p>Erro ao buscar clientes. Tente novamente.</p>'); // Mensagem de erro
                }
            });
        });
    </script>
</body>
</html>
