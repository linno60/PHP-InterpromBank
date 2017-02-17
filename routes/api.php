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
	Route::group(['prefix' => 'v1', 'namespace' => 'v1'], function () {

			Route::group(['prefix' => 'auth'], function () {
				Route::post('/send-code', ['uses' => 'AuthController@send_code']);
				Route::post('/confirm-code', ['uses' => 'AuthController@confirm_code']);
			});

			Route::post('/requests', 'RequestController@index');
			Route::post('/im', 'UserController@im');

	});
});