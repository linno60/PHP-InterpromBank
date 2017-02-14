<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*==========================
          API routes
==========================*/
Route::group(['as' => 'api.', 'namespace' => 'API'], function () {
	//Check API version
	Route::post('check', ['as' => 'check', 'uses' => 'ApiController@check']);
	
	Route::group(['prefix' => 'telegram', 'namespace' => 'telegram', 'as' => 'telegram.'], function () { 
		Route::get('/get_hooks', ['as' => 'get_hooks', 'uses' => 'TelegramController@get_hooks']);
		Route::get('/set_hooks', ['as' => 'set_hooks', 'uses' => 'TelegramController@set_hooks']);
		Route::get('/remove_hooks', ['as' => 'remove_hooks', 'uses' => 'TelegramController@remove_hooks']);
		Route::get('/update_hooks', ['as' => 'update_hooks', 'uses' => 'TelegramController@update_hooks']);
	});

	//API v1
	Route::group(['prefix' => 'v1', 'namespace' => 'v1'], function () {

		Route::resource('/favorite', 'MovieController@favorite');

		Route::group(['prefix' => 'movie', 'as' => 'movie.'], function () {	
			Route::post('new_movie', ['as' => 'new_movie', 'uses' => 'MovieController@new_movie']);
			Route::get('get_new_series', ['as' => 'get_new_series', 'uses' => 'MovieController@get_new_series']);
		});

		Route::post('favorite_update', ['as' => 'favorite_update', 'uses' => 'UserController@favorite_update']);



		// JWT Token
		
		Route::post('auth', 'AuthController@authenticate');
		Route::resource('movies', 'MovieController');

		Route::group(['middleware' => 'auth_api'], function (){

			Route::resource('auth', 'AuthController', ['only' => ['index']]);

		});


	});
});