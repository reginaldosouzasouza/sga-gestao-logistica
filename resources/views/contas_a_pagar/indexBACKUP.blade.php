
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relação de Contas a Pagar</title>
    <link rel="stylesheet" href="{{ asset('css/contasapagar_relacao.css') }}">
    
</head>
<body>

<!-- Formulário de Filtro -->
<form action="{{ route('contas-a-pagar.index') }}" method="GET"         class="form-filtro mb-3">
    <div class="form-group">
        <label for="fornecedor"><strong>Fornecedor:</strong></label>
        <input type="text" name="fornecedor" value="{{ request('fornecedor') }}" class="form-control" placeholder="Nome do Fornecedor">
    </div>

    <div class="form-group">
        <label for="status"><strong>Status:</strong></label>
        <select name="status" class="form-control">
            <option value="">Todos</option>
            <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
            <option value="pago" {{ request('status') == 'pago' ? 'selected' : '' }}>Pago</option>
            <option value="atrasado" {{ request('status') == 'atrasado' ? 'selected' : '' }}>Atrasado</option>
        </select>
    </div>

    <div class="form-group">
        <label for="forma_pagamento_id"><strong>Forma de Pagamento:</strong></label>
        <select name="forma_pagamento_id" class="form-control">
            <option value="" {{ request('forma_pagamento_id') == '' ? 'selected' : '' }}>Todas</option>
            <option value="1" {{ request('forma_pagamento_id') == '1' ? 'selected' : '' }}>Dinheiro</option>
            <option value="2" {{ request('forma_pagamento_id') == '2' ? 'selected' : '' }}>PIX</option>
            <option value="3" {{ request('forma_pagamento_id') == '3' ? 'selected' : '' }}>Fatura</option>
            <option value="4" {{ request('forma_pagamento_id') == '4' ? 'selected' : '' }}>Cartão de Crédito</option>
            <option value="5" {{ request('forma_pagamento_id') == '5' ? 'selected' : '' }}>Nota Assinada</option>
        </select>
    </div>



 

    <div class="form-group">
        <label for="data_compra_inicial"><strong>Data da Compra Inicial:</strong></label>
        <input type="date" name="data_compra_inicial" value="{{ request('data_compra_inicial') }}" class="form-control">
    </div>  
    <div class="form-group">        
        <label for="data_compra_final"><strong>Data da Compra Final:</strong></label>
        <input type="date" name="data_compra_final" value="{{ request('data_compra_final') }}"class="form-control">
    </div>  




    <div class="form-group">
        <label for="data_vencimento"><strong>Data de Vencimento:</strong></label>
        <input type="date" name="data_vencimento" value="{{ request('data_vencimento') }}" class="form-control">
    </div>

    <div class="form-group">
        <label for="data_pagamento"><strong>Data de Pagamento:</strong></label>
        <input type="date" name="data_pagamento" value="{{ request('data_pagamento') }}" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary mt-2">Filtrar</button>
</form>

<!-- Exibição de Total de Registros e Faturas -->
<p>Total de Registros: <strong>{{ $totalContas }}</strong></p>
<p>Total de Faturas: <strong>{{ number_format($valorTotalFaturas, 2, ',', '.') }}</strong></p>


<div class="container">
    <h1>Relação de Contas a Pagar</h1>

    <a href="{{ route('contas_a_pagar.create') }}" class="btn">Adicionar Nova Conta</a>
    <p><strong>este formulário é ordenado somente pela data de vencimento do recente para o mais antigo</strong></p>

    <table>
        <thead>
            <tr>
                <th>Fornecedor</th>
                <th>Descrição</th>
                <th>Fatura</th>
                <th>Valor</th>
                <th>Forma de Pagamento</th> 
                <th>Data de Emissão</th>
                <th>Data da Compra</th>
                <th>Data de Vencimento</th>
                <th>Data de Pagamento</th>
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
                @endif">
                <td>{{ $conta->fornecedor ? $conta->fornecedor->nome : 'Fornecedor não encontrado' }}</td>
                <td>{{ $conta->descricao }}</td>
                <td>{{ $conta->id }}</td>
                <td><strong>{{ $conta->valor }}</strong></td>

                <td>{{ $conta->formaPagamento->nome ?? 'Não definido' }}</td> 


                <!-- Data de Emissão formato DD/MM/AAAA -->
                <td>{{ \Carbon\Carbon::parse($conta->created_at)->format('d/m/Y') }}</td>

                 <!-- Data da Compra formato DD/MM/AAAA -->
                 <td>{{ \Carbon\Carbon::parse($conta->data_compra)->format('d/m/Y') }}</td>


                 <!-- Data de Vencimento em formato DD/MM/AAAA -->
                 <td>{{ \Carbon\Carbon::parse($conta->data_vencimento)->format('d/m/Y') }}</td>
                
                <!-- Data de Pagamento em formato DD/MM/AAAA -->
                <td>
                    @if ($conta->data_pagamento)
                        {{ \Carbon\Carbon::parse($conta->data_pagamento)->format('d/m/Y') }}
                    @else
                        -
                    @endif
                </td>
              
                <td>{{ $conta->status }}</td>
                <td>
                    <a href="{{ route('contas_a_pagar.edit', $conta->id) }}" class="btn">Editar</a>
                    <form action="{{ route('contas_a_pagar.destroy', $conta->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


</body>
</html>

