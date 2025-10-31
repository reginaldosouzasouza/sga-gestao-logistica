<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveQuantidadeFromComprasTable extends Migration
{
    public function up()
    {
        Schema::table('compras', function (Blueprint $table) {
            $table->dropColumn('quantidade');
        });
    }

    public function down()
    {
        Schema::table('compras', function (Blueprint $table) {
            $table->integer('quantidade')->nullable();
        });
    }
}
