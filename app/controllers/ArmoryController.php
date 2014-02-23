<?php

// Only use the two below if you have received API keys from Blizzard.
$GLOBALS['wowarmory']['keys']['private'] = ''; // if you have an API key from Blizzard
$GLOBALS['wowarmory']['keys']['public'] = ''; // if you have an API key from Blizzard

include('armory/BattlenetArmory.class.php'); //include the main class 

class ArmoryController extends BaseController {

	private $region = 'eu';
	private $server = 'Ravencrest';
	private $guildName = 'intrepid gaming';
	private $language = 'en_GB';

	public function getGuildMembers() {
		//Gets the data from the armory
		$armory = new BattlenetArmory($this->region,$this->server);
	    $armory->setLocale($this->language);
	    
	    $guild = $armory->getGuild($this->guildName); 
	    $guildMembers = $guild->getMembers();

	    $memberArray = array();
	    foreach ($guildMembers as $member) {
	    	$characterDAO = new CharacterDAO;

	    	$characterDAO->name = 	$member['character']['name'];
	    	$characterDAO->class = 	$this->translateClass($member['character']['class']);
			$characterDAO->race = 	$this->translateRace($member['character']['race']);
			$characterDAO->level = 	$member['character']['level'];
			$characterDAO->thumbnail = 'http://' . $this->region . '.battle.net/static-render/' . $this->region . '/' . $member['character']['thumbnail'];
			$characterDAO->guildRank = $member['rank'];

			array_push($memberArray, $characterDAO);
	    }

	    return json_encode($memberArray);
	}

	/*
		Checks if the character exsits, and that it does not have chest and weapon
	*/
	public function authenticate($server, $username) {
		$armory = new BattlenetArmory($this->region,$server);
	    $armory->setLocale($this->language);

	    //gets character
		$character = $armory->getCharacter($username);

		//gets the characters gear
		$gear = $character->getGear();

		if(is_null($gear)) {
			App::abort(400, 'Could not find ' . $username . ' on ' . $server);
		}

		$chest = false;
		$weapon = false;
		//check if json contains chest 
		try {
			$chest = $gear['chest'];
		} catch(Exception $e) {
		}
		//check if json contains main hand weapon
		try {
			$weapon = $gear['mainHand'];
		} catch(Exception $e) {
		}

		if($chest == false && $weapon == false) {
			return true;
		}
		App::abort(400, "Unequip chest and weapons");
	}

	/*
		Returns the spesific guild to see if character is in it, and what rank he got
	*/
	public function getGuild($guildName) {
		$armory = new BattlenetArmory($this->region,$this->server);
	    $armory->setLocale($this->language);
	    return $armory->getGuild($guildName); 
	}

	/*
		When a loginform is accepted, the current characters information is collected
	*/
	public function getAuthenticatedUser($server, $id) {
		$armory = new BattlenetArmory($this->region, $server);
		$armory->setLocale($this->language);

		$character = $armory->getCharacter($id);
		return $character->getData();
	}

	public function getCharacter($server, $id) {
		$armory = new BattlenetArmory($this->region, $server);
	    $armory->setLocale($this->language);
		
		$character = $armory->getCharacter($id);
		return json_encode($character->getData());
	}

	public function translateClass($classId) {
		if($classId == 1) {
			return 'Warrior';
		} elseif ($classId == 2) {
			return 'Paladin';
		} elseif ($classId == 3) {
			return 'Hunter';
		} elseif ($classId == 4) {
			return 'Rogue';
		} elseif ($classId == 5) {
			return 'Priest';
		} elseif ($classId == 6) {
			return 'Death Knight';
		} elseif ($classId == 7) {
			return 'Shaman';
		} elseif ($classId == 8) {
			return 'Mage';
		} elseif ($classId == 9) {
			return 'Warlock';
		} elseif ($classId == 10) {
			return 'Monk';
		} elseif ($classId == 11) {
			return 'Druid';
		} elseif ($classId == 25) {
			return 'Pandaren';
		}
		return $classId;
	}

	public function translateRace($raceId) {
		if($raceId == 1) {
			return 'Human';
		} elseif ($raceId == 2) {
			return 'Orc';
		} elseif ($raceId == 3) {
			return 'Dwarf';
		} elseif ($raceId == 4) {
			return 'Night Elf';
		} elseif ($raceId == 5) {
			return 'Undead';
		} elseif ($raceId == 6) {
			return 'Tauren';
		} elseif ($raceId == 7) {
			return 'Gnome';
		} elseif ($raceId == 8) {
			return 'Troll';
		} elseif ($raceId == 9) {
			return $raceId;
		} elseif ($raceId == 10) {
			return 'Blood Elf';
		}elseif ($raceId == 11) {
			return 'Draenei';
		} elseif ($raceId == 22) {
			return 'Worgen';
		}
		return $raceId;
	}
}

class CharacterDAO {
	public $name;
	public $class;
	public $race;
	public $level;
	public $thumbnail;
	public $guild;
	public $guildRank;
}