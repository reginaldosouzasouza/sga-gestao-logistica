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
    private function getEmpresaId(): int
    {
        return (int) (
            session('empresa_id')
            ?? auth()->user()->empresa_id
        );
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

        return view(
            'configuracao_previsao_vendas.index',
            compact('configuracoes')
        );
    }

    /**
     * Atualiza uma configuração específica.
     */
   public function update(Request $request, $id)
    {
        $empresaId = $this->getEmpresaId();

        $configuracao = ConfiguracaoPrevisaoVenda::where(
            'empresa_id',
            $empresaId
        )->findOrFail($id);

        /*
        * Normaliza campos decimais antes da validação.
        */
        $camposDecimais = [
            'percentual_ajuste_fim_mes',
            'percentual_ajuste_sazonalidade',
            'estoque_seguranca_dias',
        ];

        $dadosNormalizados = [];

        foreach ($camposDecimais as $campo) {
            $valor = $request->input($campo);

            if ($valor !== null && $valor !== '') {
                $valor = trim((string) $valor);

                /*
                * Só remove ponto de milhar quando existir vírgula decimal.
                */
                if (str_contains($valor, ',')) {
                    $valor = str_replace('.', '', $valor);
                    $valor = str_replace(',', '.', $valor);
                }

                $dadosNormalizados[$campo] = $valor;
            }
        }

        $request->merge($dadosNormalizados);

        $dadosValidados = $request->validate([
            'dia_inicio_fim_mes' => [
                'nullable',
                'integer',
                'between:1,31',
            ],

            'percentual_ajuste_fim_mes' => [
                'nullable',
                'numeric',
                'between:-100,100',
            ],

            'mes_inicio_sazonalidade' => [
                'nullable',
                'integer',
                'between:1,12',
            ],

            'mes_fim_sazonalidade' => [
                'nullable',
                'integer',
                'between:1,12',
            ],

            'percentual_ajuste_sazonalidade' => [
                'nullable',
                'numeric',
                'between:-100,100',
            ],

            'estoque_seguranca_dias' => [
                'nullable',
                'numeric',
                'min:0',
                'max:365',
            ],

            'base_historica_inicio' => [
                'nullable',
                'date',
            ],
        ]);

        $configuracao->update([
            'usar_ajuste_fim_mes' => $request->boolean(
                'usar_ajuste_fim_mes'
            ),

            'dia_inicio_fim_mes' =>
                $dadosValidados['dia_inicio_fim_mes'] ?? null,

            'percentual_ajuste_fim_mes' =>
                $dadosValidados['percentual_ajuste_fim_mes'] ?? 0,

            'usar_sazonalidade_manual' => $request->boolean(
                'usar_sazonalidade_manual'
            ),

            'mes_inicio_sazonalidade' =>
                $dadosValidados['mes_inicio_sazonalidade'] ?? null,

            'mes_fim_sazonalidade' =>
                $dadosValidados['mes_fim_sazonalidade'] ?? null,

            'percentual_ajuste_sazonalidade' =>
                $dadosValidados['percentual_ajuste_sazonalidade'] ?? 0,

            'estoque_seguranca_dias' =>
                $dadosValidados['estoque_seguranca_dias'] ?? 0,

            'base_historica_inicio' =>
                $dadosValidados['base_historica_inicio'] ?? null,

            'ativo' => $request->boolean('ativo'),
        ]);

        return redirect()
            ->route('configuracao-previsao-vendas.index')
            ->with(
                'success',
                'Configuração de previsão atualizada com sucesso.'
            );
    }
}