<div class="row">
    <div class="col-md-3 mb-3">
        <label class="form-label">Código</label>
        <input type="text" class="form-control" value="{{ $vale->codigo ?? 'Gerado automaticamente' }}" disabled>
    </div>

    <div class="col-md-5 mb-3">
        <label class="form-label">Cliente *</label>
        <select name="cliente_id" class="form-control" required>
            <option value="">Selecione</option>
            @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}"
                    {{ old('cliente_id', $vale->cliente_id ?? '') == $cliente->id ? 'selected' : '' }}>
                    {{ $cliente->nome }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Data do Vale *</label>
        <input type="date" name="data_vale" class="form-control"
            value="{{ old('data_vale', isset($vale) ? $vale->data_vale->format('Y-m-d') : date('Y-m-d')) }}" required>
    </div>

    <div class="col-md-5 mb-3">
        <label class="form-label">Produto *</label>
        <select name="produto_id" class="form-control" required>
            <option value="">Selecione</option>
            @foreach($produtos as $produto)
                <option value="{{ $produto->id }}"
                    {{ old('produto_id', $vale->produto_id ?? '') == $produto->id ? 'selected' : '' }}>
                    {{ $produto->nome }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2 mb-3">
        <label class="form-label">Quantidade *</label>
        <input type="number" step="1" min="1" name="quantidade" class="form-control"
            value="{{ old('quantidade', $vale->quantidade ?? 1) }}" required>
    </div>

    <div class="col-md-2 mb-3">
        <label class="form-label">Valor Pago *</label>
        <input type="number" step="0.01" min="0" name="valor_pago" class="form-control"
            value="{{ old('valor_pago', $vale->valor_pago ?? 0) }}" required>
    </div>

    <div class="col-md-3 mb-3">
        <label class="form-label">Forma de Pagamento</label>
        <select name="forma_pagamento_id" class="form-control">
            <option value="">Selecione</option>
            @foreach($formasPagamento as $forma)
                <option value="{{ $forma->id }}"
                    {{ old('forma_pagamento_id', $vale->forma_pagamento_id ?? '') == $forma->id ? 'selected' : '' }}>
                    {{ $forma->nome }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Observação</label>
        <textarea name="observacao" class="form-control" rows="4">{{ old('observacao', $vale->observacao ?? '') }}</textarea>
    </div>
</div>