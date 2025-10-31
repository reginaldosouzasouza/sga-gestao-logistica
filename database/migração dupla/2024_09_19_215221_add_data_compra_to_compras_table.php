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
    Schema::table('compras', function (Blueprint $table) {
        $table->date('data_compra')->nullable();  // Adiciona a coluna 'data_compra' como um campo do tipo DATE
    });
}

public function down()
{
    Schema::table('compras', function (Blueprint $table) {
        $table->dropColumn('data_compra');  // Remove a coluna 'data_compra' em caso de rollback
    });
}

};
