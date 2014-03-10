<?php

class UserSeeder extends DatabaseSeeder {

	public function run() {
		
		$users = array(
			array(
				"username" 	=> "Nightwíng",
				"password" 	=> Hash::make("test"),
				"email" 	=> "test@mail.eu",
				"server"	=> "Ravencrest",
				"thumbnail"	=> "http://eu.battle.net/static-render/eu/ravencrest/98/90745954-avatar.jpg",
				"about"		=> "Rogue assasin",
				"application_active" => true
			),
			array(
				"username" 	=> "Random",
				"password" 	=> Hash::make("test"),
				"email" 	=> "test2@mail.eu",
				"server"	=> "Ravencrest",
				"thumbnail"	=> "http://eu.battle.net/static-render/eu/ravencrest/98/90745954-avatar.jpg",
				"about"		=> "Rogue assasin",
				"application_active" => true
			)
		);

		foreach ($users as $user) {
			User::create($user);
		}
	}
}