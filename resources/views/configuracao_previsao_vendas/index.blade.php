@extends('layouts.app')

@section('title', 'Configuração de Previsão de Vendas')

@section('content')

<style>
    .previsao-config-page {
        padding: 20px;
    }

    .previsao-config-page h1 {
        font-weight: 700;
        margin-bottom: 8px;
    }

    .previsao-config-page .subtitulo {
        color: #64748b;
        margin-bottom: 25px;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .config-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 18px;
        margin-bottom: 18px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    .config-card h2 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 15px;
        color: #111827;
    }

    .config-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(160px, 1fr));
        gap: 14px;
        margin-bottom: 14px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 5px;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 9px 10px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
    }

    .check-row {
        display: flex;
        gap: 22px;
        align-items: center;
        margin-bottom: 14px;
        flex-wrap: wrap;
    }

    .check-row label {
        display: flex;
        align-items: center;
        gap: 7px;
        font-weight: 600;
        color: #374151;
    }

    .btn-salvar {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-salvar:hover {
        background: #1d4ed8;
    }

    .info-box {
        background: #f8fafc;
        border-left: 4px solid #2563eb;
        padding: 12px 14px;
        border-radius: 8px;
        margin-bottom: 20px;
        color: #334155;
        line-height: 1.5;
    }

    @media (max-width: 900px) {
        .config-grid {
            grid-template-columns: repeat(2, minmax(160px, 1fr));
        }
    }

    @media (max-width: 600px) {
        .config-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="previsao-config-page">

    <h1>Configuração de Previsão de Vendas</h1>
    <p class="subtitulo">
        Configure os parâmetros usados futuramente na previsão de giro, reposição e caixa por produto.
    </p>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="info-box">
        <strong>Importante:</strong>
        esta tela ainda não altera os relatórios atuais. Ela apenas prepara os parâmetros para a previsão inteligente.
        A recomendação é começar com ajustes conservadores e validar com os dados reais do S.G.A.
    </div>

    @forelse($configuracoes as $config)
        <div class="config-card">
            <h2>{{ $config->produto->nome ?? 'Produto não encontrado' }}</h2>

            <form method="POST" action="{{ route('configuracao-previsao-vendas.update', $config->id) }}">
                @csrf
                @method('PUT')

                <div class="check-row">
                    <label>
                        <input type="checkbox" name="usar_ajuste_fim_mes" value="1"
                            {{ $config->usar_ajuste_fim_mes ? 'checked' : '' }}>
                        Usar ajuste de fim de mês
                    </label>

                    <label>
                        <input type="checkbox" name="usar_sazonalidade_manual" value="1"
                            {{ $config->usar_sazonalidade_manual ? 'checked' : '' }}>
                        Usar sazonalidade manual
                    </label>

                    <label>
                        <input type="checkbox" name="ativo" value="1"
                            {{ $config->ativo ? 'checked' : '' }}>
                        Ativo
                    </label>
                </div>

                <div class="config-grid">
                    <div class="form-group">
                        <label>Dia início fim de mês</label>
                        <input type="number"
                               name="dia_inicio_fim_mes"
                               min="1"
                               max="31"
                               value="{{ old('dia_inicio_fim_mes', $config->dia_inicio_fim_mes) }}">
                    </div>

                    <div class="form-group">
                        <label>% ajuste fim de mês</label>
                        <input type="number"
                               name="percentual_ajuste_fim_mes"
                               step="0.01"
                               min="-100"
                               max="100"
                               value="{{ old('percentual_ajuste_fim_mes', $config->percentual_ajuste_fim_mes) }}">
                    </div>

                    <div class="form-group">
                        <label>Mês início sazonalidade</label>
                        <input type="number"
                               name="mes_inicio_sazonalidade"
                               min="1"
                               max="12"
                               value="{{ old('mes_inicio_sazonalidade', $config->mes_inicio_sazonalidade) }}">
                    </div>

                    <div class="form-group">
                        <label>Mês fim sazonalidade</label>
                        <input type="number"
                               name="mes_fim_sazonalidade"
                               min="1"
                               max="12"
                               value="{{ old('mes_fim_sazonalidade', $config->mes_fim_sazonalidade) }}">
                    </div>

                    <div class="form-group">
                        <label>% ajuste sazonalidade</label>
                        <input type="number"
                               name="percentual_ajuste_sazonalidade"
                               step="0.01"
                               min="-100"
                               max="100"
                               value="{{ old('percentual_ajuste_sazonalidade', $config->percentual_ajuste_sazonalidade) }}">
                    </div>

                    <div class="form-group">
                        <label>Estoque segurança em dias</label>
                        <input type="number"
                               name="estoque_seguranca_dias"
                               step="0.01"
                               min="0"
                               max="365"
                               value="{{ old('estoque_seguranca_dias', $config->estoque_seguranca_dias) }}">
                    </div>

                    <div class="form-group">
                        <label>Base histórica início</label>
                        <input type="date"
                               name="base_historica_inicio"
                               value="{{ old('base_historica_inicio', optional($config->base_historica_inicio)->format('Y-m-d')) }}">
                    </div>
                </div>

                <button type="submit" class="btn-salvar">
                    Salvar configuração
                </button>
            </form>
        </div>
    @empty
        <div class="info-box">
            Nenhum produto encontrado para configurar.
        </div>
    @endforelse

</div>

@endsection