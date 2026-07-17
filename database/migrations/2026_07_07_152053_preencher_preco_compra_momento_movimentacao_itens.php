<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            UPDATE movimentacao_itens mi
            INNER JOIN produtos p ON p.id = mi.produto_id
            SET mi.preco_compra_momento = p.preco_compra
            WHERE mi.preco_compra_momento IS NULL
        ");
    }

    public function down(): void
    {
        DB::table('movimentacao_itens')
            ->update(['preco_compra_momento' => null]);
    }
};