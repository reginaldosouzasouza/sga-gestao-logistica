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
        Schema::create('movimento_total', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pedido_de_coleta_id'); // Relaciona com o pedido de coleta
            $table->decimal('valor_total', 10, 2); // Campo para armazenar o valor total
            $table->timestamps();
    
            // Foreign key para relacionar com a tabela pedidos_de_coleta
            $table->foreign('pedido_de_coleta_id')->references('id')->on('pedidos_de_coleta')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimento_total');
    }
};
