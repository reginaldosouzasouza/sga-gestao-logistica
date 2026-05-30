<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    // Definir os campos que podem ser preenchidos em massa
    protected $fillable = [
        'empresa_id',
        'nome',
        'descricao',
        'preco_compra',
        'preco_venda',
        'quantidade_estoque',
        'unidade_de_medida',
        'estoque_minimo',
        'codigo_barras',
        'modulo_id',
        'margem_percentual',
        'margem_valor',
    ];

    /**
     * Método para calcular o valor total do estoque
     */
    public function valorTotalEstoque()
    {
        return $this->preco_compra * $this->quantidade_estoque;
    }

    /**
     * Relacionamento com a tabela 'movimentacao_itens'
     */
    public function movimentacoesItens()
    {
        return $this->hasMany(MovimentacaoItem::class);
    }

    public function modulo()
    {
        return $this->belongsTo(Modulo::class, 'modulo_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}