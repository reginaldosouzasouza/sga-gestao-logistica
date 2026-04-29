@extends('layouts.app')

@section('title', 'Rel. Contas A Pagar')


@section('content')
<link rel="stylesheet" href="{{ asset('css/relcontasapagar.css') }}">

<div class="container">
    <h2>Relatório de Contas a Pagar</h2>

    <form method="GET" action="{{ route('contas_a_pagar.relatorio') }}">
        <div class="row">
            <div class="col-md-3">
                <label>Fornecedor:</label>
                <input type="text" name="fornecedor" class="form-control" placeholder="Nome do Fornecedor" value="{{ request('fornecedor') }}">
            </div>
            <div class="col-md-2">
                <label>Status:</label>
                <select name="status" class="form-control">
                    <option value="">Todos</option>
                    <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                    <option value="pago" {{ request('status') == 'pago' ? 'selected' : '' }}>Pago</option>
                    <option value="atrasado" {{ request('status') == 'atrasado' ? 'selected' : '' }}>Atrasado</option>
                </select>
            </div>

            <div>
                <label for="forma_pagamento_id">Forma de Pagamento:</label>
                <select name="forma_pagamento_id">
                    <option value="">Todas</option>
                @foreach($formasDePagamento as $forma)
                    <option value="{{ $forma->id }}" {{ request('forma_pagamento_id') == $forma->id ? 'selected' : '' }}>
                    {{ $forma->nome }}
                    </option>
                @endforeach
                </select>
            </div>
            


        <!--    <div class="col-md-2">
                <label>Data da Compra:</label>
                <input type="date" name="data_emissao" class="form-control" value="{{ request('data_emissao') }}">
            </div>-->

              <!-- Adicionando Filtro de Data da Compra (Inicial e Final) -->
            <div class="col-md-2">
                <label>Data da Compra Inicial:</label>
                <input type="date" name="data_compra_inicial" class="form-control" value="{{ request('data_compra_inicial') }}">
            </div>
            
            <div class="col-md-2">
                <label>Data da Compra Final:</label>
                <input type="date" name="data_compra_final" class="form-control" value="{{ request('data_compra_final') }}">
            </div>

            
            

            <div class="col-md-2">
                <label>Data de Vencimento Inicial:</label>
                <input type="date" name="data_vencimento_inicial" class="form-control" value="{{ request('data_vencimento_inicial') }}">

                <label>Final:</label>
                <input type="date" name="data_vencimento_final" class="form-control"  value="{{ request('data_vencimento_final') }}">
            </div>     


            <div class="col-md-2">
                <label>Data de Pagamento Inicial:</label>
                <input type="date" name="data_pagamento_inicial" class="form-control" value="{{ request('data_pagamento_inicial') }}">

                <label>Final:</label>
                <input type="date" name="data_pagamento_final" class="form-control" value="{{ request('data_pagamento_final') }}">
            </div>


                        
            


            <div class="col-md-1">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary btn-block">Filtrar</button>
            </div>
        </div>
    </form>

    <a href="{{ route('contas-a-pagar.exportar', request()->query()) }}"
   class="btn btn-success">
    📥 Exportar Excel
</a>

    <hr>

    <p><strong>Total de Registros:</strong> {{ $contas->count() }}</p>
    <p><strong>Total de Faturas:</strong> R$ {{ number_format($total_faturas, 2, ',', '.') }}</p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Fornecedor</th>
                <th>Fatura</th>
                <th>Valor (R$)</th>
                <th>Data de Emissão</th>
                <th>Data de Compra</th>
                <th>Data de Vencimento</th>
                <th>Data de Pagamento</th>
                <th>Status</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($contas as $conta)
            <tr>
                <td>{{ $conta->fornecedor->nome ?? 'N/A' }}</td>
                <td>{{ $conta->formaPagamento->nome ?? 'Sem forma de pagamento' }}</td>
                <td><strong>{{ number_format($conta->valor, 2, ',', '.') }}</strong></td>
                <td>{{ date('d/m/Y', strtotime($conta->created_at)) }}</td>
                <td>{{ date('d/m/Y', strtotime($conta->data_compra)) }}</td>
                <td>{{ date('d/m/Y', strtotime($conta->data_vencimento)) }}</td>
                <td>{{ $conta->data_pagamento ? date('d/m/Y', strtotime($conta->data_pagamento)) : '-' }}</td>
                <td>{{ ucfirst($conta->status) }}</td>
               
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
