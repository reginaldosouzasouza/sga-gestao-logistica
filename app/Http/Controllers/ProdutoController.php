<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use Illuminate\Support\Facades\Log;
use App\Models\Modulo;

class ProdutoController extends Controller
{
    /**
     * Retorna o ID da empresa do usuário logado.
     */
    private function empresaId()
    {
        return empresaAtualId();
    }

    public function index(Request $request)
    {
        $empresaId = $this->empresaId();
        $search = $request->get('search');

        $query = Produto::with('modulo')
            ->where('empresa_id', $empresaId);

        if ($search) {
            $query->where('nome', 'like', '%' . $search . '%');
        }

        $produtos = $query
            ->orderBy('nome', 'asc')
            ->get();

        return view('produtos.index', compact('produtos'));
    }

    public function create()
    {
        $modulos = Modulo::orderBy('descricao')->get();

        return view('produtos.create', compact('modulos'));
    }

    public function store(Request $request)
    {
        Log::info('Iniciando o processo de cadastro do produto.');

        try {
            $empresaId = $this->empresaId();

            // Convertendo vírgulas em pontos ANTES da validação
            $request->merge([
                'preco_compra' => str_replace(',', '.', $request->preco_compra),
                'preco_venda' => str_replace(',', '.', $request->preco_venda),
            ]);

            Log::info('Validando os dados...');

            $validatedData = $request->validate([
                'nome' => 'required|max:255',
                'descricao' => 'nullable|max:255',
                'preco_compra' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'preco_venda' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'quantidade_estoque' => 'required|integer',
                'unidade_de_medida' => 'required|max:50',
                'estoque_minimo' => 'required|integer|min:0',
                'codigo_barras' => 'nullable|string|max:255',
                'modulo_id' => 'nullable|exists:modulos,id',
            ]);

            $validatedData['empresa_id'] = $empresaId;

            Log::info('Valor de preco_venda recebido: ' . $validatedData['preco_venda']);
            Log::info('Dados validados com sucesso.', $validatedData);

            // ─── CÁLCULO DE MARGEM ───────────────────────────────────────
            $compra = floatval($validatedData['preco_compra']);
            $venda  = floatval($validatedData['preco_venda']);

            if ($compra > 0) {
                $validatedData['margem_valor'] = round($venda - $compra, 2);
                $validatedData['margem_percentual'] = round((($venda - $compra) / $compra) * 100, 2);
            } else {
                $validatedData['margem_valor'] = 0;
                $validatedData['margem_percentual'] = 0;
            }

            Log::info('Margem calculada: ' . $validatedData['margem_percentual'] . '% | R$ ' . $validatedData['margem_valor']);
            // ─────────────────────────────────────────────────────────────

            Log::info('Tentando criar o produto...');
            $produto = Produto::create($validatedData);

            Log::info('Produto criado com sucesso', $produto->toArray());

            return redirect()
                ->route('produtos.index')
                ->with('success', 'Produto cadastrado com sucesso!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erro de validação ao criar produto: ' . $e->getMessage());
            Log::error('Erros de validação:', $e->errors());

            return redirect()
                ->route('produtos.create')
                ->withErrors($e->validator)
                ->withInput();

        } catch (\Illuminate\Database\QueryException $e) {
            if (str_contains($e->getMessage(), 'Unknown column \'codigo_barras\'')) {
                Log::error('Erro: A coluna "codigo_barras" não existe na tabela produtos.');

                return redirect()
                    ->route('produtos.create')
                    ->with('error', 'Erro: A coluna "Código de Barras" não foi encontrada. Execute as migrations.');
            }

            Log::error('Erro ao criar produto: ' . $e->getMessage());

            return redirect()
                ->route('produtos.index')
                ->with('error', 'Erro ao cadastrar produto.');

        } catch (\Exception $e) {
            Log::error('Erro inesperado ao criar produto: ' . $e->getMessage());

            return redirect()
                ->route('produtos.index')
                ->with('error', 'Erro inesperado ao cadastrar produto.');

        } finally {
            Log::info('Finalizando o processo de cadastro do produto.');
        }
    }

    public function edit($id)
    {
        Log::info('Iniciando o processo de edição do produto.');

        $empresaId = $this->empresaId();

        $produto = Produto::where('empresa_id', $empresaId)
            ->where('id', $id)
            ->firstOrFail();

        Log::info('Produto encontrado para edição.', $produto->toArray());

        $modulos = Modulo::orderBy('descricao')->get();

        return view('produtos.edit', compact('produto', 'modulos'));
    }

