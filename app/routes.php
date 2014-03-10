<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//General directions with index page
Route::get('/', 'PageController@getIndex');

//Users controller
Route::post('/api/login',		'UserController@postLogin');
Route::post('/api/register',	'UserController@postRegister');
Route::post('/api/logout',		'UserController@postLogout');

//Armory controller
Route::get('/api/armory/users', 				'ArmoryController@getGuildMembers');
Route::get('/api/armory/users/{server}/{id}', 	'ArmoryController@getCharacter');

//Articles controller (news)
Route::post('api/articles', 		'ArticlesController@create');
Route::get('api/articles', 			'ArticlesController@get');
Route::post('api/articles/update', 	'ArticlesController@update');
Route::delete('api/articles/{id}', 	'ArticlesController@delete');

/*
|--------------------------------------------------------------------------
| Forum Routes
|--------------------------------------------------------------------------
|
| All routes used to present and use the forum
|
*/
//Front page - with CATEGORY
Route::get('/api/forum',				'CategoryController@getCategories');
Route::post('/api/forum',				'CategoryController@create');
Route::post('/api/forum/update',		'CategoryController@update');
Route::delete('/api/forum/{category}',	'CategoryController@delete');

//TOPIC in a category
Route::get('/api/forum/{category}', 			'TopicController@getTopics');
Route::post('/api/forum/{category}', 			'TopicController@create');
Route::post('/api/forum/{category}/update', 	'TopicController@update');
Route::delete('/api/forum/{category}/{topic}', 	'TopicController@delete');
Route::get('api/forum/{category}/title', 		'TopicController@getTopicTitle');

//POST in topic
Route::get('/api/forum/{category}/{topic}', 			'PostController@getPosts');
Route::post('/api/forum/{category}/{topic}', 			'PostController@create');
Route::post('/api/forum/{category}/{topic}/update', 	'PostController@update');
Route::delete('/api/forum/{category}/{topic}/{postid}', 'PostController@delete');
