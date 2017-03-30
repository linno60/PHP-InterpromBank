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
				Route::post('/manage_email', ['uses' => 'AuthController@manage_email']);
			});
			Route::post('/files/list_by_app/{id}', 'FileController@listByApp');
			Route::post('/files/list_by_app/{id}/upload', 'FileController@sendFile');

			Route::post('/requests', 'RequestController@index');
			Route::post('/requests/{id}', 'RequestController@show');

			Route::post('/check_account', 'RequestController@check_account');
			Route::post('/im', 'UserController@im');

	});
});