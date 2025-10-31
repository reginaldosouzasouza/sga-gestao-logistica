<!DOCTYPE html>
<html lang="Pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Compras</title>
    <link rel="stylesheet" href="{{ asset('css/estilo-compras.css') }}">
    <style>
        .form-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .form-row > div {
            flex: 1;
            margin-right: 15px;
        }
        .form-row > div:last-child {
            margin-right: 0;
        }
    </style>
</head>
<body>
    <h1>Cadastrar Compras</h1>

    <form action="{{ route('compras.store') }}" method="POST">
    @csrf

    <!-- Primeira linha: Fornecedor e Nota Fiscal -->
    <div class="form-row">
        <!-- Campo Fornecedor -->
        <div>
            <label for="fornecedor_id">Fornecedor:</label>
            <select name="fornecedor_id" required>
                <option value="" disabled selected>Selecione um Fornecedor</option>
                @foreach($fornecedores as $fornecedor)
                <option value="{{ $fornecedor->id }}">{{ $fornecedor->nome }}</option>
                @endforeach
            </select>
        </div>

        <!-- Campo Nota Fiscal -->
        <div>
            <label for="nota_fiscal">Nota Fiscal:</label>
            <input type="text" name="nota_fiscal" id="nota_fiscal" placeholder="Digite a Nota Fiscal">
        </div>
    </div>

    <!-- Segunda linha: Data da Compra -->
    <div class="form-row">
        <!-- Campo Data da Compra -->
        <div>
            <label for="data_compra">Data da Compra:</label>
            <input type="date" name="data_compra" id="data_compra" value="{{ date('Y-m-d') }}" required>
        </div>
    </div>

    <!-- Campo Produto -->
    <div>
        <label for="produto_id">Produto:</label>
        <select name="produto_id" required>
            <option value="" disabled selected>Selecione um Produto</option>
            @foreach($produtos as $produto)
            <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
            @endforeach
        </select>
    </div>

    <!-- Campo Quantidade -->
    <div>
        <label for="quantidade">Quantidade:</label>
        <input type="number" name="quantidade" id="quantidade" required>
    </div>

    <!-- Campo Preço Unitário -->
    <div>
        <label for="preco_unitario">Preço Unitário:</label>
        <input type="number" name="preco_unitario" id="preco_unitario" step="0.01" required>
    </div>

        <!-- Campo Preço Total -->
    <div>
        <label for="preco_total">Preço Total:</label>
        <input type="number" id="preco_total" step="0.01" readonly>
        <input type="hidden" name="total" id="total">
    </div>

    <!-- Campo Preço Total 
    <div>
        <label for="preco_total">Preço Total:</label>
        <input type="number" name="preco_total" id="preco_total" step="0.01" readonly>
    </div> -->

    <!-- Campo Margem de Lucro -->
    <div>
        <label for="margem_lucro">Margem de Lucro (%):</label>
        <input type="number" name="margem_lucro" id="margem_lucro" step="0.01">
    </div>

    <!-- Campo Forma de Pagamento -->
        <div class="form-group">
            <label for="forma_pagamento_id">Forma de Pagamento</label>
                <select name="forma_pagamento_id" class="form-control" required>
                    @foreach ($formas_pagamento as $forma)
                <option value="{{ $forma->id }}">{{ $forma->nome }}</option>
                    @endforeach
                </select>
        </div>


    <!-- Campo Prazo de Pagamento -->
    <div>
        <label for="prazo_id">Prazo de Pagamento:</label>
        <select name="prazo_id" required>
            <option value="" disabled selected>Selecione um Prazo</option>
            @foreach($prazos as $prazo)
            <option value="{{ $prazo->id }}">{{ $prazo->prazo }}</option>
            @endforeach
        </select>
    </div>

    <!-- Campo Observação -->
    <div>
        <label for="observacao">Observação:</label>
        <textarea name="observacao" id="observacao" rows="3" placeholder="Insira observações aqui"></textarea>
    </div>

    <button type="submit">Salvar Compra</button>
    </form>

    <!-- Script para calcular o preço total automaticamente -->
    <script>
        document.getElementById('quantidade').addEventListener('input', calcularTotal);
        document.getElementById('preco_unitario').addEventListener('input', calcularTotal);

       
        function calcularTotal() {
            var quantidade = document.getElementById('quantidade').value;
            var precoUnitario = document.getElementById('preco_unitario').value;
            var total = quantidade * precoUnitario;
            document.getElementById('preco_total').value = total.toFixed(2);
            document.getElementById('total').value = total.toFixed(2); // Atualiza o campo hidden
        }
        /* function calcularTotal() {
            var quantidade = document.getElementById('quantidade').value;
            var precoUnitario = document.getElementById('preco_unitario').value;
            var total = quantidade * precoUnitario;
            document.getElementById('preco_total').value = total.toFixed(2);
        }*/
    </script>

</body>
</html>

