<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('venda_itens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venda_id');
            $table->unsignedBigInteger('produto_id');
            $table->integer('quantidade');
            $table->decimal('valor_unitario', 8, 2);
            $table->decimal('valor_total', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('venda_itens');
    }
};