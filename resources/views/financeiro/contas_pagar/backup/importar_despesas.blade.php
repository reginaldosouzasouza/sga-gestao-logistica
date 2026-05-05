@extends('layouts.app')

@section('title', 'Importar Despesas')

@section('content')
<div class="container">
    <h3 class="mb-4">Importar Despesas por Excel</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('contas-pagar.importacao.importar') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="arquivo" class="form-label">Arquivo Excel</label>
                    <input type="file" name="arquivo" id="arquivo" class="form-control" required>
                    @error('arquivo')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Importar
                </button>
            </form>
        </div>
    </div>

    @if(session('resultado_importacao'))
        @php $r = session('resultado_importacao'); @endphp

        <div class="card mt-4">
            <div class="card-header">
                Resultado da Importação
            </div>
            <div class="card-body">
                <ul class="mb-3">
                    <li><strong>Linhas lidas:</strong> {{ $r['lidas'] }}</li>
                    <li><strong>Linhas válidas:</strong> {{ $r['validas'] }}</li>
                    <li><strong>Importadas:</strong> {{ $r['importadas'] }}</li>
                    <li><strong>Duplicadas:</strong> {{ $r['duplicadas'] }}</li>
                    <li><strong>Ignoradas:</strong> {{ $r['ignoradas'] }}</li>
                </ul>

                @if(!empty($r['erros']))
                    <div class="alert alert-warning mb-0">
                        <strong>Ocorrências:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($r['erros'] as $erro)
                                <li>{{ $erro }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection