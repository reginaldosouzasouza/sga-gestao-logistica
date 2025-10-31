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
            <h4>Descrição das Peças</h4>
            <table class="table table-bordered" id="tabela-itens">
                <thead style="background: #005baa; color: white;">
                    <tr>
                        <th>Produto</th>
                        <th>Qtde</th>
                        <th>Unidade de Valor.</th>
                        <th>Valor Total</th>
                        <th>Remover</th>
                    </tr>
                </thead>
                <tbody id="itens-body">
                    <tr>
                        <td>
                            <select name="produtos[]" class="form-control produto-select" required>
                                <option value="">Selecione</option>
                                @foreach($produtos as $produto)
                                    <option value="{{ $produto->id }}" data-preco="{{ $produto->preco_venda }}">
                                        {{ $produto->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" name="quantidades[]" class="form-control quantidade" min="1" required></td>
                        <td><input type="number" name="valores_unitarios[]" class="form-control valor-unitario" step="0.01" required></td>
                        <td><input type="text" name="valores_totais[]" class="form-control valor-total" readonly></td>
                        <td><button type="button" class="btn btn-danger remover-linha">X</button></td>
                    </tr>
                </tbody>
            </table>

            <button type="button" id="adicionar-linha" class="btn btn-primary">+ Adicionar Produto</button>

            <div style="margin-top: 20px;">
                <strong>Valor Total Geral:</strong>
                <input type="text" id="valor-total-geral" class="form-control" readonly>
            </div>
        </section>

        <div class="form-group" style="grid-column: span 3;">
            <label>Descrição do Serviço</label>
            <textarea name="servico_realizado" class="form-control"></textarea>
        </div>
        <div class="form-group" style="grid-column: span 3;">
            <label>Observações</label>
            <textarea name="observacoes" class="form-control"></textarea>
        </div>

        <div class="button-group">
            <button type="submit" class="btn-salvar">Salvar</button>
            <a href="{{ route('ordens-servico.index') }}" class="btn-cancelar">Cancelar</a>
        </div>
    </form>
</div>

<script>
    function formatarReal(valor) {
        return valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    }

    function atualizarValorTotal(linha) {
        const qtd = parseFloat(linha.querySelector('.quantidade').value) || 0;
        const unit = parseFloat(linha.querySelector('.valor-unitario').value) || 0;
        const total = qtd * unit;
        linha.querySelector('.valor-total').value = formatarReal(total);
        return total;
    }

    function atualizarValorTotalGeral() {
        let totalGeral = 0;
        document.querySelectorAll('#itens-body tr').forEach(tr => {
            totalGeral += atualizarValorTotal(tr);
        });
        document.getElementById('valor-total-geral').value = formatarReal(totalGeral);
    }

    function adicionarNovaLinha() {
        const tabela = document.getElementById('itens-body');
        const novaLinha = tabela.rows[0].cloneNode(true);

        novaLinha.querySelectorAll('input').forEach(input => input.value = '');
        novaLinha.querySelector('select').selectedIndex = 0;

        tabela.appendChild(novaLinha);
    }

    document.getElementById('adicionar-linha').addEventListener('click', () => {
        adicionarNovaLinha();
    });

    document.getElementById('itens-body').addEventListener('input', function (e) {
        const linha = e.target.closest('tr');
        atualizarValorTotal(linha);
        atualizarValorTotalGeral();
    });

    document.getElementById('itens-body').addEventListener('change', function (e) {
        if (e.target.classList.contains('produto-select')) {
            const preco = e.target.selectedOptions[0].getAttribute('data-preco') || 0;
            const linha = e.target.closest('tr');
            linha.querySelector('.valor-unitario').value = parseFloat(preco).toFixed(2);
            atualizarValorTotal(linha);
            atualizarValorTotalGeral();
        }
    });

        document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('itens-body').addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remover-linha')) {
            e.preventDefault(); // evita submit
            const linha = e.target.closest('tr');
            if (linha && document.querySelectorAll('#itens-body tr').length > 1) {
                linha.remove();
                atualizarValorTotalGeral();
            }
        }
    });
});



    // Buscar veículo
    document.getElementById('placa').addEventListener('blur', function () {
        const placa = this.value.trim();
        if (placa !== '') {
            fetch(`/veiculo/buscar/${placa}`)
                .then(res => res.json())
                .then(data => {
                    document.querySelector('input[name="marca"]').value = data.marca || '';
                    document.querySelector('input[name="modelo"]').value = data.modelo || '';
                    const selectCliente = document.querySelector('select[name="cliente"]');
                    for (let option of selectCliente.options) {
                        if (option.text.trim().toLowerCase() === (data.cliente?.trim().toLowerCase())) {
                            option.selected = true;
                            break;
                        }
                    }
                })
                .catch(() => alert('Veículo não encontrado'));
        }
    });
</script>

@endsection

