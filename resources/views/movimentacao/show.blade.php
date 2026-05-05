@extends('layouts.app')

@section('title', 'Detalhes da Movimentação')

@section('content')

<style>
    .container-detalhes {
        width: 85%;
        margin: 20px auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1, h2 {
        text-align: center;
        font-family: Arial, sans-serif;
        color: #333;
        margin-bottom: 20px;
    }

    .details {
        font-size: 18px;
        line-height: 1.6;
        margin-bottom: 10px;
        border: 1px solid #007bff;
        padding: 10px;
        border-radius: 5px;
        background-color: #f0f8ff;
        color: #000;
    }

    .details strong {
        color: #007bff;
    }

    .btn-voltar {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    .btn-voltar:hover {
        background-color: #0056b3;
        color: white;
    }

    .itens-pedido-table,
    .historico-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background: #fff;
    }

    .itens-pedido-table th,
    .itens-pedido-table td,
    .historico-table th,
    .historico-table td {
        border: 1px solid #dee2e6;
        padding: 10px;
        text-align: center;
        color: #000;
    }

    .itens-pedido-table th,
    .historico-table th {
        background-color: #007bff;
        color: white;
    }

    .total-pedido {
        font-size: 22px;
        margin-top: 10px;
        color: #28a745;
        font-weight: bold;
        text-align: right;
    }

    .separador {
        margin: 35px 0;
        border: 0;
        border-top: 2px solid #ddd;
    }

    .historico-table tbody tr {
        transition: background-color 0.25s ease;
    }

    .historico-table tbody tr:hover {
        background-color: #eef7ff;
    }

    .badge-atual {
        background: #28a745;
        color: #fff;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 13px;
        font-weight: bold;
    }


    .total-historico {
    margin: 15px 0 20px 0;
    padding: 14px 18px;
    background-color: #e9f7ef;
    border: 1px solid #28a745;
    border-radius: 6px;
    color: #155724;
    font-size: 20px;
    font-weight: bold;
    text-align: right;
}

.total-historico span {
    color: #0b7d26;
    font-size: 24px;
}

</style>

<div class="container-detalhes">
    <h1>Detalhes da Movimentação</h1>

    <p class="details">
        <strong>Ordem de Coleta:</strong> {{ $movimentacao->id }}
        &nbsp;&nbsp;&nbsp;&nbsp;
        <strong>Data:</strong> {{ \Carbon\Carbon::parse($movimentacao->data_coleta ?? $movimentacao->created_at)->format('d/m/Y') }}
    </p>

    <p class="details"><strong>Nome:</strong> {{ $movimentacao->nome }}</p>
    <p class="details"><strong>Endereço:</strong> {{ $movimentacao->endereco }}</p>
    <p class="details"><strong>Número:</strong> {{ $movimentacao->numero }}</p>
    <p class="details"><strong>Bairro:</strong> {{ $movimentacao->bairro }}</p>
    <p class="details"><strong>Cidade:</strong> {{ $movimentacao->cidade }}</p>
    <p class="details"><strong>Observação:</strong> {{ $movimentacao->observacao ?? 'Nenhuma observação.' }}</p>

    <h2>Detalhes do Produto desta Movimentação</h2>

    @if($movimentacao->itens->count() > 0)
        <table class="itens-pedido-table">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Valor Unitário</th>
                    <th>Valor Total</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($movimentacao->itens as $item)
                    <tr>
                        <td>{{ optional($item->produto)->nome ?? 'Produto não encontrado' }}</td>
                        <td>{{ $item->quantidade }}</td>
                        <td>R$ {{ number_format($item->valor_unitario, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($item->valor_total, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p class="total-pedido">
            Total desta movimentação: R$ {{ number_format($movimentacao->itens->sum('valor_total'), 2, ',', '.') }}
        </p>
    @else
        <p class="details"><strong>Nenhum produto encontrado nesta movimentação.</strong></p>
    @endif

    <hr class="separador">
    <h2>Histórico de Movimentações do Cliente</h2>

@if(isset($historicoCliente) && $historicoCliente->count() > 0)

    @php
        $totalHistorico = $historicoCliente->sum(function ($historico) {
            return $historico->valor_total ?? $historico->itens->sum('valor_total');
        });
    @endphp

    <div class="total-historico">
        Total do histórico do cliente: 
        <span>R$ {{ number_format($totalHistorico, 2, ',', '.') }}</span>
    </div>

    <table class="historico-table">

            <thead>
                <tr>
                    <th>Data</th>
                    <th>Coleta</th>
                    <th>Cliente</th>
                    <th>Forma Pagamento</th>
                    <th>Prazo</th>
                    <th>Valor Total</th>
                    <th>Situação</th>
                </tr>
            </thead>

            <tbody>
                @foreach($historicoCliente as $historico)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($historico->data_coleta ?? $historico->created_at)->format('d/m/Y') }}</td>
                        <td>{{ $historico->id }}</td>
                        <td>{{ $historico->nome }}</td>
                        <td>{{ $historico->formaPagamento->nome ?? '-' }}</td>
                        <td>{{ $historico->prazo_id ?? '-' }}</td>
                        <td>R$ {{ number_format($historico->valor_total ?? $historico->itens->sum('valor_total'), 2, ',', '.') }}</td>
                        <td>
                            @if($historico->id == $movimentacao->id)
                                <span class="badge-atual">Atual</span>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="details">
            <strong>Nenhum histórico encontrado para este cliente.</strong>
        </p>
    @endif

    <a href="{{ route('movimentacao.index') }}" class="btn-voltar">Voltar</a>
</div>

@endsection