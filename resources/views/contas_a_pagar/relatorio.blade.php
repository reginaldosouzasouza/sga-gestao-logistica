@extends('layouts.app')

@section('title', 'Rel. Contas A Pagar')

@section('content')

<link rel="stylesheet" href="{{ asset('css/relcontasapagar.css') }}">

<div class="container relatorio-contas-pagar">

    <h2>Relatório de Contas a Pagar</h2>

    <form
        method="GET"
        action="{{ route('contas-a-pagar.relatorio') }}"
        class="card-filtros"
    >

        {{-- PRIMEIRA LINHA --}}
        <div class="row">

            <div class="col-md-5 campo-filtro">
                <label for="fornecedor">
                    Fornecedor:
                </label>

                <input
                    type="text"
                    name="fornecedor"
                    id="fornecedor"
                    class="form-control"
                    placeholder="Nome do Fornecedor"
                    value="{{ request('fornecedor') }}"
                >
            </div>

            <div class="col-md-3 campo-filtro">
                <label for="status">
                    Status:
                </label>

                <select
                    name="status"
                    id="status"
                    class="form-control"
                >
                    <option value="">Todos</option>

                    <option
                        value="pendente"
                        {{ request('status') == 'pendente' ? 'selected' : '' }}
                    >
                        Pendente
                    </option>

                    <option
                        value="pago"
                        {{ request('status') == 'pago' ? 'selected' : '' }}
                    >
                        Pago
                    </option>

                    <option
                        value="atrasado"
                        {{ request('status') == 'atrasado' ? 'selected' : '' }}
                    >
                        Atrasado
                    </option>
                </select>
            </div>

            <div class="col-md-4 campo-filtro">
                <label for="forma_pagamento_id">
                    Forma de Pagamento:
                </label>

                <select
                    name="forma_pagamento_id"
                    id="forma_pagamento_id"
                    class="form-control"
                >
                    <option value="">Todas</option>

                    @foreach($formasDePagamento as $forma)
                        <option
                            value="{{ $forma->id }}"
                            {{ request('forma_pagamento_id') == $forma->id ? 'selected' : '' }}
                        >
                            {{ $forma->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        {{-- SEGUNDA LINHA --}}
        <div class="row linha-periodos">

            {{-- DATA DA COMPRA --}}
            <div class="col-md-4">
                <div class="grupo-periodo">

                    <h4>Data da Compra</h4>

                    <div class="row">

                        <div class="col-md-6 campo-filtro">
                            <label for="data_compra_inicial">
                                Inicial:
                            </label>

                            <input
                                type="date"
                                name="data_compra_inicial"
                                id="data_compra_inicial"
                                class="form-control"
                                value="{{ request('data_compra_inicial') }}"
                            >
                        </div>

                        <div class="col-md-6 campo-filtro">
                            <label for="data_compra_final">
                                Final:
                            </label>

                            <input
                                type="date"
                                name="data_compra_final"
                                id="data_compra_final"
                                class="form-control"
                                value="{{ request('data_compra_final') }}"
                            >
                        </div>

                    </div>

                </div>
            </div>

            {{-- DATA DE VENCIMENTO --}}
            <div class="col-md-4">
                <div class="grupo-periodo">

                    <h4>Data de Vencimento</h4>

                    <div class="row">

                        <div class="col-md-6 campo-filtro">
                            <label for="data_vencimento_inicial">
                                Inicial:
                            </label>

                            <input
                                type="date"
                                name="data_vencimento_inicial"
                                id="data_vencimento_inicial"
                                class="form-control"
                                value="{{ request('data_vencimento_inicial') }}"
                            >
                        </div>

                        <div class="col-md-6 campo-filtro">
                            <label for="data_vencimento_final">
                                Final:
                            </label>

                            <input
                                type="date"
                                name="data_vencimento_final"
                                id="data_vencimento_final"
                                class="form-control"
                                value="{{ request('data_vencimento_final') }}"
                            >
                        </div>

                    </div>

                </div>
            </div>

            {{-- DATA DE PAGAMENTO --}}
            <div class="col-md-4">
                <div class="grupo-periodo">

                    <h4>Data de Pagamento</h4>

                    <div class="row">

                        <div class="col-md-6 campo-filtro">
                            <label for="data_pagamento_inicial">
                                Inicial:
                            </label>

                            <input
                                type="date"
                                name="data_pagamento_inicial"
                                id="data_pagamento_inicial"
                                class="form-control"
                                value="{{ request('data_pagamento_inicial') }}"
                            >
                        </div>

                        <div class="col-md-6 campo-filtro">
                            <label for="data_pagamento_final">
                                Final:
                            </label>

                            <input
                                type="date"
                                name="data_pagamento_final"
                                id="data_pagamento_final"
                                class="form-control"
                                value="{{ request('data_pagamento_final') }}"
                            >
                        </div>

                    </div>

                </div>
            </div>

        </div>

        {{-- BOTÕES --}}
        <div class="acoes-filtros">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Filtrar
            </button>

            <a
                href="{{ route('contas-a-pagar.relatorio') }}"
                class="btn btn-secondary"
            >
                Limpar
            </a>

            <a
                href="{{ route('contas-a-pagar.exportar', request()->query()) }}"
                class="btn btn-success"
            >
                📥 Exportar Excel
            </a>

        </div>

    </form>

    <hr>

    {{-- RESUMO --}}
    <div class="resumo-relatorio">

        <div class="resumo-item">
            <span>Total de Registros</span>

            <strong>
                {{ $contas->count() }}
            </strong>
        </div>

        <div class="resumo-item">
            <span>Total de Faturas</span>

            <strong>
                R$ {{ number_format($total_faturas, 2, ',', '.') }}
            </strong>
        </div>

    </div>

    {{-- TABELA --}}
    <div class="tabela-responsiva">

        <table class="table table-bordered">

            <thead>
                <tr>
                    <th>Fornecedor</th>
                    <th>Forma de Pagamento</th>
                    <th>Valor (R$)</th>
                    <th>Data de Emissão</th>
                    <th>Data da Compra</th>
                    <th>Data de Vencimento</th>
                    <th>Data de Pagamento</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                @forelse($contas as $conta)

                    <tr>

                        <td>
                            {{ $conta->fornecedor->nome ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $conta->formaPagamento->nome ?? 'Sem forma de pagamento' }}
                        </td>

                        <td>
                            <strong>
                                {{ number_format($conta->valor, 2, ',', '.') }}
                            </strong>
                        </td>

                        <td>
                            {{ $conta->created_at
                                ? date('d/m/Y', strtotime($conta->created_at))
                                : '-'
                            }}
                        </td>

                        <td>
                            {{ $conta->data_compra
                                ? date('d/m/Y', strtotime($conta->data_compra))
                                : '-'
                            }}
                        </td>

                        <td>
                            {{ $conta->data_vencimento
                                ? date('d/m/Y', strtotime($conta->data_vencimento))
                                : '-'
                            }}
                        </td>

                        <td>
                            {{ $conta->data_pagamento
                                ? date('d/m/Y', strtotime($conta->data_pagamento))
                                : '-'
                            }}
                        </td>

                        <td>
                            {{ ucfirst($conta->status) }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="8" class="text-center">
                            Nenhum registro encontrado para os filtros informados.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection