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
    Schema::create('prazos', function (Blueprint $table) {
        $table->id();
        $table->string('prazo'); // Campo para armazenar o nome ou descrição do prazo
        $table->timestamps();
    });
}

};
