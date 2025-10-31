<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('pedidos_de_coleta', function (Blueprint $table) {
        $table->string('controle_de_coleta')->nullable(); // Campo controle de coleta
    });
}

public function down()
{
    Schema::table('pedidos_de_coleta', function (Blueprint $table) {
        $table->dropColumn('controle_de_coleta');
    });
}
    
};
