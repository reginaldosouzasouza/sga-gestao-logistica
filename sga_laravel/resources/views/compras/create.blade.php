<!DOCTYPE html>
<html lang="Pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compras</title>
    <link rel="stylesheet" href="{{ asset('css/create-compras.css') }}">
</head>
<body>
    <div class="container">
        <h1>Cadastrar Compras</h1>
        <form action="{{ route('compras.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="fornecedor_id">Fornecedor:</label>
                <select name="fornecedor_id" required>
                    <option value="" disabled selected>Selecione um Fornecedor</option>
                    @foreach($fornecedores as $fornecedor)
                        <option value="{{ $fornecedor->id }}">{{ $fornecedor->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="nota_fiscal">Nota Fiscal:</label>
                <input type="text" name="nota_fiscal" placeholder="Digite a Nota Fiscal">
            </div>

            <div class="form-group">
                <label for="data_compra">Data da Compra:</label>
                <input type="date" name="data_compra" value="{{ date('Y-m-d') }}" required>
            </div>

            <div class="form-group">
                <label for="data_vencimento">Data de Vencimento:</label>
                <input type="date" name="data_vencimento" class="form-control" 
                    value="{{ old('data_vencimento', now()->addDays(30)->format('Y-m-d')) }}" readonly>
            </div>



            <div class="form-group">
                <label for="forma_pagamento_id">Forma de Pagamento:</label>
                <select name="forma_pagamento_id" required>
                    @foreach($formas_pagamento as $forma)
                        <option value="{{ $forma->id }}">{{ $forma->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="prazo_id">Prazo de Pagamento:</label>
                <select name="prazo_id" required>
                    <option value="" disabled selected>Selecione um Prazo</option>
                    @foreach($prazos as $prazo)
                        <option value="{{ $prazo->id }}">{{ $prazo->prazo }}</option>
                    @endforeach
                </select>
            </div>

            <h3>Itens da Compra</h3>

            <!-- Adicionando os rótulos de cabeçalho -->
            <div class="form-row-label">
                <label>Produto</label>
                <label>Quantidade</label>
                <label>Valor Unitário</label>
                <label>Valor Total do Item</label>
            </div>

            <div id="itens-container">
                <div class="item form-row">
                    <select name="itens[0][produto_id]" class="produto-select" onchange="atualizarValorUnitario(0)" required>
                        <option value="" disabled selected>Selecione um Produto</option>
                        @foreach($produtos as $produto)
                            <option value="{{ $produto->id }}" data-preco="{{ $produto->preco_compra }}">{{ $produto->nome }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="itens[0][quantidade]" class="quantidade" placeholder="Quantidade" oninput="calcularTotalItem(0)" required>
                    <input type="number" name="itens[0][valor_unitario]" class="valor-unitario" placeholder="Valor Unitário" step="0.01">
                    <input type="number" name="itens[0][valor_total]" class="valor-total" placeholder="Valor Total do Item" step="0.01" readonly>
                    <button type="button" class="btn btn-danger" onclick="removerItem(this)">Remover</button>
                </div>
            </div>

            <button type="button" class="btn-adicionar_item" onclick="adicionarItem()">Adicionar Item</button>

            <h3>Valor Total: R$ <span id="valor-total-compra">0.00</span></h3>
            <input type="hidden" name="valor_total_compra" id="valor_total_compra">

            <button type="submit" class="submit-btn">Salvar Compra</button>
        </form>
    </div>

    <script>
    let itemIndex = 1;

    function atualizarValorUnitario(index) {
        const selectProduto = document.querySelector(`[name="itens[${index}][produto_id]"]`);
        const valorUnitarioInput = document.querySelector(`[name="itens[${index}][valor_unitario]"]`);

        if (selectProduto && selectProduto.selectedIndex > 0) {
            const precoVenda = selectProduto.options[selectProduto.selectedIndex].dataset.preco;
            
            // Somente definir o valor unitário se o usuário ainda não tiver editado
            if (!valorUnitarioInput.dataset.editado) {
                valorUnitarioInput.value = parseFloat(precoVenda).toFixed(2);
            }
        }

        calcularTotalItem(index);
    }

    function calcularTotalItem(index) {
        const quantidadeInput = document.querySelector(`[name="itens[${index}][quantidade]"]`);
        const valorUnitarioInput = document.querySelector(`[name="itens[${index}][valor_unitario]"]`);
        const valorTotalInput = document.querySelector(`[name="itens[${index}][valor_total]"]`);

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
        const newItem = document.createElement('div');
        newItem.classList.add('item', 'form-row');
        newItem.innerHTML = `
            <select name="itens[${itemIndex}][produto_id]" class="produto-select" onchange="atualizarValorUnitario(${itemIndex})" required>
                <option value="" disabled selected>Selecione um Produto</option>
                @foreach($produtos as $produto)
                    <option value="{{ $produto->id }}" data-preco="{{ $produto->preco_compra }}">{{ $produto->nome }}</option>
                @endforeach
            </select>
            <input type="number" name="itens[${itemIndex}][quantidade]" class="quantidade" placeholder="Quantidade" oninput="calcularTotalItem(${itemIndex})" required>
            <input type="number" name="itens[${itemIndex}][valor_unitario]" class="valor-unitario" step="0.01" oninput="this.dataset.editado = true; calcularTotalItem(${itemIndex})">
            <input type="number" name="itens[${itemIndex}][valor_total]" class="valor-total" step="0.01" readonly>
            <button type="button" class="btn btn-danger" onclick="removerItem(this)">Remover</button>
        `;
        container.appendChild(newItem);
        itemIndex++;
    }

    function removerItem(button) {
        button.parentElement.remove();
        calcularValorTotalCompra();
    }
</script>



</body>
</html>
