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

        <input type="hidden" id="cliente_id" name="cliente_id" value="{{ $cliente_id }}">

        <!-- Pesquisa Cliente -->
        <div class="form-row">
            <div class="short-input">
                <label for="pesquisar_cliente">Pesquisar Cliente</label>
                <input type="text" class="form-control" id="pesquisar_cliente" name="pesquisar_cliente" placeholder="Digite o nome ou telefone">
                <div id="lista-clientes" class="list-group"></div>
                <a href="{{ route('clientes.create', ['from' => 'pedido_coleta']) }}" class="btn btn-primary">Cadastrar Cliente</a>
                <button type="button" id="limpar-busca" class="btn btn-secondary mt-2">Limpar Busca</button>
            </div>

            <div class="form-group">
                <label for="data_coleta">Data da Coleta</label>
                <input type="date" name="data_coleta" id="data_coleta" class="form-control" value="{{ old('data_coleta', \Carbon\Carbon::now()->format('Y-m-d')) }}">
            </div>

            <div class="short-input">
                <label for="controle_de_coleta">Controle de Coleta</label>
                <input type="text" class="form-control" name="id" value="{{ old('id', $proximoId ?? '') }}" readonly>
            </div>
        </div>

        <!-- CPF, Nome, Telefone -->
        <div class="form-row">
            <div class="short-input">
                <label for="cpf">CPF (opcional)</label>
                <input type="text" class="form-control" id="cpf" name="cpf">
            </div>

            <div class="medium-input">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>

            <div class="short-input">
                <label for="telefone">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone">
            </div>
        </div>

        <!-- Endereço, Número, Bairro, Cidade -->
        <div class="form-row">
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

            <div class="short-input">
                <label for="cidade">Cidade</label>
                <input type="text" class="form-control" id="cidade" name="cidade" required>
            </div>
        </div>

        <!-- Observação -->
        <div class="form-group">
            <label for="observacao">Observação</label>
            <textarea class="form-control" id="observacao" name="observacao" rows="3">{{ old('observacao') }}</textarea>
        </div>

        <!-- Veículo / Entregador -->
        <div class="form-row">
            <div class="medium-input">
                <label for="veiculo_id">Veículo / Entregador</label>
                <select name="veiculo_id" id="veiculo_id" class="form-control">
                    <option value="">Selecione o veículo</option>

                    @foreach(($veiculos ?? []) as $veiculo)
                        <option
                            value="{{ $veiculo->id }}"
                            data-motorista="{{ $veiculo->motorista->nome ?? 'Sem motorista vinculado' }}"
                            {{ old('veiculo_id') == $veiculo->id ? 'selected' : '' }}
                        >
                            {{ $veiculo->descricao }}
                            @if($veiculo->placa)
                                - {{ $veiculo->placa }}
                            @endif
                            @if($veiculo->motorista)
                                - {{ $veiculo->motorista->nome }}
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="short-input">
                <label for="motorista_info">Motorista Vinculado</label>
                <input type="text" id="motorista_info" class="form-control" readonly>
            </div>
        </div>

        <!-- Itens do Pedido -->
        <div id="itens-pedido">
            <div class="item form-row">
                <div class="col-md-3">
                    <label for="produto">Produto</label>
                    <select name="produtos[0][produto_id]" class="form-control produto-select" required>
                        <option value="" selected disabled>Selecione um produto</option>
                        @foreach ($produtos as $produto)
                            <option value="{{ $produto->id }}" data-preco="{{ $produto->preco_venda }}">
                                {{ $produto->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="quantidade">Quantidade</label>
                    <input type="number" step="0.01" name="produtos[0][quantidade]" class="form-control quantidade" value="1" required>
                </div>

                <div class="col-md-2">
                    <label for="valor_unitario">Valor Unitário</label>
                    <input type="number" step="0.01" name="produtos[0][valor_unitario]" class="form-control valor-unitario" required>
                </div>

                <div class="col-md-2">
                    <label for="valor_total">Total do Item</label>
                    <input type="number" step="0.01" name="produtos[0][valor_total]" class="form-control valor-total" value="0.00" readonly>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-item">Remover</button>
                </div>
            </div>
        </div>

        <button type="button" id="add-item" class="btn btn-primary mt-2">Adicionar Produto</button>

        <!-- Pagamentos -->
        <h1>PAGAMENTOS</h1>

        <aside>
            <div class="pagamentos">
                <label for="forma_pagamento">Forma de Pagamento</label>
                <select name="forma_pagamento" id="forma_pagamento" class="form-control">
                    <option value="">Selecione a forma de pagamento</option>
                    @foreach($formas_de_pagamento as $forma)
                        <option value="{{ $forma->id }}">{{ $forma->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div class="pagamentos">
                <label for="prazo">Prazo</label>
                <select name="prazo" id="prazo" class="form-control">
                    <option value="">Selecione o prazo</option>
                    @foreach($prazos as $prazo)
                        <option value="{{ $prazo->id }}">{{ $prazo->prazo }}</option>
                    @endforeach
                </select>
            </div>
        </aside>

        <p>Valor Total do Pedido: <span id="total-pedido">0.00</span></p>

        <button type="submit" class="btn btn-primary">Salvar Coleta</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    let itemIndex = 0;

    // =======================
    // FOCO INICIAL
    // =======================
    const campoPesquisa = document.getElementById('pesquisar_cliente');
    if (campoPesquisa) {
        campoPesquisa.focus();
    }

    // =======================
    // VEÍCULO / MOTORISTA
    // =======================
    function atualizarDadosVeiculo() {
        let option = $('#veiculo_id option:selected');

        if (!option.val()) {
            $('#motorista_info').val('');
            return;
        }

        let motorista = option.data('motorista') || 'Sem motorista vinculado';
        $('#motorista_info').val(motorista);
    }

    $('#veiculo_id').on('change', atualizarDadosVeiculo);
    atualizarDadosVeiculo();

    // =======================
    // PESQUISA DE CLIENTES
    // =======================
    $('#pesquisar_cliente').on('input', function() {
        let termo = $(this).val();

        if (termo.length < 2) {
            $('#lista-clientes').empty();
            return;
        }

        $.ajax({
            url: "{{ route('buscar.cliente') }}",
            type: "GET",
            data: { termo: termo },
            success: function(data) {
                let lista = $('#lista-clientes');
                lista.empty();

                if (data.length > 0) {
                    data.forEach(cliente => {
                        lista.append(`
                            <button type="button"
                                class="list-group-item list-group-item-action"
                                onclick="selecionarCliente(
                                    ${cliente.id},
                                    '${cliente.nome}',
                                    '${cliente.telefone}',
                                    '${cliente.endereco}',
                                    '${cliente.cpf}',
                                    '${cliente.numero}',
                                    '${cliente.bairro}',
                                    '${cliente.cidade}'
                                )">
                                ${cliente.nome} (${cliente.telefone})
                            </button>
                        `);
                    });
                } else {
                    lista.append('<div class="list-group-item">Nenhum cliente encontrado.</div>');
                }
            }
        });
    });

    $('#limpar-busca').on('click', function() {
        $('#pesquisar_cliente').val('').focus();
        $('#lista-clientes').empty();
    });

    window.selecionarCliente = function(id, nome, telefone, endereco, cpf, numero, bairro, cidade) {
        $('#cliente_id').val(id);
        $('#nome').val(nome);
        $('#telefone').val(telefone);
        $('#endereco').val(endereco);
        $('#cpf').val(cpf);
        $('#numero').val(numero);
        $('#bairro').val(bairro);
        $('#cidade').val(cidade);
        $('#lista-clientes').empty();
    };

    // =======================
    // CONVERSÃO SEGURA
    // =======================
    function paraNumero(valor) {
        if (!valor) return 0;

        valor = valor.toString().trim();

        if (valor.includes(',')) {
            valor = valor.replace(/\./g, '').replace(',', '.');
        }

        return parseFloat(valor) || 0;
    }

    function formatarNumero(valor) {
        return valor.toFixed(2);
    }

    // =======================
    // CALCULAR TOTAIS
    // =======================
    function calcularTotais() {
        let totalPedido = 0;

        $('.item').each(function() {
            let quantidade = paraNumero($(this).find('.quantidade').val());
            let valorUnitario = paraNumero($(this).find('.valor-unitario').val());
            let totalItem = quantidade * valorUnitario;

            $(this).find('.valor-total').val(formatarNumero(totalItem));
            totalPedido += totalItem;
        });

        $('#total-pedido').text(formatarNumero(totalPedido));
    }

    // =======================
    // ADICIONAR ITEM
    // =======================
    $('#add-item').click(function() {
        itemIndex++;

        let novoItem = $('.item:first').clone();

        novoItem.find('input, select').val('');
        novoItem.find('.quantidade').val(1);
        novoItem.find('.valor-unitario').val('');
        novoItem.find('.valor-total').val('0.00');

        novoItem.find('select, input').each(function() {
            let name = $(this).attr('name');

            if (name) {
                name = name.replace(/\[\d+\]/, '[' + itemIndex + ']');
                $(this).attr('name', name);
            }
        });

        novoItem.appendTo('#itens-pedido');
        calcularTotais();
    });

    // =======================
    // REMOVER ITEM
    // =======================
    $(document).on('click', '.remove-item', function() {
        if ($('.item').length > 1) {
            $(this).closest('.item').remove();
        } else {
            let item = $(this).closest('.item');
            item.find('input, select').val('');
            item.find('.quantidade').val(1);
            item.find('.valor-unitario').val('');
            item.find('.valor-total').val('0.00');
        }

        calcularTotais();
    });

    // =======================
    // AO ESCOLHER PRODUTO
    // =======================
    $(document).on('change', '.produto-select', function() {
        let item = $(this).closest('.item');
        let precoVenda = paraNumero(item.find('.produto-select option:selected').data('preco'));

        item.find('.valor-unitario').val(formatarNumero(precoVenda));
        calcularTotais();
    });

    // =======================
    // AO ALTERAR QUANTIDADE OU VALOR UNITÁRIO
    // =======================
    $(document).on('input change keyup', '.quantidade, .valor-unitario', function() {
        calcularTotais();
    });

    calcularTotais();
});
</script>

@endsection
