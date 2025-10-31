<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class OrdemServicoItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'ordem_servico_id',
        'produto_id',
        'quantidade',
        'valor_unitario',
        'valor_total',
        'forma_pagamento_id',
        'prazo_id',
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function formaPagamento()
    {
        return $this->belongsTo(FormaPagamento::class);
    }

    public function prazo()
    {
        return $this->belongsTo(Prazo::class);
    }

    public function ordemServico()
    {
        return $this->belongsTo(OrdemServico::class);
    }

    public function itens()
    {
    return $this->hasMany(OrdemServicoItem::class);
    }

}
