@extends('layouts.app')
@section('title', 'Lista Ordens de Serviços')

@section('content')
<div class="container">
    <h2 style="color: purple;">Lista de Ordens de Serviço</h2>

    @if(session('success'))
        <div style="background-color: #d4edda; padding: 10px; margin-bottom: 15px; color: #155724;">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('ordens-servico.create') }}" class="btn btn-primary mb-3">Nova Ordem de Serviço</a>

    {{-- FILTROS --}}
    <form method="GET" action="{{ route('ordens-servico.index') }}" class="row g-2 mb-3">
        <div class="col-md-3">
            <label class="form-label mb-0">Status</label>
            <select name="status" class="form-select">
                <option value="">-- Todos --</option>
                @foreach (['Aberto','Concluído','Cancelado','Orçamento'] as $opt)
                    <option value="{{ $opt }}" {{ request('status')===$opt ? 'selected' : '' }}>
                        {{ $opt }}
                    </option>
                @endforeach
            </select>

        </div>

        <div class="col-md-4">
            <label class="form-label mb-0">Busca (cliente, placa, serviço)</label>
            <input type="text" name="busca" value="{{ request('busca') }}" class="form-control" placeholder="Digite para filtrar...">
        </div>

        <div class="col-md-2">
            <label class="form-label mb-0">Por página</label>
            <select name="per_page" class="form-select">
                @foreach([10,15,25,50,100] as $n)
                    <option value="{{ $n }}" {{ (int)request('per_page',15)===$n ? 'selected' : '' }}>{{ $n }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3 d-flex align-items-end gap-2">
            <button class="btn btn-success" type="submit">Filtrar</button>
            <a href="{{ route('ordens-servico.index') }}" class="btn btn-outline-secondary">Limpar</a>
        </div>
    </form>

    <div class="mb-2">
        <strong>Total:</strong>
            @if($ordens instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                {{ $ordens->total() }}
            @else
                {{ $ordens->count() }}
            @endif
            registro(s)
    </div>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Data da Emissão</th>
                <th>Data do Lançamento</th>
                <th>Cliente</th>
                <th>Placa</th>
                <th>Serviço</th>
                <th>Previão da Entrega</th>
                <th>Valor</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ordens as $ordem)
                <tr>
                    <td>{{ $ordem->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($ordem->created_at)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($ordem->data_lancamento)->format('d/m/Y') }}</td>
                    <td>{{ $ordem->cliente }}</td>
                    <td>{{ $ordem->placa }}</td>
                    <td>{{ $ordem->servico_realizado }}</td>
                    <td>{{ \Carbon\Carbon::parse($ordem->data_prevista_entrega)->format('d/m/Y') }}</td>
                    <td>R$ {{ number_format($ordem->valor, 2, ',', '.') }}</td>
                    <td>{{ $ordem->status }}</td>
                    <td>
                        <a href="{{ route('ordens-servico.edit', $ordem->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('ordens-servico.destroy', $ordem->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Deseja realmente excluir esta ordem?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="10" class="text-center">Nenhum registro encontrado.</td></tr>
            @endforelse
        </tbody>
    </table>

   @if(method_exists($ordens, 'links'))
        <div class="mt-3">
            {{ $ordens->links() }}
        </div>
    @endif

</div>
@endsection

