<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('empresas', function (Blueprint $table) {
            $table
                ->string('modulo', 30)
                ->nullable()
                ->after('nome_fantasia')
                ->index();
        });
    }

    public function down(): void
    {
        Schema::table('empresas', function (Blueprint $table) {
            $table->dropIndex(['modulo']);
            $table->dropColumn('modulo');
        });
    }
};