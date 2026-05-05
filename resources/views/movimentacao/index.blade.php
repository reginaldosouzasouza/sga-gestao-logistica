@extends('layouts.app')

@section('title', 'Lista de Coletas')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/movimentacao.css') }}">
@endsection

@section('content')

<div class="movimentacao-page">

    <!-- Campo de busca -->
    <div class="search-container">
    <form action="{{ route('movimentacao.index') }}" method="GET">
        <input 
            type="text" 
            name="search"
            value="{{ request('search') }}"
            placeholder="Digite o nome, telefone, cidade ou número da coleta" 
            class="form-control"
        >

        <button type="submit" class="btn-pesquisar">
            Pesquisar
        </button>

        @if(request('search'))
            <a href="{{ route('movimentacao.index') }}" class="btn-limpar">
                Limpar
            </a>
        @endif
    </form>
</div>

    <div class="container">
        <a href="{{ route('movimentacao.create') }}" class="btn-cadastrar">
            Cadastrar Movimentação
        </a>

        <h1 class="title">MOVIMENTAÇÕES</h1>

        <div class="table-responsive">
            <table class="table tabela-movimentacao">
                <thead>
                    <tr>
                        <th>Data Coleta</th>
                        <th>Controle de Coleta</th>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Valor Total</th>
                        <th>Forma de Pagamento</th>
                        <th>Prazo em Dias</th>
                        <th>Cidade</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($movimentacoes as $movimentacao)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($movimentacao->data_coleta)->format('d/m/Y') }}</td>
                            <td>{{ $movimentacao->id }}</td>
                            <td>{{ $movimentacao->nome }}</td>
                            <td>{{ $movimentacao->quantidade }}</td>
                            <td>R$ {{ number_format($movimentacao->valor_total, 2, ',', '.') }}</td>
                            <td>{{ $movimentacao->formaPagamento->nome ?? 'Sem forma de pagamento' }}</td>
                            <td>{{ $movimentacao->prazo_id }}</td>
                            <td>{{ $movimentacao->cidade }}</td>
                            <td>
                                <div class="btn-group-acoes">
                                    <a href="{{ route('movimentacao.show', $movimentacao->id) }}" class="btn btn-consultar">
                                        Consultar/Alterar
                                    </a>

                                    <form action="{{ route('movimentacao.destroy', $movimentacao->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button 
                                            type="submit" 
                                            class="btn btn-excluir" 
                                            onclick="return confirm('Tem certeza que deseja excluir?')"
                                        >
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            <p>
                Mostrando {{ $movimentacoes->firstItem() }} a {{ $movimentacoes->lastItem() }} 
                de {{ $movimentacoes->total() }} resultados
            </p>

            {{ $movimentacoes->onEachSide(1)->links('vendor.pagination.custom') }}
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
    document.getElementById('search').addEventListener('input', function() {
        let filter = this.value.toUpperCase();
        let rows = document.querySelectorAll('.tabela-movimentacao tbody tr');

        rows.forEach(row => {
            let nome = row.querySelector('td:nth-child(3)').textContent.toUpperCase();
            let cidade = row.querySelector('td:nth-child(8)').textContent.toUpperCase();

            if (nome.indexOf(filter) > -1 || cidade.indexOf(filter) > -1) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endsection