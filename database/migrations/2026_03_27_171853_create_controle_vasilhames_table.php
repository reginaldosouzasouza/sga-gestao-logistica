<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('controle_vasilhames', function (Blueprint $table) {
            $table->id();
            $table->date('data_referencia')->unique();
            $table->unsignedInteger('total_vasilhames')->default(0);
            $table->unsignedInteger('cheios')->default(0);
            $table->unsignedInteger('vazios')->default(0);
            $table->unsignedInteger('emprestados')->default(0);
            $table->unsignedInteger('vendidos')->default(0);
            $table->unsignedInteger('retornaram')->default(0);
            $table->text('observacao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('controle_vasilhames');
    }
};
