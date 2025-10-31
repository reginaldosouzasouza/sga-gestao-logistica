@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Estoque Total de Produtos</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade em Estoque</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produtos as $produto)
            <tr>
                <td>{{ $produto->nome }}</td>
                <td>{{ $produto->quantidade_estoque }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
