<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfils'; // ajuste se o nome da tabela for outro

    public function permissoes()
    {
        return $this->belongsToMany(
            Permissao::class,
            'perfil_permissao',   // nome da tabela pivô
            'perfil_id',
            'permissao_id'
        );
    }
}