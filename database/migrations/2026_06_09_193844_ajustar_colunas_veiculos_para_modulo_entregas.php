<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('veiculos', function (Blueprint $table) {
            if (!Schema::hasColumn('veiculos', 'empresa_id')) {
                $table->unsignedBigInteger('empresa_id')->nullable()->after('id');
            }

            if (!Schema::hasColumn('veiculos', 'motorista_id')) {
                $table->unsignedBigInteger('motorista_id')->nullable()->after('empresa_id');
            }

            if (!Schema::hasColumn('veiculos', 'descricao')) {
                $table->string('descricao')->nullable()->after('motorista_id');
            }

            if (!Schema::hasColumn('veiculos', 'modelo')) {
                $table->string('modelo')->nullable()->after('marca');
            }

            if (!Schema::hasColumn('veiculos', 'tipo')) {
                $table->string('tipo')->nullable()->after('ano');
            }

            if (!Schema::hasColumn('veiculos', 'comissao_tipo')) {
                $table->string('comissao_tipo', 50)->nullable()->after('combustivel');
            }

            if (!Schema::hasColumn('veiculos', 'comissao_valor')) {
                $table->decimal('comissao_valor', 10, 2)->default(0)->after('comissao_tipo');
            }

            if (!Schema::hasColumn('veiculos', 'observacao')) {
                $table->text('observacao')->nullable()->after('comissao_valor');
            }

            if (!Schema::hasColumn('veiculos', 'ativo')) {
                $table->boolean('ativo')->default(true)->after('observacao');
            }
        });

        DB::table('veiculos')
            ->whereNull('empresa_id')
            ->update(['empresa_id' => 1]);

        if (Schema::hasColumn('veiculos', 'veiculo') && Schema::hasColumn('veiculos', 'modelo')) {
            DB::statement("
                UPDATE veiculos 
                SET modelo = veiculo 
                WHERE (modelo IS NULL OR modelo = '') 
                  AND veiculo IS NOT NULL
            ");
        }

        if (Schema::hasColumn('veiculos', 'observacoes') && Schema::hasColumn('veiculos', 'observacao')) {
            DB::statement("
                UPDATE veiculos 
                SET observacao = observacoes 
                WHERE (observacao IS NULL OR observacao = '') 
                  AND observacoes IS NOT NULL
            ");
        }

        if (Schema::hasColumn('veiculos', 'descricao')) {
            DB::statement("
                UPDATE veiculos
                SET descricao = CONCAT(
                    COALESCE(marca, ''),
                    ' ',
                    COALESCE(modelo, ''),
                    ' - ',
                    COALESCE(placa, '')
                )
                WHERE descricao IS NULL OR descricao = ''
            ");
        }
    }

    public function down(): void
    {
        Schema::table('veiculos', function (Blueprint $table) {
            if (Schema::hasColumn('veiculos', 'motorista_id')) {
                $table->dropColumn('motorista_id');
            }

            if (Schema::hasColumn('veiculos', 'descricao')) {
                $table->dropColumn('descricao');
            }

            if (Schema::hasColumn('veiculos', 'modelo')) {
                $table->dropColumn('modelo');
            }

            if (Schema::hasColumn('veiculos', 'tipo')) {
                $table->dropColumn('tipo');
            }

            if (Schema::hasColumn('veiculos', 'comissao_tipo')) {
                $table->dropColumn('comissao_tipo');
            }

            if (Schema::hasColumn('veiculos', 'comissao_valor')) {
                $table->dropColumn('comissao_valor');
            }

            if (Schema::hasColumn('veiculos', 'observacao')) {
                $table->dropColumn('observacao');
            }

            if (Schema::hasColumn('veiculos', 'ativo')) {
                $table->dropColumn('ativo');
            }

            if (Schema::hasColumn('veiculos', 'empresa_id')) {
                $table->dropColumn('empresa_id');
            }
        });
    }
};