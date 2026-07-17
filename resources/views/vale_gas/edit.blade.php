@extends('layouts.app')

@section('title', 'Alteração - Vale GÁS')

@section('content')

<style>
    body {
        background-color: #f5f7fb;
    }

    .vale-gas-page .topo-pagina {
        margin-bottom: 24px;
    }

    .vale-gas-page .titulo-pagina {
        font-weight: 700;
        color: #1f2937;
        font-size: 2rem;
        line-height: 1.2;
        margin-bottom: 4px;
    }

    .vale-gas-page .subtitulo-pagina {
        color: #6b7280;
        font-size: 0.95rem;
        margin: 0;
    }

    .vale-gas-page .card-principal {
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        overflow: hidden;
    }

    .vale-gas-page .card-header-custom {
        background-color: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
        padding: 16px 20px;
        font-size: 1.1rem;
        font-weight: 700;
        color: #1f2937;
    }

    .vale-gas-page .card-body-custom {
        padding: 24px;
    }

    .vale-gas-page .form-label {
        font-size: 13px;
        font-weight: 700;
        color: #374151;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .vale-gas-page .form-control,
    .vale-gas-page .form-select,
    .vale-gas-page textarea {
        border-radius: 10px;
        min-height: 44px;
        border: 1px solid #d1d5db;
    }

    .vale-gas-page textarea {
        min-height: 110px;
    }

    .vale-gas-page .form-control:focus,
    .vale-gas-page .form-select:focus,
    .vale-gas-page textarea:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }

    .vale-gas-page .campo-readonly {
        background-color: #f8fafc;
        font-weight: 600;
    }

    .vale-gas-page .bloco-acoes {
        margin-top: 24px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
</style>

<div class="container-fluid mt-4 vale-gas-page">
    <div class="d-flex justify-content-between align-items-center topo-pagina">
        <div>
            <h1 class="titulo-pagina">Editar Vale</h1>
            <p class="subtitulo-pagina">Atualize os dados do vale selecionado</p>
        </div>

        <a href="{{ route('vale-gas.index') }}" class="btn btn-secondary">
            Voltar
        </a>
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

    <div class="card-principal">
        <div class="card-header-custom">
            Alteração do Vale
        </div>

        <div class="card-body-custom">
            <form action="{{ route('vale-gas.update', $vale->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Código</label>
                        <input type="text" class="form-control campo-readonly" value="{{ $vale->codigo ?? 'Gerado automaticamente' }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Cliente *</label>
                        <select name="cliente_id" class="form-select" required>
                            <option value="">Selecione</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}"
                                    {{ old('cliente_id', $vale->cliente_id ?? '') == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Data do Vale *</label>
                        <input type="date" name="data_vale" class="form-control"
                            value="{{ old('data_vale', isset($vale) ? $vale->data_vale->format('Y-m-d') : date('Y-m-d')) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Produto *</label>
                        <select name="produto_id" class="form-select" required>
                            <option value="">Selecione</option>
                            @foreach($produtos as $produto)
                                <option value="{{ $produto->id }}"
                                    {{ old('produto_id', $vale->produto_id ?? '') == $produto->id ? 'selected' : '' }}>
                                    {{ $produto->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Quantidade *</label>
                        <input type="number" step="1" min="1" name="quantidade" class="form-control"
                            value="{{ old('quantidade', $vale->quantidade ?? 1) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Valor Pago *</label>
                        <input type="number" step="0.01" min="0" name="valor_pago" class="form-control"
                            value="{{ old('valor_pago', $vale->valor_pago ?? 0) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Forma de Pagamento</label>
                        <select name="forma_pagamento_id" class="form-select">
                            <option value="">Selecione</option>
                            @foreach($formasPagamento as $forma)
                                <option value="{{ $forma->id }}"
                                    {{ old('forma_pagamento_id', $vale->forma_pagamento_id ?? '') == $forma->id ? 'selected' : '' }}>
                                    {{ $forma->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Observação</label>
                        <textarea name="observacao" class="form-control" rows="4">{{ old('observacao', $vale->observacao ?? '') }}</textarea>
                    </div>
                </div>

                <div class="bloco-acoes">
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                    <a href="{{ route('vale-gas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection