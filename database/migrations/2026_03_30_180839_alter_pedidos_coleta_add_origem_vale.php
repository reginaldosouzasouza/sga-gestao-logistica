<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('movimentacao', function (Blueprint $table) {
            $table->string('origem_tipo', 30)->nullable()->after('id');
            $table->unsignedBigInteger('origem_id')->nullable()->after('origem_tipo');
            $table->boolean('gerar_financeiro')->default(true)->after('origem_id');
        });
    }

    public function down(): void
    {
        Schema::table('movimentacao', function (Blueprint $table) {
            $table->dropColumn([
                'origem_tipo',
                'origem_id',
                'gerar_financeiro',
            ]);
        });
    }
};