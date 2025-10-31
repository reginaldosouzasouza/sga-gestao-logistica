<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relação de Contas a Receber</title>
    <link rel="stylesheet" href="{{ asset('css/contasareceber_relacao.css') }}">
</head>
<body>

<div class="container">
  
    <h1>Relação de Contas a Receber</h1>

    <!-- Exibição de Mensagens de Sucesso ou Informações -->
    @if(session('success'))
        <div class="alert alert-success" style="color: green; font-weight: bold;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info" style="color: blue; font-weight: bold;">
            {{ session('info') }}
        </div>
    @endif

      <!-- Campo para Atualizar o Status Contas a Receber de "pendente para atrasado'   -->

    <form action="{{ route('contas_a_receber.atualizar-status') }}" method="POST" style="display: inline;">
    @csrf
        <button type="submit" class="botao-status" title="Atualizar Status de Pendente para Atrasado com vencimentos anterior à data atual">
            Atualizar Status
        </button>
    </form>


   

   

    

    <!-- Formulário de Filtro -->
    <form method="GET" action="{{ route('contas_a_receber.index') }}" class="form-filtro mb-3">
        <div class="form-group">
            <label for="cliente"><strong>Cliente:</strong></label>
            <input type="text" name="cliente" value="{{ request('cliente') }}" class="form-control" placeholder="Nome do Cliente">
        </div>

        <div class="form-group">
            <label for="status"><strong>Status:</strong></label>
            <select name="status" class="form-control">
                <option value="">Todos</option>
                <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                <option value="Recebido" {{ request('status') == 'Recebido' ? 'selected' : '' }}>Recebido</option>
                <option value="atrasado" {{ request('status') == 'atrasado' ? 'selected' : '' }}>Atrasado</option>
            </select>
        </div>

        <div class="form-group">
            <label for="forma_pagamento_id"><strong>Forma de Pagamento:</strong></label>
            <select name="forma_pagamento_id" class="form-control">
                <option value="">Todas</option>
                @foreach($formasDePagamento as $forma)
                    <option value="{{ $forma->id }}" {{ request('forma_pagamento_id') == $forma->id ? 'selected' : '' }}>
                        {{ $forma->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="data_venda_inicial"><strong>Data da Venda Inicial:</strong></label>
            <input type="date" name="data_venda_inicial" value="{{ request('data_venda_inicial') }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="data_venda_final"><strong>Data da Venda Final:</strong></label>
            <input type="date" name="data_venda_final" value="{{ request('data_venda_final') }}" class="form-control">
        </div>
       

      <!--  <div class="form-group">
            <label for="data_venda"><strong>Data de Venda:</strong></label>
            <input type="date" name="data_venda" value="{{ request('data_venda') }}" class="form-control">
        </div>-->

        <div class="form-group">
            <label for="data_vencimento"><strong>Data de Vencimento:</strong></label>
            <input type="date" name="data_vencimento" value="{{ request('data_vencimento') }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="data_recebimento"><strong>Data de Recebimento:</strong></label>
            <input type="date" name="data_recebimento" value="{{ request('data_recebimento') }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-2">Filtrar</button>
    </form>

    
       <!-- Exibição de Total de Registros e Faturas -->
        <p>Total de Registros: <strong>{{ $totalContas }}</strong></p>
        <p>Total de Faturas: <strong>{{ number_format($valorTotalFaturas, 2, ',', '.') }}</strong></p>


    <a href="{{ route('contas_a_receber.create') }}" class="btn btn-success mb-3">Adicionar Nova Conta</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Forma de Pagamento</th>
                <th>Valor</th>
                <th>Data da Venda</th>
                <th>Data de Vencimento</th>
                <th>Data de Recebimento</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contasAReceber as $conta)
            <tr class="
                @if($conta->status == 'pendente') bg-warning 
                @elseif($conta->status == 'recebido') bg-success 
                @elseif($conta->status == 'atrasado') bg-danger 
                @endif">
                <td>{{ $conta->cliente->nome }}</td>
                <td>{{ $conta->formaPagamento->nome }}</td>
                <td>{{ number_format($conta->valor, 2, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($conta->data_venda)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($conta->data_vencimento)->format('d/m/Y') }}</td>
                <td>
                    @if ($conta->data_recebimento)
                        {{ \Carbon\Carbon::parse($conta->data_recebimento)->format('d/m/Y') }}
                    @else
                        -
                    @endif
                </td>

               <td>
                    @if($conta->status == 'pendente')
                        <span style="color: white; font-weight: bold;">Pendente</span>
                    @elseif($conta->status == 'recebido')
                        <span style="color: black; font-weight: bold;">Recebido</span>
                    @elseif($conta->status == 'atrasado')
                        <span style="color: white; font-weight: bold;">Atrasado</span>
                    @else
                        {{ ucfirst($conta->status) }}
                    @endif
                </td>

                <td>
                    <a href="{{ route('contas_a_receber.edit', $conta->id) }}" class="btn btn-primary">Editar</a>
                    <form action="{{ route('contas_a_receber.destroy', $conta->id) }}" method="POST" style="display:inline;">
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
