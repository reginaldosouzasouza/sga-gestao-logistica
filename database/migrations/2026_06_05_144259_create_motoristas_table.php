<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('motoristas', function (Blueprint $table) {
            $table->id();

            // Multiempresa
            $table->unsignedBigInteger('empresa_id')->nullable();

            $table->string('nome');
            $table->string('telefone')->nullable();
            $table->string('cpf')->nullable();
            $table->string('cnh')->nullable();
            $table->string('categoria_cnh')->nullable();
            $table->date('validade_cnh')->nullable();

            $table->string('endereco')->nullable();
            $table->string('numero')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();

            $table->text('observacao')->nullable();

            $table->boolean('ativo')->default(true);

            $table->timestamps();

            $table->foreign('empresa_id')
                ->references('id')
                ->on('empresas')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('motoristas');
    }
};