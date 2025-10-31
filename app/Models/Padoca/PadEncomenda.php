<?php

namespace App\Models\Padoca;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PadEncomenda extends Model
{
    // 👉 usa o banco "padaria"
    protected $connection = 'padaria';
    protected $table = 'pad_encomendas';

    public const STATUS = ['Aberto','Produção','Pronto','Entregue','Cancelado'];

    protected $fillable = [
        'cliente_id',
        'cliente_codigo',
        'nome',
        'data_pedido',
        'data_encomenda',
        'data_retirada',
        'hora_retirada',
        'status',
        'forma_pagamento',
        'pagamento_status',
        'sinal',
        'valor_total',
        'canal',
        'observacao',
    ];

    protected $casts = [
        'data_pedido'    => 'date',
        'data_encomenda' => 'date',
        'data_retirada'  => 'date',
        'valor_total'    => 'decimal:2',
        'sinal'          => 'decimal:2',
    ];

    public function itens(): HasMany
    {
        return $this->hasMany(PadEncomendaItem::class, 'encomenda_id');
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(PadEncomendaStatusLog::class, 'encomenda_id');
    }
}

