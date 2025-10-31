<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('caixa_movimentacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caixa_id')->constrained('caixa')->onDelete('cascade');
            $table->enum('tipo', ['entrada', 'saida']);
            $table->text('descricao')->nullable();
            $table->decimal('valor', 10, 2);
            $table->enum('metodo_pagamento', ['dinheiro', 'PIX', 'cartao', 'boleto']);
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('caixa_movimentacoes');
    }
};
