<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('padaria')->table('pad_encomendas', function (Blueprint $table) {
            // troca de ENUM para VARCHAR(30) e mantém como nullable
            $table->string('forma_pagamento', 30)->nullable()->change();
        });
    }

    public function down(): void
    {
        // ⚠️ Se precisar voltar, você teria que definir novamente como ENUM.
        // Exemplo (cuidado se já houver valores fora da lista):
        // DB::connection('padaria')->statement("
        //   ALTER TABLE pad_encomendas
        //   MODIFY forma_pagamento ENUM('pix','dinheiro','cartao') NULL
        // ");
    }
};
