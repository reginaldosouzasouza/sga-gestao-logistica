<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Cliente;
use App\Models\Movimentacao;
use App\Models\MovimentacaoItem;
use App\Models\ContasAReceber;
use App\Models\FormaDePagamento;
use App\Models\Prazo;
use App\Models\Estoque;
use App\Models\Caixa;
use App\Models\CaixaBanco;
use App\Models\ValeGas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Models\Veiculo;
use App\Models\EntregaRastreio;
use Illuminate\Support\Facades\Http;

class MovimentacaoController extends Controller
{
   private function empresaId()
    {
        return empresaAtualId();
    }

    public function create()
    {
        $empresaId = $this->empresaId();

        $cliente_id = null;

        $proximoId = (Movimentacao::where('empresa_id', $empresaId)->max('id') ?? 0) + 1;

        $formas_de_pagamento = FormaDePagamento::all();

        $prazos = Prazo::orderBy('prazo', 'asc')->get();

        $produtos = Produto::where('empresa_id', $empresaId)
            ->orderBy('nome', 'asc')
            ->get();

        $veiculos = Veiculo::with('motorista')
            ->where('empresa_id', $empresaId)
            ->where('ativo', 1)
            ->orderBy('descricao')
            ->get();

        return view('movimentacao.create', compact(
            'formas_de_pagamento',
            'prazos',
            'proximoId',
            'produtos',
            'cliente_id',
            'veiculos'
        ));
    }

