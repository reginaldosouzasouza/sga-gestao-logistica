@extends('layouts.app')

@section('title', 'Rel. Vendas por Emissão')

@section('content')
<link rel="stylesheet" href="{{ asset('css/relvendasemissao.css') }}">

<div class="container">
    <h2>Relatório de Vendas por Emissão</h2>

    <form method="GET" action="{{ route('relatorio.vendas-emissao') }}">
        <div class="row">

            <div class="col-md-3">
                <label>Produto:</label>
                <select name="produto_id" class="form-control">
                    <option value="">Todos</option>
                    @foreach($produtos as $p)
                        <option value="{{ $p->id }}" {{ request('produto_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label>Data Inicial:</label>
                <input type="date" name="data_inicial" class="form-control"
                       value="{{ request('data_inicial') }}">
            </div>

            <div class="col-md-2">
                <label>Data Final:</label>
                <input type="date" name="data_final" class="form-control"
                       value="{{ request('data_final') }}">
            </div>

            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary btn-block">Filtrar</button>
            </div>

        </div>
    </form>

    <a href="{{ route('relatorio.vendas-emissao.exportar', request()->query()) }}"
       class="btn btn-success">
        📥 Exportar Planilha
    </a>

    <hr>

    <div class="totais">
        <p><strong>Total de Registros:</strong> {{ $resultados->count() }}</p>
        <p><strong>Quantidade Total:</strong> {{ $total_quantidade }}</p>
        <p><strong>Valor Total:</strong> R$ {{ number_format($total_valor, 2, ',', '.') }}</p>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Data</th>
                <th>Produto</th>
                <th>Quantidade Total</th>
                <th>Valor Total (R$)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($resultados as $r)
            <tr>
                <td>{{ date('d/m/Y', strtotime($r->data)) }}</td>
                <td>{{ $r->produto }}</td>
                <td>{{ $r->quantidade_total }}</td>
                <td><strong>{{ number_format($r->valor_total, 2, ',', '.') }}</strong></td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Nenhum resultado encontrado.</td>
            </tr>
            @endforelse
        </tbody>
        @if($resultados->count() > 0)
        <tfoot>
            <tr class="linha-total">
                <td colspan="2">TOTAL</td>
                <td>{{ $total_quantidade }}</td>
                <td><strong>R$ {{ number_format($total_valor, 2, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>
@endsection