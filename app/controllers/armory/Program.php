<?php

$GLOBALS['wowarmory']['db']['driver'] = 'mysql';
$GLOBALS['wowarmory']['db']['hostname'] = '127.0.0.1'; 
$GLOBALS['wowarmory']['db']['dbname'] = 'armory';
$GLOBALS['wowarmory']['db']['username'] = 'root';
$GLOBALS['wowarmory']['db']['password'] = '';
// Only use the two below if you have received API keys from Blizzard.
$GLOBALS['wowarmory']['keys']['private'] = ''; // if you have an API key from Blizzard
$GLOBALS['wowarmory']['keys']['public'] = ''; // if you have an API key from Blizzard
include('BattlenetArmory.class.php'); //include the main class 

$armory = new BattlenetArmory('EU', 'Ravencrest');

$armory->setLocale('en_GB');

// To exclude some fields from characters to load.
$armory->characterExcludeFields(array('achievements','quests')); 
// To reset the exclude list to not exclude anymore
$armory->characterExcludeFields(FALSE); 

// Load all the guild data into an object. This is NOT an array 
$guild = $armory->getGuild('Intrepid Gaming'); 

// Load all the character data into an object. This is NOT an array 
$character = $armory->getCharacter('Tyekx'); 

echo json_encode($character->getData());