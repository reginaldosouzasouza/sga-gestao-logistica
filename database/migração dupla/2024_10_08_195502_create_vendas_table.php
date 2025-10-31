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
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');  // Relacionamento com a tabela clientes
            $table->unsignedBigInteger('pedido_coleta_id');  // Relacionamento com pedidos de coleta
            $table->decimal('total', 10, 2);  // Total da venda
            $table->timestamps();  // created_at e updated_at automáticos
    
            // Chaves estrangeiras
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('pedido_coleta_id')->references('id')->on('pedidos_de_coleta');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('vendas');
    }
    
};
