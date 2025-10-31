<!-- Nome -->
<input type="text" class="form-control" id="nome" name="nome" value="{{ session('nome') }}" required>

<!-- Telefone -->
<input type="text" class="form-control" id="telefone" name="telefone" value="{{ session('telefone') }}">

<!-- Endereço -->
<input type="text" class="form-control" id="endereco" name="endereco" value="{{ session('endereco') }}" required>

<!-- Número -->
<input type="text" class="form-control" id="numero" name="numero" value="{{ session('numero') }}" required>

<!-- Bairro -->
<input type="text" class="form-control" id="bairro" name="bairro" value="{{ session('bairro') }}" required>

<!-- Cidade -->
<input type="text" class="form-control" id="cidade" name="cidade" value="{{ session('cidade') }}" required>
