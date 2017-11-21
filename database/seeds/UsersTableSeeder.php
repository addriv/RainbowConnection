<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker; // Faker for generating random names

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Declare variables
		$numUsers = 100;

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

		// Generate user records
		for ($i=0; $i < $numUsers; $i++){
			DB::table('users')->insert([
				'first_name' => $faker->firstName,
				'last_name' => $faker->lastName,
				'favorite_color' => $colors[rand(0, 11)]
			]);
		}
	}
}
