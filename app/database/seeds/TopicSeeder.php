<?php

class TopicSeeder extends DatabaseSeeder {

	public function run() {
		$topics = array(
				array(
					"title" 	=> "Officer topic",
					"content" 	=> "Disucssion on futher development of the guild",
					"category_id"=> 1,
					"user_id"	=> 1,
					"guild_rank_required" => 3
				),
				array(
					"title" 	=> "Banana for scale",
					"content" 	=> "Check out this cool youtube thing",
					"category_id"=> 2,
					"user_id"	=> 1,
					"guild_rank_required" => 20
				),
				array(
					"title" 	=> "AB strategy",
					"content" 	=> "How we should do AB",
					"category_id"=> 3,
					"user_id"	=> 1,
					"guild_rank_required" => 20
				),
				array(
					"title" 	=> "Mages are overpowered",
					"content" 	=> "Dont DR count for mages?!",
					"category_id"=> 4,
					"user_id"	=> 1,
					"guild_rank_required" => 20
				),
				array(
					"title" 	=> "Intrepid",
					"content" 	=> "Is it good?",
					"category_id"=> 6,
					"user_id"	=> 1
				)
			);

		foreach ($topics as $topic) {
			Topic::create($topic);
		}
	}
}