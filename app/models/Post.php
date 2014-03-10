<?php

class Post extends Eloquent {
	protected $table = 'posts';

	public function topic() {
		return $this->belongsTo('Topic');
	}

	public function author() {
		return $this->belongsTo('User', 'user_id', 'id');
	}
}