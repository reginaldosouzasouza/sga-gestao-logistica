{{-- resources/views/relatorios/_tabela_movimentacao.blade.php --}}
<table style="width:100%; border-collapse:collapse; font-size:13px;">
    <thead>
        <tr style="background:#1e293b; color:#fff;">
            <th style="padding:10px 14px; text-align:left;">Data</th>
            <th style="padding:10px 14px; text-align:left;">Tipo</th>
            <th style="padding:10px 14px; text-align:left;">Meio</th>
            <th style="padding:10px 14px; text-align:left;">Forma Pgto</th>
            <th style="padding:10px 14px; text-align:left;">Origem</th>
            <th style="padding:10px 14px; text-align:left;">Fornecedor</th>
            <th style="padding:10px 14px; text-align:left;">Descrição</th>
            <th style="padding:10px 14px; text-align:right;">Valor</th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0; @endphp

        @forelse($movimentos as $i => $mov)

            @php
                if ($mov->tipo === 'saida') {
                    $total -= $mov->valor;
                } else {
                    $total += $mov->valor;
                }
            @endphp

        <tr style="border-bottom:1px solid #f1f5f9; {{ $i % 2 === 0 ? 'background:#fff;' : 'background:#fafafa;' }}">
            <td style="padding:8px 14px; color:#374151;">
                {{ \Carbon\Carbon::parse($mov->data)->format('d/m/Y') }}
            </td>

            <td style="padding:8px 14px;">
                <span style="padding:2px 10px; border-radius:20px; font-size:11px; font-weight:600;
                    background:{{ $mov->tipo === 'entrada' ? '#dcfce7' : '#fef2f2' }};
                    color:{{ $mov->tipo === 'entrada' ? '#15803d' : '#dc2626' }};">
                    {{ $mov->tipo === 'entrada' ? '⬆ Entrada' : '⬇ Saída' }}
                </span>
            </td>

            <td style="padding:8px 14px;">
                @if($mov->meio === 'Dinheiro')
                    <span style="background:#dbeafe; color:#1e40af; padding:2px 10px; border-radius:20px; font-size:11px; font-weight:600;">💵 Dinheiro</span>
                @else
                    <span style="background:#f0fdf4; color:#15803d; padding:2px 10px; border-radius:20px; font-size:11px; font-weight:600;">💳 PIX</span>
                @endif
            </td>

            <td style="padding:8px 14px;">
                @php
                    $forma = $mov->forma_pagamento ?? '-';
                    $configs = [
                        'Dinheiro'          => ['bg' => '#dbeafe', 'txt' => '#1e40af', 'icon' => '💵'],
                        'PIX'               => ['bg' => '#f0fdf4', 'txt' => '#15803d', 'icon' => '💳'],
                        'Fatura'            => ['bg' => '#fef9c3', 'txt' => '#854d0e', 'icon' => '🧾'],
                        'Cartão de Crédito' => ['bg' => '#faf5ff', 'txt' => '#6b21a8', 'icon' => '💳'],
                        'Nota Assinada'     => ['bg' => '#fff7ed', 'txt' => '#9a3412', 'icon' => '📝'],
                    ];
                    $cfg = $configs[$forma] ?? ['bg' => '#f1f5f9', 'txt' => '#6b7280', 'icon' => ''];
                @endphp

                @if($forma !== '-')
                    <span style="background:{{ $cfg['bg'] }}; color:{{ $cfg['txt'] }}; padding:2px 10px; border-radius:20px; font-size:11px; font-weight:600;">
                        {{ $cfg['icon'] }} {{ $forma }}
                    </span>
                @else
                    <span style="color:#9ca3af; font-size:12px;">—</span>
                @endif
            </td>

            <td style="padding:8px 14px; color:#6b7280;">{{ ucfirst($mov->origem) }}</td>
            <td style="padding:8px 14px; color:#374151;">{{ $mov->fornecedor ?? '-' }}</td>
            <td style="padding:8px 14px; color:#374151;">{{ $mov->descricao }}</td>

            <td style="padding:8px 14px; text-align:right; font-weight:600;
                color: {{ $mov->tipo === 'saida' ? '#dc2626' : '#16a34a' }};">
                {{ $mov->tipo === 'saida' ? '-' : '' }}
                R$ {{ number_format($mov->valor, 2, ',', '.') }}
            </td>
        </tr>

        @empty
        <tr>
            <td colspan="8" style="padding:30px; text-align:center; color:#9ca3af;">
                Nenhum registro encontrado.
            </td>
        </tr>
        @endforelse
    </tbody>

    @if(count($movimentos) > 0)
    <tfoot>
        <tr style="background:#f8fafc; font-weight:700; border-top:2px solid #e2e8f0;">
            <td colspan="7" style="padding:10px 14px; color:#374151;">
                TOTAL ({{ count($movimentos) }} registros)
            </td>
            <td style="padding:10px 14px; text-align:right;
                color: {{ $total < 0 ? '#dc2626' : '#16a34a' }};
                font-size:14px;">
                R$ {{ number_format($total, 2, ',', '.') }}
            </td>
        </tr>
    </tfoot>
    @endif
</table>