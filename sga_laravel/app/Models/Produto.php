<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    // Definir os campos que podem ser preenchidos em massa
    protected $fillable = [
        'nome',
        'descricao',
        'preco_compra',
        'preco_venda',
        'quantidade_estoque',
        'unidade_de_medida',
        'estoque_minimo',
        'codigo_barras' 
    ];

    /**
     * Método para calcular o valor total do estoque
     */
    public function valorTotalEstoque()
    {
        return $this->preco_compra * $this->quantidade_estoque;
    }

    /**
     * Relacionamento com a tabela 'movimentacoes_itens'
     * (se você tiver uma tabela de itens relacionados a movimentações)
     */
    public function movimentacoesItens()
    {
        return $this->hasMany(MovimentacaoItem::class);
    }
}

