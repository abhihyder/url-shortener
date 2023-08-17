<?php

namespace Database\Seeders;

use App\Models\Visitor;
use App\Repositories\Facades\ShortenUrlFacade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ShortenUrlTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            $url = ShortenUrlFacade::seed(
                [
                    'name' => $faker->name,
                    'url' => $faker->url,
                    'access_code' => $faker->boolean ? Str::random(6) : null,
                    'expire_date' => $faker->boolean ? date('Y-m-d H:i:s', strtotime('+ ' . rand(1, 5) . ' day')) : '',
                    'user_id' => rand(1, 3),
                    'status' => $faker->boolean
                ]
            );

            if ($url) {
                Visitor::factory()
                    ->shortenUrl($url->id)
                    ->user($url->user_id)
                    ->count(rand(1, 5))
                    ->create();
            }
        }
    }
}
