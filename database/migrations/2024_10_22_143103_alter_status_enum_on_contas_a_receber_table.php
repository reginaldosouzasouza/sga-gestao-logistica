<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStatusEnumOnContasAReceberTable extends Migration
{
    public function up()
    {
        Schema::table('contas_a_receber', function (Blueprint $table) {
            $table->enum('status', ['pendente', 'pago', 'recebido', 'atrasado'])->default('pendente')->change();
        });
    }

    public function down()
    {
        Schema::table('contas_a_receber', function (Blueprint $table) {
            $table->enum('status', ['pendente', 'recebido', 'atrasado'])->default('pendente')->change();
        });
    }
}
