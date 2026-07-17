<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimentacaoItem extends Model
{
    use HasFactory;

    // Definir o nome da tabela se necessário (caso não siga a convenção)
    protected $table = 'movimentacao_itens';

    // Definir os campos que podem ser preenchidos via mass assignment
    protected $fillable = [
        'empresa_id',
        'movimentacao_id', 
        'produto_id',
        'quantidade', 
        'valor_unitario', 
        'preco_compra_momento',
        'valor_total'
    ];

    // Relacionamento com a tabela Movimentacao
    public function movimentacao()
    {
        return $this->belongsTo(Movimentacao::class);
    }

    // Relacionamento com a tabela Produto
    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
