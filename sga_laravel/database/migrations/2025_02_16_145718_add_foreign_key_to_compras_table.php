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
            $table->foreign('forma_pagamento_id')
                  ->references('id')
                  ->on('formas_de_pagamento')
                  ->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('compras', function (Blueprint $table) {
            $table->dropForeign(['forma_pagamento_id']);
        });
    }
};
