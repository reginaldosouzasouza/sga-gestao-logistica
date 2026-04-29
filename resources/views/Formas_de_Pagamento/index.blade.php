@extends('layouts.app')

@section('title', 'Formas de Pagamento')

@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formas de Pgamento</title>
    <link rel="stylesheet" href="{{ asset('css/formadepagamento.css') }}">
</head>


    <div class="container">
        <h1>Formas de Pagamento</h1>
        <a href="{{ route('formas_de_pagamento.create') }}" class="actions">Cadastrar Forma de Pagamento</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($formasDePagamento as $forma)
                    <tr>
                        <td>{{ $forma->id }}</td>

                        <td>{{ $forma->nome }}</td>
                        <td>
                            <a href="{{ route('formas_de_pagamento.edit', $forma->id) }}" class="btn-consultar">Consultar/Editar</a>
                            <form action="{{ route('formas_de_pagamento.destroy', $forma->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-excluir">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
