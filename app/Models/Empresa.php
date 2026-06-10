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

    // Controle atual da empresa
    'status',
    'ativo',

    // Controle SaaS
    'plano',
    'status_assinatura',
    'data_inicio_teste',
    'data_fim_teste',
    'data_vencimento',
    'bloqueada',
    'motivo_bloqueio',
    'limite_usuarios',
    'limite_clientes',


    ];

    protected $casts = [
    'data_inicio_teste' => 'date',
    'data_fim_teste' => 'date',
    'data_vencimento' => 'date',
    'bloqueada' => 'boolean',
    'ativo' => 'boolean',
    ];
    

    public function usuarios()
    {
        return $this->hasMany(User::class);
    }
}