<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('contas_a_receber', function (Blueprint $table) {
        $table->id();
        $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
        $table->string('descricao');
        $table->decimal('valor', 10, 2);
        $table->date('data_vencimento');
        $table->date('data_recebimento')->nullable();
        $table->enum('status', ['pendente', 'recebido', 'atrasado'])->default('pendente');
        $table->foreignId('forma_pagamento_id')->constrained('formas_de_pagamento')->onDelete('cascade');
        $table->text('observacao')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contas_a_receber');
    }
};
