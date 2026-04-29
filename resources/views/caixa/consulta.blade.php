@extends('layouts.app')

@section('title', 'Consulta de Caixa')

@section('content')

<link rel="stylesheet" href="{{ asset('css/caixa-consulta.css') }}">

<div class="container mt-4">
    <div class="caixa-consulta shadow-sm">

        <h3>🔍 Consulta de Movimentações do Caixa</h3>

        <!-- FILTROS -->
        <form method="GET" class="card card-filtros p-3 mb-4">
            <div class="row g-3 align-items-end justify-content-center text-center">


                <div class="col-md-2">
                    <label>Data Inicial</label>
                    <input type="date" name="data_inicio" value="{{ $dataInicio }}" class="form-control">
                
                    <label>Data Final</label>
                    <input type="date" name="data_fim" value="{{ $dataFim }}" class="form-control">
                </div>

                <div class="col-md-2">
                    <label>Tipo</label>
                    <select name="tipo" class="form-control">
                        <option value="">Todos</option>
                        <option value="entrada" {{ $tipo=='entrada' ? 'selected' : '' }}>Entrada</option>
                        <option value="saida" {{ $tipo=='saida' ? 'selected' : '' }}>Saída</option>
                    </select>
                

                
                    <label>Origem</label>
                    <select name="origem" class="form-control">
                        <option value="">Todas</option>
                        <option value="caixa" {{ $origem=='caixa' ? 'selected' : '' }}>Caixa</option>
                        <option value="banco" {{ $origem=='banco' ? 'selected' : '' }}>Banco</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Descrição</label>
                    <input type="text" name="texto" value="{{ $texto }}" class="form-control" placeholder="Buscar...">
                

                
                    <button class="btn btn-filtrar w-100">
                        Filtrar
                    </button>
                </div>

            </div>
        </form>

        

                <!-- TOTALIZADORES -->
        <div class="totalizadores-linha mb-4">

            <div class="total-card caixa">
                <span>Caixa (Dinheiro)</span>
                <strong class="{{ $totalCaixa < 0 ? 'negativo' : '' }}">
                    R$ {{ number_format($totalCaixa, 2, ',', '.') }}
                </strong>
            </div>

            <div class="total-card banco">
                <span>Caixa Banco (PIX)</span>
                <strong class="{{ $totalBanco < 0 ? 'negativo' : '' }}">
                    R$ {{ number_format($totalBanco, 2, ',', '.') }}
                </strong>
            </div>

            <div class="total-card total">
                <span>Total Geral</span>
                <strong class="{{ $totalGeral < 0 ? 'negativo' : '' }}">
                    R$ {{ number_format($totalGeral, 2, ',', '.') }}
                </strong>
            </div>

        </div>



     








        <!-- TABELA -->
        <div class="card shadow-sm mx-auto caixa-tabela">

            <div class="card-body table-responsive text-center">

                <table class="table table-bordered table-caixa">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Origem</th>
                            <th>Tipo</th>
                            <th>Forma</th>
                            <th>Descrição</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movimentacoes as $mov)
                            <tr>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($mov->data_movimentacao)->format('d/m/Y') }}
                                </td>

                                <td class="text-center {{ $mov->origem_caixa == 'Banco' ? 'origem-banco' : 'origem-caixa' }}">
                                    {{ $mov->origem_caixa }}
                                </td>

                                <td class="text-center">
                                    <span class="badge {{ $mov->tipo == 'entrada' ? 'badge-entrada' : 'badge-saida' }}">
                                        {{ ucfirst($mov->tipo) }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    {{ $mov->forma_pagamento ?? '-' }}
                                </td>

                                <td>
                                    {{ $mov->descricao }}
                                </td>

                                <td class="valor">
                                    R$ {{ number_format($mov->valor, 2, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="sem-registros">
                                    Nenhuma movimentação encontrada
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection
