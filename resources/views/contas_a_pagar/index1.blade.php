@extends('layouts.app')

@section('title', 'Contas a Pagar')

@section('content')

<div class="container-fluid py-4">

    <!-- TÍTULO -->
    <div class="row mb-4">

        <div class="col-12">

            <div class="card shadow-sm">

                <div class="card-body text-center">

                    <h3 class="mb-0">Relação de Contas a Pagar</h3>

                </div>

            </div>

        </div>

    </div>


    <!-- FILTROS -->
    <div class="row mb-4">

        <div class="col-12">

            <div class="card shadow-sm">

                <div class="card-body">

                    <form method="GET" action="{{ route('contas-a-pagar.index') }}">

                        <div class="row">

                            <div class="col-md-3">
                                <label>Fornecedor</label>
                                <input type="text"
                                    name="fornecedor"
                                    class="form-control"
                                    value="{{ request('fornecedor') }}">
                            </div>

                            <div class="col-md-2">
                                <label>Status</label>

                                <select name="status" class="form-control">

                                    <option value="">Todos</option>

                                    <option value="pendente"
                                        {{ request('status') == 'pendente' ? 'selected' : '' }}>
                                        Pendente
                                    </option>

                                    <option value="atrasado"
                                        {{ request('status') == 'atrasado' ? 'selected' : '' }}>
                                        Atrasado
                                    </option>

                                    <option value="pago"
                                        {{ request('status') == 'pago' ? 'selected' : '' }}>
                                        Pago
                                    </option>

                                </select>

                            </div>

                            <div class="col-md-2">

                                <label>Forma de Pagamento</label>

                                <select name="forma_pagamento_id" class="form-control">

                                    <option value="">Todas</option>

                                    @foreach($formasPagamento as $forma)

                                        <option value="{{ $forma->id }}"
                                            {{ request('forma_pagamento_id') == $forma->id ? 'selected' : '' }}>
                                            {{ $forma->nome }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            <div class="col-md-2">
                                <label>Compra Inicial</label>
                                <input type="date"
                                    name="data_compra_inicial"
                                    class="form-control"
                                    value="{{ request('data_compra_inicial') }}">
                            </div>

                            <div class="col-md-2">
                                <label>Compra Final</label>
                                <input type="date"
                                    name="data_compra_final"
                                    class="form-control"
                                    value="{{ request('data_compra_final') }}">
                            </div>

                            <div class="col-md-1 d-flex align-items-end">

                                <button type="submit"
                                    class="btn btn-primary w-100">

                                    Filtrar

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>


    <!-- TOTALIZADOR -->
    <div class="row mb-4">

        <div class="col-md-6">

            <div class="card shadow-sm">

                <div class="card-body text-center">

                    <strong>Total de Registros:</strong>

                    <span class="text-primary">

                        {{ $contasAPagar->count() }}

                    </span>

                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card shadow-sm">

                <div class="card-body text-center">

                    <strong>Total de Faturas:</strong>

                    <span class="text-danger">

                        R$ {{ number_format($contasAPagar->sum('valor'), 2, ',', '.') }}

                    </span>

                </div>

            </div>

        </div>

    </div>


    <!-- TABELA -->
    <div class="row">

        <div class="col-12">

            <div class="card shadow-sm">

                <div class="card-body table-responsive">

                    <table class="table table-hover table-bordered">

                        <thead class="table-light">

                            <tr>

                                <th>ID</th>

                                <th>Fornecedor</th>

                                <th>Descrição</th>

                                <th>Valor</th>

                                <th>Vencimento</th>

                                <th>Pagamento</th>

                                <th>Status</th>

                                <th>Ações</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($contasAPagar as $conta)

                            <tr>

                                <td>{{ $conta->id }}</td>

                                <td>{{ $conta->fornecedor->nome ?? '' }}</td>

                                <td>{{ $conta->descricao }}</td>

                                <td>
                                    R$ {{ number_format($conta->valor, 2, ',', '.') }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($conta->data_vencimento)->format('d/m/Y') }}
                                </td>

                                <td>
                                    {{ $conta->data_pagamento
                                        ? \Carbon\Carbon::parse($conta->data_pagamento)->format('d/m/Y')
                                        : '-' }}
                                </td>

                                <td>

                                    @if($conta->status == 'pendente')

                                        <span class="badge bg-warning text-dark">
                                            Pendente
                                        </span>

                                    @elseif($conta->status == 'atrasado')

                                        <span class="badge bg-danger">
                                            Atrasado
                                        </span>

                                    @else

                                        <span class="badge bg-success">
                                            Pago
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <a href="{{ route('contas-a-pagar.edit', $conta->id) }}"
                                        class="btn btn-sm btn-primary">

                                        Editar

                                    </a>

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
