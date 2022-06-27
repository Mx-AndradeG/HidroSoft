<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoryMovementTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('inventory_movement_types')->insert([
            'id'   => 1,
            'name' => 'Entrada',
        ]);

        DB::table('inventory_movement_types')->insert([
            'id'   => 2,
            'name' => 'Salida',
        ]);

        DB::table('inventory_movement_types')->insert([
            'id'   => 3,
            'name' => 'Movimiento entre almacenes',
        ]);
    }
}
