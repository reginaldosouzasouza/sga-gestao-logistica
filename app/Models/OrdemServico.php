<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdemServico extends Model
{
    use HasFactory;

    // app/Models/OrdemServico.php
    protected static function booted()
    {
        static::addGlobalScope('order', function ($q) {
            $q->orderByDesc('id');
        });
    }


    protected $table = 'ordens_servico';

    protected $fillable = [
    'cliente',
    'veiculo',
    'placa',
    'marca',
    'modelo',
    'mecanico',
    'km',
    'servico_realizado',
    'valor',
    'status',
    'observacoes',
    'descricao_pecas',
    'data_prevista_entrega',
    'data_lancamento',
    'created_at',
    'updated_at',
];

protected $casts = [
    'valor' => 'decimal:2',
];

}
