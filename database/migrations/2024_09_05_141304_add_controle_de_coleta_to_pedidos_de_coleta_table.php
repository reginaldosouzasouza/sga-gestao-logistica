<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('pedido_de_coletas', function (Blueprint $table) {
        $table->string('controle_de_coleta')->nullable(); // Campo controle de coleta
    });
}

public function down()
{
    Schema::table('pedido_de_coletas', function (Blueprint $table) {
        $table->dropColumn('controle_de_coleta');
    });
}
    
};
