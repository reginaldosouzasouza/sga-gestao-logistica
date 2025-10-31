<?php
 namespace App\Http\Controllers;

 use Illuminate\Http\Request;
 use App\Models\Produto;
 use Illuminate\Support\Facades\Log;
 
 
 class ProdutoController extends Controller
 {


 public function index(Request $request)
{
    $search = $request->get('search');
    
    if ($search) {
        // Ordenar os produtos encontrados pela busca em ordem alfabética
        $produtos = Produto::where('nome', 'like', '%' . $search . '%')
                        ->orderBy('nome', 'asc') // Ordenação alfabética
                        ->get();
    } else {
        // Se não houver busca, ordenar todos os produtos em ordem alfabética
        $produtos = Produto::orderBy('nome', 'asc')->get();
    }

    return view('produtos.index', compact('produtos'));
}

 
 
     public function create()
     {
         return view('produtos.create');
     }




     public function store(Request $request)
     {
         Log::info('Iniciando o processo de cadastro do produto.');
     
         try {
             // Convertendo vírgulas em pontos ANTES da validação
             $request->merge([
                 'preco_compra' => str_replace(',', '.', $request->preco_compra),
                 'preco_venda' => str_replace(',', '.', $request->preco_venda),
             ]);
     
             // Validação dos dados
             Log::info('Validando os dados...');
             $validatedData = $request->validate([
                 'nome' => 'required|max:255',
                 'descricao' => 'nullable|max:255',
                 'preco_compra' => 'required|regex:/^\d+(\.\d{1,2})?$/', // Agora aceita ponto decimal
                 'preco_venda' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                 'quantidade_estoque' => 'required|integer',
                 'unidade_de_medida' => 'required|max:50',
                 'estoque_minimo' => 'required|integer|min:0',
                 'codigo_barras' => 'nullable|string|max:255',
             ]);
     
             Log::info('Valor de preco_venda recebido: ' . $validatedData['preco_venda']);
             Log::info('Dados validados com sucesso.', $validatedData);
     
             // Tentando criar o produto
             Log::info('Tentando criar o produto...');
             $produto = Produto::create($validatedData);
     
             Log::info('Produto criado com sucesso', $produto->toArray());
     
             return redirect()->route('produtos.index')->with('success', 'Produto cadastrado com sucesso!');
         
         } catch (\Illuminate\Validation\ValidationException $e) {
             Log::error('Erro de validação ao criar produto: ' . $e->getMessage());
             Log::error('Erros de validação:', $e->errors());
     
             return redirect()->route('produtos.create')->withErrors($e->validator)->withInput();
         
         } catch (\Illuminate\Database\QueryException $e) {
             // Verifica se o erro é sobre a coluna inexistente `codigo_barras`
             if (str_contains($e->getMessage(), 'Unknown column \'codigo_barras\'')) {
                 Log::error('Erro: A coluna "codigo_barras" não existe na tabela produtos. Certifique-se de que a migration foi executada corretamente.');
                 return redirect()->route('produtos.create')->with('error', 'Erro: A coluna "Código de Barras" não foi encontrada. Execute as migrations.');
             }
     
             Log::error('Erro ao criar produto: ' . $e->getMessage());
             return redirect()->route('produtos.index')->with('error', 'Erro ao cadastrar produto.');
         
         } catch (\Exception $e) {
             Log::error('Erro inesperado ao criar produto: ' . $e->getMessage());
             return redirect()->route('produtos.index')->with('error', 'Erro inesperado ao cadastrar produto.');
         
         } finally {
             Log::info('Finalizando o processo de cadastro do produto.');
         }
     }
     




    
    public function update(Request $request, $id)
    {
        Log::info('Iniciando o processo de atualização do produto.');

        try {
            // Validação dos dados
            $validatedData = $request->validate([
                'nome' => 'required|max:255',
                'descricao' => 'nullable|max:255',
                'preco_compra' => 'required|numeric',
                'preco_venda' => 'required|numeric',
                'quantidade_estoque' => 'required|integer',
                'unidade_de_medida' => 'required|max:50',
                'estoque_minimo' => 'required|integer|min:0', // Validação para o estoque mínimo
                'codigo_barras' => 'nullable|string|max:255',

            ]);

            // Convertendo vírgulas em pontos nos campos numéricos
            $validatedData['preco_compra'] = str_replace(',', '.', $validatedData['preco_compra']);
            $validatedData['preco_venda'] = str_replace(',', '.', $validatedData['preco_venda']);

            // Buscando o produto e atualizando
            $produto = Produto::findOrFail($id);
            $produto->update($validatedData);

            Log::info('Produto atualizado com sucesso', $produto->toArray());

            return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar produto: ' . $e->getMessage());

            return redirect()->route('produtos.index')->with('error', 'Erro ao atualizar produto.');
        } finally {
            Log::info('Finalizando o processo de atualização do produto.');
        }
    }

    public function edit($id)
    {
        Log::info('Iniciando o processo de edição do produto.');
    
        // Tente buscar o produto pelo ID
        $produto = Produto::findOrFail($id);

        Log::info('Produto encontrado para edição.', $produto->toArray());

        // Retorne a view com os dados do produto
        return view('produtos.edit', compact('produto'));
    }


    public function destroy($id)
    {
        Log::info('Iniciando o processo de exclusão do produto.');

        try {
            // Buscar o produto e excluir
            $produto = Produto::findOrFail($id);
            $produto->delete();

            Log::info('Produto excluído com sucesso', ['id' => $id]);

            return redirect()->route('produtos.index')->with('success', 'Produto excluído com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao excluir produto: ' . $e->getMessage());

            return redirect()->route('produtos.index')->with('error', 'Erro ao excluir produto.');
        } finally {
            Log::info('Finalizando o processo de exclusão do produto.');
        }
    }

    public function consulta()
    {
        // Executa a consulta SQL para buscar os produtos
        $produtos = Produto::select('nome', 'quantidade_estoque', 'updated_at')
                    ->orderBy('quantidade_estoque', 'desc')
                    ->get();

        // Retorna a view com os dados dos produtos
        return view('produtos.consulta', compact('produtos'));
    }

   
    public function relatorioEstoqueAtual(Request $request)
    {
        $sort = $request->input('sort', 'nome'); // Ordenar por nome por padrão
        $direction = $request->input('direction', 'asc'); // Ordenar em ordem ascendente por padrão

        $produtos = Produto::orderBy($sort, $direction)->get();

        return view('relatorios.estoqueAtual', compact('produtos'));
    }

    public function gerarRelatorioPdf()
    {
        $produtos = Produto::all();
        
        // Gerar o PDF com base na view estoqueAtual
        $pdf = PDF::loadView('relatorios.estoqueAtual_pdf', compact('produtos'));

        // Retornar o PDF para download
        return $pdf->download('relatorio_estoque_atual.pdf');
    }


    public function verificarEstoque(Request $request)
{
    $produto = Produto::find($request->produto_id);

    return response()->json([
        'quantidade_estoque' => $produto->quantidade_estoque
    ]);
}

public function autocomplete(Request $request)
{
    $termo = $request->get('query');
    $produtos = Produto::where('nome', 'like', '%' . $termo . '%')->get();

    $resultados = [];

    foreach ($produtos as $produto) {
        $resultados[] = [
            'id' => $produto->id,
            'text' => $produto->nome,
        ];
    }

    return response()->json($resultados);
}

public function saldoEstoque(Request $request)
{
    // Inicia a query base para os produtos
    $query = Produto::select('nome', 'quantidade_estoque', 'estoque_minimo');

    // Verifica se há um filtro pelo nome do produto
    if ($request->has('nome') && $request->nome != '') {
        $query->where('nome', 'LIKE', '%' . $request->nome . '%');
    }

    // Ordena os produtos por nome
    $produtos = $query->orderBy('nome')->get();

    // Retorna a view com os produtos filtrados
    return view('relatorios.saldo_estoque', compact('produtos'));
}


public function buscar(Request $request)
{
    $termo = $request->input('query');
    
    // Busca produtos que contêm o termo digitado no nome
    $produtos = Produto::where('nome', 'LIKE', '%' . $termo . '%')->pluck('nome');

    // Retorna os nomes em formato JSON
    return response()->json($produtos);
}


public function buscarPorCodigo(Request $request)
{
    $codigoBarras = $request->input('codigo_barras');

    $produto = Produto::where('codigo_barras', $codigoBarras)->first();

    if ($produto) {
        return response()->json([
            'success' => true,
            'produto' => $produto,
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Produto não encontrado!',
    ]);
}





    
    



 }    

 
     