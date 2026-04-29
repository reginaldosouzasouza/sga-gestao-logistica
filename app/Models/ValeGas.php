<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ValeGas extends Model
{
    protected $table = 'vale_gas';

    protected $fillable = [
        'codigo',
        'cliente_id',
        'data_vale',
        'produto_id',
        'quantidade',
        'valor_pago',
        'forma_pagamento_id',
        'status',
        'pedido_coleta_id',
        'data_retirada',
        'observacao',
        'usuario_cadastro_id',
        'usuario_retirada_id',
    ];

    protected $casts = [
        'data_vale' => 'date',
        'data_retirada' => 'datetime',
        'quantidade' => 'integer',
        'valor_pago' => 'decimal:2',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }

    public function formaPagamento()
    {
        return $this->belongsTo(FormaDePagamento::class, 'forma_pagamento_id');
    }

    public function usuarioCadastro()
    {
        return $this->belongsTo(User::class, 'usuario_cadastro_id');
    }

    public function usuarioRetirada()
    {
        return $this->belongsTo(User::class, 'usuario_retirada_id');
    }
}