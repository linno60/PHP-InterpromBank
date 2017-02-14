<?php

namespace App\Service;

use \nokogiri;
use Illuminate\Database\Eloquent\Model;
use App\Movie;
use App\Season;

class AniDubParser extends Model
{	
    protected $fillable = ['url', 'title', 'code', 'year', 'image', 'description'];


    // Возвращает результат парсинга страницы.
	public function __construct($url)
    {
        $html = file_get_contents($url);
        $page = new nokogiri($html);

        $title = $page->get('.titlfull')->toTextArray();
        $discription = $page->get('[itemprop="description"]')->toTextArray();    
        $image = $page->get('.poster_img')->toArray();
        $year = $page->get('.maincont ul.reset li:nth-child(1)')->toTextArray();

        $parse_url = $this->fn_parse_url($url);

        $this->code = $parse_url['code'];
        $this->season_code = $parse_url['season_code'];
        $this->season_number = $parse_url['season_number'];

        $this->nokogiri = $page;
        $this->url = $url;
        $this->title = $title[0];
        $this->description = trim($discription[3]);
        $this->image = $image[0]['img'][0]['src'];
        $this->year = trim($year[1]);
        $this->season = array();
        $this->playlist_url = false;

    }

    public function fn_parse_url($url) {
        $url = explode('/', $url);
        $url = array_pop($url);
        preg_match_all('!\d+!', $url, $numbers);

        $url = str_replace($numbers[0][0], '', $url);
        $url = str_replace('.html', '', $url);
        $url = substr($url, 1);

        $result = array(
            'id' => $numbers[0][0],
            'season_number' => 1,
            'code' => $url,
            'season_code' => '1-sezon'
        );

        return $result;

    }

    // Проверяет существование такого фильма в базе
    public function is_exist() {
        return $movie = Movie::where('code', '=', $this->code)->exists();
    }

    // Получает экземпляр модели Movie
    public function get_movie() {
        return $movie = Movie::where('code', '=', $this->code)->first();
    }

    // Синхронезируем сезоны.
    public function sync_seasons() {
        $parser = $this;
        $movie = $parser->get_movie();
        $season = $movie->toArray();
        $season['season_code'] = $parser->season_code;
        $season['season_number'] = $parser->season_number;
        $season['episodes_count'] = count($parser->getEpisodes());

        $movie->seasons()->save(new Season((array)$season));

        return $season; 
    }


    // Список эпизодов
    public function getEpisodes() {
        return $this->getEpisodesFromUrl($this->url);
    }

    public static function getEpisodesFromUrl($url) {
        $play_list = $url;
        $result = array();
        if($play_list) {
            $playlist_url = new nokogiri(file_get_contents($play_list));
            $episodes = $playlist_url->get('#sel option')->toArray();    
            $result = array_map(function($value) {
               return array('value' => $value['value'], 'text' => $value['#text'][0]);
            }, $episodes);
        }
    
        return $result;
    }

    
}



