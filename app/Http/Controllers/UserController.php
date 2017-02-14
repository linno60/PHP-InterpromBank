<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favorite;
use App\User;

class UserController extends Controller
{
    public function profile()
    {   
        return view('public.resourses.users.profile', array('user' => \Auth::user()));
    }

}
