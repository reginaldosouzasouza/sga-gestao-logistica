<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('empresas', function (Blueprint $table) {
            if (!Schema::hasColumn('empresas', 'plano')) {
                $table->string('plano', 50)->default('teste')->after('ativo');
            }

            if (!Schema::hasColumn('empresas', 'status_assinatura')) {
                $table->string('status_assinatura', 50)->default('teste')->after('plano');
            }

            if (!Schema::hasColumn('empresas', 'data_inicio_teste')) {
                $table->date('data_inicio_teste')->nullable()->after('status_assinatura');
            }

            if (!Schema::hasColumn('empresas', 'data_fim_teste')) {
                $table->date('data_fim_teste')->nullable()->after('data_inicio_teste');
            }

            if (!Schema::hasColumn('empresas', 'data_vencimento')) {
                $table->date('data_vencimento')->nullable()->after('data_fim_teste');
            }

            if (!Schema::hasColumn('empresas', 'bloqueada')) {
                $table->boolean('bloqueada')->default(false)->after('data_vencimento');
            }

            if (!Schema::hasColumn('empresas', 'motivo_bloqueio')) {
                $table->string('motivo_bloqueio', 255)->nullable()->after('bloqueada');
            }

            if (!Schema::hasColumn('empresas', 'limite_usuarios')) {
                $table->integer('limite_usuarios')->nullable()->after('motivo_bloqueio');
            }

            if (!Schema::hasColumn('empresas', 'limite_clientes')) {
                $table->integer('limite_clientes')->nullable()->after('limite_usuarios');
            }
        });

        DB::table('empresas')
            ->whereNull('plano')
            ->update(['plano' => 'teste']);

        DB::table('empresas')
            ->whereNull('status_assinatura')
            ->update(['status_assinatura' => 'teste']);
    }

    public function down(): void
    {
        Schema::table('empresas', function (Blueprint $table) {
            if (Schema::hasColumn('empresas', 'limite_clientes')) {
                $table->dropColumn('limite_clientes');
            }

            if (Schema::hasColumn('empresas', 'limite_usuarios')) {
                $table->dropColumn('limite_usuarios');
            }

            if (Schema::hasColumn('empresas', 'motivo_bloqueio')) {
                $table->dropColumn('motivo_bloqueio');
            }

            if (Schema::hasColumn('empresas', 'bloqueada')) {
                $table->dropColumn('bloqueada');
            }

            if (Schema::hasColumn('empresas', 'data_vencimento')) {
                $table->dropColumn('data_vencimento');
            }

            if (Schema::hasColumn('empresas', 'data_fim_teste')) {
                $table->dropColumn('data_fim_teste');
            }

            if (Schema::hasColumn('empresas', 'data_inicio_teste')) {
                $table->dropColumn('data_inicio_teste');
            }

            if (Schema::hasColumn('empresas', 'status_assinatura')) {
                $table->dropColumn('status_assinatura');
            }

            if (Schema::hasColumn('empresas', 'plano')) {
                $table->dropColumn('plano');
            }
        });
    }
};