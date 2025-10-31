@extends('layouts.app')

@section('title', 'Detalhes da Movimentação')

@section('content')

<!-- Adicionando o CSS diretamente -->
<style>
    .container {
        width: 65%;
        margin: 20px auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        font-family: 'Arial', sans-serif;
        color: #333;
        margin-bottom: 20px;
    }

    .details {
        font-size: 18px;
        line-height: 1.6;
        margin-bottom: 10px;
        border: 1px solid #007bff; /* Borda azul */
        padding: 10px;
        border-radius: 5px;
        background-color: #f0f8ff; /* Fundo azul claro */
    }

    .details strong {
        color: #007bff;
    }

    a {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    a:hover {
        background-color: #0056b3;
    }

    /* Estilos para os itens do pedido */
    .itens-pedido-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .itens-pedido-table th, .itens-pedido-table td {
        border: 1px solid #007bff;
        padding: 10px;
        text-align: left;
    }

    .itens-pedido-table th {
        background-color: #007bff;
        color: white;
        text-align: center;
    }

    .itens-pedido-table td {
        text-align: center;
    }

    .total-pedido {
        font-size: 25px;
        margin-top: 10px;
        text-align: right;
        color: #28a745;
        font-weight: bolder;
    }

</style>

<div class="container">
    <h1>Detalhes da Movimentação</h1>
    <p class="details"><strong>Ordem de Coleta:</strong> {{ $movimentacao->id }}&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
    <strong>Data:</strong> {{ \Carbon\Carbon::parse($movimentacao->created_at)->format('d/m/Y') }}</p><!-- Formata a data como dia/mês/ano -->
    <p class="details"><strong>Nome:</strong> {{ $movimentacao->nome }}</p>
    <p class="details"><strong>Endereço:</strong> {{ $movimentacao->endereco }}</p>
    <p class="details"><strong>Número:</strong> {{ $movimentacao->numero }}</p>
    <p class="details"><strong>Bairro:</strong> {{ $movimentacao->bairro }}</p>
    <p class="details"><strong>Cidade:</strong> {{ $movimentacao->cidade }}</p>
    <p class="details"><strong>Observação:</strong> {{ $movimentacao->observacao ?? 'Nenhuma observação.' }}</p>

    <!-- Itens do Pedido -->
    <h3>Itens do Pedido</h3>
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
                <td>{{ $item->produto->nome }}</td>
                <td>{{ $item->quantidade }}</td>
                <td>{{ number_format($item->valor_unitario, 2, ',', '.') }}</td>
                <td>{{ number_format($item->valor_total, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p class="total-pedido">Valor Total do Pedido: {{ number_format($movimentacao->itens->sum('valor_total'), 2, ',', '.') }}</p>

    <a href="{{ route('movimentacao.index') }}">Voltar</a>
</div>

@endsection

