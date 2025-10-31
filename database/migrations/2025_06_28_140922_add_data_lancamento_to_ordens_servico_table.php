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
                $table->date('data_lancamento')->nullable()->after('id'); // ou ajuste a posição conforme desejar
            });
    }

        public function down()
    {
            Schema::table('ordens_servico', function (Blueprint $table) {
                $table->dropColumn('data_lancamento');
            });
    }

};   