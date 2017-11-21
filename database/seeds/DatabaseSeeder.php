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
		DB::statement('TRUNCATE users, user_connections RESTART IDENTITY;');

		// Call seeders
		$this->call('UsersTableSeeder');
		$this->call('UserConnectionsTableSeeder');
	}
}
