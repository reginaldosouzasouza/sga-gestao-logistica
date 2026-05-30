<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContasAPagar extends Model
{
    use HasFactory;

    protected $table = 'contas_a_pagar';

    protected $fillable = [
        'empresa_id',
        'compra_id',
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
        'parcela',
        'total_parcelas',
        'origem_importacao',
        'data_importacao',
        'usuario_importacao',
        'hash_importacao',
    ];

    protected $casts = [
        'data_compra'      => 'date',
        'data_vencimento'  => 'date',
        'data_pagamento'   => 'date',
        'data_importacao'  => 'datetime',
        'valor'            => 'decimal:2',
    ];

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class);
    }

    public function formaPagamento()
    {
        return $this->belongsTo(FormaDePagamento::class, 'forma_pagamento_id');
    }

    public function empresa()
{
    return $this->belongsTo(Empresa::class);
}
}
