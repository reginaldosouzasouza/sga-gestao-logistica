<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemovePrecoUnitarioFromComprasTable extends Migration
{
    public function up()
    {
        Schema::table('compras', function (Blueprint $table) {
            $table->dropColumn('preco_unitario');
        });
    }

    public function down()
    {
        Schema::table('compras', function (Blueprint $table) {
            $table->decimal('preco_unitario', 10, 2)->nullable();
        });
    }
}
