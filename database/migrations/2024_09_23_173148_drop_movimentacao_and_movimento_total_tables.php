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
    Schema::dropIfExists('movimentacao');
    Schema::dropIfExists('movimento_total');
}

public function down()
{
    Schema::create('movimentacao', function (Blueprint $table) {
        // Coloque aqui os campos da tabela caso queira restaurar a estrutura no método down
    });

    Schema::create('movimento_total', function (Blueprint $table) {
        // Coloque aqui os campos da tabela caso queira restaurar a estrutura no método down
    });
}

};
