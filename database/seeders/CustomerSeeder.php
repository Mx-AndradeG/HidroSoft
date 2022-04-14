<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert([
            'name'          => 'José Luis Castañeda',
            'address'       => 'En mi Canton',
            'phone'         => '498198198',
            'rfc'           => 'ALGO1818',
            'email'         => 'elpepe@gmail.mx',
            'social'        => 'Tienas Pepino',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        
        DB::table('customers')->insert([
            'name'          => 'Customer',
            'address'       => 'My house',
            'phone'         => 'Phone',
            'rfc'           => 'RFC',
            'email'         => 'mail@gmail.mx',
            'social'        => 'Tienas Customer',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}