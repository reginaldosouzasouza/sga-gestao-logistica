
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
        Schema::create('movimentacao', function (Blueprint $table) {
            $table->id(); // Número da coleta (sequencial e auto-incrementado)
            $table->string('cpf')->nullable(); // CPF (não obrigatório)
            $table->string('nome'); // Nome (obrigatório)
            $table->string('endereco'); // Endereço (obrigatório)
            $table->string('numero'); // Número (obrigatório)
            $table->string('bairro'); // Bairro (obrigatório)
            $table->string('cidade'); // Cidade (obrigatório)
            $table->text('observacao')->nullable(); // Observação (não obrigatório)
            $table->timestamps(); // Criado em e Atualizado em
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('movimentacao');
    }
    
};
