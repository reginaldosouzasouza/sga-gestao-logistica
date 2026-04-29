<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vale_gas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->unique();
            $table->unsignedBigInteger('cliente_id');
            $table->date('data_vale');
            $table->unsignedBigInteger('produto_id');
            $table->decimal('quantidade', 10, 2)->default(1);
            $table->decimal('valor_pago', 10, 2)->default(0);
            $table->unsignedBigInteger('forma_pagamento_id')->nullable();
            $table->enum('status', ['ABERTO', 'CANCELADO'])->default('ABERTO');
            $table->text('observacao')->nullable();
            $table->unsignedBigInteger('usuario_cadastro_id')->nullable();
            $table->timestamps();

            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('produto_id')->references('id')->on('produtos');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vale_gas');
    }
};