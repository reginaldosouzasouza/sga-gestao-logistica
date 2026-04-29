<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('padaria')->create('pad_encomendas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id'); // referencia cliente no DB principal (sga/gas)
            $table->date('data_encomenda')->default(DB::raw('CURRENT_DATE'));
            $table->date('data_retirada')->index();
            $table->time('hora_retirada')->nullable();
            $table->enum('status', ['Aberto','Produção','Pronto','Entregue','Cancelado'])->default('Aberto')->index();
            $table->unsignedBigInteger('forma_pagamento_id')->nullable(); // referencia forma_pagamento no DB principal
            $table->decimal('sinal', 10, 2)->default(0);
            $table->decimal('valor_total', 12, 2)->default(0);
            $table->string('canal', 50)->nullable(); // WhatsApp, balcão, telefone
            $table->text('observacao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('padaria')->dropIfExists('pad_encomendas');
    }
};
