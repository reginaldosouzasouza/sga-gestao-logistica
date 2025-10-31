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
    Schema::table('movimentacao', function (Blueprint $table) {
        $table->date('data_coleta')->after('id')->nullable();
    });
}

public function down()
{
    Schema::table('movimentacao', function (Blueprint $table) {
        $table->dropColumn('data_coleta');
    });
}

};
