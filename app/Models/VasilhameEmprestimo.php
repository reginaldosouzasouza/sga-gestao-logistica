<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VasilhameEmprestimo extends Model
{
    protected $table = 'vasilhame_emprestimos';

    protected $fillable = [
        'empresa_id',
        'cliente',
        'produto',
        'quantidade',
        'data_saida',
        'data_previsao_devolucao',
        'data_devolucao',
        'status',
        'user_id',
    ];

    protected $casts = [
        'data_saida'              => 'date',
        'data_previsao_devolucao' => 'date',
        'data_devolucao'          => 'date',
    ];

    // Vasilhames ainda não devolvidos
    public function scopePendentes($query)
    {
        return $query->where('status', 'pendente');
    }

    // Vasilhames já devolvidos
    public function scopeDevolvidos($query)
    {
        return $query->where('status', 'devolvido');
    }

    public function empresa()
{
    return $this->belongsTo(Empresa::class);
}
}