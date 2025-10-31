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
        $table->unsignedBigInteger('cliente_id')->after('cidade')->nullable();
        $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('movimentacao', function (Blueprint $table) {
        $table->dropForeign(['cliente_id']);
        $table->dropColumn('cliente_id');
    });
}

};
