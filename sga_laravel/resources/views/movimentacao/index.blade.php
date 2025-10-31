<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Coletas</title>
    <link rel="stylesheet" href="{{ asset('css/movimentacao.css') }}">
    
</head>
<body>

    <!-- Centralizando o campo de busca -->
    <div class="search-container">
        <input type="text" id="search" placeholder="Digite o nome ou endereço para pesquisar" class="form-control">
    </div>

    <div class="container">
        <a href="{{ route('movimentacao.create') }}" class="btn-cadastrar">Cadastrar Movimentação</a>

        <h1 class="title">MOVIMENTAÇÕES</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>Data Coleta</th>
                    <th>Controle de Coleta</th>
                    <th>Nome</th>
                    <th>quantidade</th>
                    <th>valor_total</th>
                    <th>Forma de Pagamento</th>
                    <th>prazo em Dias</th>
                  

                <!--    <th>CPF</th>
                    <th>Nome</th>
                    <th>Endereço</th>
                    <th>Número</th>
                    <th>Bairro</th>-->
                    <th>Cidade</th>
                <!--    <th>Observação</th>  -->
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($movimentacoes as $movimentacao)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($movimentacao->data_coleta)->format('d/m/Y') }}</td>
                    <td>{{ $movimentacao->id }}</td>
                 <!--  <td>{{ $movimentacao->cpf }}</td>-->
                    <td>{{ $movimentacao->nome }}</td>
                    <td>{{ $movimentacao->quantidade }}</td>
                    <td>R$ {{ number_format($movimentacao->valor_total, 2, ',', '.') }}</td>
                    <td>{{ $movimentacao->formaPagamento->nome ?? 'sem forma de pagamento'}}</td>
                    <td>{{ $movimentacao->prazo_id }}</td>
                    <td>{{ $movimentacao->cidade }}</td>
                <!--    <td>{{ $movimentacao->endereco }}</td>
                    <td>{{ $movimentacao->numero }}</td>
                    <td>{{ $movimentacao->bairro }}</td>
                    <td>{{ $movimentacao->cidade }}</td>
                    <td>{{ $movimentacao->observacao }}</td>  -->
                    <td>
                        <a href="{{ route('movimentacao.show', $movimentacao->id) }}" class="btn btn-consultar">Consultar/Alterar</a>
                        <form action="{{ route('movimentacao.destroy', $movimentacao->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-excluir" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
       

       <div class="pagination-wrapper">
            <p>Mostrando {{ $movimentacoes->firstItem() }} a {{ $movimentacoes->lastItem() }} 
                de {{ $movimentacoes->total() }} resultados</p>
            {{ $movimentacoes->onEachSide(1)->links('vendor.pagination.custom') }}
        </div>


    </div>

    <script>
        document.getElementById('search').addEventListener('input', function() {
            let filter = this.value.toUpperCase();
            let rows = document.querySelectorAll('table tbody tr');

            rows.forEach(row => {
                let nome = row.querySelector('td:nth-child(4)').textContent.toUpperCase();
                let endereco = row.querySelector('td:nth-child(5)').textContent.toUpperCase();

                if (nome.indexOf(filter) > -1 || endereco.indexOf(filter) > -1) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>

</body>
</html>
