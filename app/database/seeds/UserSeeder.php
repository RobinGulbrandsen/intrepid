<?php

class UserSeeder extends DatabaseSeeder {

	public function run() {
		
		$users = array(
			array(
				"username" 	=> "Nightwíng",
				"password" 	=> Hash::make("test"),
				"email" 	=> "test@mail.eu",
				"server"	=> "Ravencrest",
				"about"		=> "Rogue assasin",
				"application_active" => true
			)
		);

		foreach ($users as $user) {
			User::create($user);
		}
	}
}