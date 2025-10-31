<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdemServico;
use App\Models\Mecanico;
use App\Models\Cliente;
use App\Models\Veiculo;
use App\Http\Controllers\OrdemServicoController;
use App\Models\Produto;
use App\Models\FormaDePagamento;
use App\Models\Prazo;




class OrdemServicoController extends Controller
{
    public function index()
    {
        $ordens = OrdemServico::all();
        return view('ordens_servico.index', compact('ordens'));
    }

        public function create()
    {
        $clientes = Cliente::orderBy('nome')->get();
        $mecanicos = Mecanico::orderBy('nome')->get();
        $produtos = Produto::orderBy('nome')->get();
        $formasPagamento = FormaDePagamento::orderBy('nome')->get();
        $prazos = Prazo::orderBy('prazo')->get();
         $proximoId = OrdemServico::max('id') + 1;

        return view('ordens_servico.create', compact(
            'clientes', 'mecanicos', 'produtos', 'formasPagamento', 'prazos',
            'proximoId'));
    }

 
   // CAMPO NOVO DO STORE

   public function store(Request $request)
{
    try {
        // Debug: vamos ver o que está chegando no request
        \Log::info('Dados recebidos no store:', $request->all());
        
        // Validação dos campos principais
        $validated = $request->validate([
            // Campos principais da ordem de serviço
            'cliente' => 'required|string|max:255',
            'veiculo' => 'nullable|string|max:255', 
            'placa' => 'nullable|string|max:20',
            'marca' => 'nullable|string|max:255',
            'modelo' => 'nullable|string|max:255',
            'mecanico' => 'nullable|string|max:255',
            'km' => 'nullable|integer',
            'servico_realizado' => 'nullable|string',
            'status' => 'nullable|string|max:50',
            'observacoes' => 'nullable|string',
            'data_prevista_entrega' => 'nullable|date',
            'valor_total_geral' => 'nullable|string',
            'data_lancamento' => 'nullable|date',

            
            // Campos dos produtos (arrays)
            'produto_id' => 'nullable|array',
            'produto_id.*' => 'nullable|integer|exists:produtos,id',
            'quantidade' => 'nullable|array',
            'quantidade.*' => 'nullable|numeric|min:0',
            'valor_unitario' => 'nullable|array',
            'valor_unitario.*' => 'nullable|string',
            'valor_total' => 'nullable|array',
            'valor_total.*' => 'nullable|string',
        ]);

        // Processa o valor total geral
        $valorTotalGeral = 0;
        if (!empty($validated['valor_total_geral'])) {
            $valorTotalGeral = $this->converterMoedaParaDecimal($validated['valor_total_geral']);
        }

        // Prepara os dados principais da ordem de serviço
        $dadosOrdemServico = [
            'cliente' => $validated['cliente'],
            'veiculo' => $validated['veiculo'] ?? null,
            'placa' => $validated['placa'] ?? null,
            'marca' => $validated['marca'] ?? null,
            'modelo' => $validated['modelo'] ?? null,
            'mecanico' => $validated['mecanico'] ?? null,
            'km' => $validated['km'] ?? null,
            'servico_realizado' => $validated['servico_realizado'] ?? null,
            'status' => $validated['status'] ?? 'Aberto',
            'observacoes' => $validated['observacoes'] ?? null,
            'data_prevista_entrega' => $validated['data_prevista_entrega'] ?? null,
             'data_lancamento' => $validated['data_lancamento'] ?? null,
            'valor' => $valorTotalGeral,
        ];

        // Adiciona as datas de criação se não existirem
        $dadosOrdemServico['created_at'] = now();
        $dadosOrdemServico['updated_at'] = now();

        \Log::info('Dados preparados para inserção:', $dadosOrdemServico);

        // Cria a ordem de serviço
        $ordemServico = OrdemServico::create($dadosOrdemServico);

        \Log::info('Ordem de serviço criada com ID:', ['id' => $ordemServico->id]);

        // Processa os produtos se existirem
        if (!empty($validated['produto_id']) && is_array($validated['produto_id'])) {
            $this->processarProdutos($ordemServico->id, $validated);
        }

        return redirect()->route('ordens-servico.index')
                         ->with('success', 'Ordem de serviço cadastrada com sucesso!');
                         
    } catch (\Illuminate\Validation\ValidationException $e) {
        \Log::error('Erro de validação:', $e->errors());
        return redirect()->back()
                         ->withErrors($e->errors())
                         ->withInput();
                         
    } catch (\Exception $e) {
        \Log::error('Erro ao salvar ordem de serviço:', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return redirect()->back()
                         ->with('error', 'Erro ao salvar ordem de serviço: ' . $e->getMessage())
                         ->withInput();
    }
}

/**
 * Converte valor monetário brasileiro para decimal
 */
private function converterMoedaParaDecimal($valor)
{
    if (empty($valor)) {
        return 0;
    }
    
    // Remove símbolos e espaços: R$ 1.234,56 -> 1234,56
    $valor = str_replace(['R$', ' ', '.'], '', $valor);
    // Substitui vírgula por ponto: 1234,56 -> 1234.56
    $valor = str_replace(',', '.', $valor);
    
    return (float) $valor;
}

/**
 * Processa e salva os produtos da ordem de serviço
 */
private function processarProdutos($ordemServicoId, $dadosValidados)
{
    $produtoIds = $dadosValidados['produto_id'] ?? [];
    $quantidades = $dadosValidados['quantidade'] ?? [];
    $valoresUnitarios = $dadosValidados['valor_unitario'] ?? [];
    $valoresTotal = $dadosValidados['valor_total'] ?? [];

    for ($i = 0; $i < count($produtoIds); $i++) {
        // Verifica se o produto foi selecionado
        if (!empty($produtoIds[$i]) && !empty($quantidades[$i])) {
            
            $valorUnitario = $this->converterMoedaParaDecimal($valoresUnitarios[$i] ?? '0');
            $valorTotal = $this->converterMoedaParaDecimal($valoresTotal[$i] ?? '0');
            
            // Aqui você pode salvar em uma tabela de produtos da ordem
            // Exemplo se você tiver uma tabela ordem_servico_produtos:
            /*
            DB::table('ordem_servico_produtos')->insert([
                'ordem_servico_id' => $ordemServicoId,
                'produto_id' => $produtoIds[$i],
                'quantidade' => $quantidades[$i],
                'valor_unitario' => $valorUnitario,
                'valor_total' => $valorTotal,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            */
            
            // Ou se você salvar como JSON em um campo:
            $produtos[] = [
                'produto_id' => $produtoIds[$i],
                'quantidade' => $quantidades[$i],
                'valor_unitario' => $valorUnitario,
                'valor_total' => $valorTotal,
            ];
        }
    }
    
    // Se você salvar como JSON no campo descricao_pecas:
    if (!empty($produtos)) {
        OrdemServico::where('id', $ordemServicoId)->update([
            'descricao_pecas' => json_encode($produtos)
        ]);
    }
}

// Adicione este método no seu OrdemServicoController para testar

public function testarDados()
{
    // Busca a última ordem de serviço criada
    $ultimaOrdem = OrdemServico::latest()->first();
    
    if ($ultimaOrdem) {
        dd([
            'id' => $ultimaOrdem->id,
            'cliente' => $ultimaOrdem->cliente,
            'placa' => $ultimaOrdem->placa,
            'valor' => $ultimaOrdem->valor,
            'status' => $ultimaOrdem->status,
            'dados_completos' => $ultimaOrdem->toArray()
        ]);
    } else {
        dd('Nenhuma ordem de serviço encontrada');
    }
}

// Adicione esta rota no seu web.php para testar:
// Route::get('/testar-dados', [OrdemServicoController::class, 'testarDados']);

// Depois acesse: http://seu-site.com/testar-dados

    public function edit($id)
    {
        $ordem = OrdemServico::findOrFail($id);
        return view('ordens_servico.edit', compact('ordem'));
    }

    public function update(Request $request, $id)
    {
        $ordem = OrdemServico::findOrFail($id);

        $request->validate([
            'cliente' => 'required|string|max:255',
            'veiculo' => 'nullable|string|max:255',
            'placa' => 'nullable|string|max:20',
            'servico_realizado' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'status' => 'nullable|string|max:50',
            'observacoes' => 'nullable|string',
        ]);

        $ordem->update($request->all());

        return redirect()->route('ordens-servico.index')
                         ->with('success', 'Ordem de serviço atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $ordem = OrdemServico::findOrFail($id);
        $ordem->delete();

        return redirect()->route('ordens-servico.index')
                         ->with('success', 'Ordem de serviço excluída com sucesso!');
    }
}
