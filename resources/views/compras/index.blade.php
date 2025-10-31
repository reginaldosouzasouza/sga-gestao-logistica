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
            <input type="text" name="query" placeholder="Pesquise por Fornecedor">
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
                <th>Nota Fiscal</th>
                <th>Preço Total</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($compras as $compra)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($compra->data_compra)->format('d/m/Y') }}</td> <!-- Formata a data como dia/mês/ano -->
                    <td>{{ optional($compra->fornecedor)->nome }}</td>
                    <td>{{ $compra->nota_fiscal }}</td>
                    <td>{{ number_format($compra->total, 2, ',', '.') }}</td> <!-- Usa o campo total da compra -->
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






