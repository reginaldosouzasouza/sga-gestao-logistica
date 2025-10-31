@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Cadastrar Encomenda</h1>

    <form method="POST" action="{{ route('padoca.encomendas.store') }}" id="form-encomenda">
        @csrf
    <div class="row mb-3">
    <div class="col-md-3">
        <label>Cliente ID (sequencial)</label>
        <input type="text" class="form-control" value="{{ $proxCodigo }}" disabled>
        <input type="hidden" name="cliente_codigo" value="{{ $proxCodigo }}">
    </div>
    <div class="col-md-9">
        <label>Nome (livre)</label>
        <input type="text" name="nome" class="form-control" placeholder="Ex.: Maria do Bolo">
    </div>
    </div>



<div class="row mb-3">
  <div class="col">
      <label>Data do Pedido</label>
      <input type="date" name="data_pedido" class="form-control" value="{{ now()->toDateString() }}">
  </div>
  <div class="col">
      <label>Data da Entrega</label>
      <input type="date" name="data_retirada" class="form-control" required>
  </div>
  <div class="col">
      <label>Hora da Entrega</label>
      <input type="time" name="hora_retirada" class="form-control">
  </div>
</div>

<div class="row mb-3">
  <div class="col-md-4">
      <label>Forma de Pagamento</label>
      <select name="forma_pagamento" class="form-control">
          <option value="">Selecione...</option>
          <option value="pix">PIX</option>
          <option value="dinheiro">Dinheiro</option>
          <option value="cartao">Cartão</option>
          <option value="Acerta na Entrega">Acerta na Entrega</option>
          <option value="Fiado">Fiado</option>
      </select>
  </div>
  <div class="col-md-4">
      <label>Status do Pagamento</label>
      <select name="pagamento_status" class="form-control" required>
          <option value="Pendente">Pendente</option>
          <option value="Pago">Pago</option>
      </select>
  </div>
  <div class="col-md-4">
      <label>Sinal (R$) — opcional</label>
      <input type="number" step="0.01" name="sinal" class="form-control" value="0">
  </div>
</div>


        <div class="mb-3">
            <label>Detalhes da Encomenda</label>
            <textarea name="observacao" class="form-control" rows="2"></textarea>
        </div>

        <hr>

        <h4>Itens</h4>
        <div class="table-responsive">
            <table class="table" id="tabela-itens">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Qtd</th>
                        <th>Vlr Unit (R$)</th>
                         <th>Adiantamento(R$)</th>
                        <th>Tamanho</th>
                        <th>Sabor</th>
                        <th>Personalização</th>
                        <th>Total (R$)</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <button type="button" class="btn btn-secondary mb-2" id="btn-add-linha">+ Adicionar Item</button>

        <div class="text-end mb-3">
            <label style="font-size:1.1rem;font-weight:bold;">Valor Total: R$ <span id="valor-total">0,00</span></label>
            <input type="hidden" name="valor_total_calculado" id="valor_total_input" value="0">
        </div>

        <button class="btn btn-success">Salvar Encomenda</button>
        <a href="{{ route('padoca.encomendas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </form>
</div>

<script>
(function() {
  const tbody = document.querySelector('#tabela-itens tbody');
  const btnAdd = document.getElementById('btn-add-linha');
  const totalSpan = document.getElementById('valor-total');
  const totalInput = document.getElementById('valor_total_input');

  function br(n){ return Number(n||0); }
  function formatMoney(n){ return (br(n)).toFixed(2).replace('.', ','); }

  function calcTotalGeral(){
    let total = 0;
    tbody.querySelectorAll('tr').forEach(tr=>{
      const qtd = br(tr.querySelector('.qtd').value);
      const vu  = br(tr.querySelector('.vu').value);
      const ad  = br(tr.querySelector('.ad').value);
      let vt    = (qtd * vu) - ad;
      if (vt < 0) vt = 0;
      tr.querySelector('.vt').value = vt.toFixed(2);
      tr.querySelector('.vt_view').innerText = formatMoney(vt);
      total += vt;
    });
    totalSpan.innerText = formatMoney(total);
    totalInput.value = total.toFixed(2);
  }

  function addLinha(item={}){
    const key = Date.now().toString();
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td><input type="text" class="form-control pnome" name="itens[${key}][produto_nome]" value="${item.produto_nome||''}" required></td>
      <td><input type="number" step="0.001" class="form-control qtd" name="itens[${key}][quantidade]" value="${item.quantidade||1}" required></td>
      <td><input type="number" step="0.01" class="form-control vu" name="itens[${key}][valor_unitario]" value="${item.valor_unitario||0}" required></td>
      <td><input type="number" step="0.01" class="form-control ad" name="itens[${key}][adiantamento]" value="${item.adiantamento||0}"></td>
      <td><input type="text" class="form-control" name="itens[${key}][tamanho]" value="${item.tamanho||''}"></td>
      <td><input type="text" class="form-control" name="itens[${key}][sabor]" value="${item.sabor||''}"></td>
      <td><input type="text" class="form-control" name="itens[${key}][personalizacao]" value="${item.personalizacao||''}"></td>
      <td>
          <input type="hidden" class="vt" name="itens[${key}][valor_total]" value="0">
          <span class="vt_view">0,00</span>
      </td>
      <td><button type="button" class="btn btn-sm btn-danger btn-del">x</button></td>
    `;
    tbody.appendChild(tr);
    tr.querySelectorAll('.qtd,.vu,.ad').forEach(inp=>inp.addEventListener('input', calcTotalGeral));
    tr.querySelector('.btn-del').addEventListener('click', ()=>{ tr.remove(); calcTotalGeral(); });
    calcTotalGeral();
  }

  btnAdd.addEventListener('click', ()=> addLinha());
  addLinha(); // começa com uma linha
})();
</script>

@endsection



