<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControleVasilhame extends Model
{
    use HasFactory;

    protected $table = 'controle_vasilhames';

    protected $fillable = [
        'empresa_id',
        'data_referencia',
        'total_vasilhames',
        'cheios',
        'vazios',
        'emprestados',
        'vendidos',
        'retornaram',
        'observacao',
    ];

    protected $casts = [
        'data_referencia' => 'date',
    ];

    public function historicos()
    {
        return $this->hasMany(HistoricoVasilhame::class);
    }

    public function getTotalEstoqueAttribute(): int
    {
        return $this->cheios + $this->vazios;
    }

    public function getTotalSobControleAttribute(): int
    {
        return $this->cheios + $this->vazios + $this->emprestados;
    }

    public function getDiferencaAttribute(): int
    {
        return $this->total_vasilhames - $this->total_sob_controle;
    }

    public function getStatusConferenciaAttribute(): string
    {
        return $this->diferenca === 0 ? 'ESTOQUE COMPLETO' : 'DIVERGENTE';
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}