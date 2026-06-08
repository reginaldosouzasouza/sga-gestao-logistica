<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('movimentacao', function (Blueprint $table) {
            $table->unsignedBigInteger('veiculo_id')->nullable()->after('cliente_id');
            $table->unsignedBigInteger('motorista_id')->nullable()->after('veiculo_id');

            $table->string('comissao_tipo')->nullable()->after('motorista_id');
            $table->decimal('comissao_valor', 10, 2)->default(0)->after('comissao_tipo');
            $table->decimal('valor_comissao', 10, 2)->default(0)->after('comissao_valor');

            $table->foreign('veiculo_id')
                ->references('id')
                ->on('veiculos')
                ->onDelete('set null');

            $table->foreign('motorista_id')
                ->references('id')
                ->on('motoristas')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('movimentacao', function (Blueprint $table) {
            $table->dropForeign(['veiculo_id']);
            $table->dropForeign(['motorista_id']);

            $table->dropColumn([
                'veiculo_id',
                'motorista_id',
                'comissao_tipo',
                'comissao_valor',
                'valor_comissao',
            ]);
        });
    }
};