<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntregaRastreio extends Model
{
    protected $table = 'entrega_rastreios';

    protected $fillable = [
        'empresa_id',
        'movimentacao_id',
        'cliente_id',
        'codigo_rastreio',
        'link_rastreio',
        'link_whatsapp',
        'status',
    ];
}