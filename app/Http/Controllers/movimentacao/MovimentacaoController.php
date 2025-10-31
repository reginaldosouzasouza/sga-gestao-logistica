<?php

namespace App\Http\Controllers;

use App\Models\Produto; // Adicione esta linha para importar o modelo Produto
use App\Models\Movimentacao;
use App\Models\ContasAReceber;
use Illuminate\Http\Request;
use App\Models\MovimentacaoItem;
use Illuminate\Support\Facades\Log;
use App\Models\FormaDePagamento;
use App\Models\Prazo;
use App\Models\Estoque;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;







class MovimentacaoController extends Controller

{

    public function create() 
    {
        $cliente_id = null; // Inicialize como null
    
       // $ultimo_id = Movimentacao::max('id');
        $proximoId = Movimentacao::max('id') + 1;
        $formas_de_pagamento = FormaDePagamento::all();
        $prazos = Prazo::all();
        $produtos = Produto::orderBy('nome', 'asc')->get();

       
          
    
        return view('movimentacao.create', compact('formas_de_pagamento', 'prazos', 'proximoId', 'produtos', 'cliente_id'));
    }
        
   

    public function store(Request $request)
    {
        $request->validate([
            'data_coleta' => 'required|date|before_or_equal:today',
            'nome' => 'required',
            'endereco' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'produtos' => 'required|array',
            'produtos.*.produto_id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1',
            'produtos.*.valor_unitario' => 'required|numeric|min:0',
            'forma_pagamento' => 'required|exists:formas_de_pagamento,id',
        ]);
    
        DB::beginTransaction();
        try {
            // Cálculo do valor total da movimentação
            $valorTotalMovimentacao = 0;
            foreach ($request->produtos as $item) {
                $valorTotalMovimentacao += $item['quantidade'] * $item['valor_unitario'];
            }
    
            // Criação da movimentação
            $movimentacao = Movimentacao::create([
                'data_coleta' => $request->data_coleta,
                'nome' => $request->nome,
                'endereco' => $request->endereco,
                'numero' => $request->numero,
                'bairro' => $request->bairro,
                'cidade' => $request->cidade,
                'cliente_id' => $request->cliente_id,
                'observacao' => $request->observacao,
                'forma_pagamento_id' => $request->forma_pagamento,
                'prazo_id' => $request->prazo,
                'valor_total' => $valorTotalMovimentacao,
                'quantidade' => array_sum(array_column($request->produtos, 'quantidade')),
            ]);
    
            // Processamento dos itens da movimentação
            foreach ($request->produtos as $item) {
                $produto = Produto::find($item['produto_id']);
                if (!$produto) {
                    continue;
                }
    
                MovimentacaoItem::create([
                    'movimentacao_id' => $movimentacao->id,
                    'produto_id' => $item['produto_id'],
                    'quantidade' => $item['quantidade'],
                    'valor_unitario' => $item['valor_unitario'],
                    'valor_total' => $item['quantidade'] * $item['valor_unitario'],
                ]);
    
                // Atualização do estoque
                $produto->quantidade_estoque -= $item['quantidade'];
                $produto->save();
            }
    
            DB::commit();
            return redirect()->route('movimentacao.index')->with('success', 'Movimentação salva com sucesso.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erro ao salvar itens da movimentação:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors('Erro ao salvar a movimentação.');
        }
    }




   


 

    public function atualizarStatusAutomaticamente()
    {
        $contas = ContaReceber::all();
    
        foreach ($contas as $conta) {
            if (Carbon::parse($conta->data_vencimento)->isPast() && $conta->status != 'Pago') {
                $conta->status = 'Atrasado';
                $conta->save();
            }
        }
    
        return view('contas_a_receber.index', compact('contas'));
    }
         


    public function verificarEstoque(Request $request)
    {
        $produto = Produto::find($request->produto_id);

        return response()->json([
            'quantidade_estoque' => $produto->quantidade_estoque
        ]);
    }


    //FUNÇÃO DESTROY

    public function destroy($id)
    {
    // Buscar a movimentação pelo ID
    $movimentacao = Movimentacao::findOrFail($id);

    // Excluir os itens relacionados à movimentação primeiro
    \App\Models\MovimentacaoItem::where('movimentacao_id', $id)->delete();

    // Depois, excluir a movimentação
    $movimentacao->delete();

    // Redirecionar de volta para a lista de movimentações com uma mensagem de sucesso
    return redirect()->route('movimentacao.index')->with('success', 'Movimentação excluída com sucesso.');
}





    public function index()
    {
        // Buscar todas as movimentações
        $movimentacoes = Movimentacao::with('formaPagamento')->get();


            // Obter as movimentações com paginação de 30 registros por página, ordenadas pelo ID de forma crescente
                $movimentacoes = Movimentacao::orderBy('id', 'desc') // Aqui você pode ordenar por 'id', 'data_coleta' ou outro campo
                ->paginate(20); // Limite de 30 registros por págin

        // Retornar a view com as movimentações
        return view('movimentacao.index', compact('movimentacoes'));
    }




    
    public function show($id)
    {
        $movimentacao = Movimentacao::with('itens.produto')->findOrFail($id); // Carregar movimentação com itens e produto relacionado
        return view('movimentacao.show', compact('movimentacao'));
    }

    
        public function itens()
    {
        return $this->hasMany(MovimentacaoItem::class, 'movimentacao_id');
    }




        public function pesquisar(Request $request)
        {
            $termo = $request->input('termo');
            dd($termo);
            
            // Pesquisar movimentações pelo nome ou endereço
            $movimentacoes = Movimentacao::where('nome', 'like', "%{$termo}%")
                ->orWhere('endereco', 'like', "%{$termo}%")
                ->get();
                
            dd($movimentacoes);  // Isto irá mostrar os dados pesquisados na tela
            
            // Retornar a view com os resultados filtrados
            return view('movimentacao.index', compact('movimentacoes'));
        }

    
        



}
