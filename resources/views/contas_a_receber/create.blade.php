@extends('layouts.app')

@section('title', 'Cirar Contas a Receber')

@section('content')
<div class="container">
    <h1>Criar Conta a Receber</h1>

    <!-- Exibir mensagens de erro -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('contas_a_receber.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="cliente_id">Cliente</label>
            <select name="cliente_id" class="form-control" required>
                <option value="">Selecione um Cliente</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                @endforeach
            </select>
        </div>
        <br>

        <div class="form-group">
            <label for="descricao">Descrição</label>
            <input type="text" name="descricao" class="form-control" value="{{ old('descricao') }}" required>
        </div>
        <br>
        <div class="form-group">
            <label for="valor">Valor</label>
            <input type="number" name="valor" class="form-control" value="{{ old('valor') }}" required step="0.01">
        </div>
          <br>

        <div class="form-group">
            <label for="data_venda">Data da Venda</label>
            <input type="date" name="data_venda" id="data_venda" class="form-control" value="{{ old('data_venda', $contaAReceber->data_venda ?? now()->format('Y-m-d')) }}">
        </div>
        <br>

        
        <div class="form-group">
            <label for="data_vencimento">Data de Vencimento</label>
            <input type="date" name="data_vencimento" class="form-control" value="{{ old('data_vencimento') }}" required>
        </div>
          <br>

        

        <div class="form-group">
            <label for="forma_pagamento_id">Forma de Pagamento</label>
            <select name="forma_pagamento_id" class="form-control" required>
                <option value="">Selecione a Forma de Pagamento</option>
                @foreach($formasDePagamento as $forma)
                    <option value="{{ $forma->id }}">{{ $forma->nome }}</option>
                @endforeach
            </select>
        </div>
          

        <div class="form-group">
            <label for="prazo">Prazo</label>
            <select name="prazo" class="form-control">
                @foreach($prazos as $prazo)
                    <option value="{{ $prazo->prazo }}" {{ old('prazo', $contaAReceber->prazo ?? '') == $prazo->prazo ? 'selected' : '' }}>
                        {{ $prazo->prazo }}
                    </option>
                @endforeach
            </select>
        </div>
        

        <div class="form-group">
            <label for="observacao">Observação</label>
            <textarea name="observacao" class="form-control">{{ old('observacao') }}</textarea>
        </div>
          <br>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="{{ route('contas_a_receber.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script>
document.querySelectorAll('input[type="date"]').forEach(function (campo) {
    campo.addEventListener('click', function () {
        if (this.showPicker) {
            this.showPicker();
        }
    });
});
</script>


@endsection
