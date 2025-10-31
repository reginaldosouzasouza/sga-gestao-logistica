<<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Estoque Atual</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Relatório de Estoque Atual</h1>

    <table>
        <thead>
            <tr>
                <th>Nome do Produto</th>
                <th>Quantidade em Estoque</th>
                <th>Última Atualização</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produtos as $produto)
                <tr>
                    <td>{{ $produto->nome }}</td>
                    <td>{{ $produto->quantidade_estoque }}</td>
                    <td>{{ $produto->updated_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
