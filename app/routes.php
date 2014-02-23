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
Route::get('/api/users', 		'UserController@getUsers');
Route::get('/api/users/{id}',	'UserController@getUser');

//Armory controller
Route::get('/api/armory/users', 				'ArmoryController@getGuildMembers');
Route::get('/api/armory/users/{server}/{id}', 	'ArmoryController@getCharacter');

//Forum controllers
Route::post('/api/forum/categories',		'CategoryController@create');
Route::get('/api/forum/categories',			'CategoryController@getCategories');
Route::get('/api/forum/categories/{id}',	'CategoryController@getCategory');
Route::post('/api/forum/categories/update',	'CategoryController@update');
Route::delete('/api/forum/categories/{id}',	'CategoryController@delete');