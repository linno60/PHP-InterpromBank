<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Movie;
use App\User;

class UserController extends Controller
{	

	public function favorite_update(Request $request) {

		if(\Auth::check()) {
			$user = User::find(\Auth::id());

			$movie_id = $request->movie_id;

			$is_favorite = $user->is_favorite($movie_id);

			$user->favorites()->toggle($movie_id);
		} else {
			$is_favorite = true;
		}
	

	    return array('is_favorite' => !$is_favorite);
	}


}