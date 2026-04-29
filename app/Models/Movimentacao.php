<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MovimentacaoItem;


class Movimentacao extends Model
{
    use HasFactory;

    protected $table = 'movimentacao';

    // Lista de campos que podem ser preenchidos
    protected $fillable = [
        'cliente_id',
        'data_coleta',
        'cpf',
        'nome',
        'endereco',
        'numero',
        'bairro',
        'cidade',
        'observacao',
        'forma_pagamento_id',  // Verifique se este campo está aqui
        'prazo_id',  // Verifique se este campo está aqui
        'valor_total',  // Certifique-se de que este campo está aqui
        'quantidade',  // Adicione aqui se estiver faltando
        'origem_tipo',
        'origem_id',
        'gerar_financeiro'
    ];

    public function itens()
{
    return $this->hasMany(MovimentacaoItem::class, 'movimentacao_id');
}

public function formaPagamento()
{
    return $this->belongsTo(FormaDePagamento::class, 'forma_pagamento_id');
}








}


