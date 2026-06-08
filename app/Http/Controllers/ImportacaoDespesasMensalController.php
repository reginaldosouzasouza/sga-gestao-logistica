<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ImportacaoDespesasMensalController extends Controller
{
    /**
     * Retorna a empresa atual do usuário logado.
     */
    private function empresaAtualId()
    {
        $user = auth()->user();

        return $user->empresa_id ?? session('empresa_id');
    }

    /**
     * Exibe a tela de importação com as despesas do mês anterior
     */
    public function index()
    {
        $empresaId = $this->empresaAtualId();

        if (!$empresaId) {
            return redirect()->back()->with('erro', 'Empresa não identificada para o usuário logado.');
        }

        $mesAnterior        = Carbon::now()->subMonth();
        $inicioMesAnterior = $mesAnterior->copy()->startOfMonth()->toDateString();
        $fimMesAnterior    = $mesAnterior->copy()->endOfMonth()->toDateString();

        // Busca somente as contas a pagar da empresa do usuário logado
        $despesas = DB::table('contas_a_pagar as cp')
            ->leftJoin('fornecedores as f', function ($join) use ($empresaId) {
                $join->on('f.id', '=', 'cp.fornecedor_id')
                     ->where('f.empresa_id', '=', $empresaId);
            })
            ->leftJoin('compras as c', function ($join) use ($empresaId) {
                $join->on('c.id', '=', 'cp.compra_id')
                     ->where('c.empresa_id', '=', $empresaId);
            })
            ->leftJoin('fornecedores as fc', function ($join) use ($empresaId) {
                $join->on('fc.id', '=', 'c.fornecedor_id')
                     ->where('fc.empresa_id', '=', $empresaId);
            })
            ->leftJoin('formas_de_pagamento as fp', 'fp.id', '=', 'cp.forma_pagamento_id')
            ->where('cp.empresa_id', $empresaId)
            ->whereBetween('cp.data_vencimento', [$inicioMesAnterior, $fimMesAnterior])
            ->select(
                'cp.id',
                DB::raw('COALESCE(f.nome, fc.nome, "Sem fornecedor") as fornecedor'),
                'cp.fornecedor_id',
                'cp.compra_id',
                'cp.descricao',
                'cp.valor',
                'cp.data_compra',
                'cp.data_vencimento',
                'cp.forma_pagamento_id',
                'fp.nome as forma_pagamento',
                'cp.parcela',
                'cp.total_parcelas',
                'cp.prazo'
            )
            ->orderBy('cp.data_vencimento')
            ->get();

        // Calcula as novas datas de vencimento
        $despesas = $despesas->map(function ($d) {
            $novaData = Carbon::parse($d->data_vencimento)->addMonth()->toDateString();

            $d->nova_data_vencimento = $novaData;
            $d->novo_valor = $d->valor;

            return $d;
        });

        $mesReferencia   = $mesAnterior->format('m/Y');
        $mesDestino      = Carbon::now()->format('m/Y');
        $totalDespesas   = $despesas->count();
        $totalValor      = $despesas->sum('valor');
        $formasPagamento = DB::table('formas_de_pagamento')->pluck('nome', 'id');

        return view('importacao.despesas', compact(
            'despesas',
            'mesReferencia',
            'mesDestino',
            'totalDespesas',
            'totalValor',
            'formasPagamento'
        ));
    }

    /**
     * Processa a importação e insere as novas contas a pagar
     */
    public function importar(Request $request)
    {
        $empresaId = $this->empresaAtualId();

        if (!$empresaId) {
            return redirect()->back()->with('erro', 'Empresa não identificada para o usuário logado.');
        }

        $itens = $request->input('itens', []);

        if (empty($itens)) {
            return redirect()->back()->with('erro', 'Nenhuma despesa selecionada para importar.');
        }

        $importadas = 0;

        DB::beginTransaction();

        try {
            foreach ($itens as $item) {
                if (empty($item['selecionado'])) {
                    continue;
                }

                $dataVencimento = Carbon::parse($item['data_vencimento']);
                $dataCompra     = Carbon::now()->startOfMonth()->toDateString();

                $fornecedorId = !empty($item['fornecedor_id']) ? $item['fornecedor_id'] : null;
                $compraId     = !empty($item['compra_id']) ? $item['compra_id'] : null;

                /*
                 * Segurança multiempresa:
                 * Mantém fornecedor somente se ele pertence à empresa logada.
                 */
                if ($fornecedorId) {
                    $fornecedorExisteNaEmpresa = DB::table('fornecedores')
                        ->where('id', $fornecedorId)
                        ->where('empresa_id', $empresaId)
                        ->exists();

                    if (!$fornecedorExisteNaEmpresa) {
                        $fornecedorId = null;
                    }
                }

                /*
                 * Segurança multiempresa:
                 * Mantém compra somente se ela pertence à empresa logada.
                 */
                if ($compraId) {
                    $compraExisteNaEmpresa = DB::table('compras')
                        ->where('id', $compraId)
                        ->where('empresa_id', $empresaId)
                        ->exists();

                    if (!$compraExisteNaEmpresa) {
                        $compraId = null;
                    }
                }

                DB::table('contas_a_pagar')->insert([
                    'empresa_id'          => $empresaId,
                    'fornecedor_id'       => $fornecedorId,
                    'compra_id'           => $compraId,
                    'descricao'           => $item['descricao'],
                    'valor'               => str_replace(',', '.', $item['valor']),
                    'data_compra'         => $dataCompra,
                    'data_vencimento'     => $dataVencimento->toDateString(),
                    'data_pagamento'      => null,
                    'status'              => 'pendente',
                    'forma_pagamento_id'  => !empty($item['forma_pagamento_id']) ? $item['forma_pagamento_id'] : null,
                    'parcela'             => !empty($item['parcela']) ? $item['parcela'] : null,
                    'total_parcelas'      => !empty($item['total_parcelas']) ? $item['total_parcelas'] : null,
                    'prazo'               => !empty($item['prazo']) ? $item['prazo'] : null,
                    'observacao'          => 'Importado automaticamente de ' . ($item['mes_referencia'] ?? ''),
                    'created_at'          => now(),
                    'updated_at'          => now(),
                ]);

                $importadas++;
            }

            DB::commit();

            return redirect()->back()->with(
                'sucesso',
                "{$importadas} despesa(s) importada(s) com sucesso para " . Carbon::now()->format('m/Y') . "!"
            );

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('erro', 'Erro ao importar: ' . $e->getMessage());
        }
    }
}