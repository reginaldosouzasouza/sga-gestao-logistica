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
    Schema::table('clientes', function (Blueprint $table) {
        // Remove a chave única se estiver presente
        $table->dropUnique(['cpf']); 

        // Se quiser também tornar o campo não obrigatório
        $table->string('cpf')->nullable()->change();
    });
}

public function down()
{
    Schema::table('clientes', function (Blueprint $table) {
        // Reverter as mudanças, tornando o CPF único novamente
        $table->string('cpf')->unique()->nullable(false)->change();
    });
}

};
