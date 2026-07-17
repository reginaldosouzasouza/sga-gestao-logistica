@extends('layouts.app')

@section('title', 'Relatório de Margem por Emissão')

@section('content')

<div class="container">

    <h1 style="margin-bottom: 20px;">Relatório de Margem por Emissão</h1>

    <form method="GET" action="{{ route('relatorios.margem-emissao') }}" style="margin-bottom: 25px;">

        <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: end;">

            <div>
                <label>Data Início</label>
                <input type="date"
                       name="data_inicio"
                       value="{{ request('data_inicio') }}"
                       class="form-control">
            </div>

            <div>
                <label>Data Fim</label>
                <input type="date"
                       name="data_fim"
                       value="{{ request('data_fim') }}"
                       class="form-control">
            </div>

            <div>
                <label>Produto</label>
                <select name="produto_id" class="form-control">
                    <option value="">Todos</option>

                    @foreach($produtos as $produto)
                        <option value="{{ $produto->id }}"
                            {{ request('produto_id') == $produto->id ? 'selected' : '' }}>
                            {{ $produto->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="btn btn-primary">
                    Filtrar
                </button>

                <a href="{{ route('relatorios.margem-emissao') }}" class="btn btn-secondary">
                    Limpar
                </a>

                <a href="{{ route('relatorios.margem-emissao.exportar', request()->query()) }}" 
                    class="btn btn-success">
                    Exportar Excel
                </a>


            </div>

        </div>

    </form>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(190px, 1fr)); gap: 15px; margin-bottom: 25px;">

        <div style="background: #e0f2fe; padding: 15px; border-radius: 10px;">
            <div style="font-weight: bold;">Total Vendido</div>
            <div style="font-size: 22px;">
                R$ {{ number_format($totalVendido, 2, ',', '.') }}
            </div>
        </div>

        <div style="background: #fee2e2; padding: 15px; border-radius: 10px;">
            <div style="font-weight: bold;">Total de Custo</div>
            <div style="font-size: 22px;">
                R$ {{ number_format($totalCusto, 2, ',', '.') }}
            </div>
        </div>

        <div style="background: #dcfce7; padding: 15px; border-radius: 10px;">
            <div style="font-weight: bold;">Margem Total</div>
            <div style="font-size: 22px;">
                R$ {{ number_format($totalMargem, 2, ',', '.') }}
            </div>
        </div>

        <div style="background: #fef9c3; padding: 15px; border-radius: 10px;">
            <div style="font-weight: bold;">Margem Média</div>
            <div style="font-size: 22px;">
                {{ number_format($margemMediaPercentual, 2, ',', '.') }}%
            </div>
        </div>

    </div>

    <div style="overflow-x: auto;">

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Emissão</th>
                    <th>Cliente</th>
                    <th>Produto</th>
                    <th>Qtd</th>
                    <th>Venda Unit.</th>
                    <th>Custo Unit.</th>
                    <th>Total Venda</th>
                    <th>Total Custo</th>
                    <th>Margem Unit.</th>
                    <th>Margem Total</th>
                    <th>Margem %</th>
                </tr>
            </thead>

            <tbody>
                @forelse($itens as $item)

                    @php
                        $totalCustoItem = $item->preco_compra_momento * $item->quantidade;
                    @endphp

                    <tr>
                        <td>
                            {{ $item->data_coleta ? \Carbon\Carbon::parse($item->data_coleta)->format('d/m/Y') : '-' }}
                        </td>

                        <td>
                            #{{ $item->movimentacao_id }}
                        </td>

                        <td>
                            {{ $item->cliente ?? 'Não informado' }}
                        </td>

                        <td>
                            {{ $item->produto }}
                        </td>

                        <td>
                            {{ number_format($item->quantidade, 2, ',', '.') }}
                        </td>

                        <td>
                            R$ {{ number_format($item->valor_unitario, 2, ',', '.') }}
                        </td>

                        <td>
                            R$ {{ number_format($item->preco_compra_momento, 2, ',', '.') }}
                        </td>

                        <td>
                            R$ {{ number_format($item->valor_total_item, 2, ',', '.') }}
                        </td>

                        <td>
                            R$ {{ number_format($totalCustoItem, 2, ',', '.') }}
                        </td>

                        <td>
                            <strong style="color: {{ $item->margem_unitaria >= 0 ? 'green' : 'red' }};">
                                R$ {{ number_format($item->margem_unitaria, 2, ',', '.') }}
                            </strong>
                        </td>

                        <td>
                            <strong style="color: {{ $item->margem_total >= 0 ? 'green' : 'red' }};">
                                R$ {{ number_format($item->margem_total, 2, ',', '.') }}
                            </strong>
                        </td>

                        <td>
                            <strong style="color: {{ $item->margem_percentual >= 0 ? 'green' : 'red' }};">
                                {{ number_format($item->margem_percentual, 2, ',', '.') }}%
                            </strong>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="12" style="text-align: center;">
                            Nenhum registro encontrado para o filtro informado.
                        </td>
                    </tr>

                @endforelse
            </tbody>

            @if($itens->count() > 0)
                <tfoot>
                    <tr style="font-weight: bold; background: #f3f4f6;">
                        <td colspan="7">Totais</td>

                        <td>
                            R$ {{ number_format($totalVendido, 2, ',', '.') }}
                        </td>

                        <td>
                            R$ {{ number_format($totalCusto, 2, ',', '.') }}
                        </td>

                        <td>-</td>

                        <td>
                            R$ {{ number_format($totalMargem, 2, ',', '.') }}
                        </td>

                        <td>
                            {{ number_format($margemMediaPercentual, 2, ',', '.') }}%
                        </td>
                    </tr>
                </tfoot>
            @endif

        </table>

    </div>

</div>

@endsection