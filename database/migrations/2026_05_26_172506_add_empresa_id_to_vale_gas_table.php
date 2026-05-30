<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('vale_gas') && !Schema::hasColumn('vale_gas', 'empresa_id')) {
            Schema::table('vale_gas', function (Blueprint $table) {
                $table->foreignId('empresa_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('empresas')
                    ->nullOnDelete();
            });

            DB::table('vale_gas')
                ->whereNull('empresa_id')
                ->update(['empresa_id' => 1]);
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('vale_gas') && Schema::hasColumn('vale_gas', 'empresa_id')) {
            Schema::table('vale_gas', function (Blueprint $table) {
                $table->dropForeign(['empresa_id']);
                $table->dropColumn('empresa_id');
            });
        }
    }
};