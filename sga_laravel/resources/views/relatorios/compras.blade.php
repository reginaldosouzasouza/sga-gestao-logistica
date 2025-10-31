<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Compras</title>
    <link rel="stylesheet" href="{{ asset('css/relatorio-compras.css') }}">
</head>
<body>
    <div class="container">
        <h1>Relatório de Compras</h1>

        <!-- Filtro de busca -->

        <form action="{{ route('relatorio.compras') }}" method="GET">
            <label>Código:</label>
            <input type="text" name="id" placeholder="Código da Compra" value="{{ request('id') }}">

        <form action="{{ route('relatorio.compras') }}" method="GET">
            <label>Produto:</label>
            <input type="text" name="produto" placeholder="Nome do Produto" value="{{ request('produto') }}">

            <label>Fornecedor:</label>
            <input type="text" name="fornecedor" placeholder="Nome do Fornecedor" value="{{ request('fornecedor') }}">

            <label>Data Inicial:</label>
            <input type="date" name="data_inicial" value="{{ request('data_inicial') }}">

            <label>Data Final:</label>
            <input type="date" name="data_final" value="{{ request('data_final') }}">

            <button type="submit">Filtrar</button>
            <a href="{{ route('relatorio.compras') }}" class="limpar-filtros">Limpar Filtros</a>
        </form>

        <!-- Tabela de Relatório -->
        <table>
            <thead>
                <tr>
                    <th>Cód. Compra</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Valor Unitário</th>
                    <th>Valor Total</th>
                    <th>Nota Fiscal</th>
                    <th>Fornecedor</th>
                    <th>Data da Compra</th>
                </tr>
            </thead>
            <tbody>
                @foreach($compras as $compra)
                    <tr>
                        <td>{{ $compra->compra_id }}</td>
                        <td>{{ $compra->produto }}</td>
                        <td>{{ $compra->quantidade }}</td>
                        <td>R$ {{ number_format($compra->valor_unitario, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($compra->valor_total, 2, ',', '.') }}</td>
                        <td>{{ $compra->nota_fiscal }}</td>
                        <td>{{ $compra->fornecedor }}</td>
                        <td>{{ \Carbon\Carbon::parse($compra->data_compra)->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

            <!-- Exibir o Total de Compras -->
                <h3 style="text-align: right; margin-top: 20px;">
                    Total de Compras: <strong>R$ {{ number_format($totalCompras, 2, ',', '.') }}</strong>
                </h3>
    </div>
</body>
</html>
