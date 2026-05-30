<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fechamentos_caixa', function (Blueprint $table) {
            $table->dropUnique('fechamentos_caixa_data_unique');
        });

        Schema::table('fechamentos_caixa', function (Blueprint $table) {
            $table->unique(['empresa_id', 'data'], 'fechamentos_caixa_empresa_data_unique');
        });
    }

    public function down(): void
    {
        Schema::table('fechamentos_caixa', function (Blueprint $table) {
            $table->dropUnique('fechamentos_caixa_empresa_data_unique');
        });

        Schema::table('fechamentos_caixa', function (Blueprint $table) {
            $table->unique('data', 'fechamentos_caixa_data_unique');
        });
    }
};