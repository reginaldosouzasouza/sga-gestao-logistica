<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItensDeCompras extends Model
{
    use HasFactory;

    protected $fillable = [
        'compra_id',
        'produto_id',
        'quantidade',
        'valor_unitario',
        'valor_total',
    ];

    // Relacionamento com o modelo Produto
    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }

    // Relacionamento com o modelo Compra
    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }
}
