<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vale_gas', function (Blueprint $table) {
            $table->unsignedBigInteger('pedido_coleta_id')->nullable()->after('status');
            $table->dateTime('data_retirada')->nullable()->after('pedido_coleta_id');
            $table->unsignedBigInteger('usuario_retirada_id')->nullable()->after('usuario_cadastro_id');
        });

        DB::statement("
            ALTER TABLE vale_gas 
            MODIFY status ENUM('ABERTO', 'EM_PROCESSO', 'RETIRADO', 'CANCELADO') 
            NOT NULL DEFAULT 'ABERTO'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE vale_gas 
            MODIFY status ENUM('ABERTO', 'CANCELADO') 
            NOT NULL DEFAULT 'ABERTO'
        ");

        Schema::table('vale_gas', function (Blueprint $table) {
            $table->dropColumn([
                'pedido_coleta_id',
                'data_retirada',
                'usuario_retirada_id',
            ]);
        });
    }
};