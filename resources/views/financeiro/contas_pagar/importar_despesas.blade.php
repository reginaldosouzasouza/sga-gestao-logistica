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

    <div class="row">
        <!-- LADO ESQUERDO: FORMULÁRIO DE IMPORTAÇÃO -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Importar Arquivo Excel
                </div>

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
        </div>

        <!-- LADO DIREITO: INSTRUÇÕES DE IMPORTAÇÃO -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Como importar as despesas
                </div>

                <div class="card-body">
                    <div class="alert alert-info mb-0">
                        <h6 class="fw-bold">Instruções para importação</h6>

                        <p class="mb-2">
                            Para importar as despesas, selecione um arquivo Excel contendo os dados do mês.
                        </p>

                        <ul class="mb-0">
                             <li>Gerar o arquivo de despesas no sistema<strong> Relatórios -> Caixa -> Relatório de Movimentação de Caixa</strong>.</li>
                              <li>OBS: se houver necessidade de alterar aruqivo <strong>NÃO ESQUECER DE SALVAR COMO .XLS</strong>.</li>
                            <li>Clique em <strong>Escolher arquivo</strong>.</li>
                            <li>Selecione o arquivo Excel das despesas.</li>
                            <li>Confira se o arquivo possui as colunas corretas.</li>
                            <li>Clique em <strong>Importar</strong>.</li>
                            <li>Após a importação, confira o resultado exibido abaixo.</li>
                            <li>Verifique se houve despesas duplicadas, ignoradas ou com erro.</li>
                        </ul>

                        <hr>

                        <p class="mb-0">
                            <strong>Observação:</strong>
                            evite importar o mesmo arquivo mais de uma vez para não gerar despesas duplicadas.
                        </p>
                    </div>
                </div>
            </div>
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