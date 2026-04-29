<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('naturezas_financeiras', function (Blueprint $table) {
        $table->boolean('exibir_relatorio')->default(true);
        $table->boolean('considerar_total')->default(true);
    });
}

public function down(): void
{
    Schema::table('naturezas_financeiras', function (Blueprint $table) {
        $table->dropColumn(['exibir_relatorio', 'considerar_total']);
    });
}
};
