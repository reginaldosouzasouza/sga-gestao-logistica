@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Forma de Pagamento</h1>

    <form action="{{ route('formas_de_pagamento.update', $forma_pagamento->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nome">Nome da Forma de Pagamento</label>
            <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome', $forma_pagamento->nome) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
</div>
@endsection
