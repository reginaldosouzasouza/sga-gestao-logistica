<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Importando os modelos Fornecedor e Produto
use App\Models\Fornecedor;


class Compra extends Model
{
    use HasFactory;

    protected $table = 'compras'; // Certifique-se de que o nome da tabela está correto
    
    protected $fillable = [
        'fornecedor_id',
        'quantidade',
        'preco_unitario',
        'total',
        'nota_fiscal',
        'prazo_id',
        'data_compra',
        'data_vencimento', 
        'data_pagamento',  
        'status', 
        'forma_pagamento_id',
    ];



    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class);
    }
    

   
    public function itensDeCompras()
{
    return $this->hasMany(ItensDeCompras::class, 'compra_id');
}

}



