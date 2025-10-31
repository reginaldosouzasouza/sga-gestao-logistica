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
            $table->string('cpf', 14)->nullable(); // CPF não obrigatório
        });
    }
    
};
