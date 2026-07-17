<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\ConfiguracaoPrevisaoVenda;
use Illuminate\Http\Request;

class ConfiguracaoPrevisaoVendaController extends Controller
{
    /**
     * Retorna a empresa atual do usuário logado.
     */
    private function getEmpresaId()
    {
        return session('empresa_id') ?? auth()->user()->empresa_id;
    }

    /**
     * Tela principal de configuração da previsão de vendas.
     */
    public function index()
    {
        $empresaId = $this->getEmpresaId();

       $produtos = Produto::where('empresa_id', $empresaId)
    ->whereNotIn('nome', [
        'PRODUTOS DIVERSOS',
        'COMPRAS -MERCADO',
        'COMPRAS- MERCADO',
        'COMPRAS-MERCADO',
        'COMPRAS MERCADO',
    ])
    ->orderBy('nome')
    ->get();

        /*
         * Garante que cada produto tenha uma configuração inicial.
         * Assim a tela já abre pronta para editar.
         */
        foreach ($produtos as $produto) {
            ConfiguracaoPrevisaoVenda::firstOrCreate(
                [
                    'empresa_id' => $empresaId,
                    'produto_id' => $produto->id,
                ],
                [
                    'usar_ajuste_fim_mes' => false,
                    'dia_inicio_fim_mes' => 21,
                    'percentual_ajuste_fim_mes' => 0,

                    'usar_sazonalidade_manual' => false,
                    'mes_inicio_sazonalidade' => null,
                    'mes_fim_sazonalidade' => null,
                    'percentual_ajuste_sazonalidade' => 0,

                    'estoque_seguranca_dias' => 2,
                    'base_historica_inicio' => null,
                    'ativo' => true,
                ]
            );
        }

        $produtoIds = $produtos->pluck('id');

        $configuracoes = ConfiguracaoPrevisaoVenda::with('produto')
            ->where('empresa_id', $empresaId)
            ->whereIn('produto_id', $produtoIds)
            ->orderBy('produto_id')
            ->get();

        return view('configuracao_previsao_vendas.index', compact('configuracoes'));
    }

    /**
     * Atualiza uma configuração específica.
     */
    public function update(Request $request, $id)
    {
        $empresaId = $this->getEmpresaId();

        $configuracao = ConfiguracaoPrevisaoVenda::where('empresa_id', $empresaId)
            ->findOrFail($id);

        $request->validate([
            'dia_inicio_fim_mes' => 'nullable|integer|min:1|max:31',
            'percentual_ajuste_fim_mes' => 'nullable|numeric|min:-100|max:100',

            'mes_inicio_sazonalidade' => 'nullable|integer|min:1|max:12',
            'mes_fim_sazonalidade' => 'nullable|integer|min:1|max:12',
            'percentual_ajuste_sazonalidade' => 'nullable|numeric|min:-100|max:100',

            'estoque_seguranca_dias' => 'nullable|numeric|min:0|max:365',
            'base_historica_inicio' => 'nullable|date',
        ]);

        $configuracao->update([
            'usar_ajuste_fim_mes' => $request->has('usar_ajuste_fim_mes'),
            'dia_inicio_fim_mes' => $request->dia_inicio_fim_mes,
            'percentual_ajuste_fim_mes' => $request->percentual_ajuste_fim_mes ?? 0,

            'usar_sazonalidade_manual' => $request->has('usar_sazonalidade_manual'),
            'mes_inicio_sazonalidade' => $request->mes_inicio_sazonalidade,
            'mes_fim_sazonalidade' => $request->mes_fim_sazonalidade,
            'percentual_ajuste_sazonalidade' => $request->percentual_ajuste_sazonalidade ?? 0,

            'estoque_seguranca_dias' => $request->estoque_seguranca_dias ?? 0,
            'base_historica_inicio' => $request->base_historica_inicio,
            'ativo' => $request->has('ativo'),
        ]);

        return redirect()
            ->route('configuracao-previsao-vendas.index')
            ->with('success', 'Configuração de previsão atualizada com sucesso.');
    }
}