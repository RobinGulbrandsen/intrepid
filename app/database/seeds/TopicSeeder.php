<?php

class TopicSeeder extends DatabaseSeeder {

	public function run() {
		$topics = array(
				array(
					"name" 		=> "My Topic",
					"content" 	=> "A really long text of content with some shit in it",
					"category_id"=> 1,
					"user_id"	=> 1
				)
			);

		foreach ($topics as $topic) {
			Topic::create($topic);
		}
	}
}