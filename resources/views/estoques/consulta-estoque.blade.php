@extends('layouts.app')

@section('title', 'Consulta de Estoque')

@section('content')
    <div class="container">
        <h1>Consulta de Estoque</h1>

        <!-- Formulário de busca -->
        <form action="{{ route('estoques.consulta') }}" method="GET">
            <input type="text" name="search" placeholder="Buscar por produto" value="{{ request('search') }}">
            <button type="submit">Pesquisar</button>
        </form>

        <!-- Tabela de consulta de estoque -->
        <table class="table">
            <thead>
                <tr>
                    <th>Nome do Produto</th>
                    <th>Quantidade em Estoque</th>
                    <th>Última Atualização</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($produtos as $produto)
                    <tr>
                        <td>{{ $produto->nome }}</td>
                        <td>{{ $produto->quantidade_estoque }}</td>
                        <td>{{ $produto->updated_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">Nenhum produto encontrado</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection