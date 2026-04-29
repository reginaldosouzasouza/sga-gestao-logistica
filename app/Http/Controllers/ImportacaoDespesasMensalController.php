<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ImportacaoDespesasMensalController extends Controller
{
    /**
     * Exibe a tela de importação com as despesas do mês anterior
     */
    public function index()
    {
        $mesAnterior      = Carbon::now()->subMonth();
        $inicioMesAnterior = $mesAnterior->copy()->startOfMonth()->toDateString();
        $fimMesAnterior    = $mesAnterior->copy()->endOfMonth()->toDateString();

        // Busca todas as contas a pagar do mês anterior
        $despesas = DB::table('contas_a_pagar as cp')
            ->leftJoin('fornecedores as f', 'f.id', '=', 'cp.fornecedor_id')
            ->leftJoin('compras as c', 'c.id', '=', 'cp.compra_id')
            ->leftJoin('fornecedores as fc', 'fc.id', '=', 'c.fornecedor_id')
            ->leftJoin('formas_de_pagamento as fp', 'fp.id', '=', 'cp.forma_pagamento_id')
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

        // Calcula as novas datas de vencimento (mesmo dia, mês seguinte ao anterior = mês atual)
        $despesas = $despesas->map(function ($d) {
            $novaData = Carbon::parse($d->data_vencimento)->addMonth()->toDateString();
            $d->nova_data_vencimento = $novaData;
            $d->novo_valor           = $d->valor; // valor editável
            return $d;
        });

        $mesReferencia      = $mesAnterior->format('m/Y');
        $mesDestino         = Carbon::now()->format('m/Y');
        $totalDespesas      = $despesas->count();
        $totalValor         = $despesas->sum('valor');
        $formasPagamento    = DB::table('formas_de_pagamento')->pluck('nome', 'id');

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
        $itens = $request->input('itens', []);

        if (empty($itens)) {
            return redirect()->back()->with('erro', 'Nenhuma despesa selecionada para importar.');
        }

        $importadas = 0;
        $erros      = [];

        DB::beginTransaction();

        try {
            foreach ($itens as $item) {
                // Pula itens desmarcados
                if (empty($item['selecionado'])) {
                    continue;
                }

                $dataVencimento = Carbon::parse($item['data_vencimento']);
                $dataCompra     = Carbon::now()->startOfMonth()->toDateString();

                DB::table('contas_a_pagar')->insert([
                    'fornecedor_id'     => $item['fornecedor_id'] ?: null,
                    'compra_id'         => $item['compra_id'] ?: null,
                    'descricao'         => $item['descricao'],
                    'valor'             => str_replace(',', '.', $item['valor']),
                    'data_compra'       => $dataCompra,
                    'data_vencimento'   => $dataVencimento->toDateString(),
                    'data_pagamento'    => null,
                    'status'            => 'pendente',
                    'forma_pagamento_id'=> $item['forma_pagamento_id'] ?: null,
                    'parcela'           => $item['parcela'] ?: null,
                    'total_parcelas'    => $item['total_parcelas'] ?: null,
                    'prazo'             => $item['prazo'] ?: null,
                    'observacao'        => 'Importado automaticamente de ' . $item['mes_referencia'],
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);

                $importadas++;
            }

            DB::commit();

            return redirect()->back()->with('sucesso', "{$importadas} despesa(s) importada(s) com sucesso para " . Carbon::now()->format('m/Y') . "!");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('erro', 'Erro ao importar: ' . $e->getMessage());
        }
    }
}
