<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Perfil extends Model
{
    protected $table = 'perfis';

    protected $fillable = [
        'empresa_id',
        'modulo',
        'nome',
        'descricao',
    ];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function permissoes(): BelongsToMany
    {
        return $this->belongsToMany(
            Permissao::class,
            'perfil_permissoes',
            'perfil_id',
            'permissao_id'
        );
    }
}