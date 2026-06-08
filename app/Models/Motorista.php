<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motorista extends Model
{
    use HasFactory;

    protected $table = 'motoristas';

    protected $fillable = [
        'empresa_id',
        'nome',
        'telefone',
        'cpf',
        'cnh',
        'categoria_cnh',
        'validade_cnh',
        'endereco',
        'numero',
        'bairro',
        'cidade',
        'observacao',
        'ativo',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}