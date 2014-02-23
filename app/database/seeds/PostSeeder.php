<?php

class PostSeeder extends DatabaseSeeder {

	public function run() {
		$posts = array(
				array(
					"content" 	=> "Post content about a page",
					"topic_id"	=> 1,
					"user_id"	=> 1
				)
			);

		foreach ($posts as $post) {
			Post::create($post);
		}
	}
}