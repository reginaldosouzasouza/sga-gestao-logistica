<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoVasilhame extends Model
{
    use HasFactory;

    protected $table = 'historico_vasilhames';

    protected $fillable = [
        'controle_vasilhame_id',
        'tipo_movimento',
        'quantidade',
        'responsavel',
        'cliente',
        'descricao',
    ];

    public function controle()
    {
        return $this->belongsTo(ControleVasilhame::class, 'controle_vasilhame_id');
    }
}
