<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    use HasFactory;

    protected $table = 'veiculos';

    protected $fillable = [
        'empresa_id',
        'motorista_id',
        'descricao',
        'placa',
        'marca',
        'modelo',
        'ano',
        'tipo',
        'combustivel',
        'comissao_tipo',
        'comissao_valor',
        'ativo',
        'observacao',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function motorista()
    {
        return $this->belongsTo(Motorista::class);
    }
}