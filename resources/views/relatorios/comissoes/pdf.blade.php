<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Comissões</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #111;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .periodo {
            text-align: center;
            margin-bottom: 15px;
            font-size: 11px;
        }

        .resumo {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }

        .resumo td {
            border: 1px solid #ccc;
            padding: 8px;
            font-size: 12px;
        }

        .resumo strong {
            font-size: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #2f2f2f;
            color: #ffffff;
            padding: 6px;
            border: 1px solid #333;
            font-size: 10px;
        }

        td {
            padding: 5px;
            border: 1px solid #ccc;
            font-size: 10px;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        tfoot td {
            background: #e9ecef;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h2>Relatório de Comissões</h2>

    <div class="periodo">
        Período:
        @if($dataInicial)
            {{ \Carbon\Carbon::parse($dataInicial)->format('d/m/Y') }}
        @else
            Início
        @endif

        até

        @if($dataFinal)
            {{ \Carbon\Carbon::parse($dataFinal)->format('d/m/Y') }}
        @else
            Atual
        @endif
    </div>

    <table class="resumo">
        <tr>
            <td>
                Total de Pedidos<br>
                <strong>{{ $totalPedidos }}</strong>
            </td>

            <td>
                Total de Vendas<br>
                <strong>R$ {{ number_format($totalVendas, 2, ',', '.') }}</strong>
            </td>

            <td>
                Total de Comissão<br>
                <strong>R$ {{ number_format($totalComissao, 2, ',', '.') }}</strong>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Nº Coleta</th>
                <th>Cliente</th>
                <th>Veículo</th>
                <th>Motorista</th>
                <th>Valor Pedido</th>
                <th>Tipo</th>
                <th>Comissão</th>
                <th>Valor Comissão</th>
            </tr>
        </thead>

        <tbody>
            @forelse($movimentacoes as $movimentacao)
                <tr>
                    <td class="center">
                        @if($movimentacao->data_coleta)
                            {{ \Carbon\Carbon::parse($movimentacao->data_coleta)->format('d/m/Y') }}
                        @else
                            -
                        @endif
                    </td>

                    <td class="center">
                        {{ $movimentacao->controle_coleta ?? $movimentacao->id }}
                    </td>

                    <td>
                        {{ $movimentacao->nome ?? '-' }}
                    </td>

                    <td>
                        {{ $movimentacao->veiculo->descricao ?? '-' }}
                        @if(optional($movimentacao->veiculo)->placa)
                            - {{ $movimentacao->veiculo->placa }}
                        @endif
                    </td>

                    <td>
                        {{ $movimentacao->motorista->nome ?? 'Sem motorista vinculado' }}
                    </td>

                    <td class="right">
                        R$ {{ number_format($movimentacao->valor_total ?? 0, 2, ',', '.') }}
                    </td>

                    <td class="center">
                        @if($movimentacao->comissao_tipo === 'percentual')
                            Percentual
                        @elseif($movimentacao->comissao_tipo === 'fixa')
                            Fixa
                        @else
                            -
                        @endif
                    </td>

                    <td class="right">
                        @if($movimentacao->comissao_tipo === 'percentual')
                            {{ number_format($movimentacao->comissao_valor ?? 0, 2, ',', '.') }}%
                        @elseif($movimentacao->comissao_tipo === 'fixa')
                            R$ {{ number_format($movimentacao->comissao_valor ?? 0, 2, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>

                    <td class="right">
                        <strong>
                            R$ {{ number_format($movimentacao->valor_comissao ?? 0, 2, ',', '.') }}
                        </strong>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="center">
                        Nenhuma comissão encontrada para os filtros selecionados.
                    </td>
                </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr>
                <td colspan="5">Total Geral</td>

                <td class="right">
                    R$ {{ number_format($totalVendas, 2, ',', '.') }}
                </td>

                <td colspan="2"></td>

                <td class="right">
                    R$ {{ number_format($totalComissao, 2, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>

</body>
</html>