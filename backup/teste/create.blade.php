<!DOCTYPE html>
<html lang="Pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compras</title>
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

    <!-- Campo de Upload para Importar XML -->
    <form action="{{ route('compras.importarXML') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <div>
                <label for="xml_file">Importar Nota Fiscal (XML):</label>
                <input type="file" name="xml_file" id="xml_file" accept=".xml" required>
            </div>
            <button type="submit">Importar XML</button>
        </div>
    </form>

    <form action="{{ route('compras.store') }}" method="POST">
    @csrf

    <!-- Campo Fornecedor -->
    <div class="form-row">
        <div>
            <label for="fornecedor">Fornecedor:</label>
            <input type="text" name="fornecedor" id="fornecedor" value="{{ $nomeFornecedor ?? '' }}" readonly>
        </div>

        <!-- Campo Nota Fiscal -->
        <div>
            <label for="nota_fiscal">Nota Fiscal:</label>
            <input type="text" name="nota_fiscal" id="nota_fiscal" value="{{ $numeroNotaFiscal ?? '' }}" readonly>
        </div>
    </div>

    <!-- Campo Valor Total da Nota -->
    <div class="form-row">
        <div>
            <label for="total">Valor Total da Nota:</label>
            <input type="number" name="total" id="total" value="{{ $valorTotalNota ?? '' }}" step="0.01" readonly>
        </div>
    </div>

    <!-- Campos de Produtos Importados do XML -->
    @if(isset($produtos) && count($produtos) > 0)
        @foreach($produtos as $produto)
            <div class="form-row">
                <!-- Nome do Produto -->
                <div>
                    <label for="produto_nome">Produto:</label>
                    <input type="text" name="produto_nome[]" value="{{ $produto['nome'] }}" readonly>
                </div>

                <!-- Quantidade -->
                <div>
                    <label for="quantidade">Quantidade:</label>
                    <input type="number" name="quantidade[]" value="{{ $produto['quantidade'] }}" readonly>
                </div>

                <!-- Preço Unitário -->
                <div>
                    <label for="preco_unitario">Preço Unitário:</label>
                    <input type="number" name="preco_unitario[]" value="{{ $produto['preco_unitario'] }}" step="0.01" readonly>
                </div>

                <!-- Preço Total -->
                <div>
                    <label for="preco_total">Preço Total:</label>
                    <input type="number" name="preco_total[]" value="{{ $produto['preco_total'] }}" step="0.01" readonly>
                </div>
            </div>
        @endforeach
    @endif
    

    <!-- Campos Adicionais -->
    <div>
        <label for="margem_lucro">Margem de Lucro (%):</label>
        <input type="number" name="margem_lucro" id="margem_lucro" step="0.01">
    </div>

    <div class="form-group">
        <label for="forma_pagamento_id">Forma de Pagamento</label>
        <select name="forma_pagamento_id" class="form-control" required>
            @foreach ($formas_pagamento as $forma)
                <option value="{{ $forma->id }}">{{ $forma->nome }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="prazo_id">Prazo de Pagamento:</label>
        <select name="prazo_id" required>
            <option value="" disabled selected>Selecione um Prazo</option>
            @foreach($prazos as $prazo)
                <option value="{{ $prazo->id }}">{{ $prazo->prazo }}</option>
            @endforeach
        </select>
    </div>

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
</script>

    
</body>
</html>
