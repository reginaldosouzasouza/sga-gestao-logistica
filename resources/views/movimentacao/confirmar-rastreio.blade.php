@extends('layouts.app')

@section('title', 'Confirmar Rastreio')

@section('content')
<div class="container" style="max-width: 700px; margin-top: 40px;">

    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-weight: bold;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('info'))
        <div style="background: #dbeafe; color: #1e40af; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-weight: bold;">
            {{ session('info') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-weight: bold;">
            {{ session('error') }}
        </div>
    @endif

    <div style="background: #fff; border-radius: 12px; padding: 25px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">

        <h2 style="margin-bottom: 20px;">🚚 Rastreio da entrega</h2>

        <p><strong>Cliente:</strong> {{ $movimentacao->nome }}</p>

        <p><strong>Endereço:</strong>
            {{ $movimentacao->endereco }},
            {{ $movimentacao->numero }} -
            {{ $movimentacao->bairro }} -
            {{ $movimentacao->cidade }}
        </p>

        @if($rastreio)

            <div style="background: #ecfdf5; color: #065f46; padding: 15px; border-radius: 8px; margin-top: 20px;">
                <strong>✅ Rastreio já gerado para esta entrega.</strong><br><br>

                <strong>Código:</strong> {{ $rastreio->codigo_rastreio }}<br>
                <strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $rastreio->status)) }}

                <div style="display: flex; gap: 12px; margin-top: 20px; flex-wrap: wrap;">

                    @if($rastreio->link_whatsapp)
                        <a href="{{ $rastreio->link_whatsapp }}" target="_blank"
                           style="background: #22c55e; color: #fff; padding: 12px 18px; border-radius: 8px; text-decoration: none; font-weight: bold;">
                            📲 Enviar WhatsApp ao cliente
                        </a>
                    @endif

                    @if($rastreio->link_rastreio)
                        <a href="{{ $rastreio->link_rastreio }}" target="_blank"
                           style="background: #e5e7eb; color: #111827; padding: 12px 18px; border-radius: 8px; text-decoration: none; font-weight: bold;">
                            🔎 Abrir rastreio
                        </a>
                    @endif

                    

                   <a href="{{ route('movimentacao.index') }}"
                        style="background: #d1d5db; color: #111827; padding: 12px 18px; border-radius: 8px; text-decoration: none; font-weight: bold;">
                        ⬅ Voltar
                    </a>

                </div>
            </div>

        @else

            <div style="background: #f8fafc; padding: 15px; border-radius: 8px; margin-top: 20px;">
                <strong>Deseja gerar rastreio para esta entrega?</strong>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 25px; flex-wrap: wrap;">

                <form method="POST" action="{{ route('movimentacao.gerar-rastreio', $movimentacao->id) }}">
                    @csrf
                    <button type="submit"
                        style="background: #2563eb; color: #fff; padding: 12px 18px; border-radius: 8px; border: none; cursor: pointer; font-weight: bold;">
                        Sim, gerar rastreio
                    </button>
                </form>

              <a href="{{ route('movimentacao.index') }}"
                    style="background: #e5e7eb; color: #111827; padding: 12px 18px; border-radius: 8px; text-decoration: none; font-weight: bold;">
                    Não, continuar sem rastreio
                </a>
            </div>

        @endif

    </div>
</div>
@endsection