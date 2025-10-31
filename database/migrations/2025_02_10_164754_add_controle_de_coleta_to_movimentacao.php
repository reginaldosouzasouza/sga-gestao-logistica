<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('movimentacao', function (Blueprint $table) {
            $table->bigInteger('controle_de_coleta')->after('id')->unique()->comment('Número sequencial da coleta');
        });
    }

    public function down()
    {
        Schema::table('movimentacao', function (Blueprint $table) {
            $table->dropColumn('controle_de_coleta');
        });
    }
};
