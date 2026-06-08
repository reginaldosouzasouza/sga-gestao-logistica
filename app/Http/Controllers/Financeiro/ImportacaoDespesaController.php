<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Http\Requests\Financeiro\ImportarDespesaExcelRequest;
use App\Services\Financeiro\ImportacaoDespesaExcelService;

class ImportacaoDespesaController extends Controller
{
    public function index()
    {
        return view('financeiro.contas_pagar.importar_despesas');
    }

  public function importar(
    ImportarDespesaExcelRequest $request,
    ImportacaoDespesaExcelService $service
) {
    try {
        $empresaId = auth()->user()->empresa_id ?? session('empresa_id');

        if (!$empresaId) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Empresa não identificada para o usuário logado.');
        }

        $resultado = $service->importar(
            $request->file('arquivo')->getRealPath(),
            $empresaId
        );

        return redirect()
            ->back()
            ->with('success', 'Importação realizada com sucesso.')
            ->with('resultado_importacao', $resultado);

    } catch (\Throwable $e) {
        return redirect()
            ->back()
            ->withInput()
            ->with('error', $e->getMessage());
    }
}
}