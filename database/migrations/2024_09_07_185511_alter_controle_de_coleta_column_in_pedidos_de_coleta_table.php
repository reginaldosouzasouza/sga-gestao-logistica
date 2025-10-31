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
            $table->integer('controle_de_coleta')->change();
        });
    }
    
    public function down()
    {
        Schema::table('pedidos_de_coleta', function (Blueprint $table) {
            $table->string('controle_de_coleta', 255)->change();
        });
    }
    
};
