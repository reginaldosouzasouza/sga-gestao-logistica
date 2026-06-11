<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /*
         * Ajustes na tabela veiculos.
         * Essa tabela herdou campos antigos obrigatórios do módulo anterior.
         * Para o SaaS, esses campos precisam aceitar NULL.
         */
        if (Schema::hasTable('veiculos')) {
            if (Schema::hasColumn('veiculos', 'cliente')) {
                DB::statement("ALTER TABLE veiculos MODIFY cliente VARCHAR(255) NULL");
            }

            if (Schema::hasColumn('veiculos', 'veiculo')) {
                DB::statement("ALTER TABLE veiculos MODIFY veiculo VARCHAR(255) NULL");
            }

            if (Schema::hasColumn('veiculos', 'marca')) {
                DB::statement("ALTER TABLE veiculos MODIFY marca VARCHAR(255) NULL");
            }

            if (Schema::hasColumn('veiculos', 'placa')) {
                DB::statement("ALTER TABLE veiculos MODIFY placa VARCHAR(255) NULL");
            }

            /*
             * Remove índice antigo único global da placa.
             * No SaaS, a mesma placa pode existir em empresas diferentes.
             */
            $indices = DB::select("SHOW INDEX FROM veiculos WHERE Key_name = 'veiculos_placa_unique'");

            if (! empty($indices)) {
                DB::statement("ALTER TABLE veiculos DROP INDEX veiculos_placa_unique");
            }

            /*
             * Cria índice único correto: empresa_id + placa.
             * Antes verifica se já existe para evitar erro ao rodar novamente.
             */
            $indiceEmpresaPlaca = DB::select("SHOW INDEX FROM veiculos WHERE Key_name = 'veiculos_empresa_placa_unique'");

            if (empty($indiceEmpresaPlaca) && Schema::hasColumn('veiculos', 'empresa_id') && Schema::hasColumn('veiculos', 'placa')) {
                DB::statement("ALTER TABLE veiculos ADD UNIQUE veiculos_empresa_placa_unique (empresa_id, placa)");
            }
        }

        /*
         * Ajuste na tabela movimentacao.
         * Campo antigo obrigatório que não é mais enviado no insert atual.
         */
        if (Schema::hasTable('movimentacao')) {
            if (Schema::hasColumn('movimentacao', 'controle_de_coleta')) {
                DB::statement("ALTER TABLE movimentacao MODIFY controle_de_coleta VARCHAR(255) NULL");
            }
        }
    }

    public function down(): void
    {
        /*
         * Não vamos reverter para NOT NULL para não quebrar dados já gravados.
         * Apenas removemos o índice novo se necessário.
         */
        if (Schema::hasTable('veiculos')) {
            $indiceEmpresaPlaca = DB::select("SHOW INDEX FROM veiculos WHERE Key_name = 'veiculos_empresa_placa_unique'");

            if (! empty($indiceEmpresaPlaca)) {
                DB::statement("ALTER TABLE veiculos DROP INDEX veiculos_empresa_placa_unique");
            }
        }
    }
};