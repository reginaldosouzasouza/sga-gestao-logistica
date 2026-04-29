@extends('layouts.app')

@section('title', 'Caixa')

@section('content')
<link rel="stylesheet" href="{{ asset('css/caixa.css') }}">

<div class="caixa-container">

  <div style="text-align:center; margin-bottom:20px">

    @if($caixaAbertoHoje)
        <h1 style="color:#198754;">
            🔓 Caixa Aberto - {{ \Carbon\Carbon::parse($dataAtual)->format('d/m/Y') }}
        </h1>
    @else
        <h1>
            📦 Caixa Geral
        </h1>
    @endif

</div>


    @if($caixaFechadoHoje)
        <div style="margin:15px 0; padding:12px; background:#ffecec; border-left:6px solid #d63031;">
            🔒 <strong>CAIXA FECHADO</strong> em {{ \Carbon\Carbon::parse($caixaFechadoHoje->data)->format('d/m/Y') }} |
            Saldo final: <strong>R$ {{ number_format($caixaFechadoHoje->saldo_final, 2, ',', '.') }}</strong>
        </div>
    @endif


    {{-- RESUMO --}}
    <div class="resumo-grid">
        <div class="card azul">
            <span>Caixa (Dinheiro)</span>
            <strong class="{{ $saldoCaixa < 0 ? 'negativo' : '' }}">
                 R$ {{ number_format($saldoCaixa, 2, ',', '.') }}
            </strong>

            <small>Entradas hoje: R$ {{ number_format($entradasCaixaHoje, 2, ',', '.') }}<br>
                   Saídas hoje: R$ {{ number_format($saidasCaixaHoje, 2, ',', '.') }}</small>
        </div>

        <div class="card verde">
            <span>Caixa Banco (PIX)</span>
            <strong class="{{ $saldoBanco < 0 ? 'negativo' : '' }}">
                R$ {{ number_format($saldoBanco, 2, ',', '.') }}
            </strong>

            <small>Entradas hoje: R$ {{ number_format($entradasBancoHoje, 2, ',', '.') }}<br>
                   Saídas hoje: R$ {{ number_format($saidasBancoHoje, 2, ',', '.') }}</small>
        </div>

        <div class="card roxo">
            <span>Saldo Geral</span>
            <strong>R$ {{ number_format($saldoGeral, 2, ',', '.') }}</strong>
            <small>Caixa + Banco</small>
        </div>
    </div>

    <form action="{{ route('caixa.fechar') }}" method="POST" style="margin-bottom: 20px;">
    @csrf

    <input type="hidden" name="data" value="{{ now()->toDateString() }}">

    <div style="display:flex; gap:10px; align-items:center;">
        <input type="text"
               name="observacao"
               placeholder="Observação do fechamento (opcional)"
               class="form-control"
               style="max-width:300px">

        <button class="btn btn-danger"
                onclick="return confirm('Confirma o FECHAMENTO do caixa do dia?')">
            🔒 Fechar Caixa do Dia
        </button>
    </div>
</form>

<form action="{{ route('caixa.ajuste') }}" method="POST" style="margin-bottom:30px;">
    @csrf

    <div style="display:flex; gap:10px; flex-wrap:wrap;">
        <select name="meio" class="form-control" required>
            <option value="">Dinheiro / PIX</option>
            <option value="dinheiro">Dinheiro</option>
            <option value="pix">PIX</option>
        </select>

        <select name="tipo" class="form-control" required>
            <option value="">Entrada / Saída</option>
            <option value="entrada">Entrada</option>
            <option value="saida">Saída</option>
        </select>

        <input type="number"
               step="0.01"
               name="valor"
               class="form-control"
               placeholder="Valor"
               required>

        <input type="text"
               name="descricao"
               class="form-control"
               placeholder="Ex: Sangria / Reforço"
               required>

        <button class="btn btn-warning">
            ➕ Ajuste Manual
        </button>
    </div>
</form>








    {{-- FILTROS --}}
    <form method="GET" class="filtros">
        <div>
            <label>Data Inicial</label>
            <input type="date" name="data_inicio" value="{{ request('data_inicio') }}">
        </div>

        <div>
            <label>Data Final</label>
            <input type="date" name="data_fim" value="{{ request('data_fim') }}">
        </div>

        <div>
            <label>Tipo</label>
            <select name="tipo">
                <option value="">Todos</option>
                <option value="entrada" {{ request('tipo')=='entrada' ? 'selected' : '' }}>Entrada</option>
                <option value="saida" {{ request('tipo')=='saida' ? 'selected' : '' }}>Saída</option>
            </select>
        </div>

        <div class="btn-area">
            <button type="submit">Filtrar</button>
        </div>
    </form>

    {{-- TABELAS --}}
    <div class="tabelas-grid">

        {{-- CAIXA DINHEIRO --}}
        <div class="box box-caixa">
            <h3>💵 Caixa (Dinheiro)</h3>
            <table>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Tipo</th>
                        <th>Valor</th>
                        <th>Origem</th>
                        <th>Descrição</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($caixa as $mov)
                        <tr class="{{ $mov->tipo }}">
                            <td>{{ \Carbon\Carbon::parse($mov->data_movimentacao)->format('d/m/Y') }}</td>
                           <td class="tipo-mov">
                                @if($mov->tipo === 'entrada')
                                    <span class="entrada">
                                        ⬆ Entrada
                                    </span>
                                @else
                                    <span class="saida">
                                        ⬇ Saída
                                    </span>
                                @endif
                            </td>

                            <td>R$ {{ number_format($mov->valor, 2, ',', '.') }}</td>
                            <td>{{ $mov->origem }}</td>
                            <td>{{ $mov->descricao }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5">Nenhum registro</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- CAIXA BANCO --}}
        <div class="box box-banco">
            <h3>🏦 Caixa Banco (PIX)</h3>
            <table>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Tipo</th>
                        <th>Valor</th>
                        <th>Origem</th>
                        <th>Descrição</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($caixaBanco as $mov)
                        <tr class="{{ $mov->tipo }}">
                            <td>{{ \Carbon\Carbon::parse($mov->data_movimentacao)->format('d/m/Y') }}</td>
                    <td class="tipo-mov">
                        @if($mov->tipo === 'entrada')
                            <span class="entrada">
                                ⬆ Entrada
                            </span>
                        @else
                            <span class="saida">
                                ⬇ Saída
                            </span>
                        @endif
                    </td>

                            <td>R$ {{ number_format($mov->valor, 2, ',', '.') }}</td>
                            <td>{{ $mov->origem }}</td>
                            <td>{{ $mov->descricao }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5">Nenhum registro</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection
