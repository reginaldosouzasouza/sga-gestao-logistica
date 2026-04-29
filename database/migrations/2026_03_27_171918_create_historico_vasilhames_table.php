<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historico_vasilhames', function (Blueprint $table) {
            $table->id();
            $table->foreignId('controle_vasilhame_id')->constrained('controle_vasilhames')->cascadeOnDelete();
            $table->string('tipo_movimento');
            $table->unsignedInteger('quantidade')->default(0);
            $table->string('responsavel')->nullable();
            $table->string('cliente')->nullable();
            $table->text('descricao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historico_vasilhames');
    }
};