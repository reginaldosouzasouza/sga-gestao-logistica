@extends('layouts.app')

@section('title', 'Duração do Gás por Cliente')

@section('styles')
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { background: #f0f2f5; font-family: 'Segoe UI', sans-serif; }

    .dur-wrapper { padding: 24px; max-width: 1200px; margin: 0 auto; }

    .dur-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .dur-header h2 { font-size: 22px; color: #1F4E79; display: flex; align-items: center; gap: 8px; }

    .btn-novo {
        background: #1F4E79;
        color: #fff;
        padding: 9px 18px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: background .2s;
    }
    .btn-novo:hover { background: #163a5f; color: #fff; }

    /* ── Filtro ── */
    .dur-filtro {
        background: #fff;
        border-radius: 10px;
        padding: 16px 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,.06);
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }
    .dur-filtro label { font-size: 13px; font-weight: 600; color: #555; white-space: nowrap; }
    .dur-filtro input {
        flex: 1;
        min-width: 220px;
        padding: 8px 12px;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        font-size: 13px;
        outline: none;
        transition: border .2s;
    }
    .dur-filtro input:focus { border-color: #1F4E79; }
    .btn-filtrar {
        background: #E97132;
        color: #fff;
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: background .2s;
    }
    .btn-filtrar:hover { background: #c85e20; }
    .btn-limpar {
        background: #6c757d;
        color: #fff;
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: background .2s;
    }
    .btn-limpar:hover { background: #545b62; color: #fff; }

    .alert-success-box {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        border-radius: 6px;
        padding: 12px 16px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    /* ── Tabela ── */
    .dur-table-wrap {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,.08);
        overflow: hidden;
    }
    .dur-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .dur-table thead tr th {
        padding: 13px 16px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        text-align: center;
        border-bottom: 2px solid #dee2e6;
    }
    .th-cliente { background: #1F4E79; color: #fff; text-align: left !important; width: 45%; }
    .th-produto { background: #E97132; color: #fff; }
    .th-duracao { background: #70AD47; color: #fff; }
    .th-acoes   { background: #1F4E79; color: #fff; width: 140px; }

    .dur-table tbody tr { border-bottom: 1px solid #f0f0f0; transition: background .15s; }
    .dur-table tbody tr:hover { background: #f7fbff; }
    .dur-table tbody tr:nth-child(even) { background: #fafafa; }
    .dur-table tbody tr:nth-child(even):hover { background: #f0f7ff; }
    .dur-table td { padding: 10px 16px; text-align: center; }
    .td-cliente { text-align: left !important; font-weight: 600; color: #1F4E79; }
    .td-produto { color: #E97132; font-weight: 600; }
    .td-duracao { font-weight: 700; font-size: 14px; color: #2e7d32; }

    /* ── Botões ação ── */
    .acoes-wrap { display: flex; gap: 6px; justify-content: center; }
    .btn-editar {
        background: #E97132;
        color: #fff;
        padding: 5px 10px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
        transition: background .2s;
    }
    .btn-editar:hover { background: #c85e20; color: #fff; }
    .btn-excluir {
        background: #dc3545;
        color: #fff;
        padding: 5px 10px;
        border-radius: 5px;
        border: none;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        transition: background .2s;
    }
    .btn-excluir:hover { background: #b02a37; }

    /* ── Paginação ── */
    .dur-pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
        border-top: 1px solid #f0f0f0;
        font-size: 12px;
        color: #666;
        flex-wrap: wrap;
        gap: 8px;
    }
    .dur-pagination nav { display: flex; align-items: center; gap: 4px; }
    .dur-pagination nav a,
    .dur-pagination nav span {
        color: #1F4E79;
        text-decoration: none;
        padding: 4px 9px;
        border-radius: 4px;
        border: 1px solid #dee2e6;
        font-size: 12px;
        line-height: 1.4;
        display: inline-block;
    }
    .dur-pagination nav a:hover { background: #1F4E79; color: #fff; border-color: #1F4E79; }
    .dur-pagination nav span[aria-current] { background: #1F4E79; color: #fff; border-color: #1F4E79; }

    .dur-footer { text-align: center; margin-top: 14px; font-size: 12px; color: #999; }
</style>
@endsection

@section('content')
<div class="dur-wrapper">

    <div class="dur-header">
        <h2>🔥 Duração do Gás por Cliente</h2>
        <a href="{{ route('duracao.create') }}" class="btn-novo">+ Novo</a>
    </div>

    @if(session('success'))
        <div class="alert-success-box">✅ {{ session('success') }}</div>
    @endif

    {{-- Filtro --}}
    <form method="GET" action="{{ route('duracao.index') }}" class="dur-filtro">
        <label>🔍 Pesquisar:</label>
        <input type="text" name="busca" placeholder="Digite o nome do cliente..."
               value="{{ request('busca') }}" autofocus>
        <button type="submit" class="btn-filtrar">Buscar</button>
        @if(request('busca'))
            <a href="{{ route('duracao.index') }}" class="btn-limpar">✕ Limpar</a>
        @endif
    </form>

    <div class="dur-table-wrap">
        <table class="dur-table">
            <thead>
                <tr>
                    <th class="th-cliente">Cliente</th>
                    <th class="th-produto">Produto</th>
                    <th class="th-duracao">Duração (dias)</th>
                    <th class="th-acoes">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($duracoes as $item)
                <tr>
                    <td class="td-cliente">{{ $item->cliente->nome }}</td>
                    <td class="td-produto">{{ $item->produto->nome }}</td>
                    <td class="td-duracao">{{ $item->duracao }} dias</td>
                    <td>
                        <div class="acoes-wrap">
                            <a href="{{ route('duracao.edit', $item->id) }}" class="btn-editar">✏️ Editar</a>
                            <form action="{{ route('duracao.destroy', $item->id) }}" method="POST"
                                  onsubmit="return confirm('Confirma exclusão?')">
                                @csrf @method('DELETE')
                                <button class="btn-excluir">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center; padding:30px; color:#999;">
                        Nenhum cliente encontrado.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="dur-pagination">
            <span>Mostrando {{ $duracoes->firstItem() ?? 0 }} a {{ $duracoes->lastItem() ?? 0 }} de {{ $duracoes->total() }} registros</span>
            <nav>
                {{-- Previous --}}
                @if($duracoes->onFirstPage())
                    <span>‹</span>
                @else
                    <a href="{{ $duracoes->previousPageUrl() }}">‹</a>
                @endif

                {{-- Páginas --}}
                @foreach($duracoes->getUrlRange(1, $duracoes->lastPage()) as $page => $url)
                    @if($page == $duracoes->currentPage())
                        <span aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next --}}
                @if($duracoes->hasMorePages())
                    <a href="{{ $duracoes->nextPageUrl() }}">›</a>
                @else
                    <span>›</span>
                @endif
            </nav>
        </div>
    </div>

    <div class="dur-footer">Total: {{ $duracoes->total() }} clientes cadastrados</div>
</div>
@endsection