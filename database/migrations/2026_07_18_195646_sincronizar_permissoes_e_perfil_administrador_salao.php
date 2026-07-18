<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
     

        $permissoes = [
            'salao_acessar' => 'Acessar o módulo Salão / Barbearia',

            'salao_agendamentos_visualizar' => 'Visualizar agendamentos',
            'salao_agendamentos_criar' => 'Criar agendamentos',
            'salao_agendamentos_editar' => 'Editar agendamentos',
            'salao_agendamentos_cancelar' => 'Cancelar agendamentos',
            'salao_agendamentos_status' => 'Alterar status dos agendamentos',

            'salao_clientes_visualizar' => 'Visualizar clientes',
            'salao_clientes_criar' => 'Cadastrar clientes',
            'salao_clientes_editar' => 'Editar clientes',
            'salao_clientes_excluir' => 'Excluir clientes',

            'salao_profissionais_visualizar' => 'Visualizar profissionais',
            'salao_profissionais_gerenciar' => 'Gerenciar profissionais',

            'salao_servicos_visualizar' => 'Visualizar serviços',
            'salao_servicos_gerenciar' => 'Gerenciar serviços',

            'salao_caixa_visualizar' => 'Visualizar o caixa',
            'salao_caixa_movimentar' => 'Realizar lançamentos no caixa',
            'salao_caixa_fechar' => 'Fechar e reabrir o caixa',

            'salao_contas_pagar' => 'Gerenciar contas a pagar',
            'salao_contas_receber' => 'Gerenciar contas a receber',

            'salao_previsao_financeira' => 'Visualizar previsão financeira',
        ];

        /*
         * Cadastra ou atualiza as permissões globais do módulo Salão.
         * Não depende dos IDs existentes em cada banco.
         */
        foreach ($permissoes as $nome => $descricao) {
            DB::table('permissoes')->updateOrInsert(
                ['nome' => $nome],
                [
                    'descricao' => $descricao,
                    'modulo' => 'salao',
                  
                ]
            );
        }

        /*
         * Neste primeiro momento habilitamos a empresa 5,
         * que é a ECLE no módulo Salão.
         */
        $empresaId = 5;

        $empresaExiste = DB::table('empresas')
            ->where('id', $empresaId)
            ->exists();

        if (!$empresaExiste) {
            return;
        }

        /*
         * Cria ou atualiza o perfil administrativo específico
         * da empresa e do módulo.
         */
        DB::table('perfis')->updateOrInsert(
            [
                'empresa_id' => $empresaId,
                'modulo' => 'salao',
                'nome' => 'Administrador do Salão',
            ],
            [
                'descricao' => 'Acesso administrativo completo ao módulo Salão / Barbearia',
             
            ]
        );

        $perfilId = DB::table('perfis')
            ->where('empresa_id', $empresaId)
            ->where('modulo', 'salao')
            ->where('nome', 'Administrador do Salão')
            ->value('id');

        $permissoesIds = DB::table('permissoes')
            ->where('modulo', 'salao')
            ->whereIn('nome', array_keys($permissoes))
            ->pluck('id');

        /*
         * Vincula todas as permissões ao perfil administrador,
         * sem criar duplicidades.
         */
       foreach ($permissoesIds as $permissaoId) {
            $vinculoExiste = DB::table('perfil_permissoes')
                ->where('perfil_id', $perfilId)
                ->where('permissao_id', $permissaoId)
                ->exists();

            if (!$vinculoExiste) {
                DB::table('perfil_permissoes')->insert([
                    'perfil_id' => $perfilId,
                    'permissao_id' => $permissaoId,
                ]);
            }
        }
    }

    public function down(): void
    {
        /*
         * Não removemos as permissões globais no rollback,
         * pois elas podem estar em uso por outras empresas.
         */
        $perfilId = DB::table('perfis')
            ->where('empresa_id', 5)
            ->where('modulo', 'salao')
            ->where('nome', 'Administrador do Salão')
            ->value('id');

        if ($perfilId) {
            DB::table('perfil_permissoes')
                ->where('perfil_id', $perfilId)
                ->delete();

            DB::table('perfis')
                ->where('id', $perfilId)
                ->delete();
        }
    }
};