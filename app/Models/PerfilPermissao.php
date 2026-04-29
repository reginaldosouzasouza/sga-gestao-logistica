<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerfilPermissao extends Model
{
    protected $table = 'perfil_permissoes';

    public $timestamps = false;

    protected $fillable = [
        'perfil_id',
        'permissao_id',
    ];
}