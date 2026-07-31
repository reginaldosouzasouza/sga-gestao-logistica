<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class RestaurarDemoGas extends Command
{
    /**
     * Comando utilizado no terminal.
     */
    protected $signature = 'demo:restaurar-gas';

    /**
     * Descrição exibida na lista de comandos Artisan.
     */
    protected $description = 'Restaura os dados operacionais da demonstração do módulo Gás';

    /**
     * Empresa utilizada como demonstração.
     */
    private int $empresaId;

    public function handle(): int
    {

        $this->empresaId = (int) config('demo.gas.empresa_id');

        $this->info('Iniciando restauração da demonstração...');

        try {
            DB::transaction(function (): void {
                /*
                |--------------------------------------------------------------------------
                | 1. Excluir registros dependentes
                |--------------------------------------------------------------------------
                */

                DB::statement(
                    '
                    DELETE ic
                    FROM itens_de_compras ic
                    INNER JOIN compras c
                        ON c.id = ic.compra_id
                    WHERE c.empresa_id = ?
                    ',
                    [$this->empresaId]
                );

                DB::statement(
                    '
                    DELETE mc
                    FROM mov_coletas mc
                    INNER JOIN clientes c
                        ON c.id = mc.cliente_id
                    WHERE c.empresa_id = ?
                    ',
                    [$this->empresaId]
                );

                DB::statement(
                    '
                    DELETE cpd
                    FROM cliente_produto_duracao cpd
                    INNER JOIN clientes c
                        ON c.id = cpd.cliente_id
                    WHERE c.empresa_id = ?
                    ',
                    [$this->empresaId]
                );

                $tabelasDependentes = [
                    'entrega_rastreios',
                    'movimentacao_itens',
                    'contas_a_receber',
                    'contas_a_pagar',
                    'caixa',
                    'caixa_banco',
                    'caixas_abertos',
                    'fechamentos_caixa',
                    'estoques',
                    'vale_gas',
                    'vasilhame_emprestimos',
                    'controle_vasilhames',
                    'historico_vasilhames',
                ];

                foreach ($tabelasDependentes as $tabela) {
                    DB::table($tabela)
                        ->where('empresa_id', $this->empresaId)
                        ->delete();
                }

                /*
                |--------------------------------------------------------------------------
                | 2. Excluir registros principais
                |--------------------------------------------------------------------------
                */

                DB::table('movimentacao')
                    ->where('empresa_id', $this->empresaId)
                    ->delete();

                DB::table('compras')
                    ->where('empresa_id', $this->empresaId)
                    ->delete();

                DB::table('clientes')
                    ->where('empresa_id', $this->empresaId)
                    ->delete();

                DB::table('fornecedores')
                    ->where('empresa_id', $this->empresaId)
                    ->delete();

                DB::table('produtos')
                    ->where('empresa_id', $this->empresaId)
                    ->delete();

                /*
                |--------------------------------------------------------------------------
                | 3. Restaurar cadastros principais
                |--------------------------------------------------------------------------
                */

                $this->restaurarTabela(
                    'clientes',
                    'demo_snapshot_clientes'
                );

                $this->restaurarTabela(
                    'fornecedores',
                    'demo_snapshot_fornecedores'
                );

                $this->restaurarTabela(
                    'produtos',
                    'demo_snapshot_produtos'
                );

                /*
                |--------------------------------------------------------------------------
                | 4. Restaurar compras e movimentações
                |--------------------------------------------------------------------------
                */

                $this->restaurarTabela(
                    'compras',
                    'demo_snapshot_compras'
                );

                $this->restaurarTabela(
                    'itens_de_compras',
                    'demo_snapshot_itens_de_compras'
                );

                $this->restaurarTabela(
                    'movimentacao',
                    'demo_snapshot_movimentacao'
                );

                $this->restaurarTabela(
                    'movimentacao_itens',
                    'demo_snapshot_movimentacao_itens'
                );

                /*
                |--------------------------------------------------------------------------
                | 5. Restaurar financeiro
                |--------------------------------------------------------------------------
                */

                $this->restaurarTabela(
                    'contas_a_pagar',
                    'demo_snapshot_contas_a_pagar'
                );

                $this->restaurarTabela(
                    'contas_a_receber',
                    'demo_snapshot_contas_a_receber'
                );

                $this->restaurarTabela(
                    'caixa',
                    'demo_snapshot_caixa'
                );

                $this->restaurarTabela(
                    'caixa_banco',
                    'demo_snapshot_caixa_banco'
                );

                $this->restaurarTabela(
                    'caixas_abertos',
                    'demo_snapshot_caixas_abertos'
                );

                /*
                |--------------------------------------------------------------------------
                | 6. Atualizar o caixa aberto para a data da restauração
                |--------------------------------------------------------------------------
                */

                DB::table('caixas_abertos')
                    ->where('empresa_id', $this->empresaId)
                    ->where('status', 'aberto')
                    ->update([
                        'data_caixa' => now()->toDateString(),
                        'data_abertura' => now(),
                        'updated_at' => now(),
                    ]);

                /*
                |--------------------------------------------------------------------------
                | 7. Restaurar estoque e rastreios
                |--------------------------------------------------------------------------
                */

                $this->restaurarTabela(
                    'estoques',
                    'demo_snapshot_estoques'
                );

                $this->restaurarTabela(
                    'entrega_rastreios',
                    'demo_snapshot_entrega_rastreios'
                );
            });

            $this->newLine();
            $this->info('Demonstração restaurada com sucesso.');

            $this->mostrarTotais();

            return self::SUCCESS;
        } catch (Throwable $erro) {
            $this->newLine();
            $this->error('Não foi possível restaurar a demonstração.');
            $this->error($erro->getMessage());

            report($erro);

            return self::FAILURE;
        }
    }

    /**
     * Copia todos os registros da tabela de snapshot
     * para a tabela original.
     */
    private function restaurarTabela(
        string $tabelaDestino,
        string $tabelaSnapshot
    ): void {
        DB::statement(
            sprintf(
                'INSERT INTO `%s` SELECT * FROM `%s`',
                $tabelaDestino,
                $tabelaSnapshot
            )
        );
    }

    /**
     * Exibe os totais após a restauração.
     */
    private function mostrarTotais(): void
    {
        $tabelas = [
            'clientes',
            'fornecedores',
            'produtos',
            'compras',
            'movimentacao',
            'movimentacao_itens',
            'contas_a_pagar',
            'contas_a_receber',
            'caixa',
            'caixa_banco',
            'caixas_abertos',
            'estoques',
            'entrega_rastreios',
        ];

        $resultado = [];

        foreach ($tabelas as $tabela) {
            $resultado[] = [
                'Tabela' => $tabela,
                'Total' => DB::table($tabela)
                    ->where('empresa_id', $this->empresaId)
                    ->count(),
            ];
        }

        $resultado[] = [
            'Tabela' => 'itens_de_compras',
            'Total' => DB::table('itens_de_compras as ic')
                ->join('compras as c', 'c.id', '=', 'ic.compra_id')
                ->where('c.empresa_id', $this->empresaId)
                ->count(),
        ];

        $this->newLine();

        $this->table(
            ['Tabela', 'Total'],
            $resultado
        );
    }
}
