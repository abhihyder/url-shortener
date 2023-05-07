<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		Country::truncate();
		$countries = array();
		$countries[] = [
			'name' => 'Worldwide Deal (All Countries)',
			'country_code' => 'WWD'
		];
		
		$jsonString = json_decode(file_get_contents(public_path('assets/json/countries.json')));

		foreach ($jsonString as $country) {
			$countries[] = [
				'name' => $country->name,
				'country_code' => $country->iso2
			];
		}

		Country::insert($countries);
    }
}
