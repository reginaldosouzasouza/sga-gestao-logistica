<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\PerfilPermissao;





class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'usuario',
        'nome_completo',
        'email',
        'password',
        'tipo',
        'perfil_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


   public function perfil()
{
    return $this->belongsTo(Perfil::class, 'perfil_id');
}


public function temPermissao($nomePermissao)
{
    if (strtoupper($this->tipo ?? '') === 'MASTER') {
        return true;
    }

    if (!$this->perfil_id) {
        return false;
    }

    $mapaPermissoes = [
        'cliente_visualizar'           => 2,
        'cliente_cadastrar'            => 3,
        'cliente_editar'               => 4,
        'cliente_excluir'              => 5,
        'cliente_historico_visualizar' => 6,
    ];

    if (!isset($mapaPermissoes[$nomePermissao])) {
        return false;
    }

    return PerfilPermissao::where('perfil_id', $this->perfil_id)
        ->where('permissao_id', $mapaPermissoes[$nomePermissao])
        ->exists();
}





 /*public function temPermissao($permissao)
{
    $tipo = strtoupper(trim($this->tipo ?? ''));

    if (in_array($tipo, ['ADMIN', 'MASTER'])) {
        return true;
    }

    if (!method_exists($this, 'permissoes')) {
        return false;
    }

    return $this->permissoes()
        ->where('nome', $permissao)
        ->exists();
}*/



}


