<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    // Definindo quais campos podem ser preenchidos
    protected $fillable = [
        'empresa_id',
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

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}