@extends('layouts.app')

@section('title', 'Rel. Contas A Receber')

@section('content')
<link rel="stylesheet" href="{{ asset('css/relcontasareceber.css') }}">

<div class="container">
    <h2>Relatório de Contas a Receber</h2>

    <form method="GET" action="{{ route('contas_a_receber.relatorio') }}">
        <div class="row">

            <div class="col-md-3">
                <label>Cliente:</label>
                <input type="text" name="cliente" class="form-control"
                       placeholder="Nome do Cliente"
                       value="{{ request('cliente') }}">
            </div>

            <div class="col-md-2">
                <label>Status:</label>
                <select name="status" class="form-control">
                    <option value="">Todos</option>
                    <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                    <option value="recebido" {{ request('status') == 'recebido' ? 'selected' : '' }}>Recebido</option>
                    <option value="atrasado" {{ request('status') == 'atrasado' ? 'selected' : '' }}>Atrasado</option>
                </select>
            </div>

            <div>
                <label>Forma de Pagamento:</label>
                <select name="forma_pagamento_id">
                    <option value="">Todas</option>
                    @foreach($formasDePagamento as $forma)
                        <option value="{{ $forma->id }}"
                            {{ request('forma_pagamento_id') == $forma->id ? 'selected' : '' }}>
                            {{ $forma->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label>Data da Emissão Inicial:</label>
                <input type="date" name="data_venda_inicial"
                       class="form-control"
                       value="{{ request('data_venda_inicial') }}">
            </div>

            <div class="col-md-2">
                <label>Data da Emissão Final:</label>
                <input type="date" name="data_venda_final"
                       class="form-control"
                       value="{{ request('data_venda_final') }}">
            </div>

            <div class="col-md-2">
                <label>Data de Vencimento Inicial:</label>
                <input type="date" name="data_vencimento_inicial"
                       class="form-control"
                       value="{{ request('data_vencimento_inicial') }}">

                <label>Final:</label>
                <input type="date" name="data_vencimento_final"
                       class="form-control"
                       value="{{ request('data_vencimento_final') }}">
            </div>



             <div class="col-md-2">
                <label>Data de Recebimento Inicial:</label>
                <input type="date" name="data_recebimento_inicial"
                       class="form-control"
                       value="{{ request('data_recebimento_inicial') }}">

                <label>Final:</label>
                <input type="date" name="data_recebimento_final"
                       class="form-control"
                       value="{{ request('data_recebimento_final') }}">
            </div>


            <div class="col-md-1">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary btn-block">Filtrar</button>
                <a href="{{ route('contas_a_receber.relatorio') }}" class="btn btn-secondary">Limpar</a>.
                  <label>&nbsp;</label>
                 

                <a href="{{ route('contas_a_receber.exportar', request()->query()) }}"
                    class="btn btn-success">
                        📥 Exportar CSV
                </a>  
            </div>

        </div>
    </form>

    <hr>
       <div class="total">
           <h3> Total de Registros:<strong>&nbsp;{{ $contas->count() }}</strong>            
            <h3>Total a Receber:</strong>&nbsp; R$ {{ number_format($total_faturas, 2, ',', '.') }}</strong>
          
        </div>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Forma de Pagamento</th>
                <th>Valor (R$)</th>
                <th>Data da Venda</th>
                <th>Data de Vencimento</th>
                <th>Data de Recebimento</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contas as $conta)
                <tr>
                    <td>{{ $conta->cliente->nome ?? 'N/A' }}</td>
                    <td>{{ $conta->formaPagamento->nome ?? '-' }}</td>
                    <td><strong>{{ number_format($conta->valor, 2, ',', '.') }}</strong></td>
                    <td>{{ date('d/m/Y', strtotime($conta->data_venda)) }}</td>
                    <td>{{ date('d/m/Y', strtotime($conta->data_vencimento)) }}</td>
                    <td>
                        {{ $conta->data_recebimento
                            ? date('d/m/Y', strtotime($conta->data_recebimento))
                            : '-' }}
                    </td>
                    <td>{{ ucfirst($conta->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection