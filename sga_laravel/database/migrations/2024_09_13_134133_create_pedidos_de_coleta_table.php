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
    Schema::create('pedidos_de_coleta', function (Blueprint $table) {
        $table->id();
        $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
        $table->string('telefone', 15);
        $table->string('endereco', 255);
        $table->string('numero', 10);
        $table->string('bairro', 100);
        $table->string('cidade', 100);
        $table->text('observacao')->nullable();
        $table->integer('controle_coleta');
        $table->timestamp('data_pedido')->useCurrent();
        $table->timestamps();
    });
}

};
