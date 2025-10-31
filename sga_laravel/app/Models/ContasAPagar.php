<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ContasAPagar extends Model
{
    use HasFactory;

    protected $table = 'contas_a_pagar';

    protected $fillable = [
        'fornecedor_id',
        'descricao',
        'valor',
        'data_vencimento',
        'data_pagamento',
        'status',
        'forma_pagamento_id',
        'observacao',
        'data_compra',
        'prazo',
    ];

    public function fornecedor()
{
    return $this->belongsTo(Fornecedor::class);
}

public function formaPagamento()
{
    return $this->belongsTo(FormaDePagamento::class, 'forma_pagamento_id');
}


}
