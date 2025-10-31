<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PrazoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('prazos')->insert([
            ['prazo' => '1 dia'],
            ['prazo' => '15 dias'],
            ['prazo' => '20 dias'],
            ['prazo' => '30 dias'],
        ]);
    }
    
}
