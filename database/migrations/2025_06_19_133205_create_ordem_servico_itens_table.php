<?php
    

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ordem_servico_itens', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ordem_servico_id');
            $table->unsignedBigInteger('produto_id');
            $table->integer('quantidade');
            $table->decimal('valor_unitario', 10, 2);
            $table->decimal('valor_total', 10, 2);

            $table->unsignedBigInteger('forma_pagamento_id')->nullable();
            $table->unsignedBigInteger('prazo_id')->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreign('ordem_servico_id')->references('id')->on('ordens_servico')->onDelete('cascade');
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('restrict');
            $table->foreign('forma_pagamento_id')->references('id')->on('formas_pagamento')->onDelete('set null');
            $table->foreign('prazo_id')->references('id')->on('prazos')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordem_servico_itens');
    }
};
