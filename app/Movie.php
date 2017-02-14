<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\User;
use App\Favorite;

class Movie extends Model
{	

    protected $fillable = ['title', 'year', 'code', 'url', 'image', 'description'];
	
	protected $appends = ['is_favorite', 'is_serial', 'last_season_info'];

    public function seasons()
    {
        return $this->hasMany('App\Season');
    }

    public function last_season() {
    	return $this->seasons()->orderBy('season_number', 'DESC')->first();
    }


    public function getIsFavoriteAttribute()
    {   
        if(Auth::check()) {
            $user = User::find(Auth::id());
            $is_favorite = $user->is_favorite($this->id);
        } else {
            $is_favorite = false;
        }
            

            return $this->attributes['is_favorite'] = $is_favorite; 
    }

    public function getIsSerialAttribute()
    {
    	if($this->last_season()) {
    		return $this->attributes['is_serial'] = ($this->last_season()->episodes_count > 0);
    	}

    	return $this->attributes['is_serial'] = false;
        
    }

    public function getLastSeasonInfoAttribute()
    {	
    	if($this->last_season()) {
    		return $this->attributes['last_season_info'] = $this->last_season();
    	}

    	return $this->attributes['last_season_info'] = array();

        
    }



}
