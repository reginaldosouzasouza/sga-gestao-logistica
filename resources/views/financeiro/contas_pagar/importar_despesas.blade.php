@extends('layouts.app')

@section('title', 'Importar Despesas')

@section('content')
<div class="container">
    <h1 class="mb-4">Importar Despesas por Excel</h1><br>

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
                        <br>
                           <strong>clique -></strong>
                        <button type="submit" class="btn btn-primary">
                            Importar
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <br>
        <!-- LADO DIREITO: INSTRUÇÕES DE IMPORTAÇÃO -->
        <div class="col-md-6">
            <div class="card">
               

                <div class="card-body">
                    <div class="alert alert-info mb-0">
                        <h1 class="fw-bold">Instruções para importação</h1>

                        <p class="mb-2">
                            Para importar as despesas, selecione um arquivo Excel contendo os dados do mês.
                        </p>
                        <br>
                        <ul class="mb-0">
                             <li>Gerar o arquivo de despesas no sistema<strong> Relatórios -> Caixa -> Relatório de Movimentação de Caixa</strong>.</li><br>
                              <li>OBS: se houver necessidade de alterar aruqivo <strong>NÃO ESQUECER DE SALVAR COMO .XLS</strong>.</li><br>
                            <li>Clique em <strong>Escolher arquivo</strong>.</li><br>
                            <li>Selecione o arquivo Excel das despesas.</li><br>
                            <li>Confira se o arquivo possui as colunas corretas.</li><br>
                            <li>Clique em <strong>Importar</strong>.</li><br>
                            <li>Após a importação, confira o resultado exibido abaixo.</li><br>
                            <li>Verifique se houve despesas duplicadas, ignoradas ou com erro.</li>
                        </ul>

                        
                         <br>   
                        <p class="mb-0">
                            <h2>Observação:</h2>
                            Evite importar o mesmo arquivo mais de uma vez para não gerar despesas duplicadas.
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