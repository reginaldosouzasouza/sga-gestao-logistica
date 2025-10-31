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
    Schema::create('movimentacao_itens', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('movimentacao_id');
        $table->unsignedBigInteger('produto_id');
        $table->integer('quantidade');
        $table->decimal('valor_unitario', 10, 2);
        $table->decimal('valor_total', 10, 2);
        $table->timestamps();

        // Chaves estrangeiras
        $table->foreign('movimentacao_id')->references('id')->on('movimentacao')->onDelete('cascade');
        $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');
    });
}

};
