<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('caixas_abertos', function (Blueprint $table) {
            $table->id();

            // Data do caixa (data contábil)
            $table->date('data_caixa');

            // Data e hora real da abertura
            $table->dateTime('data_abertura');

            // Usuário que abriu (se existir autenticação)
            $table->unsignedBigInteger('usuario_id')->nullable();

            // Saldos iniciais (herdados do fechamento anterior)
            $table->decimal('saldo_inicial_caixa', 10, 2)->default(0);
            $table->decimal('saldo_inicial_banco', 10, 2)->default(0);

            // Status do caixa
            $table->enum('status', ['aberto', 'fechado'])->default('aberto');

            $table->timestamps();

            // Índices
            $table->index('data_caixa');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('caixas_abertos');
    }
};

