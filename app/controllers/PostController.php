<?php

class PostController extends BaseController {

	//Authenticate
	private function auth($topicId) {
		$topic = Topic::find($topicId);
		if($topic === null) {
			App::abort(404, "Could not find spesified topic");
		}

		$guildRankRequired = $topic->guild_rank_required;
		$sessionGuildRank = Session::get('guildRank');

		if($guildRankRequired != null) {
			if($sessionGuildRank > $guildRankRequired || $sessionGuildRank === null) {
				App::abort(403, "You do not have permission to view this content");
			}
		}
	}

	//Create
	public function create($categoryId, $topicId) {
		//Validate user
		$this->auth($topicId);

		//Validate inputform
		$content = Input::get("content");
		if($content === null) {
			App::abort(400, "Content must be filled");
		}

		$topic = Topic::find($topicId);
		if($topic === null) {
			App::abort(400, "cant find topic");
		}

		$category = Category::find($categoryId);
		if($category === null) {
			App::abort(400, "cant find category");
		}

		$post = new Post();
		$post->content = $content;
		$post->topic_id = $topicId;
		$post->user_id = Auth::user()->id;
		$post->guild_rank_required = $topic->guild_rank_required;

		//create new
		$post->save();

		//Updates topic
		$topic->last_post_name = Auth::user()->username;
		$topic->last_post_time = date('Y-m-d H:i:s');
		$topic->update();

		//Updates category with last topic
		$category->last_post_name = Auth::user()->username;
		$category->last_post_time = date('Y-m-d H:i:s');
		$category->update();

		return json_encode(true);
	}

	//Read
	public function getPosts($categoryId, $topicId) {
		//Authenticate
		$this->auth($topicId);

		return Topic::where('id', '=', $topicId)
					->with('author', 'posts.author')
					->get();
	}

	//Update
	public function update($categoryId, $topicId) {
		//User is not loged in
		if(!Auth::check()) {
			App::abort(401, "You must be loged in");
		}

		$id = Input::get("id");
		if($id === null) {
			App::abort(400, "Must edit a specific post");
		}

		$post = Post::find($id);
		if($post === null) {
			App::abort(400, "Post not found");
		}

		if($post->user_id != Auth::user()->id) {
			App::abort(401, "You do not have permission to edit post");
		}

		$post->content = Input::get("content");
		return json_encode($post->update());
	}

	//Delete
	public function delete($categoryId, $topicId, $postId) {
		//validates user is loged in
		if(!Auth::check()) {
			App::abort(401, "You must be logged in");
		}

		//gets the post
		$post = Post::find($postId);

		if(Session::get("guildRank") > 3 || Session::get("guildRank") == null) {
			if($post->user_id != Auth::user()->id) {
				App::abort(401, "You do not have permission to delete post");	
			}
		}

		return json_encode($post->delete());
	}
}
