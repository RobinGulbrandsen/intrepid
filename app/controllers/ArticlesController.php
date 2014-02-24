<?php

class ArticlesController extends BaseController {

	//Authenticate
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

		$title 		= Input::get("title");
		$content	= Input::get("content");

		if(is_null($title) || is_null($content)) {
			App::abort(400, "Fill in title and content");
		}

		$article = new Article();
		$article->title 	= $title;
		$article->content 	= $content;
		$article->user_id	= Auth::user()->id;
		$success = $article->save();
		return json_encode($success);
	}

	//Read
	public function get() {
		return Article::take(5)->orderBy('created_at', 'DESC')->get();
	}

	//Update
	public function update() {
		$this->authenticate();

		$id 		= Input::get("id");
		$title 		= Input::get("title");
		$content	= Input::get("content");

		if(is_null($title) || is_null($content)) {
			App::abort(400, "Fill in title and content");
		}

		$article = Article::find($id);
		$article->title 	= $title;
		$article->content 	= $content;
		$article->user_id	= Auth::user()->id;
		$success = $article->update();
		return json_encode($success);
	}

	//Delete
	public function delete($id) {
		$this->authenticate();
		$article = Article::find($id);
		$success = $article->delete();
		return json_encode($success);
	}

}