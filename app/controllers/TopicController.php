<?php

class TopicController extends BaseController {

	//Authenticate
	private function auth($guildRank) {
		if($guildRank != null) {
			$sessionGuildRank = Session::get('guildRank');
			if($sessionGuildRank === null) {
				App::abort(401, "Content requires loged in user");
			}
			if($sessionGuildRank > $guildRank) {
				App::abort(403, "You do not have permission to view this content");
			}
		}
	}

	//Create topic under given category
	public function create($categoryId) {
		//Validate category
		$category = Category::find($categoryId);
		if($category === null) {
			App::abort(400, "A topic must be created under a valid category");
		}

		//Validate user
		if(!Auth::check()) {
			App::abort(401, "You must be logged in to create topics");
		}

		$currentUser = Auth::user();
		$currentUser->guild_rank = Session::get("guildRank");
		if($category->guild_rank_required !== null && $currentUser->guild_rank > $category->guild_rank_required) {
			App::abort(401, "You do not have permission to create topic under this category");
		}

		//Gets the last topic the user created and checks the time
		$lastTopicByUser = Topic::where('user_id', '=', Auth::user()->id)
									->orderBy('created_at', 'DESC')
									->first();

		if(!is_null($lastTopicByUser)) {
			$currentTime = strtotime(date('Y-m-d H:i:s'));
			$lastCreatedTime = strtotime($lastTopicByUser->created_at);

			if($currentTime - $lastCreatedTime < 60) {
				App::abort(400, "Can only create content once a min. Last " . ($currentTime - $lastCreatedTime) . "secounds ago.");
			}
		}

		//Validate input
		$title = 	Input::get("title");
		$content = 	Input::get("content");

		if($title === null || $content === null) {
			App::abort(400, "Both title and content must have data");
		}

		//Create object
		$topic = new Topic();
		$topic->title = $title;
		$topic->content = $content;
		$topic->sticky = false;
		$topic->category_id = $categoryId;
		$topic->user_id = $currentUser->id;
		$topic->guild_rank_required = $category->guild_rank_required;
		$topic->last_post_name = $currentUser->username;
		$topic->last_post_time = date('Y-m-d H:i:s');

		//If user is officer, check for sticky
		if($currentUser->guild_rank <= 3) {
			$sticky = Input::get("sticky");
			if($sticky !== null) {
				$topic->sticky = $sticky;
			}
		}

		//Updates category with last topic
		$category->last_post_name = $currentUser->username;
		$category->last_post_time = date('Y-m-d H:i:s');
		$category->update();

		//Save object
		$success = $topic->save();
		if($success) {
			//Adds topic to viewed topics
			$userTopic = new UserTopic();
			$userTopic->user_id = Auth::user()->id;
			$userTopic->topic_id = $topic->id;
			$userTopic->save();
		}
		return json_encode($success);
	}

	//Read all topics in a category
	public function getTopics($categoryId) {
		//Authenticate
		$category = Category::find($categoryId);
		if($category === null) {
			App::abort(404, "Could not find spesified category");
		}

		$this->auth($category->guild_rank_required);

		$topics = Topic::where('category_id', '=', $categoryId)
						->orderBy('sticky', 'DESC')
						->orderBy('updated_at', 'DESC')
						->orderBy('id')
						->get();

		if(Auth::check()) {

			//Category is now seen, adds row to db
			$seen = UserCategory::where('category_id', '=', $categoryId)
							->where('user_id', '=', Auth::user()->id)
							->first();

			if(is_null($seen)) {
				$newUserCategory = new UserCategory();
				$newUserCategory->user_id = Auth::user()->id;
				$newUserCategory->category_id = $categoryId;
				$newUserCategory->save();
			}

			//Loops through and updates current users views
			foreach ($topics as $topic) {
				$seen = UserTopic::where('user_id', '=', Auth::user()->id)
								->where('topic_id', '=', $topic->id)
								->first();
				if(!is_null($seen)) {
					$topic->seen = 1;
				}
			}
		}
		return $topics;
	}

	//Update given category
	public function update() {
		//Validate user is logged in
		if(!Auth::check()) {
			App::abort(401, "You must be logged in to edit topics");
		}

		$id = Input::get("id");
		if($id === null) {
			App::abort(400, "A topic must be selected");
		}

		$dbTopic = Topic::find($id);
		if($dbTopic === null) {
			App::abort(400, "No topic found on given attributes");
		}

		//Check user rights to edit topic
		$currentUser = Auth::user();
		if($currentUser->id != $dbTopic->user_id) {
			App::abort(401, "You do not have permission to edit given topic");	
		}
	
		//Validation complete
		$dbTopic->title = Input::get("title");
		$dbTopic->content = Input::get("content");

		$currentUserGuildRank = Session::get("guildRank");
		if($currentUserGuildRank <= 3) {
			$dbTopic->sticky = Input::get("sticky");
		}
		return json_encode($dbTopic->update());
	}

	//Delete given category
	public function delete($categoryId, $topicId) {
		if(!Auth::check()) {
			App::Abort(401, "You must be loged in to delete topics");
		}

		$currentUser = Auth::user();
		$currentUser->guild_rank = Session::get("guildRank");

		$topic = Topic::find($topicId);
		if($topic === null) {
			App::abort(400, "No topic found");
		}

		//Not an officer
		if($currentUser->guild_rank > 3 || $currentUser->guild_rank === null) {
			if($topic->user_id != $currentUser->id) {
				App::abort(401, "You do not have permission to delete topic");
			}
		}

		return json_encode($topic->delete());
	}

	public function getTopicTitle($id) {
		return Category::find($id)->title;
	}
}