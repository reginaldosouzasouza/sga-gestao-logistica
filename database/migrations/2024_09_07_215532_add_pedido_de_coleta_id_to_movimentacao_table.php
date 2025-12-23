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
    Schema::table('movimentacao', function (Blueprint $table) {
        $table->foreignId('pedido_de_coleta_id')->constrained('pedido_de_coletas');
    });
}

public function down()
{
    Schema::table('movimentacao', function (Blueprint $table) {
        $table->dropForeign(['pedido_de_coleta_id']);
        $table->dropColumn('pedido_de_coleta_id');
    });
}

};
