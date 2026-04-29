@extends('layouts.app')

@section('title', 'Caixa Fechado')

@section('content')
<div class="container py-5">

    <div class="alert alert-danger text-center shadow-lg">
        <h2 class="mb-2">🔒 Caixa Fechado</h2>
        <p class="mb-0">
            Data: <strong>{{ \Carbon\Carbon::parse($dataAtual)->format('d/m/Y') }}</strong>
        </p>
    </div>

    <div class="card shadow mt-4">
        <div class="card-body text-center">

            <p class="fs-5 text-danger fw-bold">
                {{ $mensagem ?? 'Este caixa já foi encerrado e não permite novos lançamentos.' }}
            </p>

            <hr>

            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('caixa.consultas') }}" class="btn btn-outline-primary">
                    📊 Histórico de Caixas
                </a>

                <a href="{{ route('caixa.consultas') }}" class="btn btn-secondary">
                         ⬅ Voltar ao Histórico de Caixas
                </a>

            </div>

        </div>
    </div>

</div>
@endsection
