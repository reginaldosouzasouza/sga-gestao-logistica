<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable = [
        'nome_fantasia',
        'razao_social',
        'cnpj',
        'telefone',
        'email',
        'endereco',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'status',
        'plano',
        'data_inicio_teste',
        'data_vencimento',
    ];

    public function usuarios()
    {
        return $this->hasMany(User::class);
    }
}