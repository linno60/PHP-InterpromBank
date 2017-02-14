<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class HomeController extends Controller
{

    public function index()
    {
        return view('public.pages.index');
    }

    public function getUpdates()
    {
        $updates = Telegram::getMe();

        Telegram::sendMessage([
               'chat_id' => '179903861',
               'text' => 'Привет'
           ]);
    }
}
