<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\Compra;
use App\Models\FormaDePagamento;
use App\Models\Prazo;
use App\Models\ContasAPagar;
use App\Models\Estoque;
use App\Models\Caixa;
use App\Models\CaixaBanco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ComprasController extends Controller
{
    private function empresaId()
    {
        return auth()->user()->empresa_id;
    }

    public function create()
    {
        $empresaId = $this->empresaId();

        $fornecedores = Fornecedor::where('empresa_id', $empresaId)
            ->orderBy('nome', 'asc')
            ->get();

        $produtos = Produto::where('empresa_id', $empresaId)
            ->orderBy('nome', 'asc')
            ->get();

        $formas_pagamento = FormaDePagamento::orderBy('nome', 'asc')->get();
        $prazos = Prazo::orderBy('prazo', 'asc')->get();

        return view('compras.create', compact(
            'fornecedores',
            'produtos',
            'formas_pagamento',
            'prazos'
        ));
    }

    public function store(Request $request)
    {
        if ($request->acao === 'importar_xml') {
            return $this->importarXmlCompra($request);
        }

        $empresaId = $this->empresaId();

        $request->validate([
            'fornecedor_id' => [
                'required',
                Rule::exists('fornecedores', 'id')->where(function ($query) use ($empresaId) {
                    return $query->where('empresa_id', $empresaId);
                }),
            ],
            'nota_fiscal' => 'nullable|string',
            'data_compra' => 'required|date',
            'forma_pagamento_id' => 'required|exists:formas_de_pagamento,id',
            'prazo_id' => 'required|exists:prazos,id',
            'parcelas' => 'nullable|integer|min:1|max:12',
            'itens' => 'required|array',
            'itens.*.produto_id' => [
                'required',
                Rule::exists('produtos', 'id')->where(function ($query) use ($empresaId) {
                    return $query->where('empresa_id', $empresaId);
                }),
            ],
            'itens.*.quantidade' => 'required|numeric|min:0.001',
            'itens.*.valor_unitario' => 'required|numeric|min:0',
            'itens.*.valor_total' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $valorTotalCompra = 0;

            foreach ($request->itens as $item) {
                $quantidade = (float) ($item['quantidade'] ?? 0);
                $valorUnitario = (float) ($item['valor_unitario'] ?? 0);

                $valorTotalCompra += $quantidade * $valorUnitario;
            }

            $prazo = Prazo::findOrFail($request->prazo_id);
            $prazoDias = intval($prazo->prazo);

            $formaPagamento = FormaDePagamento::findOrFail($request->forma_pagamento_id);
            $formaNome = strtolower(trim($formaPagamento->nome));

            $dataCompra = Carbon::parse($request->data_compra);
            $dataVencimento = $dataCompra->copy()->addDays($prazoDias);

            $compra = Compra::create([
                'empresa_id' => $empresaId,
                'fornecedor_id' => $request->fornecedor_id,
                'nota_fiscal' => $request->nota_fiscal,
                'data_compra' => $request->data_compra,
                'data_vencimento' => $dataVencimento->format('Y-m-d'),
                'data_pagamento' => null,
                'status' => 'pendente',
                'forma_pagamento_id' => $request->forma_pagamento_id,
                'prazo_id' => $request->prazo_id,
                'total' => $valorTotalCompra,
            ]);

            foreach ($request->itens as $item) {
                $produto = Produto::where('empresa_id', $empresaId)
                    ->where('id', $item['produto_id'])
                    ->firstOrFail();

                $quantidade = (float) $item['quantidade'];
                $valorUnitario = (float) $item['valor_unitario'];
                $valorTotalItem = $quantidade * $valorUnitario;

                $itemCompra = $compra->itensDeCompras()->create([
                    'produto_id' => $produto->id,
                    'quantidade' => $quantidade,
                    'valor_unitario' => $valorUnitario,
                    'valor_total' => $valorTotalItem,
                ]);

                Estoque::create([
                    'empresa_id' => $empresaId,
                    'produto_id' => $itemCompra->produto_id,
                    'quantidade' => $itemCompra->quantidade,
                    'tipo_movimentacao' => 'entrada',
                    'origem' => 'compra',
                    'data_movimentacao' => now(),
                ]);

                $produto->quantidade_estoque += $itemCompra->quantidade;
                $produto->save();
            }

            if ($formaNome === 'dinheiro') {
                Caixa::create([
                    'empresa_id' => $empresaId,
                    'data_movimentacao' => $request->data_compra,
                    'tipo' => 'saida',
                    'valor' => $valorTotalCompra,
                    'origem' => 'compra',
                    'descricao' => 'Compra à vista - NF ' . ($request->nota_fiscal ?? ''),
                    'referencia_id' => $compra->id,
                ]);
            } elseif ($formaNome === 'pix') {
                CaixaBanco::create([
                    'empresa_id' => $empresaId,
                    'data_movimentacao' => $request->data_compra,
                    'tipo' => 'saida',
                    'valor' => $valorTotalCompra,
                    'forma' => 'pix',
                    'origem' => 'compra',
                    'descricao' => 'Compra via PIX - NF ' . ($request->nota_fiscal ?? ''),
                    'referencia_id' => $compra->id,
                ]);
            } else {
                $parcelas = (int) ($request->parcelas ?? 1);

                if ($parcelas < 1) {
                    $parcelas = 1;
                }

                $valorParcela = $valorTotalCompra / $parcelas;

                for ($i = 1; $i <= $parcelas; $i++) {
                    $dataVencimentoParcela = $dataCompra->copy()->addDays($prazoDias * $i);

                    ContasAPagar::create([
                        'empresa_id' => $empresaId,
                        'compra_id' => $compra->id,
                        'fornecedor_id' => $request->fornecedor_id,
                        'descricao' => 'Compra de produtos - Parcela ' . $i . '/' . $parcelas . ' - NF ' . ($request->nota_fiscal ?? ''),
                        'valor' => $valorParcela,
                        'data_compra' => $request->data_compra,
                        'data_vencimento' => $dataVencimentoParcela->format('Y-m-d'),
                        'status' => 'pendente',
                        'forma_pagamento_id' => $request->forma_pagamento_id,
                        'prazo' => $prazoDias,
                        'parcela' => $i,
                        'total_parcelas' => $parcelas,
                        'data_pagamento' => null,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('compras.index')
                ->with('success', 'Compra salva com sucesso.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erro ao salvar compra', [
                'erro' => $e->getMessage(),
                'linha' => $e->getLine(),
                'arquivo' => $e->getFile(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->withErrors('Erro ao salvar a compra: ' . $e->getMessage());
        }
    }

    private function importarXmlCompra(Request $request)
    {
        $empresaId = $this->empresaId();

        $request->validate([
            'xml_nfe' => 'required|file|mimes:xml,txt',
        ]);

        try {
            $arquivo = $request->file('xml_nfe');
            $xmlContent = file_get_contents($arquivo->getRealPath());

            $xml = simplexml_load_string($xmlContent);

            if (!$xml) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Não foi possível ler o XML informado.');
            }

            $xml->registerXPathNamespace('nfe', 'http://www.portalfiscal.inf.br/nfe');

            $ide = $xml->xpath('//nfe:ide')[0] ?? null;
            $emit = $xml->xpath('//nfe:emit')[0] ?? null;
            $detalhes = $xml->xpath('//nfe:det') ?? [];

            if (!$ide || !$emit) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'XML inválido ou fora do padrão NF-e.');
            }

            $cnpjFornecedor = preg_replace('/\D/', '', (string) ($emit->CNPJ ?? ''));
            $nomeFornecedor = trim((string) ($emit->xNome ?? ''));

            $fornecedor = null;

            if (!empty($cnpjFornecedor)) {
                $fornecedor = Fornecedor::where('empresa_id', $empresaId)
                    ->whereRaw(
                        "REPLACE(REPLACE(REPLACE(cnpj, '.', ''), '/', ''), '-', '') = ?",
                        [$cnpjFornecedor]
                    )
                    ->first();
            }

            $notaFiscal = (string) ($ide->nNF ?? '');

            $dataCompra = date('Y-m-d');

            if (!empty($ide->dhEmi)) {
                $dataCompra = Carbon::parse((string) $ide->dhEmi)->format('Y-m-d');
            } elseif (!empty($ide->dEmi)) {
                $dataCompra = Carbon::parse((string) $ide->dEmi)->format('Y-m-d');
            }

            $itensXml = [];

            foreach ($detalhes as $det) {
                $prod = $det->prod ?? null;

                if (!$prod) {
                    continue;
                }

                $nomeProdutoXml = trim((string) ($prod->xProd ?? ''));
                $quantidade = (float) str_replace(',', '.', (string) ($prod->qCom ?? 0));
                $valorUnitario = (float) str_replace(',', '.', (string) ($prod->vUnCom ?? 0));
                $valorTotal = (float) str_replace(',', '.', (string) ($prod->vProd ?? 0));

                $produtoSistema = null;

                if (!empty($nomeProdutoXml)) {
                    $produtoSistema = Produto::where('empresa_id', $empresaId)
                        ->where('nome', 'LIKE', '%' . $nomeProdutoXml . '%')
                        ->first();
                }

                $itensXml[] = [
                    'produto_id' => $produtoSistema?->id,
                    'nome_produto_xml' => $nomeProdutoXml,
                    'quantidade' => $quantidade,
                    'valor_unitario' => $valorUnitario,
                    'valor_total' => $valorTotal,
                ];
            }

            if (empty($itensXml)) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'O XML foi lido, mas nenhum item de produto foi encontrado.');
            }

            $fornecedores = Fornecedor::where('empresa_id', $empresaId)
                ->orderBy('nome', 'asc')
                ->get();

            $produtos = Produto::where('empresa_id', $empresaId)
                ->orderBy('nome', 'asc')
                ->get();

            $formas_pagamento = FormaDePagamento::orderBy('nome', 'asc')->get();
            $prazos = Prazo::orderBy('prazo', 'asc')->get();

            return view('compras.create', [
                'fornecedores' => $fornecedores,
                'produtos' => $produtos,
                'formas_pagamento' => $formas_pagamento,
                'prazos' => $prazos,
                'dadosXml' => [
                    'fornecedor_id' => $fornecedor?->id,
                    'cnpj_fornecedor' => $cnpjFornecedor,
                    'nome_fornecedor' => $nomeFornecedor,
                    'nota_fiscal' => $notaFiscal,
                    'data_compra' => $dataCompra,
                    'itens' => $itensXml,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Erro ao importar XML da compra', [
                'erro' => $e->getMessage(),
                'linha' => $e->getLine(),
                'arquivo' => $e->getFile(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao importar XML: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $empresaId = $this->empresaId();

        $compras = Compra::with(['fornecedor', 'itensDeCompras.produto', 'contasAPagar'])
            ->where('empresa_id', $empresaId)
            ->orderBy('id', 'desc')
            ->get();

        return view('compras.index', compact('compras'));
    }

    public function destroy($id)
    {
        $empresaId = $this->empresaId();

        $compra = Compra::where('empresa_id', $empresaId)
            ->where('id', $id)
            ->firstOrFail();

        $compra->delete();

        return redirect()
            ->route('compras.index')
            ->with('success', 'Compra excluída com sucesso.');
    }

    public function edit($id)
    {
        $empresaId = $this->empresaId();

        $compra = Compra::where('empresa_id', $empresaId)
            ->where('id', $id)
            ->firstOrFail();

        return view('compras.edit', compact('compra'));
    }

    public function relatorioCompras(Request $request)
    {
        $empresaId = $this->empresaId();

        $query = DB::table('compras as c')
            ->join('itens_de_compras as ic', 'c.id', '=', 'ic.compra_id')
            ->join('produtos as p', 'ic.produto_id', '=', 'p.id')
            ->leftJoin('fornecedores as f', 'c.fornecedor_id', '=', 'f.id')
            ->join('formas_de_pagamento as fp', 'c.forma_pagamento_id', '=', 'fp.id')
            ->leftJoin(DB::raw('(
                SELECT compra_id, MAX(data_pagamento) as data_pagamento, MAX(status) as status
                FROM contas_a_pagar
                GROUP BY compra_id
            ) as cap'), 'cap.compra_id', '=', 'c.id')
            ->where('c.empresa_id', $empresaId)
            ->select(
                'c.id as compra_id',
                'p.nome as produto',
                'ic.quantidade',
                'ic.valor_unitario',
                'ic.valor_total',
                'c.nota_fiscal',
                'f.nome as fornecedor',
                'f.natureza_financeira',
                'fp.nome as forma_pagamento',
                'c.data_compra',
                'c.data_vencimento',
                'cap.data_pagamento',
                DB::raw("
                    CASE
                        WHEN fp.nome IN ('Dinheiro','PIX') THEN 'pago'
                        ELSE COALESCE(cap.status,'pendente')
                    END AS status_pagamento
                ")
            );

        if ($request->filled('id')) {
            $query->where('c.id', $request->id);
        }

        if ($request->filled('produto')) {
            $query->where('p.nome', 'like', '%' . $request->produto . '%');
        }

        if ($request->filled('fornecedor')) {
            $query->where('f.nome', 'like', '%' . $request->fornecedor . '%');
        }

        if ($request->filled('natureza_financeira') && $request->natureza_financeira !== 'todas') {
            $query->where('f.natureza_financeira', $request->natureza_financeira);
        }

        if ($request->filled('data_inicial')) {
            $query->whereDate('c.data_compra', '>=', $request->data_inicial);
        }

        if ($request->filled('data_final')) {
            $query->whereDate('c.data_compra', '<=', $request->data_final);
        }

        if ($request->filled('data_vencimento_inicial')) {
            $query->whereDate('c.data_vencimento', '>=', $request->data_vencimento_inicial);
        }

        if ($request->filled('data_vencimento_final')) {
            $query->whereDate('c.data_vencimento', '<=', $request->data_vencimento_final);
        }

        if ($request->filled('status_pagamento') && $request->status_pagamento !== 'todos') {
            if ($request->status_pagamento === 'pago') {
                $query->where(function ($q) {
                    $q->whereIn('fp.nome', ['Dinheiro', 'PIX'])
                        ->orWhere('cap.status', 'pago');
                });
            }

            if ($request->status_pagamento === 'pendente') {
                $query->whereNotIn('fp.nome', ['Dinheiro', 'PIX'])
                    ->where('cap.status', 'pendente');
            }

            if ($request->status_pagamento === 'atrasado') {
                $query->whereNotIn('fp.nome', ['Dinheiro', 'PIX'])
                    ->where('cap.status', 'atrasado');
            }
        }

        $compras = $query
            ->orderBy('c.data_compra', 'desc')
            ->get();

        $baseComprasUnicas = DB::table('compras as c')
            ->leftJoin('fornecedores as f', 'c.fornecedor_id', '=', 'f.id')
            ->join('formas_de_pagamento as fp', 'c.forma_pagamento_id', '=', 'fp.id')
            ->leftJoin('contas_a_pagar as cap', 'cap.compra_id', '=', 'c.id')
            ->where('c.empresa_id', $empresaId);

        if ($request->filled('id')) {
            $baseComprasUnicas->where('c.id', $request->id);
        }

        if ($request->filled('fornecedor')) {
            $baseComprasUnicas->where('f.nome', 'like', '%' . $request->fornecedor . '%');
        }

        if ($request->filled('natureza_financeira') && $request->natureza_financeira !== 'todas') {
            $baseComprasUnicas->where('f.natureza_financeira', $request->natureza_financeira);
        }

        if ($request->filled('data_inicial')) {
            $baseComprasUnicas->whereDate('c.data_compra', '>=', $request->data_inicial);
        }

        if ($request->filled('data_final')) {
            $baseComprasUnicas->whereDate('c.data_compra', '<=', $request->data_final);
        }

        $totalGeral = (clone $baseComprasUnicas)
            ->select('c.id', 'c.total')
            ->distinct()
            ->get()
            ->sum('total');

        $totalPago = (clone $baseComprasUnicas)
            ->where(function ($q) {
                $q->whereIn('fp.nome', ['Dinheiro', 'PIX'])
                    ->orWhere('cap.status', 'pago');
            })
            ->select('c.id', 'c.total')
            ->distinct()
            ->get()
            ->sum('total');

        $totalPendente = (clone $baseComprasUnicas)
            ->whereNotIn('fp.nome', ['Dinheiro', 'PIX'])
            ->where('cap.status', 'pendente')
            ->select('c.id', 'c.total')
            ->distinct()
            ->get()
            ->sum('total');

        $totalAtrasado = (clone $baseComprasUnicas)
            ->whereNotIn('fp.nome', ['Dinheiro', 'PIX'])
            ->where('cap.status', 'atrasado')
            ->select('c.id', 'c.total')
            ->distinct()
            ->get()
            ->sum('total');

        $totalCompras = $totalGeral;

        return view('relatorios.compras', compact(
            'compras',
            'totalCompras',
            'totalGeral',
            'totalPago',
            'totalPendente',
            'totalAtrasado'
        ));
    }

    public function search(Request $request)
    {
        $empresaId = $this->empresaId();
        $query = $request->get('query');

        $compras = Compra::with('fornecedor')
            ->where('empresa_id', $empresaId)
            ->whereHas('fornecedor', function ($q) use ($query, $empresaId) {
                $q->where('empresa_id', $empresaId)
                    ->where('nome', 'like', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('compras.index', compact('compras'));
    }
}