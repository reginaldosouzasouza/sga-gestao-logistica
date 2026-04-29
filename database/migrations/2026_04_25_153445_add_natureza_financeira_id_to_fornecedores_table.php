<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fornecedores', function (Blueprint $table) {
            $table->unsignedBigInteger('natureza_financeira_id')
                ->nullable()
                ->after('natureza_financeira');

            $table->foreign('natureza_financeira_id')
                ->references('id')
                ->on('naturezas_financeiras')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('fornecedores', function (Blueprint $table) {
            $table->dropForeign(['natureza_financeira_id']);
            $table->dropColumn('natureza_financeira_id');
        });
    }
};