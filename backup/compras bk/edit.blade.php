<!DOCTYPE html>
<html>
<head>
    <title>Consultar Compra</title>
    <!-- Link para o arquivo CSS separado -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/edit-compra.css') }}">
</head>
<body>
    <div class="container">
        <h1>Editar Compra</h1>
        <form action="{{ route('compras.update', $compra->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="fornecedor">Fornecedor:</label>
                <input type="text" class="form-control" id="fornecedor" name="fornecedor" value="{{ $compra->fornecedor->nome }}" disabled>
            </div>

            <div class="form-group">
                <label for="data_compra">Data da Compra:</label>
                <input type="date" name="data_compra" class="form-control"
                value="{{ old('data_compra', $compra->data_compra ? \Carbon\Carbon::parse($compra->data_compra)->format('Y-m-d') : '') }}" required>
            </div>


            <div class="form-group">
                <label for="produto">Produto:</label>
                <input type="text" class="form-control" id="produto" name="produto" value="{{ $compra->produto->nome }}" disabled>
            </div>

            <div class="form-group">
                <label for="quantidade">Quantidade:</label>
                <input type="number" class="form-control" id="quantidade" name="quantidade" value="{{ intval($compra->quantidade) }}" step="1">
            </div>

            <div class="form-group">
                <label for="preco_unitario">Preço Unitário:</label>
                <input type="text" class="form-control" id="preco_unitario" name="preco_unitario" value="{{ number_format($compra->preco_unitario, 2, ',', '.') }}">
            </div>

            <div class="form-group">
                <label for="total">Total:</label>
                <input type="text" class="form-control" id="total" name="total" value="{{ number_format($compra->total, 2, ',', '.') }}" disabled>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>

   
</body>
</html>


