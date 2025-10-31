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
        Schema::table('produtos', function (Blueprint $table) {
            $table->string('codigo_barras')->nullable()->after('estoque_minimo');
        });
    }
    
    public function down()
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropColumn('codigo_barras');
        });
    }
    

};
