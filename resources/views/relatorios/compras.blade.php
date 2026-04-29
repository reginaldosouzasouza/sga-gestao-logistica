@extends('layouts.app')

@section('title', 'Relatório de Compras')
@section('content')

<link rel="stylesheet" href="{{ asset('css/relatorio-novo-compras.css') }}">


@section('content')
<div class="rc-page">

    {{-- ── Topo ─────────────────────────────────────────────── --}}
    <div class="rc-topbar">
        <div>
            <div class="rc-breadcrumb">Financeiro › <span>Relatórios</span></div>
            <h1 class="rc-title">Relatório de <em>Compras</em></h1>
        </div>
        <div class="rc-actions">
            <button class="btn btn-ghost" onclick="window.print()">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2M6 14h12v8H6z"/></svg>
                Imprimir
            </button>
            <a href="{{ route('relatorios.compras.export', request()->query()) }}" class="btn btn-ghost">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                Exportar CSV
            </a>
        </div>
    </div>

    {{-- ── Cards totais ─────────────────────────────────────── --}}
    <div class="rc-cards">
        <div class="rc-card rc-card--total">
            <div class="rc-card__icon">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div class="rc-card__label">Registros</div>
            <div class="rc-card__value">{{ $totais['qtd_registros'] }}</div>
        </div>
        <div class="rc-card rc-card--geral">
            <div class="rc-card__icon">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
            </div>
            <div class="rc-card__label">Total Geral</div>
            <div class="rc-card__value">R$ {{ number_format($totais['total_geral'], 2, ',', '.') }}</div>
        </div>
        <div class="rc-card rc-card--pago">
            <div class="rc-card__icon">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div class="rc-card__label">Total Pago</div>
            <div class="rc-card__value">R$ {{ number_format($totais['total_pago'], 2, ',', '.') }}</div>
        </div>
        <div class="rc-card rc-card--pend">
            <div class="rc-card__icon">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="rc-card__label">Total Pendente</div>
            <div class="rc-card__value">R$ {{ number_format($totais['total_pendente'], 2, ',', '.') }}</div>
        </div>
    </div>

    {{-- ── Filtros ──────────────────────────────────────────── --}}
    <div class="rc-filter-panel">
        <div class="rc-filter-header open" id="filterHeader" onclick="toggleFiltros()">
            <div class="rc-filter-header-left">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                Filtros de pesquisa
            </div>
            <svg class="rc-filter-chevron open" id="filterChevron" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg>
        </div>

        <form method="GET" action="{{ route('relatorios.compras') }}">
            <div class="rc-filter-body" id="filterBody">

                <div class="rc-field">
                    <label>Período da Compra</label>
                    <div class="rc-range-separator">
                        <input type="date" name="data_compra_inicio" value="{{ $filtros['data_compra_inicio'] ?? '' }}" onclick="this.showPicker()">
                        <span>até</span>
                        <input type="date" name="data_compra_fim"    value="{{ $filtros['data_compra_fim'] ?? '' }}" onclick="this.showPicker()">
                    </div>
                </div>

                <div class="rc-field">
                    <label>Período do Vencimento</label>
                    <div class="rc-range-separator">
                        <input type="date" name="data_vencimento_inicio" value="{{ $filtros['data_vencimento_inicio'] ?? '' }}" onclick="this.showPicker()">
                        <span>até</span>
                        <input type="date" name="data_vencimento_fim"    value="{{ $filtros['data_vencimento_fim'] ?? '' }}" onclick="this.showPicker()">
                    </div>
                </div>

                <div class="rc-field">
                    <label>Período do Pagamento</label>
                    <div class="rc-range-separator">
                        <input type="date" name="data_pagamento_inicio" value="{{ $filtros['data_pagamento_inicio'] ?? '' }}" onclick="this.showPicker()">
                        <span>até</span>
                        <input type="date" name="data_pagamento_fim"    value="{{ $filtros['data_pagamento_fim'] ?? '' }}" onclick="this.showPicker()">
                    </div>
                </div>

                <div class="rc-field">
                    <label>Fornecedor</label>
                    <input type="text" name="fornecedor" value="{{ $filtros['fornecedor'] ?? '' }}" placeholder="Buscar por nome...">
                </div>

                <div style="grid-column: 1 / -1; display: grid; grid-template-columns: 1fr 1fr 2fr; gap: 1.5rem 2rem;">                
                    <div class="rc-field">
                        <label>Status</label>
                        <select name="status">
                            <option value="">Todos</option>
                            <option value="pago"     {{ ($filtros['status'] ?? '') === 'pago'     ? 'selected' : '' }}>Pago</option>
                            <option value="pendente" {{ ($filtros['status'] ?? '') === 'pendente' ? 'selected' : '' }}>Pendente</option>
                        </select>
                    </div>

                    <div class="rc-field">
                        <label>Forma de Pagamento</label>
                        <select name="forma_pagamento">
                            <option value="">Todas</option>
                            <option value="dinheiro" {{ ($filtros['forma_pagamento'] ?? '') === 'dinheiro' ? 'selected' : '' }}>Dinheiro</option>
                            <option value="pix"      {{ ($filtros['forma_pagamento'] ?? '') === 'pix'      ? 'selected' : '' }}>PIX</option>
                            <option value="prazo"    {{ ($filtros['forma_pagamento'] ?? '') === 'prazo'    ? 'selected' : '' }}>Prazo</option>
                            <option value="misto"    {{ ($filtros['forma_pagamento'] ?? '') === 'misto'    ? 'selected' : '' }}>Misto</option>
                        </select>
                    </div></div>
                </div>        

            </div>

            <div class="rc-filter-footer">
                <button type="submit" class="btn btn-accent">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    Filtrar
                </button>
                <a href="{{ route('relatorios.compras') }}" class="btn btn-danger-ghost">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Limpar
                </a>
            </div>
        </form>
    </div>

    {{-- ── Tabela ───────────────────────────────────────────── --}}
    <div class="rc-table-wrap">
        <div class="rc-table-header">
            <div class="rc-table-title">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/><line x1="9" y1="3" x2="9" y2="21"/></svg>
                Resultados
                <span class="rc-table-count">{{ $totais['qtd_registros'] }}</span>
            </div>
        </div>

        @if($resultado->isEmpty())
            <div class="rc-empty">
                <div class="rc-empty-icon">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <h3>Nenhum resultado encontrado</h3>
                <p>Tente ajustar os filtros para encontrar o que procura.</p>
            </div>
        @else
            <div style="overflow-x:auto;">
                <table class="rc-table">
                    <thead>
                        <tr>
                            <th>Data Compra</th>
                            <th>Fornecedor</th>
                            <th>Descrição</th>
                            <th>Forma Pag.</th>
                            <th>Valor</th>
                            <th>Status</th>
                            <th>Vencimento</th>
                            <th>Dt. Pagamento</th>
                            <th>Fonte</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($resultado as $row)
                        @php $forma = strtolower($row->forma_pagamento ?? ''); @endphp
                        <tr>
                            <td>
                                <div class="cell-data">
                                    <strong>{{ \Carbon\Carbon::parse($row->data_compra)->format('d/m/Y') }}</strong>
                                </div>
                            </td>
                            <td>
                                <div class="cell-fornecedor-nome">{{ $row->nome_fornecedor }}</div>
                                <div class="cell-fornecedor-cnpj">{{ $row->cnpj }}</div>
                            </td>
                            <td>
                                <div class="cell-desc" title="{{ $row->nota_fiscal ? 'NF '.$row->nota_fiscal : ($row->observacao ?? '—') }}">{{ $row->nota_fiscal ? 'NF '.$row->nota_fiscal : ($row->observacao ?? '—') }}</div>
                            </td>
                            <td>
                                <span class="badge badge-{{ $forma === 'pix' ? 'pix' : ($forma === 'dinheiro' ? 'dinheiro' : ($forma === 'misto' ? 'misto' : 'prazo')) }}">
                                    {{ ucfirst($row->forma_pagamento) }}
                                </span>
                            </td>
                            <td>
                                <span class="cell-valor">R$ {{ number_format($row->valor, 2, ',', '.') }}</span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $row->situacao === 'pago' ? 'pago' : 'pendente' }}">
                                    {{ ucfirst($row->situacao) }}
                                </span>
                            </td>
                            <td>
                                <div class="cell-data">
                                    {{ $row->data_vencimento ? \Carbon\Carbon::parse($row->data_vencimento)->format('d/m/Y') : '—' }}
                                </div>
                            </td>
                            <td>
                                <div class="cell-data">
                                    {{ $row->data_pagamento ? \Carbon\Carbon::parse($row->data_pagamento)->format('d/m/Y') : '—' }}
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-fonte">{{ $row->fonte }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">
                                <span class="tfoot-label">Total</span>
                                {{ $totais['qtd_registros'] }} registros
                            </td>
                            <td>
                                <span class="tfoot-label">Valor total</span>
                                R$ {{ number_format($totais['total_geral'], 2, ',', '.') }}
                            </td>
                            <td colspan="4"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif
    </div>

</div>

<script>
function toggleFiltros() {
    const body    = document.getElementById('filterBody');
    const header  = document.getElementById('filterHeader');
    const chevron = document.getElementById('filterChevron');
    const isOpen  = !body.classList.contains('hidden');
    body.classList.toggle('hidden', isOpen);
    header.classList.toggle('open', !isOpen);
    chevron.classList.toggle('open', !isOpen);
}
</script>
@endsection
