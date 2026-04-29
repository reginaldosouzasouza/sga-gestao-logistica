<h2>Histórico de Caixas</h2>

<table border="1" width="100%" cellpadding="8">
    <tr>
        <th>Data</th>
        <th>Status</th>
        <th>Saldo Final</th>
        <th>Ação</th>
    </tr>

@forelse($historico as $c)
<tr>
    <td>{{ \Carbon\Carbon::parse($c['data'])->format('d/m/Y') }}</td>

    <td>
        @if($c['status'] === 'Aberto')
            <span style="color:green"><strong>Aberto</strong></span>
        @else
            <span style="color:red"><strong>Fechado</strong></span>
        @endif
    </td>

    <td>
        @if($c['status'] === 'Aberto')
            —
        @else
            R$ {{ number_format($c['saldo_final'], 2, ',', '.') }}
        @endif
    </td>

    <td>
        @if($c['status'] === 'Aberto')
            <a href="{{ route('caixa.index') }}">🔓 Acessar Caixa</a>
        @else
            <a href="{{ route('caixa.visualizar', $c['data']) }}">🔍 Ver Caixa</a>
        @endif
    </td>
</tr>
@empty
<tr>
    <td colspan="4" align="center">Nenhum registro encontrado</td>
</tr>
@endforelse
</table>

