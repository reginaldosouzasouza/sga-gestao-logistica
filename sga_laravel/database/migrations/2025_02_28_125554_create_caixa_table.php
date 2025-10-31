<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('caixa', function (Blueprint $table) {
            $table->id();
            $table->dateTime('data_abertura');
            $table->decimal('saldo_inicial', 10, 2);
            $table->dateTime('data_fechamento')->nullable();
            $table->decimal('saldo_final', 10, 2)->nullable();
            $table->enum('status', ['aberto', 'fechado'])->default('aberto');
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('caixa');
    }
};
