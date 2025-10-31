<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;

    protected $table = 'fornecedores'; // Nome correto da tabela no banco 'gas'

    

    protected $fillable = [
        'cnpj',
        'nome',
        'endereco',
        'telefone',
        'cidade',
        'email',
        'observacao'
    ];
}

