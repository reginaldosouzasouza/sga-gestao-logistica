<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteProdutoDuracao extends Model
{
    protected $table = 'cliente_produto_duracao';

    protected $fillable = [
        'cliente_id',
        'produto_id',
        'duracao',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function duracaoProdutos()
    {
    return $this->hasMany(ClienteProdutoDuracao::class);
    }

    public function duracaoGas()
    {
    return $this->hasOne(ClienteProdutoDuracao::class)
                ->where('produto_id', 2); // id 2 = GAS P-13
    }
}