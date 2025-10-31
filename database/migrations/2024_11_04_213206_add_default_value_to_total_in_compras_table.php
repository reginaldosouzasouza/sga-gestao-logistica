<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultValueToTotalInComprasTable extends Migration
{
    public function up()
    {
        Schema::table('compras', function (Blueprint $table) {
            $table->decimal('total', 10, 2)->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('compras', function (Blueprint $table) {
            $table->decimal('total', 10, 2)->change();
        });
    }
}
