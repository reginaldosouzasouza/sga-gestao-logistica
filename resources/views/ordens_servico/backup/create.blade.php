@extends('layouts.app')

@section('title', 'Cadastro de Ordens de Serviço')

@section('content')
<link rel="stylesheet" href="{{ asset('css/ordem_servico-create.css') }}">

<div class="container-os">
    <h2>Cadastro de Ordem de Serviço</h2>

    <form action="{{ route('ordens-servico.store') }}" method="POST">
        @csrf

       <div class="form-grid">
            <div class="form-group">
                <label>Data Lançamento</label>
                <input type="date" name="created_at">
            </div>
            <div class="form-group">
                <label>Data Prev. Entrega</label>
                <input type="date" name="data_prevista_entrega">
            </div>
            <div class="form-group">
                <label>Placa</label>
                <input type="text" name="placa" id="placa" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Cliente</label>
                <select name="cliente" class="form-control" required>
                    <option value="">Selecione um cliente</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->nome }}">{{ $cliente->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Marca</label>
                <input type="text" name="marca" id="marca" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Modelo</label>
                <input type="text" name="modelo" id="modelo" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Mecânico</label>
                <select name="mecanico">
                    <option value="">Selecione</option>
                    @foreach($mecanicos as $mecanico)
                        <option value="{{ $mecanico->nome }}">{{ $mecanico->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>KM Atual</label>
                <input type="number" name="km">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="Aberto">Aberto</option>
                    <option value="Concluído">Concluído</option>
                    <option value="Cancelado">Cancelado</option>
                </select>
            </div>
        </div>

        <section>
            <div style="display: flex; justify-content: space-between;">
                <h4>Descrição das Peças</h4>
                <div>
                    <label for="valor_total_geral"><strong>Valor Total Geral:</strong></label>
                    <input type="text" id="valor_total_geral" name="valor_total_geral" readonly>
                </div>
            </div>

            <table id="produtos-table" class="table table-bordered">
                <thead style="background: #005baa; color: white;">
                    <tr>
                        <th>Produto</th>
                        <th>Qtde</th>
                        <th>Unidade de Valor.</th>
                        <th>Valor Total</th>
                        <th>Removedor</th>
                    </tr>
                </thead>
                <tbody id="produtos-body">
                    <tr class="produto-row">
                        <td>
                            <select name="produto_id[]" class="form-control produto-select">
                                <option value="">Selecione</option>
                                @foreach($produtos as $produto)
                                    <option value="{{ $produto->id }}" data-preco="{{ $produto->preco_venda }}">
                                        {{ $produto->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" name="quantidade[]" class="form-control quantidade"></td>
                        <td><input type="text" name="valor_unitario[]" class="form-control valor-unitario"></td>
                        <td><input type="text" name="valor_total[]" class="form-control valor-total" readonly></td>
                        <td><button type="button" class="btn btn-danger remover-linha" onclick="removerProduto(this)">X</button></td>
                    </tr>
                </tbody>
            </table>

            <button type="button" class="btn btn-primary" id="adicionar-linha">+ Adicionar Produto</button>
        </section>

        <div class="form-group">
            <label>Descrição do Serviço</label>
            <textarea name="servico_realizado" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label>Observações</label>
            <textarea name="observacoes" class="form-control"></textarea>
        </div>

        <div class="button-group">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('ordens-servico.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<script>
    function formatarReal(valor) {
        return new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        }).format(valor);
    }

    function recalcularTotais() {
        let totalGeral = 0;
        document.querySelectorAll('#produtos-body .produto-row').forEach(row => {
            const qtd = parseFloat(row.querySelector('.quantidade')?.value.replace(',', '.') || 0);
            const valorUnit = parseFloat(row.querySelector('.valor-unitario')?.value.replace(',', '.') || 0);
            const total = qtd * valorUnit;
            row.querySelector('.valor-total').value = formatarReal(total);
            totalGeral += total;
        });
        document.getElementById('valor_total_geral').value = formatarReal(totalGeral);
    }

    function adicionarLinha() {
        const table = document.getElementById('produtos-body');
        const novaLinha = document.createElement('tr');
        novaLinha.classList.add('produto-row');
        novaLinha.innerHTML = `
            <td>
                <select name="produto_id[]" class="form-control produto-select">
                    <option value="">Selecione</option>
                    @foreach($produtos as $produto)
                        <option value="{{ $produto->id }}" data-preco="{{ $produto->preco_venda }}">
                            {{ $produto->nome }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="quantidade[]" class="form-control quantidade"></td>
            <td><input type="text" name="valor_unitario[]" class="form-control valor-unitario"></td>
            <td><input type="text" name="valor_total[]" class="form-control valor-total" readonly></td>
            <td><button type="button" class="btn btn-danger remover-linha" onclick="removerProduto(this)">X</button></td>
        `;
        table.appendChild(novaLinha);
    }

    // Função global para remover produto
    function removerProduto(botao) {
        console.log('Tentando remover linha...'); // Para debug
        const linha = botao.closest('tr');
        const tbody = document.getElementById('produtos-body');
        const totalLinhas = tbody.querySelectorAll('.produto-row').length;
        
        if (totalLinhas > 1) {
            linha.remove();
            recalcularTotais();
            console.log('Linha removida com sucesso!'); // Para debug
        } else {
            alert('Deve haver pelo menos uma linha de produto!');
        }
    }

    // Botão adicionar linha
    document.getElementById('adicionar-linha').addEventListener('click', adicionarLinha);

    // Event delegation para inputs
    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('quantidade') || e.target.classList.contains('valor-unitario')) {
            recalcularTotais();
        }
    });

    // Event delegation para select de produtos
    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('produto-select')) {
            const opcaoSelecionada = e.target.selectedOptions[0];
            const preco = opcaoSelecionada ? opcaoSelecionada.dataset.preco || 0 : 0;
            const row = e.target.closest('tr');
            const valorUnitarioInput = row.querySelector('.valor-unitario');
            
            if (valorUnitarioInput) {
                valorUnitarioInput.value = preco.toString().replace('.', ',');
                recalcularTotais();
            }

            // Auto-adicionar nova linha
            const ultimaLinha = document.querySelector('#produtos-body tr:last-child');
            const selectUltimaLinha = ultimaLinha.querySelector('.produto-select');
            if (row === ultimaLinha && e.target.value !== "") {
                adicionarLinha();
            }
        }
    });

    // Também mantém o event delegation como backup
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remover-linha')) {
            console.log('Clique detectado via event delegation'); // Para debug
            removerProduto(e.target);
        }
    });

    // Atualizar o botão da primeira linha para usar onclick também
    document.addEventListener('DOMContentLoaded', function() {
        const primeiroRemover = document.querySelector('.remover-linha');
        if (primeiroRemover && !primeiroRemover.hasAttribute('onclick')) {
            primeiroRemover.setAttribute('onclick', 'removerProduto(this)');
        }
        recalcularTotais();
    });



document.getElementById('placa').addEventListener('blur', function () {
    let placa = this.value.trim();

    if (placa !== "") {
        fetch(`/buscar-veiculo/${placa}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('marca').value = data.marca;
                    document.getElementById('modelo').value = data.veiculo;
                    document.querySelector('select[name="cliente"]').value = data.cliente;
                } else {
                    alert("Placa não cadastrada!");
                    document.getElementById('marca').value = "";
                    document.getElementById('modelo').value = "";
                }
            });
    }
});


// Antes de enviar o formulário, converte valor formatado para número
document.querySelector('form').addEventListener('submit', function () {
    const campoValor = document.getElementById('valor_total_geral');
    if (campoValor) {
        let valor = campoValor.value.replace(/[R$\s.]/g, '').replace(',', '.'); // Ex: R$ 18.915,00 → 18915.00
        campoValor.value = valor;
    }
});

</script>
@endsection



