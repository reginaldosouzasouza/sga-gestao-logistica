<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('padaria')->table('pad_encomendas', function (Blueprint $table) {
            $table->unsignedBigInteger('cliente_codigo')->nullable()->after('cliente_id')->index();
        });
    }

    public function down(): void
    {
        Schema::connection('padaria')->table('pad_encomendas', function (Blueprint $table) {
            $table->dropColumn('cliente_codigo');
        });
    }
};
