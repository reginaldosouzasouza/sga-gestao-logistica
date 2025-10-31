@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Novo Item da Ordem de Serviço</h2>

    <form action="{{ route('ordem_servico_itens.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="ordem_servico_id">Ordem de Serviço</label>
            <select name="ordem_servico_id" class="form-control">
                @foreach($ordens as $ordem)
                    <option value="{{ $ordem->id }}">{{ $ordem->id }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="produto_id">Produto</label>
            <select name="produto_id" class="form-control">
                @foreach($produtos as $produto)
                    <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="quantidade">Quantidade</label>
            <input type="number" name="quantidade" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="valor_unitario">Valor Unitário</label>
            <input type="text" name="valor_unitario" class="form-control" required>
        </div>

       <!-- Forma de Pagamento -->
        <div class="form-group">
            <label for="forma_pagamento_id">Forma de Pagamento</label>
            <select name="forma_pagamento_id" id="forma_pagamento_id" class="form-control" required>
                <option value="">Selecione</option>
                @foreach($formasPagamento as $forma)
                    <option value="{{ $forma->id }}">{{ $forma->descricao }}</option>
                @endforeach
            </select>
        </div>

        <!-- Prazo -->
        <div class="form-group">
            <label for="prazo_id">Prazo</label>
            <select name="prazo_id" id="prazo_id" class="form-control" required>
                <option value="">Selecione</option>
                @foreach($prazos as $prazo)
                    <option value="{{ $prazo->id }}">{{ $prazo->dias }} dias</option>
                @endforeach
            </select>
        </div>



        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const quantidade = document.querySelector('input[name="quantidade"]');
        const valorUnitario = document.querySelector('input[name="valor_unitario"]');
        const form = document.querySelector('form');

        form.addEventListener('submit', function (e) {
            const totalInput = document.createElement('input');
            totalInput.type = 'hidden';
            totalInput.name = 'valor_total';
            totalInput.value = parseFloat(quantidade.value || 0) * parseFloat(valorUnitario.value || 0);
            form.appendChild(totalInput);
        });
    });
</script>

