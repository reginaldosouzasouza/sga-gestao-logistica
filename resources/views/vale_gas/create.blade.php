@extends('layouts.app')

@section('title', 'Cadastro Vale')

@section('content')

<style>
    body {
        background-color: #f5f7fb;
    }

    .vale-gas-page .titulo-pagina {
        font-weight: 700;
        color: #1f2937;
    }

    .vale-gas-page .card {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .vale-gas-page .card-header {
        background-color: #f8fafc;
        font-weight: 600;
        border-bottom: 1px solid #e5e7eb;
    }

    .vale-gas-page label {
        font-weight: 600;
        font-size: 14px;
    }
</style>

<div class="container mt-4 vale-gas-page">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0 titulo-pagina">Novo Vale</h3>
        <a href="{{ route('vale-gas.index') }}" class="btn btn-secondary">Voltar</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Verifique os erros abaixo:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            Dados do Vale
        </div>
        <div class="card-body">
            <form action="{{ route('vale-gas.store') }}" method="POST">
                @csrf

                @include('vale_gas._form')

                <div class="mt-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="{{ route('vale-gas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection