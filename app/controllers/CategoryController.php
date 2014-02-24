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

		//validate user
		$name 				= Input::get("name");
		$description 		= Input::get("description");
		$guild_rank_required = Input::get("guild_rank_required");

		if(is_null($name) || is_null($description)) {
			App::abort(400, "Fill in name and description");
		}

		$newCategory = new Category();
		$newCategory->name 				= $name;
		$newCategory->description 		= $description;
		$newCategory->guild_rank_required = $guild_rank_required;
		$success = $newCategory->save();
		return json_encode($success);
	}

	//Read
	public function getCategories() {
		$categories = null;
		
		//Get current user and guild rank to authenticate user
		if(Auth::check()) {
			//gets current users guild rank
			$currentGuildRank = Session::get('guildRank');
			
			if($currentGuildRank == null) {
				//user is not in the guild
				$categories = Category::where('guild_rank_required', '=', null)->get();
			} else {
				//user is in the guild - gets topics with access
				$categories = Category::where('guild_rank_required', '=', null)
									  ->where('guild_rank_required', '>=', $currentGuildRank, 'OR')
									  ->orderBy('guild_rank_required', 'ASC')
									  ->get();
			}
		} else {
			//user is not logged in. Gets general forum
			$categories = Category::where('guild_rank_required', '=', null)->get();
		}

		//builds return array based on the output from database
		$returnArray = array();
		foreach($categories as $category) {
			$categoryDTO = new CategoryDTO();
			$categoryDTO->id = $category->id;
			$categoryDTO->name = $category->name;
			$categoryDTO->description = $category->description;
			$categoryDTO->guild_rank_required = $category->guild_rank_required;

			$topic = Topic::where('user_id', '=', $category->id)->orderBy('created_at', 'DESC')->get()->first();
			if(!is_null($topic)) {
				$topicDTO = new LastTopicDTO();
				$topicDTO->id 			= $topic->id;
				$topicDTO->name 		= $topic->name;
				$topicDTO->created_at 	= $topic->created_at;
				$categoryDTO->lastTopic = $topicDTO;	
			}
			
			array_push($returnArray, $categoryDTO);
		}
		return $returnArray;
	}

	public function getCategory($id) {
		$category = Category::find($id);
		if($category->guild_rank_required == null) {
			return $category;
		} else {
			if(Auth::check() && Session::get('guildRank') <= $category->guild_rank_required) {
				return $category;
			} else {
				App::abort(401, 'Unauthorized action');
			}
		}
	}

	//Update
	public function update() {
		$this->authenticate();

		$id 				= Input::get("id");
		$name 				= Input::get("name");
		$description 		= Input::get("description");
		$guild_rank_required = Input::get("guild_rank_required");

		$category = Category::find($id);
		$category->name 				= $name;
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

class CategoryDTO {
	public $id;
	public $name;
	public $description;
	public $guild_rank_required;
	public $lastTopic;
}

class LastTopicDTO {
	public $id;
	public $name;
	public $created_at;
}