@extends('layouts.app')

@section('title', 'Pedidos de Coleta')

@section('content')

<link rel="stylesheet" href="{{ asset('css/lista-coleta.css') }}">

<div class="container">
    <h1>Pedidos de Coleta</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('movimentacao.store') }}" method="POST">
        @csrf

        <!-- Campo oculto para armazenar o cliente_id -->
        <input type="hidden" id="cliente_id" name="cliente_id">

        <!-- Pesquisar Cliente e Controle de Coleta na mesma linha -->
        <div class="form-row">
            <div class="short-input">
                <label for="pesquisa">Pesquisar Cliente</label>
                <input type="text" class="form-control" id="pesquisa" name="pesquisa" placeholder="Digite o nome ou telefone">
                <div id="lista-resultados" class="list-group"></div> <!-- Adicione este div para os resultados -->
            </div>
            <div class="short-input">
                <label for="id">Controle de Coleta</label>
                <input type="text" class="form-control" id="id" name="controle_coleta" value="{{ $proximo_id }}" readonly>
            </div>
        </div>

        <!-- CPF e Nome na mesma linha -->
        <div class="form-row">
            <div class="short-input">
                <label for="cpf">CPF (opcional)</label>
                <input type="text" class="form-control" id="cpf" name="cpf">
            </div>
            <div class="medium-input">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
        </div>

        <!-- Telefone, Endereço, Número e Bairro na mesma linha -->
        <div class="form-row">
            <div class="short-input">
                <label for="telefone">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone">
            </div>
            <div class="medium-input">
                <label for="endereco">Endereço</label>
                <input type="text" class="form-control" id="endereco" name="endereco" required>
            </div>
            <div class="short-input">
                <label for="numero">Número</label>
                <input type="text" class="form-control" id="numero" name="numero" required>
            </div>
            <div class="short-input">
                <label for="bairro">Bairro</label>
                <input type="text" class="form-control" id="bairro" name="bairro" required>
            </div>
        </div>

        <!-- Cidade e Observação na mesma linha -->
        <div class="form-row">
            <div class="short-input">
                <label for="cidade">Cidade</label>
                <input type="text" class="form-control" id="cidade" name="cidade" required>
            </div>
            <div class="medium-input">
                <label for="observacao">Observação</label>
                <textarea class="form-control" id="observacao" name="observacao" rows="3"></textarea>
            </div>
        </div>
</div>        

        <!-- Itens do Pedido -->
