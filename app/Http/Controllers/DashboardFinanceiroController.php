<?php

namespace App\Http\Controllers;

use App\Services\DashboardFinanceiroService;

class DashboardFinanceiroController extends Controller
{
    public function __construct(
        private DashboardFinanceiroService $dashboardFinanceiroService
    ) {
    }

    public function index()
    {
        $dados = $this->dashboardFinanceiroService->getDashboardData();

        return view('dashboard.financeiro', compact('dados'));
    }
}