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
    Schema::create('veiculos', function (Blueprint $table) {
        $table->id();
        $table->string('cliente');
        $table->string('marca');
        $table->string('veiculo'); // modelo
        $table->string('placa')->unique();
        $table->string('cor')->nullable();
        $table->integer('ano')->nullable();
        $table->string('combustivel')->nullable(); // Gasolina, Etanol, Flex, Diesel, Elétrico etc.
        $table->text('observacoes')->nullable();
        $table->timestamps();
    });
}

};
