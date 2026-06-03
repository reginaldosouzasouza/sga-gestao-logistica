@extends('layouts.app')

@section('title', 'Importar Clientes')

@section('content')

<div class="container" style="max-width: 900px; margin-top: 30px;">

    <div style="background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">

        <h2 style="text-align: center; margin-bottom: 20px;">Importar Clientes</h2>

        <p>
            Use esta tela para importar clientes por arquivo CSV.
            O sistema vai gravar todos os clientes na empresa selecionada.
        </p>

        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <strong>Modelo de cabeçalho do CSV:</strong><br>
            <code>nome;telefone;cpf;endereco;numero;bairro;cidade;email;nascimento;observacao</code>
        </div>

        @if ($errors->any())
            <div style="background: #f8d7da; color: #842029; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <strong>Erros encontrados:</strong>
                <ul style="margin-bottom: 0;">
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div style="background: #d1e7dd; color: #0f5132; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if (session('resultado_importacao'))
            @php
                $resultado = session('resultado_importacao');
            @endphp

            <div style="background: #e7f1ff; color: #084298; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <strong>Resultado:</strong><br>
                Importados: {{ $resultado['importados'] ?? 0 }}<br>
                Atualizados: {{ $resultado['atualizados'] ?? 0 }}<br>
                Ignorados: {{ $resultado['ignorados'] ?? 0 }}

                @if (!empty($resultado['erros']))
                    <hr>
                    <strong>Observações:</strong>
                    <ul>
                        @foreach ($resultado['erros'] as $erro)
                            <li>{{ $erro }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endif

        <form action="{{ route('clientes.importar.processar') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if (auth()->user() && strtoupper(auth()->user()->tipo ?? '') === 'MASTER')
                <div style="margin-bottom: 15px;">
                    <label for="empresa_id"><strong>Empresa de destino</strong></label>
                    <select name="empresa_id" id="empresa_id" class="form-control" required>
                        <option value="">Selecione a empresa</option>
                        @foreach ($empresas as $empresa)
                            <option value="{{ $empresa->id }}">
                                {{ $empresa->id }} - {{ $empresa->nome_fantasia }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @else
                <input type="hidden" name="empresa_id" value="{{ auth()->user()->empresa_id }}">
            @endif

            <div style="margin-bottom: 15px;">
                <label for="arquivo"><strong>Arquivo CSV</strong></label>
                <input type="file" name="arquivo" id="arquivo" class="form-control" accept=".csv,.txt" required>
            </div>

            <div style="display: flex; gap: 10px; justify-content: center; margin-top: 25px;">
                <button type="submit" class="btn btn-primary">
                    Importar Clientes
                </button>

                <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                    Voltar
                </a>
            </div>
        </form>

    </div>

</div>

@endsection