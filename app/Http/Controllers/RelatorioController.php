<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimentacao;
use Carbon\Carbon;
use App\Models\Venda;
use App\Models\Produto;



class RelatorioController extends Controller
{
    public function vendas(Request $request)
    {

        //ESTE RELATÓRIO ESTA MOSTRANDO DIRETAMENTE EM ORDEM DE DATAS DO MAIS RECENTE PARA O MAIS ANTIGO
        // CASO O USUÁRIO QUISER, PODE-SE CRIAR O SEU PRÓRPIO FILTRO.
        
        // Inicializando a query
        $query = Movimentacao::query();

        // Filtro por nome do cliente (se fornecido)
        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }

        // Filtro por data (se fornecido)
            if ($request->filled('data_inicial') && $request->filled('data_final')) {
            $query->whereBetween('created_at', [
                date('Y-m-d 00:00:00', strtotime($request->data_inicial)),
                date('Y-m-d 23:59:59', strtotime($request->data_final))
            ]);
        }
        
        

        // Ordenar pela data do mais recente para o mais antigo
        $query->orderBy('created_at', 'desc');

        // Obter os resultados
        $vendas = $query->get();

         // Calcular o total de registros e o valor total
         $totalRegistros = $vendas->count();
         $valorTotal = $vendas->sum('valor_total');
 
         return view('relatorios.vendas', compact('vendas', 'totalRegistros', 'valorTotal'));

        
    }



    public function vendasPorProduto(Request $request)
    {
        $query = Movimentacao::query()
            ->join('movimentacao_itens', 'movimentacao.id', '=', 'movimentacao_itens.movimentacao_id')
            ->join('produtos', 'movimentacao_itens.produto_id', '=', 'produtos.id')
            ->select('movimentacao.nome as nome_cliente', 
                    'produtos.nome as nome_produto',
                    'movimentacao.bairro as nome_bairro', // Adicionando o campo 'bairro'
                    'movimentacao_itens.quantidade',
                    'movimentacao_itens.valor_unitario',
                    'movimentacao_itens.valor_total',
                    'movimentacao.created_at as data_movimentacao');

        // Filtro por nome do cliente (se fornecido)
        if ($request->filled('nome_cliente')) {
            $query->where('movimentacao.nome', 'like', '%' . $request->nome_cliente . '%');
        }

        // Filtro por produto (se fornecido)
        if ($request->filled('nome_produto')) {
            $query->where('produtos.nome', 'like', '%' . $request->nome_produto . '%');
        }

        // Filtro por bairro (se fornecido)
        if ($request->filled('nome_bairro')) {
            $query->where('movimentacao.bairro', 'like', '%' . $request->nome_bairro . '%');
        }
        
        // Filtro por data (se fornecido)
        if ($request->filled('data_inicial') && $request->filled('data_final')) {
            $query->whereBetween('movimentacao.created_at', [
                date('Y-m-d 00:00:00', strtotime($request->data_inicial)),
                date('Y-m-d 23:59:59', strtotime($request->data_final))
            ]);


        }

        // Ordenar pela data
        $query->orderBy('movimentacao.created_at', 'desc');

        // Obter os resultados
        $vendas = $query->get();

        // Calcular o total de valor_total
        $quantidadeTotal = $vendas->sum('quantidade');
        $valorTotal = $vendas->sum('valor_total');

        return view('relatorios.vendas_por_produto', compact('vendas', 'quantidadeTotal', 'valorTotal'));

          
    }

    public function saldoEstoque(Request $request)
{
    $nome = $request->input('nome');

    // Consulta para obter os produtos em ordem crescente de quantidade de estoque
    $produtos = Produto::when($nome, function ($query, $nome) {
            return $query->where('nome', 'like', "%$nome%");
        })
        ->orderBy('quantidade_estoque', 'asc') // Ordena em ordem crescente
        ->get();

   

    return view('relatorios.saldo_estoque', compact('produtos'));
}


   
   



}

