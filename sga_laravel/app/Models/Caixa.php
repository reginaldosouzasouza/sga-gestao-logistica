<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caixa extends Model
{
    use HasFactory;

    protected $table = 'caixa';

    protected $fillable = [
        'data_abertura',
        'saldo_inicial',
        'data_fechamento',
        'saldo_final',
        'status',
        'usuario_id',
    ];

    public function movimentacoes()
    {
        return $this->hasMany(CaixaMovimentacao::class, 'caixa_id');
    }
}
