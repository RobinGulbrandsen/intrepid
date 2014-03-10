<?php

class PostSeeder extends DatabaseSeeder {

	public function run() {
		$posts = array(
				array(
					"content" 	=> "Post content about a page 1",
					"topic_id"	=> 5,
					"user_id"	=> 1
				),
				array(
					"content" 	=> "Post content about a page 2",
					"topic_id"	=> 5,
					"user_id"	=> 1
				),
				array(
					"content" 	=> "Post content about a page 3",
					"topic_id"	=> 5,
					"user_id"	=> 1
				),
				array(
					"content" 	=> "Post content about a page 4",
					"topic_id"	=> 5,
					"user_id"	=> 1
				),
				array(
					"content" 	=> "Post content about a page 5",
					"topic_id"	=> 5,
					"user_id"	=> 1
				),
			);

		foreach ($posts as $post) {
			Post::create($post);
		}
	}
}