<section class="pedidos">         
        <div class="itens-pedido">
            <h1>ITENS DO PEDIDO</h1>
            <div id="itens-pedido">
                <div class="item form-row">
                    <div class="col-md-3">
                        <label for="produto">Produto</label>
                        <select name="produtos[]" class="form-control produto-select" required>
                            <option value="" selected disabled>Selecione um produto</option> <!-- Adiciona uma opção em branco -->
                            @foreach ($produtos as $produto)
                                <option value="{{ $produto->id }}" data-preco="{{ $produto->preco_venda }}">
                                    {{ $produto->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="quantidade">Quantidade</label>
                        <input type="number" name="quantidades[]" class="form-control" value="" required> <!-- Campo obrigatório -->
                    </div>
                    <div class="col-md-2">
                        <label for="valor_unitario">Valor Unitário</label>
                        <input type="text" name="valores_unitarios[]" class="form-control" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="valor_total">Total do Item</label>
                        <input type="text" name="valores_totais[]" class="form-control valor_total" readonly>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" id="add-item" class="btn btn-primary">Adicionar Produto</button>

        <!-- Valor Total do Pedido -->
        <p>Valor Total do Pedido: <span id="total-pedido">0.00</span></p>

        <!-- Formas de Pagamento -->
        <div class="form-row">
            <div class="short-input">
                <label for="forma_pagamento">Forma de Pagamento</label>
                <select name="forma_pagamento" class="form-control" required>
                    <option value="" selected disabled>Selecione a forma de pagamento</option>
                    @foreach ($formasDePagamento as $forma)
                        <option value="{{ $forma->id }}">{{ $forma->nome }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Prazo -->
        <div class="form-row">
            <div class="short-input">
                <label for="prazo">Prazo</label>
                <select name="prazo" class="form-control" required>
                    <option value="" selected disabled>Selecione o prazo</option>
                    @foreach ($prazos as $prazo)
                        <option value="{{ $prazo->id }}">{{ $prazo->prazo }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Botão para Salvar Coleta -->
        <button type="submit" class="btn btn-primary">Salvar Coleta</button>
    </form>
</div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {

        // Função para calcular o total do item e o total do pedido
        function calcularTotais() {
            let totalPedido = 0;
            $('.item').each(function() {
                let quantidade = parseFloat($(this).find('input[name="quantidades[]"]').val());
                let valorUnitario = parseFloat($(this).find('input[name="valores_unitarios[]"]').val());
                let totalItem = quantidade * valorUnitario;

                $(this).find('.valor_total').val(totalItem.toFixed(2)); // Preencher o total do item
                totalPedido += totalItem;
            });
            $('#total-pedido').text(totalPedido.toFixed(2)); // Atualizar o total do pedido
        }

        // Atualizar o valor unitário automaticamente quando um produto for selecionado
        function atualizarValorUnitario(selectElement) {
            let selectedOption = $(selectElement).find('option:selected');
            let precoVenda = parseFloat(selectedOption.data('preco')); // Buscar o preço de venda do produto selecionado

            let valorUnitarioInput = $(selectElement).closest('.item').find('input[name="valores_unitarios[]"]');
            valorUnitarioInput.val(precoVenda.toFixed(2)); // Preencher o valor unitário com o preço de venda

            calcularTotais(); // Recalcular os totais
        }

        // Quando um produto for selecionado, atualizar o valor unitário
        $('#itens-pedido').on('change', '.produto-select', function() {
            atualizarValorUnitario(this);
        });

        // Calcular total sempre que quantidade ou valor unitário mudar
        $('#itens-pedido').on('input', 'input[name="quantidades[]"], input[name="valores_unitarios[]"]', function() {
            calcularTotais();
        });

        // Função para adicionar novos itens ao pedido
        $('#add-item').on('click', function() {
            let novoItem = $('.item').first().clone(); // Clonar o primeiro item
            novoItem.find('input').val(''); // Limpar os valores dos campos
            novoItem.find('.valor_total').val('0.00'); // Resetar o valor total do novo item
            $('#itens-pedido').append(novoItem); // Adicionar o novo item ao formulário

            // Reaplicar o evento de mudança de produto para o novo item
            novoItem.find('.produto-select').on('change', function() {
                atualizarValorUnitario(this);
            });
        });

        // Função para buscar clientes com AJAX
        $('#pesquisa').on('input', function() {
            var query = $(this).val();
            if (query.length > 2) {
                $.ajax({
                    url: "{{ route('clientes.pesquisar') }}",
                    type: "GET",
                    data: { query: query },
                    success: function(data) {
                        var listaResultados = $('#lista-resultados');
                        listaResultados.empty(); // Limpar resultados anteriores

                        if (data.length > 0) {
                            $.each(data, function(index, cliente) {
                                listaResultados.append(
                                    '<button type="button" class="list-group-item list-group-item-action" onclick="selecionarCliente(' + cliente.id + ', \'' + cliente.nome + '\', \'' + cliente.telefone + '\', \'' + cliente.endereco + '\', \'' + cliente.cpf + '\', \'' + cliente.numero + '\', \'' + cliente.bairro + '\', \'' + cliente.cidade + '\')">' + cliente.nome + ' (' + cliente.telefone + ')</button>'
                                );
                            });
                        } else {
                            listaResultados.append('<div class="list-group-item">Nenhum cliente encontrado. <a href="#" onclick="mostrarMensagemCadastro()">Cadastrar novo?</a></div>');
                        }
                    }
                });
            }
        });

        // Função para preencher os campos do formulário quando um cliente for selecionado
        window.selecionarCliente = function(id, nome, telefone, endereco, cpf, numero, bairro, cidade) {
            $('#nome').val(nome);
            $('#telefone').val(telefone);
            $('#endereco').val(endereco);

            $('#cpf').val(cpf);
            $('#numero').val(numero);
            $('#bairro').val(bairro);
            $('#cidade').val(cidade);
            $('#cliente_id').val(id); // Preencher o cliente_id no campo oculto
            $('#lista-resultados').empty(); // Limpar a lista suspensa após a seleção
        };

        // Função para exibir a mensagem de cadastro
        window.mostrarMensagemCadastro = function() {
            if (confirm('Não tem Cadastro! Deseja Cadastrar?')) {
                window.location.href = "{{ route('clientes.create') }}";
            }
        };
    });
</script>

@endsection
