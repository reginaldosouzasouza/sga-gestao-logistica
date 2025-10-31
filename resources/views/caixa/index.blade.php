@extends('layouts.app')

@section('title', 'CAIXA')

@section('content')
<link rel="stylesheet" href="{{ asset('css/caixa.css') }}">

@php
    // Definição de variáveis para evitar erros caso o caixa esteja fechado ou inexistente
    $totalEntrada = 0;
    $totalSaida = 0;
    $saldoAtual = 0;
@endphp

@if(isset($caixa) && $caixa)
    @php
        // Calculando totais apenas se houver movimentações no caixa
        $totalEntrada = $caixa->movimentacoes->where('tipo', 'entrada')->sum('valor');
        $totalSaida = $caixa->movimentacoes->where('tipo', 'saida')->sum('valor');
        $saldoAtual = $caixa->saldo_inicial + $totalEntrada - $totalSaida;
    @endphp
@endif

<div class="container">
    <h2>Caixa</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(isset($caixa) && $caixa)
        <p><strong>Data de Abertura:</strong> {{ \Carbon\Carbon::parse($caixa->data_abertura)->format('d-m-Y H:i') }}</p>
        <p><strong>Saldo Inicial:</strong> R$ {{ number_format($caixa->saldo_inicial, 2, ',', '.') }}</p>
        <p><strong>Status:</strong> 
            <span style="color: {{ $caixa->status == 'aberto' ? 'green' : 'red' }};">
                {{ ucfirst($caixa->status) }}
            </span>
        </p>

        <p><strong>Saldo Atual:</strong> 
            <span style="font-size: 24px; font-weight: bold; border: 2px solid black; padding: 5px;"> 
                R$ {{ number_format($saldoAtual, 2, ',', '.') }}
            </span>
        </p>

        @if($caixa->status == 'aberto')
            <form action="{{ route('caixa.fechar') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Fechar Caixa</button>
            </form>

            <!-- Formulário para registrar nova movimentação -->
            <h3>Registrar Movimentação</h3>
            <form action="{{ route('caixa.movimentacao') }}" method="POST">
                @csrf
                <div style="display: flex; gap: 10px; align-items: center;">
                    <select name="tipo" required>
                        <option value="entrada">Entrada</option>
                        <option value="saida">Saída</option>
                    </select>
                    <input type="text" name="descricao" placeholder="Descrição" required>
                    <input type="text" name="valor" placeholder="Valor" required>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </form>

            <h3>Movimentações do Caixa</h3>
            <table border="1" width="100%" cellpadding="5" cellspacing="0">
                <thead>
                    <tr style="background-color: black; color: white; text-align: center;">
                        <th>Tipo</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Forma de Pagamento</th>
                        <th>Usuário</th>
                        <th>Lançamento</th>
                        <th>Ações</th> <!-- Adicionando coluna para ações -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($caixa->movimentacoes as $mov)
                        <tr style="text-align: center;">
                            <td style="font-weight: bold; color: {{ $mov->tipo == 'entrada' ? 'green' : 'red' }}">
                                {{ ucfirst($mov->tipo) }}
                            </td>
                            <td>{{ $mov->descricao }}</td>
                            <td>R$ {{ number_format($mov->valor, 2, ',', '.') }}</td>
                            <td>{{ ucfirst($mov->metodo_pagamento) }}</td>
                            <td>{{ $mov->usuario->name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($mov->created_at)->format('d-m-Y H:i') }}</td>
                            <td>
                                <!-- Formulário para exclusão -->
                                <form action="{{ route('caixa.destroy', $mov->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta movimentação?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @else
        <h3>Abrir Caixa</h3>
        <form action="{{ route('caixa.abrir') }}" method="POST">
            @csrf
            <label for="saldo_inicial"><strong>Saldo Inicial:</strong></label>
            <input type="text" name="saldo_inicial" id="saldo_inicial" required>
            <button type="submit" class="btn btn-primary">Abrir Caixa</button>
        </form>
    @endif
</div>

<!-- Caixa lateral mostrando totais -->
<div style="position: absolute; top: 20px; right: 50px; border: 2px solid black; padding: 15px; text-align: center;">
    <h2>{{ \Carbon\Carbon::now()->format('d/m/Y') }}</h2>
    <p style="color: blue; font-size: 20px; font-weight: bold;">Entrada: R$ {{ number_format($totalEntrada, 2, ',', '.') }}</p>
    <p style="color: red; font-size: 20px; font-weight: bold;">Saída: R$ {{ number_format($totalSaida, 2, ',', '.') }}</p>
</div>

@endsection


<script>
    document.addEventListener("DOMContentLoaded", function () {
        let saldoInput = document.getElementById('saldo_inicial');
        if (saldoInput) {
            saldoInput.addEventListener('input', function (e) {
                this.value = this.value.replace(',', '.'); // Substitui vírgula por ponto
            });
        }
    });
</script>


