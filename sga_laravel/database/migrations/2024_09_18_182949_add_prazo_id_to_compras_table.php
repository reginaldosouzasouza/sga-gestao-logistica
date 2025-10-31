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
        Schema::table('compras', function (Blueprint $table) {
            $table->unsignedBigInteger('prazo_id')->nullable(); // Adiciona o campo prazo_id
            $table->foreign('prazo_id')->references('id')->on('prazos'); // Define a relação
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compras', function (Blueprint $table) {
            //
        });
    }
};
