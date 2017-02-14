<?php

namespace App\Http\Controllers\API\telegram;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{	

	public function get_hooks(Request $request)
	{   
		Telegram::sendMessage([
		          'chat_id' => config('telegram.my_chat_id'),
		          'text' => 'Привет 1'
		      ]);
	}

	public function set_hooks(Request $request)
	{   

		$res = Telegram::setWebhook([
		    'url' => 'http://62.109.10.77/api/telegram/<token>/update_hooks'
		]);
		dd($res);

		// Telegram::sendMessage([
		//           'chat_id' => '179903861',
		//           'text' => 'Привет 1'
		//       ]);
	}

	public function remove_hooks(Request $request)
	{   
		// Telegram::sendMessage([
		//           'chat_id' => '179903861',
		//           'text' => 'Привет 1'
		//       ]);
	}

	public function update_hooks(Request $request) {

	}

}