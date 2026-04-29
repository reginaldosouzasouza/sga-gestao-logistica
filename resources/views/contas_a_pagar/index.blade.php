<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Relação de Contas a Pagar</title>

    <link rel="stylesheet"
          href="{{ asset('css/contasapagar_relacao.css') }}">

</head>

<body>

<div class="container">

<h1>Relação de Contas a Pagar</h1>


{{-- MENSAGENS --}}
@if(session('success'))

<div style="color: green; font-weight: bold;">
    {{ session('success') }}
</div>

@endif


@if(session('info'))

<div style="color: blue; font-weight: bold;">
    {{ session('info') }}
</div>

@endif


<form method="GET"
      action="{{ route('contas-a-pagar.index') }}"
      class="form-filtro">


    <div class="form-group">

        <label>Fornecedor:</label>

        <input type="text"
               name="fornecedor"
               class="form-control"
               value="{{ request('fornecedor') }}"
               placeholder="Nome do Fornecedor">

    </div>


    <div class="form-group">

        <label>Status:</label>

        <select name="status"
                class="form-control">

            <option value="">Todos</option>

            <option value="pendente"
                {{ request('status') == 'pendente' ? 'selected' : '' }}>
                Pendente
            </option>

            <option value="atrasado"
                {{ request('status') == 'atrasado' ? 'selected' : '' }}>
                Atrasado
            </option>

            <option value="pago"
                {{ request('status') == 'pago' ? 'selected' : '' }}>
                Pago
            </option>

        </select>

    </div>


    <div class="form-group">

        <label>Forma de Pagamento:</label>

        <select name="forma_pagamento_id"
                class="form-control">

            <option value="">Todas</option>

            @foreach($formasPagamento as $forma)

            <option value="{{ $forma->id }}"
                {{ request('forma_pagamento_id') == $forma->id ? 'selected' : '' }}>

                {{ $forma->nome }}

            </option>

            @endforeach

        </select>

    </div>


    <div class="form-group">

        <label>Data Compra Inicial:</label>

        <input type="date"
               name="data_compra_inicial"
               class="form-control"
               value="{{ request('data_compra_inicial') }}">

    </div>


    <div class="form-group">

        <label>Data Compra Final:</label>

        <input type="date"
               name="data_compra_final"
               class="form-control"
               value="{{ request('data_compra_final') }}">

    </div>


    <div class="form-group">

        <label>Data Vencimento:</label>

        <input type="date"
               name="data_vencimento"
               class="form-control"
               value="{{ request('data_vencimento') }}">

    </div>


    <div class="form-group">

        <label>Data Pagamento:</label>

        <input type="date"
               name="data_pagamento"
               class="form-control"
               value="{{ request('data_pagamento') }}">

    </div>


    <div class="form-group">

        <button type="submit"
                class="btn btn-primary">

            Filtrar

        </button>

    </div>


</form>



<br>

<strong>Total de Registros:</strong>

{{ $contasAPagar->count() }}

<br>

<strong>Total de Faturas:</strong>

R$ {{ number_format($contasAPagar->sum('valor'), 2, ',', '.') }}

<br><br>


<table>

<thead>

<tr>

<th>ID</th>
<th>Fornecedor</th>
<th>Forma de Pagamento</th>
<th>Valor</th>
<th>Data Compra</th>
<th>Data Vencimento</th>
<th>Data Pagamento</th>
<th>Status</th>
<th>Ações</th>

</tr>

</thead>


<tbody>

@foreach($contasAPagar as $conta)

<tr class="
@if($conta->status == 'pendente') bg-warning
@elseif($conta->status == 'pago') bg-success
@elseif($conta->status == 'atrasado') bg-danger
@endif
">

<td>{{ $conta->id }}</td>

<td>{{ $conta->fornecedor->nome ?? '' }}</td>

<td>{{ $conta->formaPagamento->nome ?? '' }}</td>

<td>
{{ number_format($conta->valor, 2, ',', '.') }}
</td>

<td>
{{ \Carbon\Carbon::parse($conta->data_compra)->format('d/m/Y') }}
</td>

<td>
{{ \Carbon\Carbon::parse($conta->data_vencimento)->format('d/m/Y') }}
</td>

<td>

{{ $conta->data_pagamento
? \Carbon\Carbon::parse($conta->data_pagamento)->format('d/m/Y')
: '-' }}

</td>

<td>

{{ ucfirst($conta->status) }}

</td>



<td>

    <a href="{{ route('contas-a-pagar.edit', $conta->id) }}"
       class="btn">

        Editar

    </a>

    <form action="{{ route('contas-a-pagar.destroy', $conta->id) }}"
          method="POST"
          style="display:inline-block; margin-left:6px;"
          onsubmit="return confirm('Tem certeza que deseja excluir esta conta a pagar?');">

        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger">
            Excluir
        </button>

    </form>

</td>



</tr>

@endforeach

</tbody>

</table>


</div>

</body>
</html>
