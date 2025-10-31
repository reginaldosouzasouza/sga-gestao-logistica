<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relação de Contas a Receber</title>
    <link rel="stylesheet" href="{{ asset('css/contasareceber_relacao.css') }}">
    
</head>


<div class="container">
    <h1>Relação de Contas a Receber</h1>


    <a href="{{ route('contas_a_receber.create') }}" class="btn btn-success mb-3">Adicionar Nova Conta</a>

  

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Descrição</th>
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
                 @elseif($conta->status == 'pago') bg-success 
                @elseif($conta->status == 'atrasado') bg-danger 
                @endif">
                <td>{{ $conta->cliente->nome }}</td>
                <td>{{ $conta->descricao }}</td>
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
                <td>{{ $conta->status }}</td>
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

