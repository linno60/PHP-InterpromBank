<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = ['title', 'year', 'code', 'season_code', 'season_number', 'url', 'image', 'description', 'episodes_count', 'movie_id', 'playlist_url'];

    protected $touches = ['movie'];

    public function movie()
    {
          return $this->belongsTo('App\Movie');
    }
}
