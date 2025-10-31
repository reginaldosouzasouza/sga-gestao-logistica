<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemovePedidoIdFromMovimentacaoTable extends Migration
{
    public function up()
    {
        Schema::table('movimentacao', function (Blueprint $table) {
            // Primeiro, remover a chave estrangeira
            $table->dropForeign(['pedido_id']);
            // Agora, remover a coluna
            $table->dropColumn('pedido_id');
        });
    }

    public function down()
    {
        Schema::table('movimentacao', function (Blueprint $table) {
            // Restaurar a coluna 'pedido_id'
            $table->bigInteger('pedido_id')->unsigned()->nullable();
            // Restaurar a chave estrangeira
            $table->foreign('pedido_id')->references('id')->on('pedidos')->onDelete('cascade');
        });
    }
}
