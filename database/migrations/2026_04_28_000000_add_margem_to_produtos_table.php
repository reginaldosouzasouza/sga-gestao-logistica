<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adiciona colunas de margem de lucro na tabela de produtos.
     */
    public function up(): void
    {
        Schema::table('produtos', function (Blueprint $table) {

            // % de margem aplicado sobre o preço de compra (Markup)
            // Exemplo: se preço compra = 9.50 e venda = 19.00, margem_percentual = 100.00
            $table->decimal('margem_percentual', 8, 2)
                  ->default(0.00)
                  ->after('preco_venda')
                  ->comment('Percentual de margem aplicado sobre o preço de compra');

            // Valor em R$ da margem (preço venda - preço compra)
            // Exemplo: 19.00 - 9.50 = 9.50
            $table->decimal('margem_valor', 10, 2)
                  ->default(0.00)
                  ->after('margem_percentual')
                  ->comment('Valor em reais da margem de lucro');
        });
    }

    /**
     * Reverse the migrations.
     * Remove as colunas de margem caso precise reverter.
     */
    public function down(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropColumn(['margem_percentual', 'margem_valor']);
        });
    }
};