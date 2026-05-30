<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;

    protected $table = 'fornecedores';

    protected $fillable = [
        'empresa_id',
        'cnpj',
        'nome',
        'endereco',
        'telefone',
        'cidade',
        'email',
        'observacao',
        'natureza_financeira',
        'natureza_financeira_id',
    ];

    public function naturezaFinanceira()
    {
        return $this->belongsTo(NaturezaFinanceira::class, 'natureza_financeira_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}