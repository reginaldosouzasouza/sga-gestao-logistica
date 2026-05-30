<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            if (!Schema::hasColumn('clientes', 'empresa_id')) {
                $table->foreignId('empresa_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('empresas')
                    ->nullOnDelete();
            }
        });

        Schema::table('fornecedores', function (Blueprint $table) {
            if (!Schema::hasColumn('fornecedores', 'empresa_id')) {
                $table->foreignId('empresa_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('empresas')
                    ->nullOnDelete();
            }
        });

        Schema::table('produtos', function (Blueprint $table) {
            if (!Schema::hasColumn('produtos', 'empresa_id')) {
                $table->foreignId('empresa_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('empresas')
                    ->nullOnDelete();
            }
        });

        DB::table('clientes')->whereNull('empresa_id')->update(['empresa_id' => 1]);
        DB::table('fornecedores')->whereNull('empresa_id')->update(['empresa_id' => 1]);
        DB::table('produtos')->whereNull('empresa_id')->update(['empresa_id' => 1]);
    }

    public function down(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            if (Schema::hasColumn('produtos', 'empresa_id')) {
                $table->dropForeign(['empresa_id']);
                $table->dropColumn('empresa_id');
            }
        });

        Schema::table('fornecedores', function (Blueprint $table) {
            if (Schema::hasColumn('fornecedores', 'empresa_id')) {
                $table->dropForeign(['empresa_id']);
                $table->dropColumn('empresa_id');
            }
        });

        Schema::table('clientes', function (Blueprint $table) {
            if (Schema::hasColumn('clientes', 'empresa_id')) {
                $table->dropForeign(['empresa_id']);
                $table->dropColumn('empresa_id');
            }
        });
    }
};