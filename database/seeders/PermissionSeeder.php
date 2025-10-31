<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // se seu guard é o padrão 'web', não precisa passar guard_name
        $perms = ['acesso_padaria','acesso_oficina','acesso_gas','acesso_gerencial'];

        foreach ($perms as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $admin->givePermissionTo($perms);

        $atendentePadaria = Role::firstOrCreate(['name' => 'Atendente Padaria']);
        $atendentePadaria->givePermissionTo(['acesso_padaria']);
    }
}
