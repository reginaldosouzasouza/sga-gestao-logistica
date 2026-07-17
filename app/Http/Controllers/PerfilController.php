<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            $usuario = auth()->user();

            if (
                !$usuario
                || !in_array(
                    strtoupper($usuario->tipo ?? ''),
                    ['MASTER', 'ADMIN'],
                    true
                )
            ) {
                return redirect()
                    ->route('sga')
                    ->with('error', 'Acesso não autorizado.');
            }

            return $next($request);
        });
    }

    public function permissoes($perfil_id)
    {
        $perfil = DB::table('perfis')
            ->where('id', $perfil_id)
            ->first();

        if (!$perfil) {
            abort(404, 'Perfil não encontrado.');
        }

        $permissoes = DB::table('permissoes')
            ->orderBy('modulo')
            ->orderBy('descricao')
            ->get();

        $permissoesPerfil = DB::table('perfil_permissoes')
            ->where('perfil_id', $perfil_id)
            ->pluck('permissao_id')
            ->map(fn ($id) => (int) $id)
            ->toArray();

        return view(
            'perfis.permissoes',
            compact(
                'perfil',
                'permissoes',
                'permissoesPerfil'
            )
        );
    }

    public function salvarPermissoes(
        Request $request,
        $perfil_id
    ) {
        $perfilExiste = DB::table('perfis')
            ->where('id', $perfil_id)
            ->exists();

        if (!$perfilExiste) {
            abort(404, 'Perfil não encontrado.');
        }

        $dados = $request->validate([
            'permissoes' => ['nullable', 'array'],
            'permissoes.*' => [
                'integer',
                'exists:permissoes,id',
            ],
        ]);

        DB::transaction(function () use ($dados, $perfil_id) {
            DB::table('perfil_permissoes')
                ->where('perfil_id', $perfil_id)
                ->delete();

            $permissoes = array_unique(
                $dados['permissoes'] ?? []
            );

            foreach ($permissoes as $permissaoId) {
                DB::table('perfil_permissoes')->insert([
                    'perfil_id' => $perfil_id,
                    'permissao_id' => $permissaoId,
                ]);
            }
        });

        return redirect()
            ->back()
            ->with(
                'success',
                'Permissões atualizadas com sucesso.'
            );
    }
}