<?php

namespace App\Models\Padoca;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PadEncomendaItem extends Model
{
    protected $connection = 'padaria';
    protected $table = 'pad_encomenda_itens';

    protected $fillable = [
        'encomenda_id',
        'produto_id',       // opcional (não usado, deixei por compatibilidade)
        'produto_nome',
        'quantidade',
        'valor_unitario',
        'adiantamento',
        'valor_total',
        'tamanho',
        'sabor',
        'personalizacao',
    ];

    protected $casts = [
        'quantidade'     => 'decimal:3',
        'valor_unitario' => 'decimal:2',
        'adiantamento'   => 'decimal:2',
        'valor_total'    => 'decimal:2',
    ];

    public function encomenda(): BelongsTo
    {
        return $this->belongsTo(PadEncomenda::class, 'encomenda_id');
    }
}
