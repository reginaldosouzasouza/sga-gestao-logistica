@extends('layouts.app')

@section('title', 'Consultas - Vale GÁS')

@section('content')

<style>
    body {
        background-color: #f5f7fb;
    }

    .vale-gas-page .topo-pagina {
        margin-bottom: 24px;
    }

    .vale-gas-page .titulo-pagina {
        font-weight: 700;
        color: #1f2937;
        font-size: 2rem;
        line-height: 1.2;
        margin-bottom: 4px;
    }

    .vale-gas-page .subtitulo-pagina {
        color: #6b7280;
        font-size: 0.95rem;
        margin: 0;
    }

    .vale-gas-page .card-principal {
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        overflow: hidden;
    }

    .vale-gas-page .card-header-custom {
        background-color: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
        padding: 16px 20px;
        font-size: 1.1rem;
        font-weight: 700;
        color: #1f2937;
    }

    .vale-gas-page .card-body-custom {
        padding: 22px;
    }

    .vale-gas-page .info-box {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 14px 16px;
        height: 100%;
        transition: all 0.2s ease;
    }

    .vale-gas-page .info-box:hover {
        box-shadow: 0 6px 18px rgba(0,0,0,0.06);
        border-color: #d1d5db;
    }

    .vale-gas-page .campo-label {
        font-size: 12px;
        font-weight: 700;
        color: #6b7280;
        text-transform: uppercase;
        margin-bottom: 6px;
        letter-spacing: 0.3px;
    }

    .vale-gas-page .campo-valor {
        font-size: 17px;
        color: #111827;
        font-weight: 600;
        line-height: 1.35;
        word-break: break-word;
    }

    .badge-status {
        display: inline-block;
        font-size: 12px;
        padding: 7px 12px;
        border-radius: 999px;
        font-weight: 700;
    }

    .badge-aberto {
        background-color: #198754;
        color: #fff;
    }

    .badge-processo {
        background-color: #f59e0b;
        color: #fff;
    }

    .badge-retirado {
        background-color: #0d6efd;
        color: #fff;
    }

    .badge-cancelado {
        background-color: #dc3545;
        color: #fff;
    }

    .vale-gas-page .bloco-acoes {
        margin-top: 24px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .vale-gas-page .observacao-box {
        min-height: 90px;
    }
</style>

<div class="container-fluid mt-4 vale-gas-page">
    <div class="d-flex justify-content-between align-items-center topo-pagina">
        <div>
            <h1 class="titulo-pagina">Detalhes do Vale Gás</h1>
            <p class="subtitulo-pagina">Consulta completa do vale cadastrado</p>
        </div>

        <a href="{{ route('vale-gas.index') }}" class="btn btn-secondary">
            Voltar
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

    <div class="card-principal">
        <div class="card-header-custom">
            Informações do Vale
        </div>

        <div class="card-body-custom">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="info-box">
                        <div class="campo-label">Código</div>
                        <div class="campo-valor">{{ $vale->codigo }}</div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="info-box">
                        <div class="campo-label">Cliente</div>
                        <div class="campo-valor">{{ $vale->cliente->nome ?? '' }}</div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="info-box">
                        <div class="campo-label">Data do Vale</div>
                        <div class="campo-valor">{{ $vale->data_vale->format('d/m/Y') }}</div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="info-box">
                        <div class="campo-label">Quantidade</div>
                        <div class="campo-valor">{{ $vale->quantidade }}</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="info-box">
                        <div class="campo-label">Produto</div>
                        <div class="campo-valor">{{ $vale->produto->nome ?? '' }}</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="info-box">
                        <div class="campo-label">Valor Pago</div>
                        <div class="campo-valor">R$ {{ number_format($vale->valor_pago, 2, ',', '.') }}</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="info-box">
                        <div class="campo-label">Forma de Pagamento</div>
                        <div class="campo-valor">{{ $vale->formaPagamento->nome ?? '-' }}</div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="info-box">
                        <div class="campo-label">Status</div>
                        <div class="campo-valor">
                            @if($vale->status === 'ABERTO')
                                <span class="badge-status badge-aberto">ABERTO</span>
                            @elseif($vale->status === 'EM_PROCESSO')
                                <span class="badge-status badge-processo">EM PROCESSO</span>
                            @elseif($vale->status === 'RETIRADO')
                                <span class="badge-status badge-retirado">RETIRADO</span>
                            @else
                                <span class="badge-status badge-cancelado">CANCELADO</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="info-box">
                        <div class="campo-label">Usuário Cadastro</div>
                        <div class="campo-valor">{{ $vale->usuarioCadastro->nome_completo ?? '-' }}</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="info-box">
                        <div class="campo-label">Data da Retirada</div>
                        <div class="campo-valor">
                            {{ $vale->data_retirada ? $vale->data_retirada->format('d/m/Y H:i') : '-' }}
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="info-box">
                        <div class="campo-label">Usuário da Retirada</div>
                        <div class="campo-valor">{{ $vale->usuarioRetirada->nome_completo ?? '-' }}</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="info-box">
                        <div class="campo-label">Pedido de Coleta</div>
                        <div class="campo-valor">{{ $vale->pedido_coleta_id ?? '-' }}</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="info-box">
                        <div class="campo-label">Cliente ID</div>
                        <div class="campo-valor">{{ $vale->cliente_id ?? '-' }}</div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="info-box observacao-box">
                        <div class="campo-label">Observação</div>
                        <div class="campo-valor">{{ $vale->observacao ?: '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="bloco-acoes">
                <a href="{{ route('vale-gas.index') }}" class="btn btn-secondary">Voltar</a>

                @if($vale->pedido_coleta_id)
                    <a href="{{ route('movimentacao.show', $vale->pedido_coleta_id) }}" class="btn btn-info">
                        Abrir Coleta
                    </a>
                @endif

                @if($vale->status === 'ABERTO')
                    <form action="{{ route('vale-gas.iniciar-retirada', $vale->id) }}" method="POST"
                        onsubmit="return confirm('Deseja iniciar a retirada deste vale?')">
                        @csrf
                        <button type="submit" class="btn btn-warning">Retirada do Vale</button>
                    </form>

                    <a href="{{ route('vale-gas.edit', $vale->id) }}" class="btn btn-primary">Editar</a>

                    <form action="{{ route('vale-gas.cancelar', $vale->id) }}" method="POST"
                        onsubmit="return confirm('Deseja realmente cancelar este vale?')">
                        @csrf
                        <button type="submit" class="btn btn-danger">Cancelar</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection