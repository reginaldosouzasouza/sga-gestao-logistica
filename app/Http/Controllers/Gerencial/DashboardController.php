<?php

namespace App\Http\Controllers\Gerencial;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        return view('gerencial.dashboard.index');
    }

    public function data(Request $request)
    {
        $data = $request->query('data', now()->toDateString());

        $pythonUrl = "http://127.0.0.1:5000/gerencial/dashboard?data={$data}";

        $resp = Http::timeout(5)->get($pythonUrl);

        if (!$resp->successful()) {
            return response()->json([
                'error' => 'Falha ao consultar API Python',
                'status' => $resp->status()
            ], 500);
        }

        return response()->json($resp->json());
    }
}
