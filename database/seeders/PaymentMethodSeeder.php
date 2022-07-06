<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_methods')->insert([
            'id'   => 1,
            'name' => 'Efectivo',
        ]);

        DB::table('payment_methods')->insert([
            'id'   => 2,
            'name' => 'Tarjeta',
        ]);
    }
}
