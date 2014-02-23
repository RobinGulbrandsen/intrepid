<?php

class Category extends Eloquent {
	protected $table = 'categories';

	public function topics() {
		return $this->hasMany('topics');
	}
}