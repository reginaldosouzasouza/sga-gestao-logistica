@extends('layouts.app')

@section('title', 'Detalhes da Empresa')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Detalhes da Empresa</h2>

        <div>
            <a href="{{ route('empresas.edit', $empresa->id) }}" class="btn btn-warning">
                Editar
            </a>

            <a href="{{ route('empresas.index') }}" class="btn btn-secondary">
                Voltar
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered">
                <tr>
                    <th style="width: 220px;">ID</th>
                    <td>{{ $empresa->id }}</td>
                </tr>

                <tr>
                    <th>Nome Fantasia</th>
                    <td>{{ $empresa->nome_fantasia }}</td>
                </tr>

                <tr>
                    <th>Razão Social</th>
                    <td>{{ $empresa->razao_social ?? '-' }}</td>
                </tr>

                <tr>
                    <th>CNPJ</th>
                    <td>{{ $empresa->cnpj ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Telefone</th>
                    <td>{{ $empresa->telefone ?? '-' }}</td>
                </tr>

                <tr>
                    <th>E-mail</th>
                    <td>{{ $empresa->email ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Endereço</th>
                    <td>
                        {{ $empresa->endereco ?? '-' }}
                        {{ $empresa->numero ? ', ' . $empresa->numero : '' }}
                        {{ $empresa->bairro ? ' - ' . $empresa->bairro : '' }}
                    </td>
                </tr>

                <tr>
                    <th>Cidade/Estado</th>
                    <td>
                        {{ $empresa->cidade ?? '-' }}
                        {{ $empresa->estado ? '/' . $empresa->estado : '' }}
                    </td>
                </tr>

                <tr>
                    <th>CEP</th>
                    <td>{{ $empresa->cep ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Status</th>
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
                </tr>

                <tr>
                    <th>Plano</th>
                    <td>{{ $empresa->plano ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Data Início Teste</th>
                    <td>
                        {{ $empresa->data_inicio_teste ? \Carbon\Carbon::parse($empresa->data_inicio_teste)->format('d/m/Y') : '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Data Vencimento</th>
                    <td>
                        {{ $empresa->data_vencimento ? \Carbon\Carbon::parse($empresa->data_vencimento)->format('d/m/Y') : '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Cadastrada em</th>
                    <td>
                        {{ $empresa->created_at ? $empresa->created_at->format('d/m/Y H:i') : '-' }}
                    </td>
                </tr>
            </table>

        </div>
    </div>

</div>

@endsection