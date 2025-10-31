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
    Schema::create('ordens_servico', function (Blueprint $table) {
        $table->id();
        $table->string('cliente');
        $table->string('veiculo')->nullable();
        $table->string('placa')->nullable();
        $table->string('servico_realizado');
        $table->decimal('valor', 10, 2);
        $table->string('status')->default('Aberto'); // Aberto, Concluído, Cancelado
        $table->text('observacoes')->nullable();
        $table->timestamps();
    });
}

};
