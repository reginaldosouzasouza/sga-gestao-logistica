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
        // Verifica se a coluna já existe antes de adicioná-la
        if (!Schema::hasColumn('compras', 'forma_pagamento_id')) {
            Schema::table('compras', function (Blueprint $table) {
                $table->unsignedBigInteger('forma_pagamento_id')->default(1);
            });
        }
    
        // Adiciona a chave estrangeira
        Schema::table('compras', function (Blueprint $table) {
            $table->foreign('forma_pagamento_id')
                  ->references('id')
                  ->on('formas_de_pagamento')
                  ->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('compras', function (Blueprint $table) {
            $table->dropForeign(['forma_pagamento_id']); // Remove a chave estrangeira
            $table->dropColumn('forma_pagamento_id'); // Remove a coluna
        });
    }

};
