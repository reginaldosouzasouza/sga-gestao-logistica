<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('movimentacao', function (Blueprint $table) {
            if (!Schema::hasColumn('movimentacao', 'quantidade')) {
                $table->integer('quantidade')->after('valor_total')->default(0);
            }
        });
    }

    public function down()
    {
        Schema::table('movimentacao', function (Blueprint $table) {
            $table->dropColumn('quantidade');
        });
    }
};


