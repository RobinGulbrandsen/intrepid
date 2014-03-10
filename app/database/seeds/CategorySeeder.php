<?php

class CategorySeeder extends DatabaseSeeder {

	public function run() {
		$categories = array(
				array(
					"title" 		=> "Officers Room",
					"description"	=> "Private room for officers in the guild",
					"group_id" 		=> 0,
					"guild_rank_required" => 3 
				),
				array(
					"title" 		=> "Off Topic",
					"description"	=> "Open forum, private for members",
					"group_id" 		=> 1,
					"guild_rank_required" => 10
				),
				array(
					"title" 		=> "Strategies",
					"description"	=> "Strategies discussion for PvP and PvE",
					"group_id" 		=> 1,
					"guild_rank_required" => 10
				),
				array(
					"title" 		=> "PvP",
					"description"	=> "The place to discuss all topics related to PvP" ,
					"group_id" 		=> 1,
					"guild_rank_required" => 10
				),
				array(
					"title" 		=> "Tecnical",
					"description"	=> "Suggest new features or report problems / bugs",
					"group_id" 		=> 2,
					"guild_rank_required" => null
				),
				array(
					"title" 		=> "General",
					"description"	=> "Open forum",
					"group_id" 		=> 2,
					"guild_rank_required" => null
				),
			);

		foreach ($categories as $category) {
			Category::create($category);
		}
	}
}