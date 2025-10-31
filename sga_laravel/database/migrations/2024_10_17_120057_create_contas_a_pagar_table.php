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
    Schema::create('contas_a_pagar', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('fornecedor_id'); // Defina o campo fornecedor_id como unsigned

        // Demais campos
        $table->string('descricao');
        $table->decimal('valor', 10, 2);
        $table->date('data_vencimento');
        $table->date('data_pagamento')->nullable();
        $table->enum('status', ['pendente', 'pago', 'atrasado'])->default('pendente');
        $table->foreignId('forma_pagamento_id')->constrained('formas_de_pagamento')->onDelete('cascade');
        $table->text('observacao')->nullable();
        $table->timestamps();

        // Definir a chave estrangeira manualmente
        $table->foreign('fornecedor_id')
              ->references('id')
              ->on('fornecedores')
              ->onDelete('cascade');
    });
}

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contas_a_pagar');
    }
};
