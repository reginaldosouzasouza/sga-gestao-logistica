@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Conta a Receber</h1>

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

    <form method="POST"
          action="{{ route('contas_a_receber.update', $contaAReceber->id) . '?' . http_build_query(request()->query()) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="cliente_id">Cliente</label>
            <select name="cliente_id" class="form-control" required>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ $cliente->id == $contaAReceber->cliente_id ? 'selected' : '' }}>
                        {{ $cliente->nome }}
                    </option>
                @endforeach
            </select>
        </div>
          <br>

        <div class="form-group">
            <label for="descricao">Descrição</label>
            <input type="text" name="descricao" class="form-control"
                   value="{{ $contaAReceber->descricao }}" required>
        </div>
          <br>

        <div class="form-group">
            <label for="valor">Valor</label>
            <input type="number" name="valor" class="form-control"
                   value="{{ $contaAReceber->valor }}" required step="0.01">
        </div>
          <br>

        <div class="form-group">
            <label for="data_venda">Data de Venda</label>
            <input type="date" name="data_venda" class="form-control"
                   value="{{ old('data_venda', $contaAReceber->data_venda ?? now()->format('Y-m-d')) }}">
        </div>
          <br>

        <div class="form-group">
            <label for="data_vencimento">Data de Vencimento</label>
            <input type="date" name="data_vencimento" class="form-control"
                   value="{{ $contaAReceber->data_vencimento }}" required>
        </div>
          <br>

        <div class="form-group">
            <label for="data_recebimento">Data de Recebimento</label>
            <input type="date" name="data_recebimento" class="form-control"
                   value="{{ $contaAReceber->data_recebimento }}">
        </div>
          <br>

        <div class="form-group">
            <label for="forma_pagamento_id">Forma de Pagamento</label>
            <select name="forma_pagamento_id" class="form-control" required>
                @foreach($formasDePagamento as $forma)
                    <option value="{{ $forma->id }}" {{ $forma->id == $contaAReceber->forma_pagamento_id ? 'selected' : '' }}>
                        {{ $forma->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="prazo">Prazo</label>
            <select name="prazo" class="form-control">
                @foreach($prazos as $prazo)
                    <option value="{{ $prazo->id }}"
                        {{ old('prazo', $contaAReceber->prazo ?? '') == $prazo->id ? 'selected' : '' }}>
                        {{ $prazo->prazo }}
                    </option>
                @endforeach
            </select>
        </div>
          <br>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" class="form-control">
                <option value="pendente" {{ $contaAReceber->status == 'pendente' ? 'selected' : '' }}>Pendente</option>
                <option value="recebido" {{ $contaAReceber->status == 'recebido' ? 'selected' : '' }}>Recebido</option>
                <option value="atrasado" {{ $contaAReceber->status == 'atrasado' ? 'selected' : '' }}>Atrasado</option>
            </select>
        </div>

        <div class="form-group">
            <label for="observacao">Observação</label>
            <textarea name="observacao" class="form-control">{{ $contaAReceber->observacao }}</textarea>
        </div>
          <br>

        <button type="submit" class="btn btn-success">Salvar Alterações</button>

        <!-- Cancelar mantendo filtros -->
        <a href="{{ route('contas_a_receber.index') . '?' . http_build_query(request()->query()) }}"
           class="btn btn-secondary">
            Cancelar
        </a>
    </form>
</div>
@endsection