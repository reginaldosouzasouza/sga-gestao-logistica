<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('ordens_servico', function (Blueprint $table) {
        $table->integer('km')->nullable()->after('mecanico'); // ajusta a posição se necessário
    });
}

public function down()
{
    Schema::table('ordens_servico', function (Blueprint $table) {
        $table->dropColumn('km');
    });
}

};
