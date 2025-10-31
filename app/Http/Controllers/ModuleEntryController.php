<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ModuleEntryController extends Controller
{
    private function go(string $module, string $routeName)
    {
        session(['current_module' => $module]);
        return Auth::check() ? redirect()->route($routeName) : redirect()->route('login');
    }

    public function padaria()   { return $this->go('padaria', 'padaria.home'); }
    public function oficina()   { return $this->go('oficina', 'oficina.home'); }
    public function gas()       { return $this->go('gas', 'gas.home'); }
    public function gerencial() { return $this->go('gerencial', 'gerencial.home'); }
    public function padoca()    { return $this->go('padoca', 'padoca.home'); }

}