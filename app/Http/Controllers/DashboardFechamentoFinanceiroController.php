<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DashboardFinanceiroService;

class DashboardFechamentoFinanceiroController extends Controller
{
    public function __construct(
        private DashboardFinanceiroService $dashboardFinanceiroService
    ) {
    }

    public function index(Request $request)
    {
        $dados = $this->dashboardFinanceiroService->getDashboardData(
            $request->input('data_inicio'),
            $request->input('data_fim')
        );

        return view('dashboard.fechamento-financeiro', compact('dados'));
    }
}