@extends('layouts.app')
@section('title', 'Controle de Vasilhames')

@section('content')
<div class="container-fluid pagina-controle py-4">

    <style>
        .pagina-controle {
            background: #f3f3f3;
            min-height: 100vh;
        }

        .topo-grid {
            display: grid;
            grid-template-columns: 320px 1fr 520px;
            gap: 28px;
            align-items: start;
        }

        .painel-esquerdo {
            width: 100%;
            overflow: hidden;
        }

        .painel-centro {
            min-height: 100px;
        }

        .painel-direito {
            width: 100%;
        }

        .box-sombra {
            background: #fff;
            border: 1px solid #d8d8d8;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
        }

        .titulo-resumo {
            background: #d9e3ef;
            border-radius: 16px 16px 0 0;
            text-align: center;
            font-size: 34px;
            font-weight: 800;
            color: #000;
            padding: 12px 10px;
            letter-spacing: .5px;
        }

        .form-area {
            padding: 8px 10px;
        }

        .form-area .emprestados-bloco {
            margin-left: -10px;
            margin-right: -10px;
            width: calc(100% + 20px);
        }

        .form-area label {
            font-weight: 700;
            color: #222;
            margin-bottom: 2px;
            display: block;
            font-size: 17px;
        }

        .campo-planilha {
            width: 100%;
            height: 36px;
            border: 2px solid #6f6f6f;
            background: #efe6c7;
            padding: 4px 8px;
            font-size: 16px;
        }

        .campo-planilha-textarea {
            width: 100%;
            border: 2px solid #6f6f6f;
            background: #efe6c7;
            padding: 6px 8px;
            font-size: 15px;
            min-height: 90px;
            resize: vertical;
        }

        .linha-campo {
            margin-bottom: 8px;
        }

        .btn-salvar-custom {
            background: #214e7a;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 22px;
            font-weight: 700;
            box-shadow: 0 2px 6px rgba(0,0,0,.12);
        }

        .btn-salvar-custom:hover {
            background: #183b5d;
            color: #fff;
        }

        .obs-box {
            margin-top: 24px;
            background: #e9dfdf;
            border: 1px solid #d5c7c7;
            min-height: 84px;
            padding: 12px;
            font-size: 13px;
            color: #9a6400;
            width: 330px;
        }

        .resumo-tabela {
            width: 100%;
            border-collapse: collapse;
        }

        .resumo-tabela td {
            border: 1px solid #e3e3e3;
            padding: 10px 12px;
            font-size: 19px;
            line-height: 1.1;
        }

        .resumo-label {
            background: #efefef;
            font-weight: 700;
            text-align: center;
            white-space: nowrap;
        }

        .resumo-valor {
            background: #dfead7;
            width: 160px;
            text-align: center;
            font-weight: 800;
            font-size: 22px;
        }

        .texto-divergente {
            color: #e25a68;
            font-weight: 900;
        }

        .cards-resumo {
            display: flex;
            justify-content: space-between;
            gap: 18px;
            margin: 26px 10px 0 10px;
            flex-wrap: wrap;
        }

        .card-mini {
            min-width: 150px;
            height: 92px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-radius: 0;
            box-shadow: none;
            border: none;
        }

        .card-mini .titulo {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 6px;
            color: #222;
        }

        .card-mini .numero {
            font-size: 24px;
            font-weight: 800;
            color: #111;
        }

        .bg-cheios { background: #dfead7; }
        .bg-vazios { background: #f5e2cd; }
        .bg-emprestados { background: #dfead7; }
        .bg-vendidos { background: #efe3b7; }
        .bg-estoque { background: #dfead7; }
        .bg-divergencia { background: #efcaca; }

        .historico-bloco {
            margin-top: 34px;
        }

        .titulo-historico {
            background: #d9e3ef;
            text-align: center;
            font-size: 36px;
            font-weight: 900;
            padding: 12px;
            color: #000;
        }

        .tabela-historico {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: #fff;
        }

        .tabela-historico thead th {
            background: #161616;
            color: #fff;
            text-align: center;
            font-size: 18px;
            font-weight: 800;
            padding: 8px 10px;
            border-right: 2px solid #fff;
            white-space: nowrap;
        }

        .tabela-historico tbody td {
            font-size: 18px;
            text-align: center;
            padding: 10px 10px;
            border-bottom: 1px solid #ddd;
            background: #fff;
            white-space: nowrap;
        }

        .status-ok {
            color: #198754;
            font-weight: 800;
        }

        .status-divergente {
            color: #e25a68;
            font-weight: 900;
        }

        .mensagem-sucesso {
            max-width: 600px;
        }

        /* ── Bloco de emprestados ── */
        .emprestados-bloco {
            border: 1px solid #d8d8d8;
            border-radius: 12px;
            background: #fff;
            overflow: hidden;
            width: 100%;
        }

        .emprestados-titulo {
            background: #d9e3ef;
            text-align: center;
            font-size: 16px;
            font-weight: 800;
            padding: 8px 10px;
            color: #214e7a;
            letter-spacing: .3px;
        }

        .emprestados-form {
            padding: 8px 10px 6px;
            display: grid;
            grid-template-columns: 1.5fr 1fr 60px 130px 130px auto;
            gap: 6px;
            align-items: end;
            background: #f9f9f9;
            border-bottom: 1px solid #e3e3e3;
        }

        .emp-datas {
            display: contents;
        }

        .emprestados-form input {
            width: 100%;
            height: 32px;
            border: 1px solid #999;
            background: #efe6c7;
            padding: 3px 6px;
            font-size: 13px;
            border-radius: 4px;
        }

        .emprestados-form label {
            font-size: 11px;
            font-weight: 700;
            color: #444;
            margin-bottom: 2px;
            display: block;
        }

        .btn-add-emp {
            height: 32px;
            background: #214e7a;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 0 12px;
            font-size: 20px;
            font-weight: 900;
            cursor: pointer;
            line-height: 1;
        }

        .btn-add-emp:hover {
            background: #183b5d;
        }

        .tabela-emp {
            width: 100%;
            border-collapse: collapse;
        }

        .tabela-emp thead th {
            background: #214e7a;
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            padding: 7px 8px;
            text-align: center;
        }

        .tabela-emp tbody td {
            font-size: 13px;
            text-align: center;
            padding: 6px 8px;
            border-bottom: 1px solid #eee;
        }

        .tabela-emp tbody tr:nth-child(even) td {
            background: #f4f8ff;
        }

        .btn-remover-emp {
            background: none;
            border: none;
            color: #e25a68;
            font-size: 16px;
            cursor: pointer;
            font-weight: 900;
        }

        .td-entrega.editavel {
            cursor: pointer;
            transition: background 0.15s;
        }

        .td-entrega.editavel:hover {
            background: #eaf3ff !important;
            outline: 2px dashed #214e7a;
        }

        .emp-vazio {
            text-align: center;
            color: #aaa;
            font-size: 13px;
            padding: 12px;
        }

        @media (max-width: 1400px) {
            .topo-grid {
                grid-template-columns: 300px 1fr 480px;
            }

            .titulo-resumo {
                font-size: 28px;
            }

            .resumo-tabela td {
                font-size: 17px;
            }
        }

        @media (max-width: 1100px) {
            .topo-grid {
                grid-template-columns: 1fr;
            }

            .obs-box {
                width: 100%;
            }

            .cards-resumo {
                justify-content: center;
            }

            .emprestados-form {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>

    @if(session('success'))
        <div class="alert alert-success mensagem-sucesso">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mensagem-sucesso">
            <strong>Corrija os erros abaixo:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="topo-grid">

        {{-- ESQUERDA --}}
        <div class="painel-esquerdo">
            <div class="form-area">
                <form action="{{ route('controle-vasilhames.store') }}" method="POST">
                    @csrf

                    <div class="linha-campo">
                        <label>Data</label>
                        <input type="date" name="data_referencia" class="campo-planilha"
                               value="{{ old('data_referencia') }}" required>
                    </div>

                    <div class="linha-campo">
                        <label>Total de vasilhames</label>
                        <input type="number" name="total_vasilhames" class="campo-planilha"
                               value="{{ old('total_vasilhames') }}" min="0" required>
                    </div>

                    <div class="linha-campo">
                        <label>Cheios</label>
                        <input type="number" name="cheios" class="campo-planilha"
                               value="{{ old('cheios') }}" min="0" required>
                    </div>

                    <div class="linha-campo">
                        <label>Vazios</label>
                        <input type="number" name="vazios" class="campo-planilha"
                               value="{{ old('vazios') }}" min="0" required>
                    </div>

                    <div class="linha-campo">
                        <label>Emprestados</label>
                        <input type="number" name="emprestados" class="campo-planilha"
                               value="{{ old('emprestados') }}" min="0" required>
                    </div>

                    <div class="linha-campo">
                        <label>Vendidos no período</label>
                        <input type="number" name="vendidos" class="campo-planilha"
                               value="{{ old('vendidos') }}" min="0" required>
                    </div>

                    <div class="linha-campo">
                        <label>Observação</label>
                        <textarea name="observacao" class="campo-planilha-textarea">{{ old('observacao') }}</textarea>
                    </div>

                    <button type="submit" class="btn-salvar-custom">
                        Salvar Controle
                    </button>
                </form>
            </div>
        </div>

        {{-- CENTRO --}}
        <div class="painel-centro">
            <div class="obs-box" style="width:100%; margin-bottom: 16px;">
                <strong>Observação:</strong><br>
                Vendidos no período é informativo e não entra no total sob controle.<br>
                A divergência funciona como alerta para identificar diferença no fechamento.
            </div>

            {{-- BLOCO EMPRESTADOS INFORMATIVO --}}
            <div class="emprestados-bloco">
                <div class="emprestados-titulo">📋 DETALHE DOS EMPRESTADOS <span style="font-size:11px; font-weight:400;">(informativo)</span></div>

                <div class="emprestados-form">
                    <div>
                        <label>Cliente</label>
                        <input type="text" id="emp-cliente" placeholder="Nome do cliente">
                    </div>
                    <div>
                        <label>Produto</label>
                        <input type="text" id="emp-produto" placeholder="Ex: GLP P13">
                    </div>
                    <div>
                        <label>Qtde.</label>
                        <input type="number" id="emp-qtde" min="1" placeholder="0">
                    </div>
                    <div>
                        <label>Dt. Saída</label>
                        <input type="date" id="emp-data-emp">
                    </div>
                    <div>
                        <label>Dt. Previsão</label>
                        <input type="date" id="emp-data-ent">
                    </div>
                    <div>
                        <label>&nbsp;</label>
                        <button class="btn-add-emp" onclick="adicionarEmprestado()" title="Adicionar linha">+</button>
                    </div>
                </div>

                <table class="tabela-emp">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Produto</th>
                            <th>Qtde.</th>
                            <th>Dt. Saída</th>
                            <th>Dt. Previsão</th>
                            <th>Dt. Devolução</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="emp-tbody">
                        <tr id="emp-linha-vazia">
                            <td colspan="8" class="emp-vazio">Nenhum emprestado informado.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- DIREITA --}}
        <div class="painel-direito">
            <div class="box-sombra">
                <div class="titulo-resumo">RESUMO AUTOMÁTICO</div>
                <table class="resumo-tabela">
                    <tbody>
                        <tr>
                            <td class="resumo-label">Total GERAL</td>
                            <td class="resumo-valor">{{ $controle->total_vasilhames ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td class="resumo-label">Total em estoque (cheios + vazios)</td>
                            <td class="resumo-valor">{{ $controle->total_estoque ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td class="resumo-label">Total sob controle</td>
                            <td class="resumo-valor">{{ $controle->total_sob_controle ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td class="resumo-label">Diferença p/ total cadastrado</td>
                            <td class="resumo-valor">{{ $controle->diferenca ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td class="resumo-label">Status da conferência</td>
                            <td class="resumo-valor">
                                @if(($controle->diferenca ?? 0) == 0)
                                    <span class="status-ok">OK</span>
                                @else
                                    <span class="texto-divergente">DIVERGENTE</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="resumo-label">% cheios no estoque</td>
                            <td class="resumo-valor">
                                {{ (($controle->total_estoque ?? 0) > 0) ? number_format((($controle->cheios / $controle->total_estoque) * 100), 1, ',', '.') : '0,0' }}%
                            </td>
                        </tr>
                        <tr>
                            <td class="resumo-label">% vazios no estoque</td>
                            <td class="resumo-valor">
                                {{ (($controle->total_estoque ?? 0) > 0) ? number_format((($controle->vazios / $controle->total_estoque) * 100), 1, ',', '.') : '0,0' }}%
                            </td>
                        </tr>
                        <tr>
                            <td class="resumo-label">% emprestados do total</td>
                            <td class="resumo-valor">
                                {{ (($controle->total_vasilhames ?? 0) > 0) ? number_format((($controle->emprestados / $controle->total_vasilhames) * 100), 1, ',', '.') : '0,0' }}%
                            </td>
                        </tr>
                        <tr>
                            <td class="resumo-label">Vasilhames vendidos com a carga</td>
                            <td class="resumo-valor">{{ $controle->vendidos ?? 0 }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    {{-- CARDS --}}
    <div class="cards-resumo">
        <div class="card-mini bg-cheios">
            <div class="titulo">Cheios</div>
            <div class="numero">{{ $controle->cheios ?? 0 }}</div>
        </div>

        <div class="card-mini bg-vazios">
            <div class="titulo">Vazios</div>
            <div class="numero">{{ $controle->vazios ?? 0 }}</div>
        </div>

        <div class="card-mini bg-emprestados">
            <div class="titulo">Emprestados</div>
            <div class="numero">{{ $controle->emprestados ?? 0 }}</div>
        </div>

        <div class="card-mini bg-vendidos">
            <div class="titulo">Vendidos</div>
            <div class="numero">{{ $controle->vendidos ?? 0 }}</div>
        </div>

        <div class="card-mini bg-estoque">
            <div class="titulo">Total em Estoque</div>
            <div class="numero">{{ $controle->total_estoque ?? 0 }}</div>
        </div>

        <div class="card-mini bg-divergencia">
            <div class="titulo">Divergência</div>
            <div class="numero">{{ $controle->diferenca ?? 0 }}</div>
        </div>
    </div>

    {{-- HISTÓRICO --}}
    <div class="historico-bloco">
        <div class="titulo-historico">HISTÓRICO DIÁRIO</div>

        <div class="table-responsive bg-white p-2">
            <table class="tabela-historico w-100">
                <thead>
                    <tr>
                        <th>
                            <span data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Data do fechamento diário do controle.">
                                Data
                            </span>
                        </th>
                        <th>
                            <span data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Quantidade total de vasilhames que deveriam estar sob responsabilidade no dia.">
                                Total
                            </span>
                        </th>
                        <th>
                            <span data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Quantidade de vasilhames cheios em estoque.">
                                Cheios
                            </span>
                        </th>
                        <th>
                            <span data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Quantidade de vasilhames vazios em estoque.">
                                Vazios
                            </span>
                        </th>
                        <th>
                            <span data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Quantidade de vasilhames fora da empresa, mas ainda sob sua responsabilidade.">
                                Emprestados
                            </span>
                        </th>
                        <th>
                            <span data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Campo informativo. Vendidos no período não entram no total sob controle.">
                                Vendidos
                            </span>
                        </th>
                        <th>
                            <span data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Quantidade de vasilhames que retornaram no período.">
                                Retornaram
                            </span>
                        </th>
                        <th>
                            <span data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Total em estoque = cheios + vazios.">
                                Estoque
                            </span>
                        </th>
                        <th>
                            <span data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Total sob controle = cheios + vazios + emprestados.">
                                Sob Controle
                            </span>
                        </th>
                        <th>
                            <span data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Diferença entre o total cadastrado e o total sob controle. Serve como alerta de conferência.">
                                Diferença
                            </span>
                        </th>
                        <th>
                            <span data-bs-toggle="tooltip" data-bs-placement="top"
                                title="OK quando o fechamento bate. Divergente quando existe diferença.">
                                Status
                            </span>
                        </th>
                        <th>
                            <span data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Ações para editar ou excluir o registro.">
                                Ações
                            </span>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($historico as $item)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($item->data_referencia)->format('d/m/Y') }}</td>
                            <td>{{ $item->total_vasilhames }}</td>
                            <td>{{ $item->cheios }}</td>
                            <td>{{ $item->vazios }}</td>
                            <td>{{ $item->emprestados }}</td>
                            <td>{{ $item->vendidos }}</td>
                            <td>{{ $item->retornaram }}</td>
                            <td>{{ $item->total_estoque }}</td>
                            <td>
                                <span data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Cheios ({{ $item->cheios }}) + Vazios ({{ $item->vazios }}) + Emprestados ({{ $item->emprestados }}) = {{ $item->total_sob_controle }}">
                                    {{ $item->total_sob_controle }}
                                </span>
                            </td>
                            <td>
                                <span data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Total cadastrado ({{ $item->total_vasilhames }}) - Sob controle ({{ $item->total_sob_controle }}) = {{ $item->diferenca }}">
                                    {{ $item->diferenca }}
                                </span>
                            </td>
                            <td>
                                @if($item->diferenca == 0)
                                    <span class="status-ok"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="Não existe diferença neste fechamento.">
                                        OK
                                    </span>
                                @else
                                    <span class="status-divergente"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="Existe divergência neste fechamento e o registro precisa ser conferido.">
                                        DIVERGENTE
                                    </span>
                                @endif
                            </td>
                            <td>
                                {{-- Ações comentadas no original --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center">Nenhum registro encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $historico->links() }}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // ── Tooltips Bootstrap ──
    document.addEventListener('DOMContentLoaded', function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    // ── Tabela de emprestados — integrada ao banco via fetch ──
    const EMP_URL = '{{ url("vasilhame-emprestimos") }}';
    const CSRF    = '{{ csrf_token() }}';

    function formatarData(valor) {
        if (!valor) return '—';
        // Aceita tanto 'YYYY-MM-DD' quanto 'YYYY-MM-DDTHH:...'
        const parte = valor.substring(0, 10);
        const [ano, mes, dia] = parte.split('-');
        return `${dia}/${mes}/${ano}`;
    }

    function badgeStatus(status) {
        if (status === 'devolvido') {
            return '<span style="background:#d4edda;color:#155724;border-radius:6px;padding:2px 8px;font-size:12px;font-weight:700;">Devolvido</span>';
        }
        return '<span style="background:#fff3cd;color:#856404;border-radius:6px;padding:2px 8px;font-size:12px;font-weight:700;">Emprestado</span>';
    }

    function celulaDevolucao(dataDevolucao, id, status) {
        if (status === 'devolvido') {
            return `<span style="color:#198754;font-weight:700;">${formatarData(dataDevolucao)}</span>`;
        }
        return `<span class="td-dev-texto" style="color:#aaa;font-style:italic;font-size:12px;">clique p/ devolver</span>`;
    }

    function criarLinha(item) {
        const tr = document.createElement('tr');
        tr.dataset.id = item.id;
        if (item.status === 'devolvido') {
            tr.style.opacity = '0.6';
        }
        tr.innerHTML = `
            <td>${item.cliente}</td>
            <td>${item.produto ?? '—'}</td>
            <td>${item.quantidade}</td>
            <td>${formatarData(item.data_saida)}</td>
            <td>${formatarData(item.data_previsao_devolucao)}</td>
            <td class="td-entrega ${item.status !== 'devolvido' ? 'editavel' : ''}"
                title="${item.status !== 'devolvido' ? 'Clique para registrar a devolução' : ''}"
                ${item.status !== 'devolvido' ? `onclick="editarEntrega(this, ${item.id})"` : ''}
                data-valor="${item.data_devolucao ?? ''}">
                ${celulaDevolucao(item.data_devolucao, item.id, item.status)}
            </td>
            <td>${badgeStatus(item.status)}</td>
            <td>
                <button class="btn-remover-emp" onclick="removerLinha(this, ${item.id})" title="Remover">✕</button>
            </td>
        `;
        return tr;
    }

    function carregarEmprestados() {
        fetch(EMP_URL, { headers: { 'Accept': 'application/json' } })
            .then(r => r.json())
            .then(dados => {
                const tbody = document.getElementById('emp-tbody');
                tbody.innerHTML = '';
                if (dados.length === 0) {
                    tbody.innerHTML = '<tr id="emp-linha-vazia"><td colspan="8" class="emp-vazio">Nenhum emprestado informado.</td></tr>';
                    return;
                }
                dados.forEach(item => tbody.appendChild(criarLinha(item)));
            })
            .catch(() => console.error('Erro ao carregar emprestados.'));
    }

    function adicionarEmprestado() {
        const cliente  = document.getElementById('emp-cliente').value.trim();
        const produto  = document.getElementById('emp-produto').value.trim();
        const qtde     = document.getElementById('emp-qtde').value.trim();
        const dataEmp  = document.getElementById('emp-data-emp').value;
        const dataEnt  = document.getElementById('emp-data-ent').value;

        if (!cliente || !qtde || !dataEmp) {
            alert('Preencha ao menos Cliente, Quantidade e Data de Saída.');
            return;
        }

        fetch(EMP_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept':       'application/json',
                'X-CSRF-TOKEN': CSRF
            },
            body: JSON.stringify({
                cliente:                 cliente,
                produto:                 produto,
                quantidade:              qtde,
                data_saida:              dataEmp,
                data_previsao_devolucao: dataEnt || null
            })
        })
        .then(r => r.json())
        .then(item => {
            const linhaVazia = document.getElementById('emp-linha-vazia');
            if (linhaVazia) linhaVazia.remove();

            document.getElementById('emp-tbody').appendChild(criarLinha(item));

            document.getElementById('emp-cliente').value  = '';
            document.getElementById('emp-produto').value  = '';
            document.getElementById('emp-qtde').value     = '';
            document.getElementById('emp-data-emp').value = '';
            document.getElementById('emp-data-ent').value = '';
            document.getElementById('emp-cliente').focus();
        })
        .catch(() => alert('Erro ao salvar empréstimo.'));
    }

    function editarEntrega(td, id) {
        if (td.querySelector('input')) return;

        const valorAtual = td.dataset.valor || '';
        td.innerHTML = `<input type="date" value="${valorAtual}"
            style="border:1px solid #214e7a; border-radius:4px; padding:2px 4px; font-size:13px; width:130px;"
            onblur="confirmarEntrega(this, ${id})"
            onkeydown="if(event.key==='Enter') this.blur(); if(event.key==='Escape') cancelarEntrega(this);"
            autofocus>`;
    }

    function confirmarEntrega(input, id) {
        const td    = input.closest('td');
        const valor = input.value;

        if (!valor) {
            cancelarEntrega(input);
            return;
        }

        fetch(`${EMP_URL}/${id}/devolver`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept':       'application/json',
                'X-CSRF-TOKEN': CSRF
            },
            body: JSON.stringify({ data_devolucao: valor })
        })
        .then(r => r.json())
        .then(item => {
            // Recarrega a tabela para refletir status atualizado
            carregarEmprestados();
        })
        .catch(() => {
            alert('Erro ao registrar devolução.');
            cancelarEntrega(input);
        });
    }

    function cancelarEntrega(input) {
        const td    = input.closest('td');
        const valor = td.dataset.valor || '';
        td.innerHTML = valor
            ? `<span style="color:#198754;font-weight:700;">${formatarData(valor)}</span>`
            : '<span style="color:#aaa;font-style:italic;font-size:12px;">clique p/ devolver</span>';
    }

    function removerLinha(btn, id) {
        if (!confirm('Deseja realmente excluir este registro?')) return;

        fetch(`${EMP_URL}/${id}`, {
            method: 'DELETE',
            headers: {
                'Accept':       'application/json',
                'X-CSRF-TOKEN': CSRF
            }
        })
        .then(r => r.json())
        .then(() => {
            btn.closest('tr').remove();
            const tbody = document.getElementById('emp-tbody');
            if (tbody.querySelectorAll('tr[data-id]').length === 0) {
                tbody.innerHTML = '<tr id="emp-linha-vazia"><td colspan="8" class="emp-vazio">Nenhum emprestado informado.</td></tr>';
            }
        })
        .catch(() => alert('Erro ao excluir registro.'));
    }

    // Carrega ao abrir a página
    document.addEventListener('DOMContentLoaded', carregarEmprestados);

    // Enter nos campos do formulário
    ['emp-cliente','emp-produto','emp-qtde','emp-data-emp','emp-data-ent'].forEach(function(id) {
        document.getElementById(id).addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                adicionarEmprestado();
            }
        });
    });
</script>

@endsection
