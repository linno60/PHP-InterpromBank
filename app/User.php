<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
Use Auth;
Use App\Favorite;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function favorites() {
        return $this->belongsToMany('App\Favorite', 'favorites', 'user_id', 'movie_id');
    }

    public function is_favorite($movie_id)
    {   
        if(Auth::check()) {
            return Favorite::where('user_id', $this->id)->where('movie_id', $movie_id)->exists(); 
        }

        return false; 
    }
}
