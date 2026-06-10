@extends('layouts.app')

@section('title', 'Detalhes da Empresa')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/empresas-form.css') }}">
@endsection

@section('content')

<div class="empresas-page">

    <div class="empresas-header">
        <div>
            <h2>Detalhes da Empresa</h2>
            <p class="empresas-subtitle">Visualize os dados cadastrais e o controle SaaS da empresa.</p>
        </div>

        <div class="empresas-actions" style="margin-top:0;">
            <a href="{{ route('empresas.edit', $empresa->id) }}" class="btn btn-warning">
                Editar
            </a>

            <a href="{{ route('empresas.index') }}" class="btn btn-secondary">
                Voltar
            </a>
        </div>
    </div>

    <div class="card empresas-card">
        <div class="card-body">

            <h5 class="empresas-section-title">Dados da Empresa</h5>

            <table class="empresas-detail-table">
                <tr>
                    <th>ID</th>
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
            </table>

            <h5 class="empresas-section-title mt-4">Controle SaaS</h5>

            <table class="empresas-detail-table">
                <tr>
                    <th>Status da Empresa</th>
                    <td>
                        @if($empresa->status === 'ativo')
                            <span class="empresas-badge empresas-badge-success">Ativo</span>
                        @elseif($empresa->status === 'teste')
                            <span class="empresas-badge empresas-badge-info">Teste</span>
                        @elseif($empresa->status === 'bloqueado')
                            <span class="empresas-badge empresas-badge-danger">Bloqueado</span>
                        @else
                            <span class="empresas-badge empresas-badge-secondary">Inativo</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Plano</th>
                    <td>
                        @if($empresa->plano === 'completo')
                            <span class="empresas-badge empresas-badge-primary">Completo</span>
                        @elseif($empresa->plano === 'basico')
                            <span class="empresas-badge empresas-badge-secondary">Básico</span>
                        @elseif($empresa->plano === 'teste')
                            <span class="empresas-badge empresas-badge-info">Teste</span>
                        @else
                            {{ $empresa->plano ?? '-' }}
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Status da Assinatura</th>
                    <td>
                        @if($empresa->status_assinatura === 'ativa')
                            <span class="empresas-badge empresas-badge-success">Ativa</span>
                        @elseif($empresa->status_assinatura === 'teste')
                            <span class="empresas-badge empresas-badge-info">Teste</span>
                        @elseif($empresa->status_assinatura === 'vencida')
                            <span class="empresas-badge empresas-badge-warning">Vencida</span>
                        @elseif($empresa->status_assinatura === 'bloqueada')
                            <span class="empresas-badge empresas-badge-danger">Bloqueada</span>
                        @elseif($empresa->status_assinatura === 'cancelada')
                            <span class="empresas-badge empresas-badge-dark">Cancelada</span>
                        @else
                            <span class="empresas-badge empresas-badge-secondary">Não informado</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Data Início Teste</th>
                    <td>
                        {{ $empresa->data_inicio_teste ? \Carbon\Carbon::parse($empresa->data_inicio_teste)->format('d/m/Y') : '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Data Fim Teste</th>
                    <td>
                        {{ $empresa->data_fim_teste ? \Carbon\Carbon::parse($empresa->data_fim_teste)->format('d/m/Y') : '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Data Vencimento</th>
                    <td>
                        {{ $empresa->data_vencimento ? \Carbon\Carbon::parse($empresa->data_vencimento)->format('d/m/Y') : '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Bloqueada</th>
                    <td>
                        @if($empresa->bloqueada)
                            <span class="empresas-badge empresas-badge-danger">Sim</span>
                        @else
                            <span class="empresas-badge empresas-badge-success">Não</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Motivo do Bloqueio</th>
                    <td>{{ $empresa->motivo_bloqueio ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Limite de Usuários</th>
                    <td>{{ $empresa->limite_usuarios ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Limite de Clientes</th>
                    <td>{{ $empresa->limite_clientes ?? '-' }}</td>
                </tr>
            </table>

            <h5 class="empresas-section-title mt-4">Controle do Registro</h5>

            <table class="empresas-detail-table">
                <tr>
                    <th>Cadastrada em</th>
                    <td>
                        {{ $empresa->created_at ? $empresa->created_at->format('d/m/Y H:i') : '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Atualizada em</th>
                    <td>
                        {{ $empresa->updated_at ? $empresa->updated_at->format('d/m/Y H:i') : '-' }}
                    </td>
                </tr>
            </table>

        </div>
    </div>

</div>

@endsection