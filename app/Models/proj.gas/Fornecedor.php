<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model

{
    use HasFactory;
   
    
    protected $table = 'fornecedores'; // Adicione esta linha para definir explicitamente o nome da tabela

    // Restante do código...



    
    protected $fillable = [
        'cnpj',
        'nome',
        'endereco',
        'telefone',
        'email',
        'cidade',
        'observacao',
    ];
}
