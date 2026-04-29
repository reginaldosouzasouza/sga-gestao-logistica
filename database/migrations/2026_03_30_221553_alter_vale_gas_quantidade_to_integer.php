<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE vale_gas MODIFY quantidade INT NOT NULL DEFAULT 1');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE vale_gas MODIFY quantidade DECIMAL(10,2) NOT NULL DEFAULT 1');
    }
};