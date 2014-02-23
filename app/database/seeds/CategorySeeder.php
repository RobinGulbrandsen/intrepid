<?php

class CategorySeeder extends DatabaseSeeder {

	public function run() {
		$categories = array(
				array(
					"name" 			=> "My Topic",
					"description"	=> "A really long text of content with some shit in it"
				)
			);

		foreach ($categories as $category) {
			Category::create($category);
		}
	}
}