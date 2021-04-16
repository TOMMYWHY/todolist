<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		//
		DB::table( 'users' )->insert( [
			'id'       => \Ramsey\Uuid\Uuid::uuid4()->toString(),
			'name'     => "tester",
			'email'    => "testing@test.com",
			'password' => bcrypt( '123456789' ),
		] );
	}
}
