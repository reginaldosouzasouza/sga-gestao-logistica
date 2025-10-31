<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormasDePagamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formas_de_pagamento', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->timestamps();
        });

        // Populando a tabela com as formas de pagamento padrão
        DB::table('formas_de_pagamento')->insert([
            ['nome' => 'Dinheiro'],
            ['nome' => 'PIX'],
            ['nome' => 'Boleto'],
            ['nome' => 'Cartão de Crédito'],
            ['nome' => 'Nota Assinada'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formas_de_pagamento');
    }
}
