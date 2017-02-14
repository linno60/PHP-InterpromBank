<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;

use Telegram\Bot\Laravel\Facades\Telegram;
use App\Service\KinoGoParser;
use App\Service\AniDubParser;
use App\Movie;
use App\Favorite;

class MovieController extends Controller
{	

	public function index(Request $request)
	{   
		$arResult = array('success' => true);
		$arResult['data'] = Movie::orderBy('updated_at', 'desc')->get();
		
		return response()->json($arResult);
	}

	public function show(Request $request, $id)
	{   
		$result = array('success' => false, 'data' => array());

		$movie = Movie::where('id', $id);
		if($movie->exists()) {
			$result['data'] = $movie->first();
			$result['success'] = true;
		};

		return response()->json($result);
		
	}

	public function favorite(Request $request)
	{   
		$ids = Favorite::where('user_id', \Auth::id())->pluck('movie_id');
		$list = Movie::whereIn('id', $ids)->get();
		return response()->json($list);
	}

	

	public function new_movie(Request $request) {
	    $arResult = array(
	    	'success' => false,
	        'is_exist' => true,
	        'movie' => false,
	        'new_seasons' => array(),
	        'error' => ''
	    );

	    $validator = Validator::make($request->all(), [ 'url' => 'required|url' ]);

	    if($validator->fails()) {
	    	$arResult['error'] = $validator->errors()->first();
	    }

	    if(!$validator->fails()) {
	    	if(strripos($request->url, 'kinogo') > -1) {
	    		$movie_info = new KinoGoParser($request->url);
	    	}

	    	if(strripos($request->url, 'anidub') > -1) {
	    		$movie_info = new AniDubParser($request->url);
	    	}
	    	
	    	
	    	if(!$movie_info->is_exist()) {
	    	    Movie::create($movie_info->toArray());
	    	    $arResult['is_exist'] = false;
	    	};
	    	
	    	$arResult['movie'] = $movie_info->get_movie();
	    	$arResult['new_seasons'] = $movie_info->sync_seasons();
	    	$arResult['success'] = true;
	    }


	    return response()->json($arResult);
	}

	public static function get_new_series()
	{   
		$movies_id = Favorite::all()->pluck('movie_id')->toArray();

		// Получаем список сериалов, которые есть в избранном у кого-либо

	    $movies = Movie::whereIn('id', $movies_id)->whereHas('seasons', function ($query) {
	        $query->where('episodes_count', '>', '0');
	    })->get();


	    foreach ($movies as $id => $movie) {

	    	// Получаем актуальное количество серий
	    	if(strripos($movie->url, 'kinogo') > -1) {
	    		$real_count = count(KinoGoParser::getEpisodesFromUrl($movie->last_season()->playlist_url));
	    	}

	    	if(strripos($movie->url, 'anidub') > -1) {
	    		$real_count = count(AniDubParser::getEpisodesFromUrl($movie->last_season()->url));
	    	}     

	        $current_count = $movie->last_season()->episodes_count;

	        if($real_count > $current_count) {
	        	
	        	$movie->last_season()->update(array('episodes_count' => $real_count));
	  	        	// Отправляем тем, у кого фильм в избранном
	        	$favorites = Favorite::with('user')->where('movie_id', $movie->id)->get();

	        	foreach ($favorites as $favorite) {
	        		$user = $favorite->user;
	        		if($user->chat_id) {
	        			Telegram::sendMessage([
	        				'chat_id' => $user->chat_id,
	        			    'text' => getNotify($movie->title, $real_count)
						]);
	        		}
	        	}
	 

	        }
	    }

	}


}