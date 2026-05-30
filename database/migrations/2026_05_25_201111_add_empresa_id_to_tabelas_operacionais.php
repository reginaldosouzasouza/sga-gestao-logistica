<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $tabelas = [
            'compras',
            'contas_a_pagar',
            'contas_a_receber',
            'caixa',
            'caixa_banco',
            'movimentacao',
            'movimentacao_itens',
            'estoques',
        ];

        foreach ($tabelas as $tabela) {
            if (Schema::hasTable($tabela) && !Schema::hasColumn($tabela, 'empresa_id')) {
                Schema::table($tabela, function (Blueprint $table) {
                    $table->foreignId('empresa_id')
                        ->nullable()
                        ->after('id')
                        ->constrained('empresas')
                        ->nullOnDelete();
                });
            }
        }

        foreach ($tabelas as $tabela) {
            if (Schema::hasTable($tabela) && Schema::hasColumn($tabela, 'empresa_id')) {
                DB::table($tabela)
                    ->whereNull('empresa_id')
                    ->update(['empresa_id' => 1]);
            }
        }
    }

    public function down(): void
    {
        $tabelas = [
            'estoques',
            'movimentacao_itens',
            'movimentacao',
            'caixa_banco',
            'caixa',
            'contas_a_receber',
            'contas_a_pagar',
            'compras',
        ];

        foreach ($tabelas as $tabela) {
            if (Schema::hasTable($tabela) && Schema::hasColumn($tabela, 'empresa_id')) {
                Schema::table($tabela, function (Blueprint $table) {
                    $table->dropForeign(['empresa_id']);
                    $table->dropColumn('empresa_id');
                });
            }
        }
    }
};