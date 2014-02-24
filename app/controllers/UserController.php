<?php

class UserController extends BaseController {

	private $region = "eu";
	private $guildName = "intrepid gaming";

	public function postLogin() {

		//Validating
		$username = Input::get("username");
		$password = Input::get("password");

		if(is_null($username) || is_null($password)) {
			App::abort(400, "Missing username or password");
		}

		if(Auth::attempt(array('username' => $username, 'password' => $password), true)) {
			$user = User::where('username', '=', $username)->first();

			$armory = new ArmoryController();
			$character = $armory->getAuthenticatedUser($user->server, $username);
			
			//Search for characters guild rank
			$guildRank = null;
			if($character['guild']['name'] != null && 
				$character['guild']['name'] === $this->guildName) {
				
				//Character is in the guild - searching for guild rank
				$guild = $armory->getGuild($this->guildName); 
	    		$guildMembers = $guild->getMembers();
	    		foreach ($guildMembers as $member) {
	    			if($member["character"]["name"] === $username) {
	    				$guildRank = $member["rank"];
	    				break;
	    			}
	    		}
			}

			Session::put('guildRank', $guildRank);
			
			return array(
					'username' 	=> $username,
					'email'		=> $user->email,
					'server'	=> $character['realm'],//$character['realm'],
					'thumbnail' => 'http://' . $this->region . '.battle.net/static-render/' . $this->region . '/' . $character['thumbnail'],
					'rbg'		=> $character['pvp']['brackets']['ARENA_BRACKET_RBG']['rating'],
					'guild'		=> $character['guild']['name'],
					'guildRank'	=> $guildRank
			);
		} else {
			App::abort(401); //Unauthorized
		}
	}

	public function postRegister() {
		$username 	= Input::get("username");
		$password 	= Input::get("password");
		$email		= Input::get("email");
		$server 	= Input::get("server");
		$about		= Input::get("about");

		//Validate input
		if(is_null($username) || is_null($password) || is_null($email) || is_null($server)) {
			App::abort(400, "Fill inn all fields"); //Bad request
		}

		$armoryController = new ArmoryController();
		//Autenticate throws exception on apropriate locations to return 404 if not found
		if($armoryController->authenticate($server, $username)) {
			$user = new User;
			$user->username = $username;
			$user->password = Hash::make($password);
			$user->email 	= $email;
			$user->server 	= $server;
			$user->about 	= $about;
			try {
				$user->save();	
			} catch(Exception $e) {
				App::abort(400, 'Character is alredy registered, contact admins');
			}
			
		}
	}

	public function postLogout() {
		Auth::logout();
	}

	public function getUsers() {
		if(Auth::check()) {
			return User::all();	
		} else {
			return "Not logged in!";
		}
	}

	public function getUser($id) {
		return User::find($id);
	}
}