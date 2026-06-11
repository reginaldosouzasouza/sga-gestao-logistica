@extends('layouts.app')

@section('title', 'Aniversariantes')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/aniversariantes.css') }}">
@endsection

@section('content')

<div class="aniversariantes-page">
    <div class="container">

        <h2 class="page-title">Aniversariantes dos Clientes</h2>
        <p class="page-subtitle">
            Acompanhe os clientes que fazem aniversário hoje e durante o mês.
        </p>

        <div class="birthday-summary">
            <div class="summary-card today">
                <span class="label">Aniversariantes hoje</span>
                <span class="number">{{ $aniversariantesHoje->count() }}</span>
            </div>

            <div class="summary-card month">
                <span class="label">Aniversariantes no mês</span>
                <span class="number">{{ $aniversariantesMes->count() }}</span>
            </div>
        </div>

        <div class="birthday-card">
            <div class="birthday-card-header today">
                <span>🎉 Aniversariantes de Hoje</span>
                <small>{{ now()->format('d/m/Y') }}</small>
            </div>

            <div class="birthday-card-body">
                @if($aniversariantesHoje->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Telefone</th>
                                    <th>Data de Nascimento</th>
                                    <th width="180">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aniversariantesHoje as $cliente)
                                    @php
                                        $telefoneLimpo = preg_replace('/\D/', '', $cliente->telefone);

                                        if (strlen($telefoneLimpo) === 11) {
                                            $telefoneWhatsapp = '55' . $telefoneLimpo;
                                        } elseif (strlen($telefoneLimpo) === 13 && substr($telefoneLimpo, 0, 2) === '55') {
                                            $telefoneWhatsapp = $telefoneLimpo;
                                        } else {
                                            $telefoneWhatsapp = null;
                                        }


                                       $primeiroNome = explode(' ', trim($cliente->nome))[0];

                                        $emojiFesta = json_decode('"\uD83C\uDF89"'); // 🎉
                                        $emojiBolo  = json_decode('"\uD83C\uDF82"'); // 🎂

                                        $mensagem = "Olá, *{$primeiroNome}*! {$emojiFesta}\n\n"
                                            . "Hoje é um dia especial!\n\n"
                                            . "A equipe *MARIGÁS* deseja a você um feliz aniversário, com muita saúde, alegria, paz e bênçãos.\n\n"
                                            . "Que seu novo ciclo seja cheio de conquistas.\n\n"
                                            . "Parabéns pelo seu dia! {$emojiBolo}\n\n"
                                            . "Com carinho,\n"
                                            . "Equipe *MARIGÁS*";

                                        $linkWhatsapp = $telefoneWhatsapp
                                            ? 'https://api.whatsapp.com/send?phone=' . $telefoneWhatsapp . '&text=' . rawurlencode($mensagem)
                                            : null;
                                    @endphp

                                    <tr>
                                        <td data-label="Cliente">
                                            <span class="cliente-nome">{{ $cliente->nome }}</span>
                                        </td>

                                        <td data-label="Telefone">
                                            <span class="cliente-telefone">{{ $cliente->telefone }}</span>
                                        </td>

                                        <td data-label="Data de Nascimento">
                                            <span class="birthday-date">
                                                {{ \Carbon\Carbon::parse($cliente->nascimento)->format('d/m/Y') }}
                                            </span>
                                        </td>

                                        <td data-label="Ação">
                                            @if($linkWhatsapp)
                                                <a href="{{ $linkWhatsapp }}" target="_blank" class="btn-whatsapp">
                                                    Enviar WhatsApp
                                                </a>
                                            @else
                                                <span class="badge-invalid-phone">Telefone inválido</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        Nenhum cliente faz aniversário hoje.
                    </div>
                @endif
            </div>
        </div>

        <div class="birthday-card">
            <div class="birthday-card-header month">
                <span>📅 Aniversariantes do Mês</span>
                <small>{{ now()->format('m/Y') }}</small>
            </div>

            <div class="birthday-card-body">
                @if($aniversariantesMes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Dia</th>
                                    <th>Cliente</th>
                                    <th>Telefone</th>
                                    <th>Data de Nascimento</th>
                                    <th width="180">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aniversariantesMes as $cliente)
                                    @php
                                        $telefoneLimpo = preg_replace('/\D/', '', $cliente->telefone);

                                        if (strlen($telefoneLimpo) === 11) {
                                            $telefoneWhatsapp = '55' . $telefoneLimpo;
                                        } elseif (strlen($telefoneLimpo) === 13 && substr($telefoneLimpo, 0, 2) === '55') {
                                            $telefoneWhatsapp = $telefoneLimpo;
                                        } else {
                                            $telefoneWhatsapp = null;
                                        }

                                       $primeiroNome = explode(' ', trim($cliente->nome))[0];

                                        $emojiFesta = json_decode('"\uD83C\uDF89"'); // 🎉
                                        $emojiBolo  = json_decode('"\uD83C\uDF82"'); // 🎂

                                        $mensagem = "Olá, *{$primeiroNome}*! {$emojiFesta}\n\n"
                                            . "Hoje é um dia especial!\n\n"
                                            . "A equipe *MARIGÁS* deseja a você um feliz aniversário, com muita saúde, alegria, paz e bênçãos.\n\n"
                                            . "Que seu novo ciclo seja cheio de conquistas.\n\n"
                                            . "Parabéns pelo seu dia! {$emojiBolo}\n\n"
                                            . "Com carinho,\n"
                                            . "Equipe *MARIGÁS*";

                                        $linkWhatsapp = $telefoneWhatsapp
                                            ? 'https://api.whatsapp.com/send?phone=' . $telefoneWhatsapp . '&text=' . rawurlencode($mensagem)
                                            : null;
                                        
                                    @endphp

                                    <tr>
                                        <td data-label="Dia">
                                            <span class="birthday-day">
                                                {{ \Carbon\Carbon::parse($cliente->nascimento)->format('d') }}
                                            </span>
                                        </td>

                                        <td data-label="Cliente">
                                            <span class="cliente-nome">{{ $cliente->nome }}</span>
                                        </td>

                                        <td data-label="Telefone">
                                            <span class="cliente-telefone">{{ $cliente->telefone }}</span>
                                        </td>

                                        <td data-label="Data de Nascimento">
                                            <span class="birthday-date">
                                                {{ \Carbon\Carbon::parse($cliente->nascimento)->format('d/m/Y') }}
                                            </span>
                                        </td>

                                        <td data-label="Ação">
                                            @if($linkWhatsapp)
                                                <a href="{{ $linkWhatsapp }}" target="_blank" class="btn-whatsapp">
                                                    Enviar WhatsApp
                                                </a>
                                            @else
                                                <span class="badge-invalid-phone">Telefone inválido</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        Nenhum aniversariante encontrado neste mês.
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>