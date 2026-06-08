@extends('layouts.app')

@section('title', 'Cadastro de Veículos')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/veiculos.css') }}">
@endsection

@section('content')

<div class="veiculos-page">

    <h2>Cadastro de Veículos</h2>

    @if(session('success'))
        <div class="veiculos-alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('veiculos.index') }}" class="veiculos-search">
        <input 
            type="text" 
            name="search" 
            placeholder="Pesquisar por descrição, placa, marca ou modelo"
            value="{{ request('search') }}"
        >

        <button type="submit" class="btn-pesquisar">
            Pesquisar
        </button>

        <a href="{{ route('veiculos.index') }}" class="btn-limpar">
            Limpar
        </a>
    </form>

    <div class="total-veiculos">
        <strong>Total de Veículos: {{ $totalVeiculos }}</strong>
    </div>

    <a href="{{ route('veiculos.create') }}" class="btn-novo">
        + Novo Veículo
    </a>

    <div class="veiculos-table-wrapper">
        <table class="veiculos-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Placa</th>
                    <th>Motorista</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Ano</th>
                    <th>Tipo</th>
                    <th>Comissão</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                @forelse($veiculos as $veiculo)
                    <tr>
                        <td>{{ $veiculo->id }}</td>

                        <td>{{ $veiculo->descricao }}</td>

                        <td>{{ $veiculo->placa ?? '-' }}</td>

                        <td>
                            {{ $veiculo->motorista->nome ?? 'Sem motorista' }}
                        </td>

                        <td>{{ $veiculo->marca ?? '-' }}</td>

                        <td>{{ $veiculo->modelo ?? '-' }}</td>

                        <td>{{ $veiculo->ano ?? '-' }}</td>

                        <td>{{ $veiculo->tipo ?? '-' }}</td>

                        <td>
                            @if($veiculo->comissao_tipo === 'percentual')
                                <span class="comissao-badge">
                                    {{ number_format($veiculo->comissao_valor, 2, ',', '.') }}%
                                </span>
                            @elseif($veiculo->comissao_tipo === 'fixa')
                                <span class="comissao-badge">
                                    R$ {{ number_format($veiculo->comissao_valor, 2, ',', '.') }}
                                </span>
                            @else
                                <span class="comissao-badge">
                                    Sem comissão
                                </span>
                            @endif
                        </td>

                        <td>
                            @if($veiculo->ativo)
                                <span class="status-ativo">Ativo</span>
                            @else
                                <span class="status-inativo">Inativo</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('veiculos.edit', $veiculo->id) }}" class="btn-editar">
                                Editar
                            </a>

                            <form 
                                action="{{ route('veiculos.destroy', $veiculo->id) }}" 
                                method="POST" 
                                class="form-excluir"
                                onsubmit="return confirm('Deseja realmente excluir este veículo?')"
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
                        <td colspan="11" style="text-align: center;">
                            Nenhum veículo cadastrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="veiculos-paginacao">
        {{ $veiculos->links() }}
    </div>

</div>

@endsection