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

        <!-- Filtros -->
        <form action="{{ route('relatorio.compras') }}" method="GET" class="filtros">
            <label>Código:</label>
            <input type="text" name="id" placeholder="Código da Compra" value="{{ request('id') }}">

            <label>Produto:</label>
            <input type="text" name="produto" placeholder="Nome do Produto" value="{{ request('produto') }}">

            <label>Fornecedor:</label>
            <input type="text" name="fornecedor" placeholder="Nome do Fornecedor" value="{{ request('fornecedor') }}">

            <label>Natureza Financeira:</label>
            <select name="natureza_financeira">
                <option value="todas" {{ request('natureza_financeira', 'todas') == 'todas' ? 'selected' : '' }}>Todas</option>
                <option value="estoque" {{ request('natureza_financeira') == 'estoque' ? 'selected' : '' }}>Estoque</option>
                <option value="operacional" {{ request('natureza_financeira') == 'operacional' ? 'selected' : '' }}>Operacional</option>
                <option value="administrativa" {{ request('natureza_financeira') == 'administrativa' ? 'selected' : '' }}>Administrativa</option>
                <option value="pessoal" {{ request('natureza_financeira') == 'pessoal' ? 'selected' : '' }}>Pessoal</option>
                <option value="financeiro" {{ request('natureza_financeira') == 'financeiro' ? 'selected' : '' }}>Financeiro</option>
            </select>

            <!-- NOVO FILTRO -->
            <label>Status Pagamento:</label>
            <select name="status_pagamento">
                <option value="todos" {{ request('status_pagamento','todos') == 'todos' ? 'selected' : '' }}>Todos</option>
                <option value="pago" {{ request('status_pagamento') == 'pago' ? 'selected' : '' }}>Pago</option>
                <option value="pendente" {{ request('status_pagamento') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                <option value="atrasado" {{ request('status_pagamento') == 'atrasado' ? 'selected' : '' }}>Atrasado</option>
            </select>

             <!-- fltro por data da COMPRA -->

            <label>Data Compra Inicial:</label>
            <input type="date" name="data_inicial" value="{{ request('data_inicial') }}">

            <label>Data Compra Final:</label>
            <input type="date" name="data_final" value="{{ request('data_final') }}">

            <div class="grupo-vencimento">
    
                <div class="campo">
                    <label>Vencimento Inicial:</label>
                    <input type="date" name="data_vencimento_inicial" value="{{ request('data_vencimento_inicial') }}">
                </div>

                <div class="campo">
                    <label>Vencimento Final:</label>
                    <input type="date" name="data_vencimento_final" value="{{ request('data_vencimento_final') }}">
                </div>

            </div>


            <button type="submit">Filtrar</button>
            <a href="{{ route('relatorio.compras') }}" class="limpar-filtros">Limpar Filtros</a>
        </form>

        <!-- Totais -->
        <div style="display:flex; gap:20px; justify-content:flex-end; flex-wrap:wrap; margin-top: 20px;">
            <h3>
                Total Geral: <strong>R$ {{ number_format($totalGeral ?? $totalCompras ?? 0, 2, ',', '.') }}</strong>
            </h3>
            <h3>
                Total Pago: <strong>R$ {{ number_format($totalPago ?? 0, 2, ',', '.') }}</strong>
            </h3>
            <h3>
                Total Pendente: <strong>R$ {{ number_format($totalPendente ?? 0, 2, ',', '.') }}</strong>
            </h3>
            <h3>
                Total Atrasado: <strong>R$ {{ number_format($totalAtrasado ?? 0, 2, ',', '.') }}</strong>
            </h3>
        </div>

        <!-- Tabela -->
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
                    <th>Natureza Financeira</th>

                    <!-- NOVAS COLUNAS -->
                    <th>Forma Pagamento</th>
                    <th>Status Pagamento</th>
                    <th>Vencimento</th>
                    <th>Data Pagamento</th>

                    <th>Data da Compra</th>
                </tr>
            </thead>
            <tbody>
                @forelse($compras as $compra)
                    <tr>
                        <td>{{ $compra->compra_id }}</td>
                        <td>{{ $compra->produto }}</td>
                        <td>{{ $compra->quantidade }}</td>
                        <td>R$ {{ number_format($compra->valor_unitario, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($compra->valor_total, 2, ',', '.') }}</td>
                        <td>{{ $compra->nota_fiscal ?? '-' }}</td>
                        <td>{{ $compra->fornecedor ?? '-' }}</td>
                        <td>{{ ucfirst($compra->natureza_financeira ?? '-') }}</td>

                        <!-- NOVAS COLUNAS -->
                        <td>{{ $compra->forma_pagamento ?? '-' }}</td>

                        <td>
                            @php
                                $st = strtolower($compra->status_pagamento ?? '');
                            @endphp

                            @if($st === 'pago')
                                <strong style="color: #1b8f2e;">PAGO</strong>
                            @elseif($st === 'pendente')
                                <strong style="color: #b36b00;">PENDENTE</strong>
                            @elseif($st === 'atrasado')
                                <strong style="color: #b10000;">ATRASADO</strong>
                            @else
                                <strong>-</strong>
                            @endif
                        </td>

                        <td>
                            @if(!empty($compra->data_vencimento))
                                {{ \Carbon\Carbon::parse($compra->data_vencimento)->format('d/m/Y') }}
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            @if(!empty($compra->data_pagamento))
                                {{ \Carbon\Carbon::parse($compra->data_pagamento)->format('d/m/Y') }}
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            @if(!empty($compra->data_compra))
                                {{ \Carbon\Carbon::parse($compra->data_compra)->format('d/m/Y') }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="13" style="text-align:center; padding: 20px;">
                            Nenhum registro encontrado com os filtros informados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</body>
</html>