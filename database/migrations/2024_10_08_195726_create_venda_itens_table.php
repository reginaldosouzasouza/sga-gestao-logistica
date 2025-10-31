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
        Schema::create('venda_itens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venda_id');  // Referência à tabela vendas
            $table->unsignedBigInteger('produto_id');  // Referência à tabela produtos
            $table->integer('quantidade');  // Quantidade do produto vendido
            $table->decimal('valor_unitario', 8, 2);  // Valor unitário do produto
            $table->decimal('valor_total', 8, 2)->storedAs('quantidade * valor_unitario');  // Valor total do item (quantidade * valor_unitario)
            $table->timestamps();
    
            // Chaves estrangeiras
            $table->foreign('venda_id')->references('id')->on('vendas');
            $table->foreign('produto_id')->references('id')->on('produtos');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('venda_itens');
    }
    
};
