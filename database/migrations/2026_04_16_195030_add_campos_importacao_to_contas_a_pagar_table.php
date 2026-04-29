<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contas_a_pagar', function (Blueprint $table) {
            if (!Schema::hasColumn('contas_a_pagar', 'origem_importacao')) {
                $table->string('origem_importacao', 100)->nullable();
            }

            if (!Schema::hasColumn('contas_a_pagar', 'data_importacao')) {
                $table->dateTime('data_importacao')->nullable();
            }

            if (!Schema::hasColumn('contas_a_pagar', 'usuario_importacao')) {
                $table->unsignedBigInteger('usuario_importacao')->nullable();
            }

            if (!Schema::hasColumn('contas_a_pagar', 'hash_importacao')) {
                $table->string('hash_importacao', 64)->nullable();
                $table->index('hash_importacao', 'idx_contas_pagar_hash_importacao');
            }
        });
    }

    public function down(): void
    {
        Schema::table('contas_a_pagar', function (Blueprint $table) {
            if (Schema::hasColumn('contas_a_pagar', 'hash_importacao')) {
                $table->dropIndex('idx_contas_pagar_hash_importacao');
                $table->dropColumn('hash_importacao');
            }

            if (Schema::hasColumn('contas_a_pagar', 'usuario_importacao')) {
                $table->dropColumn('usuario_importacao');
            }

            if (Schema::hasColumn('contas_a_pagar', 'data_importacao')) {
                $table->dropColumn('data_importacao');
            }

            if (Schema::hasColumn('contas_a_pagar', 'origem_importacao')) {
                $table->dropColumn('origem_importacao');
            }
        });
    }
};