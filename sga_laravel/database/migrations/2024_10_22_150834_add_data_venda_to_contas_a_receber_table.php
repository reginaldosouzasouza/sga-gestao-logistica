<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataVendaToContasAReceberTable extends Migration
{
    public function up()
    {
        Schema::table('contas_a_receber', function (Blueprint $table) {
            $table->date('data_venda')->nullable()->after('data_recebimento');
        });
    }

    public function down()
    {
        Schema::table('contas_a_receber', function (Blueprint $table) {
            $table->dropColumn('data_venda');
        });
    }
}

