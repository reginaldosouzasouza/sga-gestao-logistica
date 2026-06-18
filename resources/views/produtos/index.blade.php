@extends('layouts.app')

@section('title', 'Lista de Produtos')

@section('styles')
    <link href="{{ asset('css/produtos.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="produtos-page">
    <div class="container-produtos">
        <h1>Lista de Produtos</h1>

        <div class="actions">
            <a href="{{ route('produtos.create') }}" class="btn btn-success mb-3">
                Cadastrar Produtos
            </a>
        </div>

        <form action="{{ route('produtos.index') }}" method="GET" class="mb-4 form-pesquisa-produtos">
            <div class="search-container">
                <input 
                    type="text" 
                    name="search" 
                    class="form-control" 
                    placeholder="Pesquisar produtos" 
                    value="{{ request()->get('search') }}"
                >
                <button type="submit" class="btn btn-primary">
                    Pesquisar
                </button>
            </div>
        </form>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive produtos-table-wrapper">
            <table class="table table-bordered tabela-produtos">
                <thead>
                    <tr>
                        <th class="col-modulo">Módulo</th>
                        <th>Nome</th>
                        <th class="col-descricao">Descrição</th>
                        <th>Preço de Compra</th>
                        <th>Preço de Venda</th>
                        <th>Estoque</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($produtos as $produto)
                        <tr>
                            <td data-label="Módulo" class="col-modulo">
                                {{ $produto->modulo->descricao ?? '-' }}
                            </td>

                            <td data-label="Nome">
                                {{ $produto->nome }}
                            </td>

                            <td data-label="Descrição" class="col-descricao">
                                {{ $produto->descricao }}
                            </td>

                            <td data-label="Preço de Compra">
                                {{ $produto->preco_compra }}
                            </td>

                            <td data-label="Preço de Venda">
                                {{ $produto->preco_venda }}
                            </td>

                            <td data-label="Estoque">
                                {{ $produto->quantidade_estoque }}
                            </td>

                            <td data-label="Ações" class="acoes-produto">
                                <a href="{{ route('produtos.edit', $produto->id) }}" class="btn-consultar">
                                    Consultar/Alterar
                                </a>

                                <form action="{{ route('produtos.destroy', $produto->id) }}" method="POST" class="form-excluir-produto">
                                    @csrf
                                    @method('DELETE')

                                    <button 
                                        type="submit" 
                                        class="btn-excluir"
                                        onclick="return confirm('Tem certeza que deseja excluir este produto?')"
                                    >
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
