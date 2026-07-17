<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entrega_rastreios', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('movimentacao_id');
            $table->unsignedBigInteger('cliente_id')->nullable();

            $table->string('codigo_rastreio')->unique();
            $table->string('link_rastreio')->nullable();
            $table->text('link_whatsapp')->nullable();
            $table->string('status')->default('coletado');

            $table->timestamps();

            $table->unique(['empresa_id', 'movimentacao_id']);

            $table->foreign('empresa_id')->references('id')->on('empresas')->cascadeOnDelete();
            $table->foreign('movimentacao_id')->references('id')->on('movimentacao')->cascadeOnDelete();
            $table->foreign('cliente_id')->references('id')->on('clientes')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entrega_rastreios');
    }
};