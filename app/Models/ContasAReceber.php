<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContasAReceber extends Model
{
    use HasFactory;

    protected $table = 'contas_a_receber';

    protected $fillable = [
        'empresa_id',
        'cliente_id',
        'descricao',
        'valor',
        'data_venda',
        'data_vencimento',
        'data_recebimento',
        'status',
        'forma_pagamento_id',
        'observacao',
        'prazo',
    ];

    // Relacionamento com a tabela de clientes
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relacionamento com a tabela de formas de pagamento
    public function formaPagamento()
    {
        return $this->belongsTo(FormaDePagamento::class, 'forma_pagamento_id');
    }

    public function prazo()
{
    return $this->belongsTo(Prazo::class, 'prazo_id');
}

}