    public function update(Request $request, $id)
    {
        Log::info('Iniciando o processo de atualização do produto.');

        try {
            $empresaId = $this->empresaId();

            $produto = Produto::where('empresa_id', $empresaId)
                ->where('id', $id)
                ->firstOrFail();

            $request->merge([
                'preco_compra' => str_replace(',', '.', $request->preco_compra),
                'preco_venda'  => str_replace(',', '.', $request->preco_venda),
            ]);

            $validatedData = $request->validate([
                'nome' => 'required|max:255',
                'descricao' => 'nullable|max:255',
                'preco_compra' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'preco_venda' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'quantidade_estoque' => 'required|integer',
                'unidade_de_medida' => 'required|max:50',
                'estoque_minimo' => 'required|integer|min:0',
                'codigo_barras' => 'nullable|string|max:255',
                'modulo_id' => 'required|exists:modulos,id',
            ]);

            $validatedData['empresa_id'] = $empresaId;

            $compra = floatval($validatedData['preco_compra']);
            $venda  = floatval($validatedData['preco_venda']);

            if ($compra > 0) {
                $validatedData['margem_valor'] = round($venda - $compra, 2);
                $validatedData['margem_percentual'] = round((($venda - $compra) / $compra) * 100, 2);
            } else {
                $validatedData['margem_valor'] = 0;
                $validatedData['margem_percentual'] = 0;
            }

            $produto->update($validatedData);

            Log::info('Produto atualizado com sucesso', $produto->fresh()->toArray());

            return redirect()
                ->route('produtos.index')
                ->with('success', 'Produto atualizado com sucesso!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erro de validação ao atualizar produto: ' . $e->getMessage());
            Log::error('Erros de validação:', $e->errors());

            return redirect()
                ->back()
                ->withErrors($e->validator)
                ->withInput();

        } catch (\Exception $e) {
            Log::error('Erro ao atualizar produto: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Erro ao atualizar produto.');

        } finally {
            Log::info('Finalizando o processo de atualização do produto.');
        }
    }

    public function destroy($id)
    {
        Log::info('Iniciando o processo de exclusão do produto.');

        try {
            $empresaId = $this->empresaId();

            $produto = Produto::where('empresa_id', $empresaId)
                ->where('id', $id)
                ->firstOrFail();

            $produto->delete();

            Log::info('Produto excluído com sucesso', ['id' => $id]);

            return redirect()
                ->route('produtos.index')
                ->with('success', 'Produto excluído com sucesso!');

        } catch (\Exception $e) {
            Log::error('Erro ao excluir produto: ' . $e->getMessage());

            return redirect()
                ->route('produtos.index')
                ->with('error', 'Erro ao excluir produto.');

        } finally {
            Log::info('Finalizando o processo de exclusão do produto.');
        }
    }

    public function consulta()
    {
        $empresaId = $this->empresaId();

        $produtos = Produto::select('nome', 'quantidade_estoque', 'updated_at')
            ->where('empresa_id', $empresaId)
            ->orderBy('quantidade_estoque', 'desc')
            ->get();

        return view('produtos.consulta', compact('produtos'));
    }

    public function relatorioEstoqueAtual(Request $request)
    {
        $empresaId = $this->empresaId();

        $sort = $request->input('sort', 'nome');
        $direction = $request->input('direction', 'asc');

        $produtos = Produto::where('empresa_id', $empresaId)
            ->orderBy($sort, $direction)
            ->get();

        return view('relatorios.estoqueAtual', compact('produtos'));
    }

    public function gerarRelatorioPdf()
    {
        $empresaId = $this->empresaId();

        $produtos = Produto::where('empresa_id', $empresaId)->get();

        $pdf = PDF::loadView('relatorios.estoqueAtual_pdf', compact('produtos'));

        return $pdf->download('relatorio_estoque_atual.pdf');
    }

    public function verificarEstoque(Request $request)
    {
        $empresaId = $this->empresaId();

        $produto = Produto::where('empresa_id', $empresaId)
            ->where('id', $request->produto_id)
            ->first();

        if (!$produto) {
            return response()->json([
                'quantidade_estoque' => 0,
                'erro' => 'Produto não encontrado para esta empresa.'
            ], 404);
        }

        return response()->json([
            'quantidade_estoque' => $produto->quantidade_estoque
        ]);
    }

    public function autocomplete(Request $request)
    {
        $empresaId = $this->empresaId();
        $termo = $request->get('query');

        $produtos = Produto::where('empresa_id', $empresaId)
            ->where('nome', 'like', '%' . $termo . '%')
            ->get();

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
        $empresaId = $this->empresaId();

        $query = Produto::select('nome', 'quantidade_estoque', 'estoque_minimo')
            ->where('empresa_id', $empresaId);

        if ($request->has('nome') && $request->nome != '') {
            $query->where('nome', 'LIKE', '%' . $request->nome . '%');
        }

        $produtos = $query->orderBy('nome')->get();

        return view('relatorios.saldo_estoque', compact('produtos'));
    }

    public function buscar(Request $request)
    {
        $empresaId = $this->empresaId();
        $termo = $request->input('query');

        $produtos = Produto::where('empresa_id', $empresaId)
            ->where('nome', 'LIKE', '%' . $termo . '%')
            ->pluck('nome');

        return response()->json($produtos);
    }

    public function buscarPorCodigo(Request $request)
    {
        $empresaId = $this->empresaId();
        $codigoBarras = $request->input('codigo_barras');

        $produto = Produto::where('empresa_id', $empresaId)
            ->where('codigo_barras', $codigoBarras)
            ->first();

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