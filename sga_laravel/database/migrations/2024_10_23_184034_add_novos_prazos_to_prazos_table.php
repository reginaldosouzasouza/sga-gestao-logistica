<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class AddNovosPrazosToPrazosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('prazos')->insert([
            ['prazo' => '0 dia', 'created_at' => now(), 'updated_at' => now()],
            ['prazo' => '2 dias', 'created_at' => now(), 'updated_at' => now()],
            ['prazo' => '3 dias', 'created_at' => now(), 'updated_at' => now()],
            ['prazo' => '10 dias', 'created_at' => now(), 'updated_at' => now()],
            ['prazo' => '60 dias', 'created_at' => now(), 'updated_at' => now()],
            ['prazo' => '90 dias', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*DB::table('prazos')->whereIn('prazo', [
            '0 dia', '2 dias', '3 dias', '10 dias', '60 dias', '90 dias'
        ])->delete();*/
    }
}
