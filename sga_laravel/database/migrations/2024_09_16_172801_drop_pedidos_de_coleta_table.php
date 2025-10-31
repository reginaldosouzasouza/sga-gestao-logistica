<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    // Desabilitar verificações de chave estrangeira
    Schema::disableForeignKeyConstraints();

    // Deletar a tabela
    Schema::dropIfExists('pedidos_de_coleta');

    // Habilitar novamente as verificações de chave estrangeira
    Schema::enableForeignKeyConstraints();
}



};
