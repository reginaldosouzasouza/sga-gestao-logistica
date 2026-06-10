<?php

use App\Models\Empresa;

if (! function_exists('usuarioEhMaster')) {
    function usuarioEhMaster(): bool
    {
        $user = auth()->user();

        return $user && strtoupper(trim($user->tipo ?? '')) === 'MASTER';
    }
}

if (! function_exists('empresaAtualId')) {
    function empresaAtualId(): ?int
    {
        $user = auth()->user();

        if (! $user) {
            return null;
        }

        if (usuarioEhMaster()) {
            return session('empresa_atendimento_id') ?? $user->empresa_id;
        }

        return $user->empresa_id;
    }
}

if (! function_exists('empresaAtual')) {
    function empresaAtual(): ?Empresa
    {
        $empresaId = empresaAtualId();

        if (! $empresaId) {
            return null;
        }

        return Empresa::find($empresaId);
    }
}