@extends('layouts.app')

@section('title', 'Relatório de Comissões')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/comissoes.css') }}">
@endsection

@section('content')

<div class="relatorio-comissoes-page">

    <h2>Relatório de Comissões</h2>

    <form method="GET" action="{{ route('relatorios.comissoes.index') }}" class="filtros-comissoes">

        <div class="campo-filtro">
            <label>Data Inicial</label>
            <input 
                type="date" 
                name="data_inicial" 
                value="{{ request('data_inicial') }}"
            >
        </div>

        <div class="campo-filtro">
            <label>Data Final</label>
            <input 
                type="date" 
                name="data_final" 
                value="{{ request('data_final') }}"
            >
        </div>

        <div class="campo-filtro">
            <label>Motorista</label>
            <select name="motorista_id">
                <option value="">Todos</option>
                @foreach($motoristas as $motorista)
                    <option 
                        value="{{ $motorista->id }}"
                        {{ request('motorista_id') == $motorista->id ? 'selected' : '' }}
                    >
                        {{ $motorista->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="campo-filtro">
            <label>Veículo</label>
            <select name="veiculo_id">
                <option value="">Todos</option>
                @foreach($veiculos as $veiculo)
                    <option 
                        value="{{ $veiculo->id }}"
                        {{ request('veiculo_id') == $veiculo->id ? 'selected' : '' }}
                    >
                        {{ $veiculo->descricao }}
                        @if($veiculo->placa)
                            - {{ $veiculo->placa }}
                        @endif
                    </option>
                @endforeach
            </select>
        </div>

        <div class="acoes-filtro">
            <button type="submit" class="btn-filtrar">
                Filtrar
            </button>

            <a href="{{ route('relatorios.comissoes.index') }}" class="btn-limpar">
                Limpar
            </a>

            <a 
                href="{{ route('relatorios.comissoes.pdf', request()->query()) }}" 
                class="btn-pdf" 
                target="_blank"
            >
                Gerar PDF
            </a>
        </div>

    </form>

    <div class="cards-resumo">

        <div class="card-resumo">
            <span>Total de Pedidos</span>
            <strong>{{ $totalPedidos }}</strong>
        </div>

        <div class="card-resumo">
            <span>Total de Vendas</span>
            <strong>R$ {{ number_format($totalVendas, 2, ',', '.') }}</strong>
        </div>

        <div class="card-resumo destaque">
            <span>Total de Comissão</span>
            <strong>R$ {{ number_format($totalComissao, 2, ',', '.') }}</strong>
        </div>

    </div>

    <div class="tabela-wrapper">
        <table class="tabela-comissoes">
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
                        <td>
                            @if($movimentacao->data_coleta)
                                {{ \Carbon\Carbon::parse($movimentacao->data_coleta)->format('d/m/Y') }}
                            @else
                                -
                            @endif
                        </td>

                        <td>{{ $movimentacao->controle_coleta ?? $movimentacao->id }}</td>

                        <td>{{ $movimentacao->nome ?? '-' }}</td>

                        <td>
                            {{ $movimentacao->veiculo->descricao ?? '-' }}
                            @if(optional($movimentacao->veiculo)->placa)
                                - {{ $movimentacao->veiculo->placa }}
                            @endif
                        </td>

                        <td>{{ $movimentacao->motorista->nome ?? 'Sem motorista vinculado' }}</td>

                        <td>
                            R$ {{ number_format($movimentacao->valor_total ?? 0, 2, ',', '.') }}
                        </td>

                        <td>
                            @if($movimentacao->comissao_tipo === 'percentual')
                                Percentual
                            @elseif($movimentacao->comissao_tipo === 'fixa')
                                Fixa
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            @if($movimentacao->comissao_tipo === 'percentual')
                                {{ number_format($movimentacao->comissao_valor ?? 0, 2, ',', '.') }}%
                            @elseif($movimentacao->comissao_tipo === 'fixa')
                                R$ {{ number_format($movimentacao->comissao_valor ?? 0, 2, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            <strong>
                                R$ {{ number_format($movimentacao->valor_comissao ?? 0, 2, ',', '.') }}
                            </strong>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="sem-registros">
                            Nenhuma comissão encontrada para os filtros selecionados.
                        </td>
                    </tr>
                @endforelse
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="5">
                        <strong>Total Geral</strong>
                    </td>

                    <td>
                        <strong>R$ {{ number_format($totalVendas, 2, ',', '.') }}</strong>
                    </td>

                    <td colspan="2"></td>

                    <td>
                        <strong>R$ {{ number_format($totalComissao, 2, ',', '.') }}</strong>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

</div>

@endsection