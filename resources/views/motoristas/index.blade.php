@extends('layouts.app')

@section('title', 'Cadastro de Motoristas')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/motoristas.css') }}">
@endsection

@section('content')

<div class="motoristas-page">

    <h2>Cadastro de Motoristas</h2>

    @if(session('success'))
        <div class="motoristas-alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('motoristas.index') }}" class="motoristas-search">
        <input 
            type="text" 
            name="search" 
            placeholder="Pesquisar por nome, telefone, CPF ou CNH"
            value="{{ request('search') }}"
        >

        <button type="submit" class="btn-pesquisar">
            Pesquisar
        </button>

        <a href="{{ route('motoristas.index') }}" class="btn-limpar">
            Limpar
        </a>
    </form>

    <div class="total-motoristas">
        <strong>Total de Motoristas: {{ $totalMotoristas }}</strong>
    </div>

    <a href="{{ route('motoristas.create') }}" class="btn-novo">
        + Novo Motorista
    </a>

    <div class="motoristas-table-wrapper">
        <table class="motoristas-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>CPF</th>
                    <th>CNH</th>
                    <th>Categoria</th>
                    <th>Validade CNH</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                @forelse($motoristas as $motorista)
                    <tr>
                        <td>{{ $motorista->id }}</td>
                        <td>{{ $motorista->nome }}</td>
                        <td>{{ $motorista->telefone }}</td>
                        <td>{{ $motorista->cpf }}</td>
                        <td>{{ $motorista->cnh }}</td>
                        <td>{{ $motorista->categoria_cnh }}</td>
                        <td>
                            @if($motorista->validade_cnh)
                                {{ \Carbon\Carbon::parse($motorista->validade_cnh)->format('d/m/Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($motorista->ativo)
                                <span class="status-ativo">Ativo</span>
                            @else
                                <span class="status-inativo">Inativo</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('motoristas.edit', $motorista->id) }}" class="btn-editar">
                                Editar
                            </a>

                            <form 
                                action="{{ route('motoristas.destroy', $motorista->id) }}" 
                                method="POST" 
                                class="form-excluir"
                                onsubmit="return confirm('Deseja realmente excluir este motorista?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn-excluir">
                                    Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center;">
                            Nenhum motorista cadastrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="motoristas-paginacao">
        {{ $motoristas->links() }}
    </div>

</div>

@endsection