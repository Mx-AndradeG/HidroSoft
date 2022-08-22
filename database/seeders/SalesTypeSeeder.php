<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalesTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        DB::table('sale_types')->insert([
            'id'   => 1,
            'name' => 'Contado',
        ]);

        DB::table('sale_types')->insert([
            'id'   => 2,
            'name' => 'Crédito',
        ]);
    }
}
