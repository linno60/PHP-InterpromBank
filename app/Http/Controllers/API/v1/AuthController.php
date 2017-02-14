<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

use App\User;

class AuthController extends Controller
{	

	public function index()
	 {
	   	$users = User::all();
    	return $users;
	 } 

	public function authenticate(Request $request) {

		$arResult = array(
			'success' => false, 
			'error' => ''
		);

		$credentials = $request->only('email', 'password');

		try {
		    
		    if (!$token = JWTAuth::attempt($credentials)) { 
		    		$arResult['error'] = trans('auth.failed');
		    } else {
		    		$arResult['success'] = true;
		    		$arResult['token'] = $token;
		    		$arResult['user'] = JWTAuth::parseToken()->authenticate();
		    }
		
		} catch (JWTException $e) {
		    $arResult['error'] = $e->getMessage();
		    return response()->json($arResult);
		};

		return response()->json($arResult);

	}


}