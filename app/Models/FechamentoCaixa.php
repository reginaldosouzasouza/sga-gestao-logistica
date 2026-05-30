<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FechamentoCaixa extends Model
{
    use HasFactory;

    protected $table = 'fechamentos_caixa';

    protected $fillable = [
        'empresa_id',
        'data',
        'saldo_inicial',
        'total_entradas',
        'total_saidas',
        'saldo_final',
        'saldo_final_caixa',
        'saldo_final_banco',
        'observacao',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}