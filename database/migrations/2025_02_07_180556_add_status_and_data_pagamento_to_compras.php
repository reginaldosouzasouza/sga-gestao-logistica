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
            $table->date('data_pagamento')->nullable()->after('data_vencimento'); 
            $table->string('status')->default('pendente')->after('data_pagamento'); 
        });
    }
    
    public function down()
    {
        Schema::table('compras', function (Blueprint $table) {
            $table->dropColumn(['data_pagamento', 'status']);
        });
    }
    
};
