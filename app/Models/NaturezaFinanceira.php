<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NaturezaFinanceira extends Model
{
    protected $table = 'naturezas_financeiras';

   protected $fillable = [
    'nome',
    'ativo',
    'exibir_relatorio',
    'considerar_total',
];

protected $casts = [
    'ativo' => 'boolean',
    'exibir_relatorio' => 'boolean',
    'considerar_total' => 'boolean',
];

      

}