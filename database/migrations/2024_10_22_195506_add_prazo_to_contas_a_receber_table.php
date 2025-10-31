<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrazoToContasAReceberTable extends Migration
{
    public function up()
    {
        Schema::table('contas_a_receber', function (Blueprint $table) {
            $table->string('prazo')->nullable()->after('forma_pagamento_id');
        });
    }

    public function down()
    {
        Schema::table('contas_a_receber', function (Blueprint $table) {
            $table->dropColumn('prazo');
        });
    }
}
