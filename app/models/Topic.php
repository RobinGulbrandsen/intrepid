<?php

class Topic extends Eloquent {
	protected $table = 'topics';

	public function posts() {
		return $this->hasMany('Post');
	}

	public function author() {
		return $this->belongsTo('User', 'user_id', 'id');
	}

	//Converting string input to boolean values
	public function setStickyAttribute($value) {
		$this->attributes['sticky'] = ($value == 1? true: false);
	}

	public function setCategoryIdAttribute($value) {
		$this->attributes['category_id'] = (int) $value;
	}
}