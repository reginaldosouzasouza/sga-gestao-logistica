<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaixaAberto extends Model
{
    protected $table = 'caixas_abertos';

    protected $fillable = [
        'empresa_id',
        'data_caixa',
        'data_abertura',
        'usuario_id',
        'saldo_inicial_caixa',
        'saldo_inicial_banco',
        'status',
    ];

    protected $casts = [
        'data_caixa'    => 'date',
        'data_abertura' => 'datetime',
    ];

        public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}

