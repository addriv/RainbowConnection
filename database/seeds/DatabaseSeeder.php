<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker; // Faker for generating random names

class DatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// use the factory to create a Faker\Generator instance
		$faker = Faker::create();

		// Favorite color choices
		$colors = [
			// Primary
			'red',
			'yellow',
			'blue',
			// Secondary
			'green',
			'orange',
			'violet',
			// Tertiary
			'red-orange',
			'red-violet',
			'yellow-orange', 
			'yellow-green', 
			'blue-green', 
			'blue-violet', 
		];

		for ($i=0; $i < 50; $i++){
			DB::table('users')->insert([
				'first_name' => $faker->firstName,
				'last_name' => $faker->lastName,
				'favorite_color' => $colors[rand(0, 11)]
			]);
		}
	}
}
