<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('caixas_abertos') && !Schema::hasColumn('caixas_abertos', 'empresa_id')) {
            Schema::table('caixas_abertos', function (Blueprint $table) {
                $table->foreignId('empresa_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('empresas')
                    ->nullOnDelete();
            });

            DB::table('caixas_abertos')
                ->whereNull('empresa_id')
                ->update(['empresa_id' => 1]);
        }

        if (Schema::hasTable('fechamento_caixas') && !Schema::hasColumn('fechamento_caixas', 'empresa_id')) {
            Schema::table('fechamento_caixas', function (Blueprint $table) {
                $table->foreignId('empresa_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('empresas')
                    ->nullOnDelete();
            });

            DB::table('fechamento_caixas')
                ->whereNull('empresa_id')
                ->update(['empresa_id' => 1]);
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('fechamento_caixas') && Schema::hasColumn('fechamento_caixas', 'empresa_id')) {
            Schema::table('fechamento_caixas', function (Blueprint $table) {
                $table->dropForeign(['empresa_id']);
                $table->dropColumn('empresa_id');
            });
        }

        if (Schema::hasTable('caixas_abertos') && Schema::hasColumn('caixas_abertos', 'empresa_id')) {
            Schema::table('caixas_abertos', function (Blueprint $table) {
                $table->dropForeign(['empresa_id']);
                $table->dropColumn('empresa_id');
            });
        }
    }
};