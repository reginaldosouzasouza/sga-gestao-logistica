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
    Schema::create('estoques', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('produto_id');
        $table->integer('quantidade');
        $table->string('tipo_movimentacao'); // entrada ou saída
        $table->string('origem'); // pode ser 'compra', 'venda' ou outro tipo de ajuste
        $table->timestamp('data_movimentacao')->useCurrent();
        $table->timestamps();

        // Relacionamento com produtos
        $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');
    });
}

};
