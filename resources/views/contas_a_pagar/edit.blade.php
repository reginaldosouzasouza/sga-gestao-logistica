@extends('layouts.app')  <!-- Substitua com o layout que você está usando -->

@section('content')
<div class="container">
    <h1>Editar Conta a Pagar</h1>

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

    <!-- Formulário para editar a conta a pagar -->
    <form action="{{ route('contas_a_pagar.update', $contaAPagar->id) }}" method="POST">
        @csrf
        @method('PUT')


        <input type="hidden"
       name="return_url"
       value="{{ url()->previous() }}">


        <div class="form-group">
            <label for="fornecedor_id">Fornecedor</label>
            <select name="fornecedor_id" class="form-control" required>
                @foreach ($fornecedores as $fornecedor)
                    <option value="{{ $fornecedor->id }}" {{ $fornecedor->id == $contaAPagar->fornecedor_id ? 'selected' : '' }}>
                        {{ $fornecedor->nome }}
                    </option>
                @endforeach
            </select>
        </div>
          <br>

        <div class="form-group">
            <label for="descricao">Descrição</label>
            <input type="text" name="descricao" class="form-control" value="{{ old('descricao', $contaAPagar->descricao) }}" required>
        </div>
          <br>

        <div class="form-group">
            <label for="valor">Valor</label>
            <input type="number" name="valor" class="form-control" value="{{ old('valor', $contaAPagar->valor) }}" required step="0.01">
        </div>
          <br>

        <div class="form-group">
            <label for="data_vencimento">Data de Vencimento</label>
            <input type="date" name="data_vencimento" class="form-control" 
            value="{{ old('data_vencimento', $contaAPagar->data_vencimento ? \Carbon\Carbon::parse($contaAPagar->data_vencimento)->format('Y-m-d') : '') }}" 
            required>
        </div>
          <br>

        <div class="form-group">
            <label for="forma_pagamento_id">Forma de Pagamento</label>
            <select name="forma_pagamento_id" class="form-control" required>
                @foreach ($formas_pagamento as $forma)
                    <option value="{{ $forma->id }}" {{ $forma->id == $contaAPagar->forma_pagamento_id ? 'selected' : '' }}>
                        {{ $forma->nome }}
                    </option>
                @endforeach
            </select>
        </div>
          <br>

        
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" class="form-control" required>
                <option value="pendente" {{ $contaAPagar->status == 'pendente' ? 'selected' : '' }}>Pendente</option>
                <option value="pago" {{ $contaAPagar->status == 'pago' ? 'selected' : '' }}>Pago</option>
                <option value="atrasado" {{ $contaAPagar->status == 'atrasado' ? 'selected' : '' }}>Atrasado</option>
            </select>
        </div>
          <br>

        <div class="form-group">
            <label for="data_pagamento">Data Pagamento</label>
            <input type="date" name="data_pagamento" class="form-control" value="{{ old('data_pagamento', $contaAPagar->data_pagamento) }}">
        </div>
          <br>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="{{ route('contas_a_pagar.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
