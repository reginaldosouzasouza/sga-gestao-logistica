<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    // Definindo quais campos podem ser preenchidos
    protected $fillable = [
        'telefone',
        'cpf',
        'nome',
        'endereco',
        'numero',
        'bairro',
        'cidade',
        'email',
        'nascimento',
        'observacao',
    ];

    public function movimentacoes()
{
    return $this->hasMany(Movimentacao::class, 'cliente_id');
}

}

