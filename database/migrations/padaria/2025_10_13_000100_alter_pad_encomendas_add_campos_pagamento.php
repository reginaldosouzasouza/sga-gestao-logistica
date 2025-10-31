<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('padaria')->table('pad_encomendas', function (Blueprint $table) {
            $table->string('nome')->nullable()->after('cliente_id'); // nome livre
            $table->date('data_pedido')->nullable()->after('data_encomenda'); // explícito
            $table->enum('forma_pagamento', ['pix','dinheiro','cartao'])->nullable()->after('forma_pagamento_id');
            $table->enum('pagamento_status', ['Pago','Pendente'])->default('Pendente')->after('forma_pagamento');
        });
    }

    public function down(): void
    {
        Schema::connection('padaria')->table('pad_encomendas', function (Blueprint $table) {
            $table->dropColumn(['nome','data_pedido','forma_pagamento','pagamento_status']);
        });
    }
};
