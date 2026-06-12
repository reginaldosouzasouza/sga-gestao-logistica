<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Perfil;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'empresa_id',
        'usuario',
        'nome_completo',
        'email',
        'password',
        'tipo',
        'perfil_id',

        // Monitor de acessos
        'last_seen_at',
        'last_login_at',
        'last_login_ip',
        'last_user_agent',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'last_seen_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'perfil_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function isMaster(): bool
    {
        return strtoupper(trim($this->tipo ?? '')) === 'MASTER';
    }

    public function temPermissao($nomePermissao): bool
    {
        /*
         * MASTER é o suporte/dono do sistema.
         * Ele pode acessar tudo.
         */
        if ($this->isMaster()) {
            return true;
        }

        /*
         * Se o usuário não tiver perfil, não tem permissão.
         */
        if (!$this->perfil_id) {
            return false;
        }

        /*
         * Busca a permissão pelo nome na tabela permissoes.
         * Assim não precisamos manter mapa fixo no código.
         */
        return DB::table('perfil_permissoes as pp')
            ->join('permissoes as p', 'p.id', '=', 'pp.permissao_id')
            ->where('pp.perfil_id', $this->perfil_id)
            ->where('p.nome', $nomePermissao)
            ->exists();
    }
}
