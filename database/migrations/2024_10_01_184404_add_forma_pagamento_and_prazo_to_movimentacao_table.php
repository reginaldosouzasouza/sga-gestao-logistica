<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFormaPagamentoAndPrazoToMovimentacaoTable extends Migration
{
    /**
     * Executar as mudanças no banco de dados.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movimentacao', function (Blueprint $table) {
            // Adicionar as colunas forma_pagamento_id e prazo_id
            $table->unsignedBigInteger('forma_pagamento_id')->nullable(); // Campo opcional, por isso nullable()
            $table->unsignedBigInteger('prazo_id')->nullable(); // Campo opcional, por isso nullable()

            // Adicionar as chaves estrangeiras (se necessário)
            $table->foreign('forma_pagamento_id')->references('id')->on('formas_de_pagamento');
            $table->foreign('prazo_id')->references('id')->on('prazos');
        });
    }

    /**
     * Reverter as mudanças.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movimentacao', function (Blueprint $table) {
            // Remover as colunas no rollback
            $table->dropForeign(['forma_pagamento_id']);
            $table->dropForeign(['prazo_id']);
            $table->dropColumn('forma_pagamento_id');
            $table->dropColumn('prazo_id');
        });
    }
}
