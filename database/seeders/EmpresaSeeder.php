<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empresa;

class EmpresaSeeder extends Seeder
{
    public function run(): void
    {
        Empresa::firstOrCreate(
            ['cnpj' => '24.388.525/0001-04'],
            [
                'nome_fantasia' => 'MARIGÁS COMÉRCIO DE ÁGUA E GÁS',
                'razao_social' => 'MARIGÁS COMÉRCIO DE ÁGUA E GÁS',
                'telefone' => null,
                'email' => null,
                'cidade' => 'Maringá',
                'estado' => 'PR',
                'status' => 'ativo',
                'plano' => 'completo',
                'data_inicio_teste' => now()->toDateString(),
                'data_vencimento' => null,
            ]
        );
    }
}