<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fechamentos_caixa', function (Blueprint $table) {
            $table->decimal('saldo_final_caixa', 10, 2)->default(0)->after('saldo_final');
            $table->decimal('saldo_final_banco', 10, 2)->default(0)->after('saldo_final_caixa');
        });
    }

    public function down(): void
    {
        Schema::table('fechamentos_caixa', function (Blueprint $table) {
            $table->dropColumn(['saldo_final_caixa', 'saldo_final_banco']);
        });
    }
};