    public function store(Request $request)
    {
        $empresaId = $this->empresaId();

        $request->validate([
            'data_coleta' => 'required|date|before_or_equal:today',
            'nome' => 'required',
            'endereco' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',

            'cliente_id' => [
                'nullable',
                Rule::exists('clientes', 'id')->where(function ($query) use ($empresaId) {
                    return $query->where('empresa_id', $empresaId);
                }),
            ],

            'produtos' => 'required|array',
            'produtos.*.produto_id' => [
                'required',
                Rule::exists('produtos', 'id')->where(function ($query) use ($empresaId) {
                    return $query->where('empresa_id', $empresaId);
                }),
            ],
            'produtos.*.quantidade' => 'required|integer|min:1',
            'produtos.*.valor_unitario' => 'required|numeric|min:0',
            'produtos.*.valor_total' => 'required|numeric|min:0',

            'forma_pagamento' => 'required|exists:formas_de_pagamento,id',
            'prazo' => 'required|exists:prazos,id',

            'veiculo_id' => [
                'nullable',
                Rule::exists('veiculos', 'id')->where(function ($query) use ($empresaId) {
                    return $query->where('empresa_id', $empresaId)
                        ->where('ativo', 1);
                }),
            ],
        ]);

        DB::beginTransaction();

        try {
            $formaPagamento = FormaDePagamento::findOrFail($request->forma_pagamento);
            $prazoSelecionado = Prazo::findOrFail($request->prazo);

            $valorTotalMovimentacao = array_sum(
                array_column($request->produtos, 'valor_total')
            );

            $quantidadeTotalMovimentacao = array_sum(
                array_column($request->produtos, 'quantidade')
            );

            $veiculo = null;
            $motoristaId = null;
            $comissaoTipo = null;
            $comissaoValor = 0;
            $valorComissao = 0;

            if ($request->filled('veiculo_id')) {
                $veiculo = Veiculo::with('motorista')
                    ->where('empresa_id', $empresaId)
                    ->where('ativo', 1)
                    ->find($request->veiculo_id);

                if ($veiculo) {
                    $motoristaId = $veiculo->motorista_id;
                    $comissaoTipo = $veiculo->comissao_tipo;
                    $comissaoValor = $veiculo->comissao_valor ?? 0;

                    if ($comissaoTipo === 'percentual') {
                        $valorComissao = ($valorTotalMovimentacao * $comissaoValor) / 100;
                    } elseif ($comissaoTipo === 'fixa') {
                        $valorComissao = $comissaoValor;
                    }
                }
            }


            $movimentacao = Movimentacao::create([
                'empresa_id' => $empresaId,
                'data_coleta' => $request->data_coleta,
                'nome' => $request->nome,
                'endereco' => $request->endereco,
                'numero' => $request->numero,
                'bairro' => $request->bairro,
                'cidade' => $request->cidade,
                'cliente_id' => $request->cliente_id,
                'observacao' => $request->observacao,
                'forma_pagamento_id' => $request->forma_pagamento,
                'prazo_id' => $prazoSelecionado->id,
                'valor_total' => $valorTotalMovimentacao,
                'quantidade' => $quantidadeTotalMovimentacao,
                'origem_tipo' => $request->origem_tipo,
                'origem_id' => $request->origem_id,
                'gerar_financeiro' => $request->has('gerar_financeiro')
                    ? (bool) $request->gerar_financeiro
                    : true,
                'veiculo_id' => $request->veiculo_id,
                'motorista_id' => $motoristaId,
                'comissao_tipo' => $comissaoTipo,
                'comissao_valor' => $comissaoValor,
                'valor_comissao' => $valorComissao,
            ]);

            foreach ($request->produtos as $item) {
                $produto = Produto::where('empresa_id', $empresaId)
                    ->where('id', $item['produto_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($produto->quantidade_estoque < $item['quantidade']) {
                    throw new \Exception("Estoque insuficiente para {$produto->nome}");
                }

                MovimentacaoItem::create([
                    'empresa_id'             => $empresaId,
                    'movimentacao_id'        => $movimentacao->id,
                    'produto_id'             => $produto->id,
                    'quantidade'             => $item['quantidade'],
                    'valor_unitario'         => $item['valor_unitario'],
                    'preco_compra_momento'   => $produto->preco_compra,
                    'valor_total'            => $item['valor_total'],
                ]);

                Estoque::create([
                    'empresa_id' => $empresaId,
                    'produto_id' => $produto->id,
                    'quantidade' => -$item['quantidade'],
                    'tipo_movimentacao' => 'saida',
                    'origem' => 'venda',
                    'data_movimentacao' => now(),
                ]);

                $produto->quantidade_estoque -= $item['quantidade'];
                $produto->save();
            }

            if ($movimentacao->origem_tipo === 'VALE_GAS' && $movimentacao->origem_id) {
                $vale = ValeGas::where('empresa_id', $empresaId)
                    ->where('id', $movimentacao->origem_id)
                    ->first();

                if ($vale) {
                    $vale->update([
                        'status' => 'RETIRADO',
                    ]);
                }
            }

            if ($movimentacao->gerar_financeiro) {
                $nomeFormaPagamento = strtolower(trim($formaPagamento->nome));

                if ($nomeFormaPagamento === 'dinheiro') {
                    Caixa::create([
                        'empresa_id' => $empresaId,
                        'data_movimentacao' => $movimentacao->data_coleta,
                        'tipo' => 'entrada',
                        'valor' => $movimentacao->valor_total,
                        'origem' => 'venda',
                        'descricao' => 'Venda em dinheiro - Coleta #' . $movimentacao->id,
                        'referencia_id' => $movimentacao->id,
                    ]);
                } elseif ($nomeFormaPagamento === 'pix') {
                    CaixaBanco::create([
                        'empresa_id' => $empresaId,
                        'data_movimentacao' => $movimentacao->data_coleta,
                        'tipo' => 'entrada',
                        'valor' => $movimentacao->valor_total,
                        'forma' => 'pix',
                        'origem' => 'venda',
                        'descricao' => 'Venda via PIX - Coleta #' . $movimentacao->id,
                        'referencia_id' => $movimentacao->id,
                    ]);
                } else {
                    ContasAReceber::create([
                        'empresa_id' => $empresaId,
                        'cliente_id' => $movimentacao->cliente_id,
                        'descricao' => 'Venda realizada - Coleta #' . $movimentacao->id,
                        'valor' => $movimentacao->valor_total,
                        'data_venda' => $movimentacao->data_coleta,
                        'data_vencimento' => Carbon::parse($movimentacao->data_coleta)
                            ->addDays((int) $prazoSelecionado->prazo),
                        'status' => 'pendente',
                        'forma_pagamento_id' => $movimentacao->forma_pagamento_id,
                        'prazo' => $prazoSelecionado->id,
                    ]);
                }
            }

            DB::commit();

           return redirect()
            ->route('movimentacao.confirmar-rastreio', $movimentacao->id)
            ->with('success', 'Movimentação salva com sucesso.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erro ao salvar movimentação', [
                'erro' => $e->getMessage(),
                'linha' => $e->getLine(),
                'arquivo' => $e->getFile(),
            ]);

            return back()
                ->withInput()
                ->withErrors($e->getMessage());
        }
    }

    public function index(Request $request)
    {
        $empresaId = $this->empresaId();

        $search = $request->input('search');

        $movimentacoes = Movimentacao::with(['formaPagamento', 'veiculo.motorista', 'motorista'])
            ->where('empresa_id', $empresaId)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nome', 'like', '%' . $search . '%')
                        ->orWhere('cidade', 'like', '%' . $search . '%')
                        ->orWhere('endereco', 'like', '%' . $search . '%')
                        ->orWhere('id', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(20)
            ->appends($request->query());

        return view('movimentacao.index', compact('movimentacoes', 'search'));
    }

    public function show($id)
    {
        $empresaId = $this->empresaId();

        $movimentacao = Movimentacao::with(['itens.produto', 'veiculo.motorista', 'motorista'])
            ->where('empresa_id', $empresaId)
            ->where('id', $id)
            ->firstOrFail();

        $historicoCliente = Movimentacao::with(['itens.produto', 'veiculo.motorista', 'motorista'])
            ->where('empresa_id', $empresaId)
            ->where(function ($query) use ($movimentacao) {
                if (!empty($movimentacao->cliente_id)) {
                    $query->where('cliente_id', $movimentacao->cliente_id);
                } else {
                    $query->where('nome', $movimentacao->nome);
                }
            })
            ->orderBy('data_coleta', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return view('movimentacao.show', compact('movimentacao', 'historicoCliente'));
    }

    public function destroy($id)
    {
        $empresaId = $this->empresaId();

        DB::beginTransaction();

        try {
            $movimentacao = Movimentacao::with('itens')
                ->where('empresa_id', $empresaId)
                ->where('id', $id)
                ->lockForUpdate()
                ->firstOrFail();

            $isMaster = auth()->check()
                && auth()->user()->tipo === 'MASTER';

            $formaPagamento = FormaDePagamento::find(
                $movimentacao->forma_pagamento_id
            );

            $nomeFormaPagamento = strtolower(
                trim($formaPagamento->nome ?? '')
            );

            /*
            * Localiza a Conta a Receber gerada por esta coleta.
            *
            * Atualmente a ligação é feita pela descrição porque
            * contas_a_receber ainda não possui movimentacao_id.
            */
            $descricaoConta = 'Venda realizada - Coleta #' . $movimentacao->id;

            $contaAReceber = ContasAReceber::where(
                'empresa_id',
                $empresaId
            )
                ->where('descricao', $descricaoConta)
                ->first();

            /*
            * Se a Conta a Receber já foi recebida,
            * somente o MASTER poderá cancelar a coleta.
            */
            if (
                $contaAReceber
                && $contaAReceber->status === 'recebido'
                && !$isMaster
            ) {
                DB::rollBack();

                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'Esta coleta possui uma Conta a Receber já recebida. Somente o usuário MASTER pode realizar o cancelamento completo.'
                    );
            }

            /*
            * Remove entrada financeira gerada diretamente pela venda.
            *
            * Dinheiro: Caixa
            * PIX: Caixa Banco
            */
            if ($movimentacao->gerar_financeiro) {
                if ($nomeFormaPagamento === 'dinheiro') {
                    Caixa::where('empresa_id', $empresaId)
                        ->where('origem', 'venda')
                        ->where('referencia_id', $movimentacao->id)
                        ->delete();

                } elseif ($nomeFormaPagamento === 'pix') {
                    CaixaBanco::where('empresa_id', $empresaId)
                        ->where('origem', 'venda')
                        ->where('referencia_id', $movimentacao->id)
                        ->delete();
                }
            }

            /*
            * Se existir Conta a Receber vinculada:
            *
            * - pendente ou atrasada: exclui a conta;
            * - recebida e usuário MASTER: remove também o recebimento
            *   correspondente no Caixa ou Caixa Banco.
            */
            if ($contaAReceber) {
                if ($contaAReceber->status === 'recebido') {
                    Caixa::where('empresa_id', $empresaId)
                        ->where('origem', 'recebimento')
                        ->where('referencia_id', $contaAReceber->id)
                        ->delete();

                    CaixaBanco::where('empresa_id', $empresaId)
                        ->where('origem', 'recebimento')
                        ->where('referencia_id', $contaAReceber->id)
                        ->delete();
                }

                $contaAReceber->delete();
            }

            /*
            * Devolve ao estoque cada produto vendido.
            */
            foreach ($movimentacao->itens as $item) {
                $produto = Produto::where('empresa_id', $empresaId)
                    ->where('id', $item->produto_id)
                    ->lockForUpdate()
                    ->first();

                if (!$produto) {
                    throw new \Exception(
                        'Produto do item #' . $item->id . ' não foi encontrado.'
                    );
                }

                $quantidadeDevolvida = (float) $item->quantidade;

                $produto->quantidade_estoque =
                    (float) $produto->quantidade_estoque
                    + $quantidadeDevolvida;

                $produto->save();

                /*
                * Registra a entrada compensatória no histórico.
                * Não apagamos a saída original para manter rastreabilidade.
                */
                Estoque::create([
                    'empresa_id' => $empresaId,
                    'produto_id' => $produto->id,
                    'quantidade' => $quantidadeDevolvida,
                    'tipo_movimentacao' => 'entrada',
                    'origem' => 'cancelamento_venda',
                    'data_movimentacao' => now(),
                ]);
            }

            /*
            * Remove eventual rastreio local vinculado à coleta.
            */
            EntregaRastreio::where('empresa_id', $empresaId)
                ->where('movimentacao_id', $movimentacao->id)
                ->delete();

            /*
            * Exclui os itens e, por último, a coleta.
            */
            MovimentacaoItem::where('empresa_id', $empresaId)
                ->where('movimentacao_id', $movimentacao->id)
                ->delete();

            $movimentacao->delete();

            DB::commit();

            return redirect()
                ->route('movimentacao.index')
                ->with(
                    'success',
                    'Coleta excluída com sucesso. O estoque e o saldo financeiro foram atualizados.'
                );

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erro ao cancelar movimentação', [
                'movimentacao_id' => $id,
                'empresa_id' => $empresaId,
                'usuario_id' => auth()->id(),
                'erro' => $e->getMessage(),
                'linha' => $e->getLine(),
                'arquivo' => $e->getFile(),
            ]);

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Não foi possível excluir a coleta: ' . $e->getMessage()
                );
        }
    }

    public function confirmarRastreio($id)
    {
        $empresaId = $this->empresaId();

        $movimentacao = Movimentacao::where('empresa_id', $empresaId)
            ->where('id', $id)
            ->firstOrFail();

        $rastreio = EntregaRastreio::where('empresa_id', $empresaId)
            ->where('movimentacao_id', $movimentacao->id)
            ->first();

        return view('movimentacao.confirmar-rastreio', compact('movimentacao', 'rastreio'));
    }
    

    public function gerarRastreio($id)
    {
        $empresaId = $this->empresaId();

        $movimentacao = Movimentacao::where('empresa_id', $empresaId)
            ->where('id', $id)
            ->firstOrFail();

        // Evita gerar rastreio duplicado para a mesma movimentação
        $rastreioExistente = EntregaRastreio::where('empresa_id', $empresaId)
            ->where('movimentacao_id', $movimentacao->id)
            ->first();

        if ($rastreioExistente) {
            return redirect()
                ->route('pedido_coleta.create')
                ->with('info', 'Esta movimentação já possui rastreio: ' . $rastreioExistente->codigo_rastreio);
        }

                // Monta endereço completo
          $enderecoCompleto = trim(
            ($movimentacao->endereco ?? '') .
            ', ' . ($movimentacao->numero ?? '') .
            ' - ' . ($movimentacao->bairro ?? '') .
            ', Maringá, PR - Brasil'
        );

        // URL local do sistema de rastreio
        $urlApi = 'http://127.0.0.1:8085/api/criar_coleta.php';

        try {
            $cliente = null;

            if (!empty($movimentacao->cliente_id)) {
               $cliente = Cliente::where('empresa_id', $empresaId)
                    ->where('id', $movimentacao->cliente_id)
                    ->first();
            }

            $nomeCliente = $movimentacao->nome ?? ($cliente->nome ?? '');
            $telefoneCliente = $movimentacao->telefone
                ?? $movimentacao->celular
                ?? $movimentacao->whatsapp
                ?? ($cliente->telefone ?? '')
                ?? ($cliente->celular ?? '')
                ?? ($cliente->whatsapp ?? '');

            $telefoneCliente = preg_replace('/\D/', '', $telefoneCliente);

            if ($telefoneCliente === '') {
                return redirect()
                    ->route('movimentacao.confirmar-rastreio', $movimentacao->id)
                    ->with('error', 'Não foi possível gerar o rastreio: telefone do cliente não encontrado.');
            }

            $response = Http::withHeaders([
                'X-API-TOKEN' => 'SENHA_API_SGA_RASTREIO_2026',
            ])->asForm()->post($urlApi, [
                'cliente' => $nomeCliente,
                'telefone' => $telefoneCliente,
                'endereco' => $enderecoCompleto,
                'origem' => 'sga',
                'movimentacao_id' => $movimentacao->id,
            ]);
           

            if (!$response->successful()) {
                return redirect()
                    ->route('movimentacao.confirmar-rastreio', $movimentacao->id)
                    ->with('error', 'Não foi possível gerar o rastreio. Verifique se o sistema de rastreio está aberto na porta 8085.');
            }

            $dados = $response->json();

            if (!isset($dados['success']) || $dados['success'] !== true) {
                return redirect()
                    ->route('movimentacao.confirmar-rastreio', $movimentacao->id)
                    ->with('error', $dados['message'] ?? 'Erro ao gerar rastreio.');
            }

            EntregaRastreio::create([
                'empresa_id' => $empresaId,
                'movimentacao_id' => $movimentacao->id,
                'cliente_id' => $movimentacao->cliente_id ?? null,
                'codigo_rastreio' => $dados['codigo'],
                'link_rastreio' => $dados['link_rastreio'] ?? null,
                'link_whatsapp' => $dados['link_whatsapp'] ?? null,
                'status' => $dados['status'] ?? 'coletado',
            ]);

            return redirect()
                ->route('pedido_coleta.create')
                ->with('success', 'Movimentação salva e rastreio gerado com sucesso! Código: ' . $dados['codigo']);

        } catch (\Exception $e) {
            return redirect()
                ->route('movimentacao.confirmar-rastreio', $movimentacao->id)
                ->with('error', 'Erro ao conectar com o sistema de rastreio: ' . $e->getMessage());
        }
    }

}