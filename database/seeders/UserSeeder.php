<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'MASTER',
            'email' => 'master@sistema.com',
            'password' => Hash::make('senha_super_secreta'),
            'tipo' => 'MASTER',
        ]);
    }
}
