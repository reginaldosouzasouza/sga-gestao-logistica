<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('movimentacao_itens', function (Blueprint $table) {
            $table->bigInteger('controle_de_coleta')->after('movimentacao_id')
                  ->comment('Número sequencial da coleta')
                  ->nullable();
        });
    }

    public function down()
    {
        Schema::table('movimentacao_itens', function (Blueprint $table) {
            $table->dropColumn('controle_de_coleta');
        });
    }
};
