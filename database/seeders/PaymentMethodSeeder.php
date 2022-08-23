<?php

namespace Database\Seeders;

use App\Models\PaymentMethod\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paymenmtMethods = [
            [
                'id'   => 1,
                'name' => 'Efectivo',
            ],
            [
                'id'   => 2,
                'name' => 'Tarjeta',
            ],
            [
                'id'   => 3,
                'name' => 'Credito',
            ]
        ];
        foreach ($paymenmtMethods as $paymentMethod) {
            PaymentMethod::firstOrCreate(['id' => $paymentMethod['id'], 'name' => $paymentMethod['name']]);
        }
    }
}
