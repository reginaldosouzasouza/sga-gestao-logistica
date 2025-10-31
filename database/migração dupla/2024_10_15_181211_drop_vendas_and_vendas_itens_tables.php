<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropVendasAndVendasItensTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Excluir as tabelas
        Schema::table('vendas', function (Blueprint $table) {
            $table->dropForeign(['cliente_id']);       // Remover chave estrangeira de cliente_id
            $table->dropForeign(['pedido_coleta_id']); // Remover chave estrangeira de pedido_coleta_id
        });
        

        Schema::dropIfExists('vendas');
        Schema::dropIfExists('vendas_itens');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Se desejar, pode recriar as tabelas na reversão, ou deixar vazio se não quiser
    }
}
