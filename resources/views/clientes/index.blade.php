<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLIENTES</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>
    <div class="container">
       
        <input type="text" id="search" placeholder="Digite o nome ou telefone para pesquisar o Cliente" class="form-control">
    </div>

    <div class="total-clientes" style="margin-bottom: 10px;">
        <strong>Total de Clientes: {{ $totalClientes }}</strong>
    </div>


    <div class="container">

    <a href="{{ route('clientes.create') }}" class="btn btn-adicionar">Cadastrar Cliente</a>
        
        <h1 class="title">CLIENTES</h1>

        <table class="table">
            <thead>
                <tr>
               
                    <th>Telefone</th>
                    <th>CPF</th>
                    <th>Nome</th>                  
                    <th>Endereço</th>
                    <th>Número</th>
                    <th>Bairro</th>
                    <th>Cidade</th>
                    <th>Obervação</th> 
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                <tr>
                    
                    <td>{{ $cliente->telefone }}</td>
                    <td>{{ $cliente->cpf }}</td>
                    <td>{{ $cliente->nome }}</td>
                    <td>{{ $cliente->endereco }}</td>
                    <td>{{ $cliente->numero }}</td>
                    <td>{{ $cliente->bairro }}</td>
                    <td>{{ $cliente->cidade }}</td>
                   <td>{{ $cliente->observacao }}</td>
                    <td>
                        <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-editar">Consultar/Alterar</a>
                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-excluir" onclick="return confirm('Tem certeza que deseja excluir este cliente?')">Excluir</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <script>
    document.getElementById('search').addEventListener('input', function() {
        let filter = this.value.toUpperCase();
        let rows = document.querySelectorAll('table tbody tr');

        rows.forEach(row => {
            let name = row.querySelector('td:nth-child(3)').textContent.toUpperCase();
            let phone = row.querySelector('td:nth-child(1)').textContent.toUpperCase();

            if (name.indexOf(filter) > -1 || phone.indexOf(filter) > -1) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

</body>
</html>
 