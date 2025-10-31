<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('padaria')->table('pad_encomenda_itens', function (Blueprint $table) {
            $table->decimal('adiantamento', 12, 2)->default(0)->after('valor_unitario');
        });
    }

    public function down(): void
    {
        Schema::connection('padaria')->table('pad_encomenda_itens', function (Blueprint $table) {
            $table->dropColumn('adiantamento');
        });
    }
};
