@extends('layouts.app')

@section('content')
<div class="container">
    <h2 style="color: purple;">Editar Ordem de Serviço</h2>

    <form action="{{ route('ordens-servico.update', $ordem->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Cliente:</label>
            <input type="text" name="cliente" class="form-control" value="{{ $ordem->cliente }}" required>
        </div>

        
        <div class="form-group">
            <label>Placa:</label>
            <input type="text" name="placa" class="form-control" value="{{ $ordem->placa }}">
        </div>

        <div class="form-group">
            <label>Serviço:</label>
            <input type="text" name="servico_realizado" class="form-control" value="{{ $ordem->servico_realizado }}" required>
        </div>

        <div class="form-group">
            <label>Valor:</label>
            <input type="number" step="0.01" name="valor" class="form-control" value="{{ $ordem->valor }}" required>
        </div>

        <div class="form-group">
            <label>Status:</label>
            <select name="status" class="form-control">
                <option value="Aberto" {{ $ordem->status == 'Aberto' ? 'selected' : '' }}>Aberto</option>
                <option value="Concluído" {{ $ordem->status == 'Concluído' ? 'selected' : '' }}>Concluído</option>
                <option value="Cancelado" {{ $ordem->status == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>
        </div>

        <div class="form-group">
            <label for="movimento">Movimentação O.S</label>
            <select name="movimento" id="movimento" class="form-control">
                <option value="Orçamento">Orçamento</option>
                <option value="Aguard. Aprovação">Aguard. Aprovação</option>
                <option value="Execução">Execução</option>
                <option value="Aguard. Peças">Aguard. Peças</option>
                <option value="Reparado">Reparado</option>
                <option value="Serviço Finalizado">Serviço Finalizado</option>
            </select>
        </div>


        <div class="form-group">
            <label>Observações:</label>
            <textarea name="observacoes" class="form-control" rows="3">{{ $ordem->observacoes }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Salvar Alterações</button>
        <a href="{{ route('ordens-servico.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
