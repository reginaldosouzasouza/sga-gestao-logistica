<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cria a tabela de configuração da previsão de vendas.
     *
     * Esta tabela será usada para ajustar a previsão por empresa e produto,
     * considerando fim de mês, sazonalidade e estoque de segurança.
     */
    public function up(): void
    {
        Schema::create('configuracao_previsao_vendas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('produto_id');

            /*
             * Ajuste de fim de mês
             * Exemplo:
             * usar_ajuste_fim_mes = true
             * dia_inicio_fim_mes = 21
             * percentual_ajuste_fim_mes = -15.00
             */
            $table->boolean('usar_ajuste_fim_mes')->default(false);
            $table->unsignedTinyInteger('dia_inicio_fim_mes')->nullable();
            $table->decimal('percentual_ajuste_fim_mes', 8, 2)->default(0);

            /*
             * Sazonalidade manual
             * Exemplo:
             * usar_sazonalidade_manual = true
             * mes_inicio_sazonalidade = 5
             * mes_fim_sazonalidade = 8
             * percentual_ajuste_sazonalidade = 15.00
             */
            $table->boolean('usar_sazonalidade_manual')->default(false);
            $table->unsignedTinyInteger('mes_inicio_sazonalidade')->nullable();
            $table->unsignedTinyInteger('mes_fim_sazonalidade')->nullable();
            $table->decimal('percentual_ajuste_sazonalidade', 8, 2)->default(0);

            /*
             * Estoque de segurança em dias.
             * Exemplo:
             * estoque_seguranca_dias = 2.00
             */
            $table->decimal('estoque_seguranca_dias', 8, 2)->default(0);

            /*
             * Data inicial da base histórica oficial.
             * Exemplo:
             * 2026-05-01 para considerar apenas dados confiáveis do S.G.A.
             */
            $table->date('base_historica_inicio')->nullable();

            $table->boolean('ativo')->default(true);

            $table->timestamps();

            $table->foreign('empresa_id')
                ->references('id')
                ->on('empresas')
                ->onDelete('cascade');

            $table->foreign('produto_id')
                ->references('id')
                ->on('produtos')
                ->onDelete('cascade');

            /*
             * Evita duplicar configuração para o mesmo produto dentro da mesma empresa.
             */
            $table->unique(['empresa_id', 'produto_id'], 'config_prev_empresa_produto_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracao_previsao_vendas');
    }
};