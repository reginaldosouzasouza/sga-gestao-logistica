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
        Schema::table('pedidos_de_coleta', function (Blueprint $table) {
            $table->string('telefone', 100)->change(); // Aumente o tamanho para 100, ou o que for adequado
        });
    }

    public function down()
    {
        Schema::table('pedidos_de_coleta', function (Blueprint $table) {
            $table->string('telefone', 50)->change(); // Volte para o tamanho original caso necessário
        });
    }

};
