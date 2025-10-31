@extends('layouts.app')

@section('title', 'Relatório de Estoque Atual')

@section('content')

<link rel="stylesheet" href="{{ asset('css/relatorio-estoque.css') }}">

<div class="container">
    <h1>Relatório de Estoque Atual</h1>

    <!-- Botão para gerar PDF 
    <a href="{{ route('relatorio.estoque.pdf') }}" class="btn btn-primary" target="_blank">Gerar PDF</a> -->
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>
                    <a href="{{ route('estoques.relatorio', ['sort' => 'nome', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                        Nome do Produto
                        @if(request('sort') == 'nome')
                            @if(request('direction') == 'asc')
                                ▲
                            @else
                                ▼
                            @endif
                        @endif
                    </a>
                </th>
                <th>
                    <a href="{{ route('estoques.relatorio', ['sort' => 'quantidade_estoque', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                        Quantidade em Estoque
                        @if(request('sort') == 'quantidade_estoque')
                            @if(request('direction') == 'asc')
                                ▲
                            @else
                                ▼
                            @endif
                        @endif
                    </a>
                </th>
                <th>
                    <a href="{{ route('estoques.relatorio', ['sort' => 'updated_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                        Última Atualização
                        @if(request('sort') == 'updated_at')
                            @if(request('direction') == 'asc')
                                ▲
                            @else
                                ▼
                            @endif
                        @endif
                    </a>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($produtos as $produto)
                <tr>
                    <td>{{ $produto->nome }}</td>
                    <td>{{ $produto->quantidade_estoque }}</td>
                    <td>{{ $produto->updated_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

