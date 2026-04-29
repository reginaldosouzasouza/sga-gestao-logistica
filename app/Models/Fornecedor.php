<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NaturezaFinanceira;

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
        'observacao',
        'natureza_financeira',
        'natureza_financeira_id'
        
    ];

    
        public function naturezaFinanceira()
        {
            return $this->belongsTo(NaturezaFinanceira::class, 'natureza_financeira_id');
        }
}

