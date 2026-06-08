<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('veiculos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->unsignedBigInteger('motorista_id')->nullable();

            $table->string('descricao');
            $table->string('placa', 20)->nullable();
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->integer('ano')->nullable();

            $table->string('tipo')->nullable(); 
            // Ex: Moto, Carro, Caminhonete, Caminhão

            $table->string('combustivel')->nullable();
            // Ex: Gasolina, Etanol, Flex, Diesel

            $table->string('comissao_tipo')->nullable();
            // Ex: percentual ou fixa

            $table->decimal('comissao_valor', 10, 2)->default(0);

            $table->boolean('ativo')->default(true);
            $table->text('observacao')->nullable();

            $table->timestamps();

            $table->foreign('empresa_id')
                ->references('id')
                ->on('empresas')
                ->onDelete('set null');

            $table->foreign('motorista_id')
                ->references('id')
                ->on('motoristas')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('veiculos');
    }
};