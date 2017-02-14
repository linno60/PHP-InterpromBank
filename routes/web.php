<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();
Route::get('/logout', [ 'as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
Route::get('/register', [ 'as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);

// Route::get('/', function ()
// {
// 	return Response::view('public.layout.app');
// });

Route::get('/', [ 'as' => 'home', 'uses' => 'HomeController@index']);




Route::group(['middleware' => ['auth']], function () {
    
    Route::get('/profile', ['as' => 'profile', 'uses' => 'UserController@profile']);
    Route::get('/favorite', ['as' => 'favorite', 'uses' => 'UserController@favorite_update']);
    Route::resource('users', 'UserController');

    Route::get('/get_upd', ['as' => 'update', 'uses' => 'MovieController@get_upd']);
    // Route::resource('movies', 'MovieController');
});



Auth::routes();

Route::get('/home', 'HomeController@index');
