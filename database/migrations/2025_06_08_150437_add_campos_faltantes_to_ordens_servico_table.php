<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('ordens_servico', function (Blueprint $table) {
        $table->date('data_prevista_entrega')->nullable();
        $table->string('marca', 255)->nullable();
        $table->string('modelo', 255)->nullable();
        $table->text('descricao_pecas')->nullable();
    });
}

public function down()
{
    Schema::table('ordens_servico', function (Blueprint $table) {
        $table->dropColumn(['data_prevista_entrega', 'marca', 'modelo', 'descricao_pecas']);
    });
}

};
