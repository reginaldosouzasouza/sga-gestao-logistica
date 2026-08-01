@extends('layouts.app')

@section('title', 'Rel. Contas A Receber')

@section('content')

<link rel="stylesheet" href="{{ asset('css/relcontasareceber.css') }}">

<div class="container relatorio-contas-receber">

    <h2>Relatório de Contas a Receber</h2>

    <form method="GET"
          action="{{ route('contas_a_receber.relatorio') }}"
          class="card-filtros">

        {{-- PRIMEIRA LINHA --}}
        <div class="row">

            <div class="col-md-5 campo-filtro">
                <label for="cliente">Cliente:</label>

                <input
                    type="text"
                    name="cliente"
                    id="cliente"
                    class="form-control"
                    placeholder="Nome do Cliente"
                    value="{{ request('cliente') }}"
                >
            </div>

            <div class="col-md-3 campo-filtro">
                <label for="status">Status:</label>

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
                        value="recebido"
                        {{ request('status') == 'recebido' ? 'selected' : '' }}
                    >
                        Recebido
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

            <div class="col-md-4">
                <div class="grupo-periodo">

                    <h4>Data de Emissão</h4>

                    <div class="row">

                        <div class="col-md-6 campo-filtro">
                            <label for="data_venda_inicial">
                                Inicial:
                            </label>

                            <input
                                type="date"
                                name="data_venda_inicial"
                                id="data_venda_inicial"
                                class="form-control"
                                value="{{ request('data_venda_inicial') }}"
                            >
                        </div>

                        <div class="col-md-6 campo-filtro">
                            <label for="data_venda_final">
                                Final:
                            </label>

                            <input
                                type="date"
                                name="data_venda_final"
                                id="data_venda_final"
                                class="form-control"
                                value="{{ request('data_venda_final') }}"
                            >
                        </div>

                    </div>

                </div>
            </div>

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

            <div class="col-md-4">
                <div class="grupo-periodo">

                    <h4>Data de Recebimento</h4>

                    <div class="row">

                        <div class="col-md-6 campo-filtro">
                            <label for="data_recebimento_inicial">
                                Inicial:
                            </label>

                            <input
                                type="date"
                                name="data_recebimento_inicial"
                                id="data_recebimento_inicial"
                                class="form-control"
                                value="{{ request('data_recebimento_inicial') }}"
                            >
                        </div>

                        <div class="col-md-6 campo-filtro">
                            <label for="data_recebimento_final">
                                Final:
                            </label>

                            <input
                                type="date"
                                name="data_recebimento_final"
                                id="data_recebimento_final"
                                class="form-control"
                                value="{{ request('data_recebimento_final') }}"
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
                href="{{ route('contas_a_receber.relatorio') }}"
                class="btn btn-secondary"
            >
                Limpar
            </a>

            <a
                href="{{ route('contas_a_receber.exportar', request()->query()) }}"
                class="btn btn-success"
            >
                📥 Exportar CSV
            </a>

        </div>

    </form>

    <hr>

    <div class="resumo-relatorio">

        <div class="resumo-item">
            <span>Total de Registros</span>
            <strong>{{ $contas->count() }}</strong>
        </div>

        <div class="resumo-item">
            <span>Total a Receber</span>
            <strong>
                R$ {{ number_format($total_faturas, 2, ',', '.') }}
            </strong>
        </div>

    </div>

    <div class="tabela-responsiva">

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

                @forelse($contas as $conta)

                    <tr>
                        <td>
                            {{ $conta->cliente->nome ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $conta->formaPagamento->nome ?? '-' }}
                        </td>

                        <td>
                            <strong>
                                {{ number_format($conta->valor, 2, ',', '.') }}
                            </strong>
                        </td>

                        <td>
                            {{ $conta->data_venda
                                ? date('d/m/Y', strtotime($conta->data_venda))
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
                            {{ $conta->data_recebimento
                                ? date('d/m/Y', strtotime($conta->data_recebimento))
                                : '-'
                            }}
                        </td>

                        <td>
                            {{ ucfirst($conta->status) }}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="text-center">
                            Nenhum registro encontrado para os filtros informados.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection