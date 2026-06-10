<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaAtendimentoController extends Controller
{
    public function trocar(Request $request)
    {
        $user = auth()->user();

        if (! $user || strtoupper(trim($user->tipo ?? '')) !== 'MASTER') {
            abort(403, 'Acesso não autorizado.');
        }

        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
        ]);

        $empresa = Empresa::findOrFail($request->empresa_id);

        session([
            'empresa_atendimento_id' => $empresa->id,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Empresa em atendimento alterada para: ' . $empresa->nome_fantasia);
    }

    public function limpar()
    {
        $user = auth()->user();

        if (! $user || strtoupper(trim($user->tipo ?? '')) !== 'MASTER') {
            abort(403, 'Acesso não autorizado.');
        }

        session()->forget('empresa_atendimento_id');

        return redirect()
            ->back()
            ->with('success', 'Empresa em atendimento removida.');
    }
}