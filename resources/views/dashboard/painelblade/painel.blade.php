@extends('layouts.app')

@section('title', 'Painel Financeiro')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/painel.css') }}">

<div class="container">
    <h2 class="text-center">Painel Financeiro</h2>

    <div class="row">
        <!-- Bloco de Receitas -->
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Receitas (Mês Atual)</div>
                <div class="card-body">
                    <h3>R$ {{ number_format($totalEntrada, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <!-- Bloco de Total Recebido -->
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Recebido (Mês Atual)</div>
                <div class="card-body">
                    <h3>R$ {{ number_format($totalRecebido, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <!-- Bloco de Previsão de Receitas -->
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Previsão de Receitas</div>
                <div class="card-body">
                    <h3>R$ {{ number_format($previsaoReceitas, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Bloco de Despesas -->
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Despesas (Mês Atual)</div>
                <div class="card-body">
                    <h3>R$ {{ number_format($totalSaidas, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <!-- Bloco de Total Pago -->
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Total Pago (Mês Atual)</div>
                <div class="card-body">
                    <h3>R$ {{ number_format($totalPago, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <!-- Bloco de Saldo Atual -->
        <div class="col-md-4">
            <div class="card text-white bg-dark mb-3">
                <div class="card-header">Saldo Atual</div>
                <div class="card-body">
                    <h3>R$ {{ number_format($saldoAtual, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

