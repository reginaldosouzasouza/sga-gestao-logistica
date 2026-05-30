@extends('layouts.app')

@section('title', 'Empresas')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Cadastro de Empresas</h2>

        <a href="{{ route('empresas.create') }}" class="btn btn-primary">
            + Nova Empresa
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome Fantasia</th>
                        <th>CNPJ</th>
                        <th>Cidade</th>
                        <th>Status</th>
                        <th>Plano</th>
                        <th>Vencimento</th>
                        <th style="width: 220px;">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($empresas as $empresa)
                        <tr>
                            <td>{{ $empresa->id }}</td>

                            <td>
                                <strong>{{ $empresa->nome_fantasia }}</strong>
                                <br>
                                <small class="text-muted">
                                    {{ $empresa->razao_social }}
                                </small>
                            </td>

                            <td>{{ $empresa->cnpj ?? '-' }}</td>

                            <td>
                                {{ $empresa->cidade ?? '-' }}
                                @if($empresa->estado)
                                    / {{ $empresa->estado }}
                                @endif
                            </td>

                            <td>
                                @if($empresa->status === 'ativo')
                                    <span class="badge bg-success">Ativo</span>
                                @elseif($empresa->status === 'teste')
                                    <span class="badge bg-info text-dark">Teste</span>
                                @elseif($empresa->status === 'bloqueado')
                                    <span class="badge bg-danger">Bloqueado</span>
                                @else
                                    <span class="badge bg-secondary">Inativo</span>
                                @endif
                            </td>

                            <td>{{ $empresa->plano ?? '-' }}</td>

                            <td>
                                {{ $empresa->data_vencimento ? \Carbon\Carbon::parse($empresa->data_vencimento)->format('d/m/Y') : '-' }}
                            </td>

                            <td>
                                <a href="{{ route('empresas.show', $empresa->id) }}" class="btn btn-sm btn-info">
                                    Ver
                                </a>

                                <a href="{{ route('empresas.edit', $empresa->id) }}" class="btn btn-sm btn-warning">
                                    Editar
                                </a>

                                @if($empresa->id != 1)
                                    <form action="{{ route('empresas.destroy', $empresa->id) }}"
                                          method="POST"
                                          style="display:inline-block;"
                                          onsubmit="return confirm('Deseja realmente excluir esta empresa?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Excluir
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                Nenhuma empresa cadastrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $empresas->links() }}
            </div>

        </div>
    </div>

</div>

@endsection