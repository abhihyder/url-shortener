<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CountriesTableSeeder::class,
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            PaymentMethodsTableSeeder::class,
            ShortenUrlTableSeeder::class,
        ]);
    }
}
