<!DOCTYPE html>
<html>
<head>
    <title>Compras Cadastradas</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/compras.css') }}">
    
</head>
<body>
    <h1>Compras Cadastradas</h1>

    <!-- Campo de Pesquisa -->
    <div class="search-bar">
        <form action="{{ route('compras.search') }}" method="GET">
            <input type="text" name="query" placeholder="Pesquise por Fornecedor ou Produto">
            <button type="submit">Pesquisar</button>
        </form>
    </div>

    <!-- Botão de Cadastrar Compras -->
    <div class="header-button">
        <button onclick="window.location.href='{{ route('compras.create') }}'">Cadastrar Compras</button>
    </div>

    <!-- Tabela de Compras -->
    <table class="table">
        <thead>
            <tr>
                <th>Data Compra</th>
                <th>Fornecedor</th>
                <th>Produto</th>
                <th>Preço Unitário</th>
                <th>Quantidade</th>
                <th>Preço Total</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($compras as $compra)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($compra->data_compra)->format('d/m/Y') }}</td> <!-- Formata a data como dia/mês/ano -->
                    <td>{{ optional($compra->fornecedor)->nome }}</td>
                    <td>{{ optional($compra->produto)->nome }}</td> 
                    <td>{{ number_format($compra->preco_unitario, 2, ',', '.') }}</td> <!-- Formata o preço total com 2 casas decimais e separação correta -->
                    <td>{{ number_format($compra->quantidade, 0, ',', '.') }}</td> <!-- Formata a quantidade como inteiro -->
                    <td>{{ number_format($compra->total, 2, ',', '.') }}</td> <!-- Formata o preço total com 2 casas decimais e separação correta -->
                    <td>
                        <!-- Botões de ações -->
                        <a href="{{ route('compras.edit', $compra->id) }}" class="btn btn-primary">Consultar/Alterar</a>
                        <form action="{{ route('compras.destroy', $compra->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>





