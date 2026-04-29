<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('caixa', function (Blueprint $table) {
            $table->id();
            $table->date('data_movimentacao');
            $table->enum('tipo', ['entrada', 'saida']);
            $table->decimal('valor', 10, 2);
            $table->string('origem', 50);
            $table->string('descricao')->nullable();
            $table->unsignedBigInteger('referencia_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('caixa');
    }
};
