<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cliente_produto_duracao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('produto_id')->constrained('produtos')->onDelete('cascade');
            $table->integer('duracao')->default(30)->comment('Duração média de uso em dias');
            $table->timestamps();

            $table->unique(['cliente_id', 'produto_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cliente_produto_duracao');
    }
};