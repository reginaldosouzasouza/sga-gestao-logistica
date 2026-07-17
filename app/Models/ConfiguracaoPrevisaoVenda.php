<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracaoPrevisaoVenda extends Model
{
    use HasFactory;

    protected $table = 'configuracao_previsao_vendas';

    protected $fillable = [
        'empresa_id',
        'produto_id',

        'usar_ajuste_fim_mes',
        'dia_inicio_fim_mes',
        'percentual_ajuste_fim_mes',

        'usar_sazonalidade_manual',
        'mes_inicio_sazonalidade',
        'mes_fim_sazonalidade',
        'percentual_ajuste_sazonalidade',

        'estoque_seguranca_dias',
        'base_historica_inicio',
        'ativo',
    ];

    protected $casts = [
        'usar_ajuste_fim_mes' => 'boolean',
        'usar_sazonalidade_manual' => 'boolean',
        'ativo' => 'boolean',

        'percentual_ajuste_fim_mes' => 'decimal:2',
        'percentual_ajuste_sazonalidade' => 'decimal:2',
        'estoque_seguranca_dias' => 'decimal:2',

        'base_historica_inicio' => 'date',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}