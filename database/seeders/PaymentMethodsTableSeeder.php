<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::truncate();

        PaymentMethod::insert([
            [
                'name' => 'PayPal',
            ],
            [
                'name' => 'Perfect Money',
            ],
            [
                'name' => 'Bank Transfer',
            ],
            [
                'name' => 'OVO',
            ],
            [
                'name' => 'DANA',
            ],
            [
                'name' => 'Gopay',
            ]
        ]);
    }
}
