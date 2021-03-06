<?php

class CategoryController extends BaseController {

	private function authenticate() {
		if(Auth::check() && Session::get('guildRank') <= 3) {
			return true;
		} else {
			App::abort(401, 'Unauthorized action');
		}
	}

	//Create
	public function create() {
		$this->authenticate();

		$title 				= Input::get("title");
		$description 		= Input::get("description");
		$guild_rank_required = Input::get("guild_rank_required");

		if(is_null($title) || is_null($description)) {
			App::abort(400, "Fill in title and description");
		}

		$newCategory = new Category();
		$newCategory->title 				= $title;
		$newCategory->description 			= $description;
		$newCategory->guild_rank_required 	= $guild_rank_required;
		$success = $newCategory->save();
		return json_encode($success);
	}

	//Read
	public function getCategories() {
		$currentGuildRank = Session::get('guildRank');
		$categories;

		//Returns public forums
		if($currentGuildRank === null) {
			$categories = Category::where('guild_rank_required', '=', null)
							->orderBy('group_id')
							->orderBy('title')
							->get();	
		} else {
			//If current guild rank makes him an officer, return all
			if($currentGuildRank <= 3) {
				$categories = Category::orderBy('group_id')
							->orderBy('title')
							->get();
			} else {
				$categories = Category::where('guild_rank_required', '=', null)
							->where('guild_rank_required', '>', 3, 'OR')
							->orderBy('group_id')
							->orderBy('title')
							->get(); 	
			}				
		}

		if(Auth::check()) {
			//Loops through and finds the seen categories and updates return
			foreach ($categories as $category) {
				$seen = UserCategory::where('user_id', '=', Auth::user()->id)
								->where('category_id', '=', $category->id)
								->first();
				if(!is_null($seen)) {
					$category->seen = 1;
				}
			}
		}
		return $categories;
	}

	//Update
	public function update() {
		$this->authenticate();

		$id 				= Input::get("id");
		$title 				= Input::get("title");
		$description 		= Input::get("description");
		$guild_rank_required = Input::get("guild_rank_required");

		$category = Category::find($id);
		$category->title 				= $title;
		$category->description 			= $description;
		$category->guild_rank_required 	= $guild_rank_required;
		$success = $category->update();
		return json_encode($success);
	}

	//Delete
	public function delete($id) {
		$this->authenticate();

		$success = Category::find($id)->delete();
		return json_encode($success);
	}
}