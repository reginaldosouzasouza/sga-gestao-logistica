<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FechamentoCaixa extends Model
{
    protected $table = 'fechamentos_caixa';

    protected $fillable = [
        'data',
        'saldo_inicial',
        'total_entradas',
        'total_saidas',
        'saldo_final',
        'saldo_final_caixa',  // 🔥 ADICIONADO
        'saldo_final_banco',  // 🔥 ADICIONADO
        'observacao'
    ];
}
