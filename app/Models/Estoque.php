<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    protected $fillable = [
        'produto_id',
        'quantidade',
        'tipo_movimentacao',
        'origem',
        'data_movimentacao',
    ];

    // Definir o relacionamento com Produto
    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }
}

