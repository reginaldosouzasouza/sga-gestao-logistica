<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('padaria')->create('pad_encomenda_itens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('encomenda_id');
            $table->unsignedBigInteger('produto_id'); // id do produto no DB principal
            $table->decimal('quantidade', 10, 3);
            $table->decimal('valor_unitario', 12, 2);
            $table->decimal('valor_total', 12, 2);
            $table->string('tamanho', 50)->nullable();      // P/M/G/1kg
            $table->string('sabor', 50)->nullable();        // chocolate, morango...
            $table->text('personalizacao')->nullable();     // mensagem no bolo
            $table->timestamps();

            $table->index('encomenda_id');
            $table->index('produto_id');
        });
    }

    public function down(): void
    {
        Schema::connection('padaria')->dropIfExists('pad_encomenda_itens');
    }
};
