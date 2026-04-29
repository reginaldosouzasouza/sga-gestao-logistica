<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Backup extends Model
{
    protected $table = 'backups';

    protected $fillable = [
        'nome_arquivo',
        'caminho_arquivo',
        'tamanho_bytes',
        'tipo_backup',
        'gerado_por',
        'data_geracao',
        'status',
        'observacao',
    ];

    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(User::class, 'gerado_por');
    }
}