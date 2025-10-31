@foreach ($movimentacoes as $movimentacao)
<tr>
    <td>{{ \Carbon\Carbon::parse($movimentacao->created_at)->format('d/m/Y') }}</td>
    <td data-label="Ordem de Coleta">{{ $movimentacao->id }}</td>
    <td data-label="CPF">{{ $movimentacao->cpf }}</td>
    <td data-label="Nome">{{ $movimentacao->nome }}</td>
    <td data-label="Endereço">{{ $movimentacao->endereco }}</td>
    <td data-label="Número">{{ $movimentacao->numero }}</td>
    <td data-label="Bairro">{{ $movimentacao->bairro }}</td>
    <td data-label="Cidade">{{ $movimentacao->cidade }}</td>
    <td data-label="Observação">{{ $movimentacao->observacao }}</td>
    <td data-label="Ações">
        <a href="{{ route('movimentacao.show', $movimentacao->id) }}" class="btn btn-consultar">Consultar/Alterar</a>
        <form action="{{ route('movimentacao.destroy', $movimentacao->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-excluir" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
        </form>
    </td>
</tr>
@endforeach
