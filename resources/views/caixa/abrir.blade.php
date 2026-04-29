@extends('layouts.app')

@section('title', 'Caixa - Abertura')

@section('content')
<div class="container" style="max-width:600px">

    <h2>📂 Abertura de Caixa</h2>

    <div style="margin:20px 0; padding:15px; background:#f5f5f5; border-left:5px solid #0d6efd">
        <strong>Último fechamento:</strong><br>
        Data: {{ \Carbon\Carbon::parse($ultimoFechamento->data)->format('d/m/Y') }} <br>
        Saldo final: <strong>R$ {{ number_format($ultimoFechamento->saldo_final, 2, ',', '.') }}</strong>
    </div>

    <form method="POST" action="{{ route('caixa.abrir.confirmar') }}">
        @csrf

        <button class="btn btn-success">
            🔓 Abrir Caixa
        </button>

        <a href="{{ route('caixa.index') }}" class="btn btn-secondary">
            Cancelar
        </a>
    </form>

</div>
@endsection

