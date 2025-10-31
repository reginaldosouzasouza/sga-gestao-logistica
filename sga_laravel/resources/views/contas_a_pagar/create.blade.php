@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Adicionar Conta a Pagar</h1>
        <form action="{{ route('contas_a_pagar.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="fornecedor_id">Fornecedor</label>
                <select name="fornecedor_id" class="form-control" required>
                    @foreach ($fornecedores as $fornecedor)
                        <option value="{{ $fornecedor->id }}">{{ $fornecedor->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <input type="text" name="descricao" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="valor">Valor</label>
                <input type="number" step="0.01" name="valor" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="data_compra">Data de Compra</label>
                <input type="date" name="data_compra" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="prazo">Prazo:</label>
                <select name="prazo" id="prazo" class="form-control" required>
                    @foreach ($prazos as $prazo)
                        <option value="{{ $prazo->id }}">{{ $prazo->prazo }}</option>
                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <label for="forma_pagamento_id">Forma de Pagamento</label>
                <select name="forma_pagamento_id" class="form-control" required>
                    @foreach ($formasDePagamento as $forma)
                        <option value="{{ $forma->id }}">{{ $forma->nome }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
@endsection
