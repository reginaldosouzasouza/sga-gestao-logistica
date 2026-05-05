@extends('layouts.app')

@section('title', 'Compras Cadastradas')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/compras.css') }}">
@endsection

@section('content')

<div class="compras-page">

    <h1>Compras Cadastradas</h1>

    <!-- Campo de Pesquisa -->
    <div class="search-bar">
        <form action="{{ route('compras.search') }}" method="GET">
            <input type="text" name="query" placeholder="Pesquise por Fornecedor">
            <button type="submit">Pesquisar</button>
        </form>
    </div>

    <!-- Botão de Cadastrar Compras -->
    <div class="header-button">
        <button onclick="window.location.href='{{ route('compras.create') }}'">
            Cadastrar Compras
        </button>
    </div>

    <!-- Tabela de Compras -->
    <div class="table-responsive">
        <table class="table tabela-compras">
            <thead>
                <tr>
                    <th>Data Compra</th>
                    <th>Fornecedor</th>
                    <th>Nota Fiscal</th>
                    <th>Preço Total</th>
                    <th>Parcela</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                @foreach($compras as $compra)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($compra->data_compra)->format('d/m/Y') }}</td>
                        <td>{{ optional($compra->fornecedor)->nome }}</td>
                        <td>{{ $compra->nota_fiscal }}</td>
                        <td>{{ number_format($compra->total, 2, ',', '.') }}</td>

                        <td>
                            @if($compra->contasAPagar->count() > 1)
                                {{ $compra->contasAPagar->count() }}x
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            <div class="btn-group-acoes">
                                <a href="{{ route('compras.edit', $compra->id) }}" class="btn btn-primary">
                                    Consultar/Alterar
                                </a>

                                <form action="{{ route('compras.destroy', $compra->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger">
                                        Excluir
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection