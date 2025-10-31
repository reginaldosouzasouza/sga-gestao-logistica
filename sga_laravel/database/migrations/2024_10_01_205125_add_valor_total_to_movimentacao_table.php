<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValorTotalToMovimentacaoTable extends Migration
{
    public function up()
    {
        Schema::table('movimentacao', function (Blueprint $table) {
            $table->decimal('valor_total', 10, 2)->nullable(); // Adiciona o campo valor_total
        });
    }

    public function down()
    {
        Schema::table('movimentacao', function (Blueprint $table) {
            $table->dropColumn('valor_total'); // Remove o campo valor_total em caso de rollback
        });
    }
}
