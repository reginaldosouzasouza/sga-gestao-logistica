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
        Schema::table('contas_a_pagar', function (Blueprint $table) {
            $table->date('data_compra')->nullable()->after('valor');
        });
    }
    
    public function down()
    {
        Schema::table('contas_a_pagar', function (Blueprint $table) {
            $table->dropColumn('data_compra');
        });
    }
    
};
