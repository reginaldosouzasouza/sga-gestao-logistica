<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('padaria')->create('pad_encomenda_status_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('encomenda_id')->index();
            $table->string('status_anterior', 30)->nullable();
            $table->string('status_novo', 30);
            $table->unsignedBigInteger('user_id')->nullable(); // se tiver auth
            $table->text('observacao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('padaria')->dropIfExists('pad_encomenda_status_logs');
    }
};
