<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{	
	protected $fillable = ['id','movie_id', 'user_id'];
    
    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function movie() {
     	return $this->belongsTo('App\Movie');
    }
}
