<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('perfis', function (Blueprint $table) {
            $table->unsignedBigInteger('empresa_id')
                ->nullable()
                ->index()
                ->after('id');

            $table->string('modulo', 50)
                ->nullable()
                ->index()
                ->after('empresa_id');
        });
    }

    public function down(): void
    {
        Schema::table('perfis', function (Blueprint $table) {
            $table->dropColumn([
                'empresa_id',
                'modulo',
            ]);
        });
    }
};