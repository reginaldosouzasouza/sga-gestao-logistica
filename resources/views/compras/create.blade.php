@extends('layouts.app')

@section('title', 'Cadastrar Compras')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/create-compras.css') }}">
@endsection

@section('content')

@php
    $dadosXml = $dadosXml ?? [];

    $itensCompra = old('itens', $dadosXml['itens'] ?? [
        [
            'produto_id' => '',
            'nome_produto_xml' => '',
            'quantidade' => '',
            'valor_unitario' => '',
            'valor_total' => '',
        ]
    ]);

    $valorTotalInicial = 0;

    foreach ($itensCompra as $item) {
        $valorTotalInicial += (float) ($item['valor_total'] ?? 0);
    }
@endphp

<div class="container">
    <h1>Cadastrar Compras</h1>

    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" style="margin-bottom: 15px;">
            {{ session('error') }}
        </div>
    @endif

    @if(!empty($dadosXml))
        <div class="alert alert-info" style="margin-bottom: 15px;">
            XML importado com sucesso. Confira os dados antes de salvar a compra.
        </div>
    @endif

    @if(!empty($dadosXml['nome_fornecedor']) && empty($dadosXml['fornecedor_id']))
        <div class="alert alert-warning" style="margin-bottom: 15px;">
            O fornecedor do XML foi encontrado como:
            <strong>{{ $dadosXml['nome_fornecedor'] }}</strong>

            @if(!empty($dadosXml['cnpj_fornecedor']))
                - CNPJ: <strong>{{ $dadosXml['cnpj_fornecedor'] }}</strong>
            @endif

            <br>
            Porém ele não foi localizado no cadastro de fornecedores. Selecione manualmente ou cadastre esse fornecedor.
        </div>
    @endif

    <form action="{{ route('compras.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="xml_nfe">Importar XML da NF-e:</label>

            <div style="display: flex; gap: 10px; align-items: center;">
                <input
                    type="file"
                    name="xml_nfe"
                    id="xml_nfe"
                    accept=".xml"
                    class="form-control"
                >

                <button
                    type="submit"
                    name="acao"
                    value="importar_xml"
                    class="btn btn-primary"
                    formnovalidate
                >
                    Importar XML
                </button>
            </div>

            <small style="color: #555;">
                Selecione o XML da nota fiscal de compra para preencher os dados automaticamente.
            </small>
        </div>

        <div class="form-group">
            <label for="fornecedor_id">Fornecedor:</label>

            <select name="fornecedor_id" id="fornecedor_id" required>
                <option value="" disabled
                    {{ old('fornecedor_id', $dadosXml['fornecedor_id'] ?? '') == '' ? 'selected' : '' }}>
                    Selecione um Fornecedor
                </option>

                @foreach($fornecedores as $fornecedor)
                    <option
                        value="{{ $fornecedor->id }}"
                        {{ old('fornecedor_id', $dadosXml['fornecedor_id'] ?? '') == $fornecedor->id ? 'selected' : '' }}
                    >
                        {{ $fornecedor->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="nota_fiscal">Nota Fiscal:</label>

            <input
                type="text"
                name="nota_fiscal"
                id="nota_fiscal"
                placeholder="Digite a Nota Fiscal"
                value="{{ old('nota_fiscal', $dadosXml['nota_fiscal'] ?? '') }}"
            >
        </div>

        <div class="form-group">
            <label for="data_compra">Data da Compra:</label>

            <input
                type="date"
                name="data_compra"
                id="data_compra"
                value="{{ old('data_compra', $dadosXml['data_compra'] ?? date('Y-m-d')) }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="data_vencimento">Data de Vencimento:</label>

            <input
                type="date"
                name="data_vencimento"
                id="data_vencimento"
                class="form-control"
                value="{{ old('data_vencimento', now()->addDays(30)->format('Y-m-d')) }}"
                readonly
            >
        </div>

        <div class="form-group">
            <label for="forma_pagamento_id">Forma de Pagamento:</label>

            <select name="forma_pagamento_id" id="forma_pagamento_id" required>
                @foreach($formas_pagamento as $forma)
                    <option
                        value="{{ $forma->id }}"
                        {{ old('forma_pagamento_id') == $forma->id ? 'selected' : '' }}
                    >
                        {{ $forma->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="parcelas">Parcelas:</label>

            <select name="parcelas" id="parcelas" required>
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ old('parcelas', 1) == $i ? 'selected' : '' }}>
                        {{ $i }}x
                    </option>
                @endfor
            </select>
        </div>

        <div class="form-group">
            <label for="prazo_id">Prazo de Pagamento:</label>

            <select name="prazo_id" id="prazo_id" required>
                <option value="" disabled {{ old('prazo_id') == '' ? 'selected' : '' }}>
                    Selecione um Prazo
                </option>

                @foreach($prazos as $prazo)
                    <option value="{{ $prazo->id }}" {{ old('prazo_id') == $prazo->id ? 'selected' : '' }}>
                        {{ $prazo->prazo }} dias
                    </option>
                @endforeach
            </select>
        </div>

        <h3>Itens da Compra</h3>

        <div class="form-row-label">
            <label>Produto</label>
            <label>Quantidade</label>
            <label>Valor Unitário</label>
            <label>Valor Total do Item</label>
        </div>

        <div id="itens-container">
            @foreach($itensCompra as $index => $item)
                <div class="item form-row">
                    <select
                        name="itens[{{ $loop->index }}][produto_id]"
                        class="produto-select"
                        onchange="atualizarValorUnitario({{ $loop->index }})"
                        required
                    >
                        <option value="" disabled
                            {{ empty($item['produto_id']) ? 'selected' : '' }}>
                            Selecione um Produto
                        </option>

                        @foreach($produtos as $produto)
                            <option
                                value="{{ $produto->id }}"
                                data-preco="{{ $produto->preco_compra }}"
                                {{ ($item['produto_id'] ?? '') == $produto->id ? 'selected' : '' }}
                            >
                                {{ $produto->nome }}
                            </option>
                        @endforeach
                    </select>

                    <input
                        type="number"
                        name="itens[{{ $loop->index }}][quantidade]"
                        class="quantidade"
                        placeholder="Quantidade"
                        step="0.001"
                        value="{{ $item['quantidade'] ?? '' }}"
                        oninput="calcularTotalItem({{ $loop->index }})"
                        required
                    >

                    <input
                        type="number"
                        name="itens[{{ $loop->index }}][valor_unitario]"
                        class="valor-unitario"
                        placeholder="Valor Unitário"
                        step="0.01"
                        value="{{ $item['valor_unitario'] ?? '' }}"
                        data-editado="{{ !empty($item['valor_unitario']) ? 'true' : '' }}"
                        oninput="this.dataset.editado = true; calcularTotalItem({{ $loop->index }})"
                    >

                    <input
                        type="number"
                        name="itens[{{ $loop->index }}][valor_total]"
                        class="valor-total"
                        placeholder="Valor Total do Item"
                        step="0.01"
                        value="{{ $item['valor_total'] ?? '' }}"
                        readonly
                    >

                    <button type="button" class="btn btn-danger" onclick="removerItem(this)">
                        Remover
                    </button>
                </div>

                @if(!empty($item['nome_produto_xml']) && empty($item['produto_id']))
                    <div class="alert alert-warning" style="margin-top: 5px; margin-bottom: 10px;">
                        Produto do XML não encontrado no cadastro:
                        <strong>{{ $item['nome_produto_xml'] }}</strong>.
                        Selecione manualmente o produto correspondente.
                    </div>
                @endif
            @endforeach
        </div>

        <button type="button" class="btn-adicionar_item" onclick="adicionarItem()">
            Adicionar Item
        </button>

        <h3>
            Valor Total: R$
            <span id="valor-total-compra">{{ number_format($valorTotalInicial, 2, '.', '') }}</span>
        </h3>

        <input
            type="hidden"
            name="valor_total_compra"
            id="valor_total_compra"
            value="{{ number_format($valorTotalInicial, 2, '.', '') }}"
        >

        <button type="submit" name="acao" value="salvar_compra" class="submit-btn">
            Salvar Compra
        </button>
    </form>
</div>

@endsection

@section('scripts')
<script>
    let itemIndex = {{ count($itensCompra) }};

    function atualizarValorUnitario(index) {
        const selectProduto = document.querySelector(`[name="itens[${index}][produto_id]"]`);
        const valorUnitarioInput = document.querySelector(`[name="itens[${index}][valor_unitario]"]`);

        if (selectProduto && selectProduto.selectedIndex > 0) {
            const precoCompra = selectProduto.options[selectProduto.selectedIndex].dataset.preco;

            if (!valorUnitarioInput.dataset.editado && precoCompra !== undefined && precoCompra !== '') {
                valorUnitarioInput.value = parseFloat(precoCompra).toFixed(2);
            }
        }

        calcularTotalItem(index);
    }

    function calcularTotalItem(index) {
        const quantidadeInput = document.querySelector(`[name="itens[${index}][quantidade]"]`);
        const valorUnitarioInput = document.querySelector(`[name="itens[${index}][valor_unitario]"]`);
        const valorTotalInput = document.querySelector(`[name="itens[${index}][valor_total]"]`);

        if (!quantidadeInput || !valorUnitarioInput || !valorTotalInput) {
            return;
        }

        const quantidade = parseFloat(quantidadeInput.value) || 0;
        const valorUnitario = parseFloat(valorUnitarioInput.value) || 0;
        const valorTotal = quantidade * valorUnitario;

        valorTotalInput.value = valorTotal.toFixed(2);
        calcularValorTotalCompra();
    }

    function calcularValorTotalCompra() {
        let valorTotalCompra = 0;

        document.querySelectorAll('.valor-total').forEach(item => {
            valorTotalCompra += parseFloat(item.value) || 0;
        });

        document.getElementById('valor-total-compra').innerText = valorTotalCompra.toFixed(2);
        document.getElementById('valor_total_compra').value = valorTotalCompra.toFixed(2);
    }

    function adicionarItem() {
        const container = document.getElementById('itens-container');
        const indexAtual = itemIndex;

        const newItem = document.createElement('div');
        newItem.classList.add('item', 'form-row');

        newItem.innerHTML = `
            <select name="itens[${indexAtual}][produto_id]" class="produto-select" onchange="atualizarValorUnitario(${indexAtual})" required>
                <option value="" disabled selected>Selecione um Produto</option>
                @foreach($produtos as $produto)
                    <option value="{{ $produto->id }}" data-preco="{{ $produto->preco_compra }}">
                        {{ $produto->nome }}
                    </option>
                @endforeach
            </select>

            <input
                type="number"
                name="itens[${indexAtual}][quantidade]"
                class="quantidade"
                placeholder="Quantidade"
                step="0.001"
                oninput="calcularTotalItem(${indexAtual})"
                required
            >

            <input
                type="number"
                name="itens[${indexAtual}][valor_unitario]"
                class="valor-unitario"
                step="0.01"
                placeholder="Valor Unitário"
                oninput="this.dataset.editado = true; calcularTotalItem(${indexAtual})"
            >

            <input
                type="number"
                name="itens[${indexAtual}][valor_total]"
                class="valor-total"
                step="0.01"
                placeholder="Valor Total do Item"
                readonly
            >

            <button type="button" class="btn btn-danger" onclick="removerItem(this)">
                Remover
            </button>
        `;

        container.appendChild(newItem);
        itemIndex++;
    }

    function removerItem(button) {
        const itens = document.querySelectorAll('#itens-container .item');

        if (itens.length <= 1) {
            alert('A compra precisa ter pelo menos um item.');
            return;
        }

        button.parentElement.remove();
        calcularValorTotalCompra();
    }

    document.addEventListener('DOMContentLoaded', function () {
        calcularValorTotalCompra();
    });
</script>
@endsection