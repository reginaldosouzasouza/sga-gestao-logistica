<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();

            $table->string('nome_fantasia');
            $table->string('razao_social')->nullable();
            $table->string('cnpj', 20)->nullable();
            $table->string('telefone', 30)->nullable();
            $table->string('email')->nullable();

            $table->string('endereco')->nullable();
            $table->string('numero', 20)->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado', 2)->nullable();
            $table->string('cep', 20)->nullable();

            $table->string('status')->default('ativo'); 
            $table->string('plano')->nullable();

            $table->date('data_inicio_teste')->nullable();
            $table->date('data_vencimento')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};