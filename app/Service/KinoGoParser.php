<?php

namespace App\Service;

use \nokogiri;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\DomCrawler\Crawler;
use App\Movie;
use App\Season;

class KinoGoParser extends Model
{	
    protected $fillable = ['url', 'title', 'code', 'year', 'image', 'description'];


    // Возвращает результат парсинга страницы.
	public function __construct($url)
    {
    	$html = file_get_contents($url);
        $parse_url = $this->fn_parse_url($url);
            $movie_id = $parse_url['id'];
            $this->code = $parse_url['code'];
            $this->season_code = $parse_url['season_code'];
            $this->season_number = $parse_url['season_number'];
    	 
    	$saw = new nokogiri($html);

    	$full_title = explode('(', $saw->get('h1')->toTextArray()[0]);
        $info = $saw->get('.fullimg div#news-id-'.$movie_id)->toArray();

    	$year = $info[0]['a'][1]['#text'][0];
    	if(!is_numeric($year)) {
    		if(is_numeric($info[0]['#text'][2])) {
    			$year = $info[0]['#text'][2];
    		} else {
    			$year = 0;
    		}
    	}

        $this->nokogiri = $saw;
    	$this->url = $url;
    	$this->title = trim($full_title[0]);
    	$this->year = trim($year);
    	$this->image = $info[0]['a'][0]['href'];
    	$this->description = $info[0]['#text'][0].' '.$info[0]['#text'][1];
        $this->season = array();
        $this->playlist_url = false;


    }

    public function fn_parse_url($url) {
        $url = str_replace('http', '', $url);
        $url = str_replace('/', '', $url);
        $url = str_replace(':', '', $url);
        $url = str_replace('kinogo.club', '', $url);
        preg_match_all('!\d+!', $url, $numbers);

        $url = str_replace($numbers[0][0], '', $url);
        $url = str_replace($numbers[0][1], '', $url);
        $url = str_replace('-sezon', '', $url);
        $url = str_replace('html', '', $url);
        $url = substr($url, 1, -2);

        $result = array(
            'id' => $numbers[0][0],
            'season_number' => $numbers[0][1],
            'code' => $url,
            'season_code' => $numbers[0][1].'-sezon'
        );

        return $result;

    }

    public function get_playlist() {
        $html = file_get_contents($this->url); 
        $crawler = new Crawler($html);
        $script = $crawler->filter('.box.visible script')->first()->text();
        $script = str_replace ( 'document.write(Base64.decode(' , '', $script);
        $script = str_replace ( '));' , '', $script);
        $script = base64_decode($script);

        $crawler = new Crawler($script);
        $val = $crawler->filter('param[name="flashvars"]')->first()->attr('value');

        $url_params = explode ( '&' , $val);
        $playlist = $script = str_replace ( 'pl=' , '', $url_params[3]);

        if(filter_var($playlist, FILTER_VALIDATE_URL)) {
            $this->playlist_url = $playlist;
            return $this->playlist_url;
        }

        return false;

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
        $seasons = $parser->getSeasons();
        $db_seasons = $movie->seasons->map(function ($item, $key) {return $item['season_number']; })->toArray();

        $new_seasons = array();

        foreach ($seasons as $key => $season) {
            $season = $season->toArray();
            
            if(array_search($season['season_number'], $db_seasons) === false || empty($db_seasons)) {
                $season['episodes_count'] = count($season['episodes']);
                $new_seasons[] = new Season($season);
            } else {
            }
        }

        $movie->seasons()->saveMany($new_seasons);

        return $new_seasons; 
    }


    // Список сезонов
    public function getSeasons() {
    	$html = $this->nokogiri;

        $season_links = $html->get('.quote a')->toArray();
        $seasons = array();
        foreach ($season_links as $key => $season) {
            $parser = new KinoGoParser($season['href']);
            $parser->episodes = $parser->getEpisodes();
            $seasons[] = $parser; 
        }

        $season = $this;
        $season->episodes = $season->getEpisodes();
        $seasons[] = $season;

    	return $seasons;
    	
    }

    // Список эпизодов
    public function getEpisodes() {
        return $this->getEpisodesFromUrl($this->get_playlist());
    }

    public static function getEpisodesFromUrl($url) {
        $play_list = $url;
        $result = array();
        if($play_list) {
            $playlist_url = new nokogiri(file_get_contents($play_list)); 
            $playlist_text =  join($playlist_url->get('p')->toTextArray(), ' ');           
            $playlist_array = (array)json_decode($playlist_text);
            if(isset($playlist_array['playlist'])) {
                 $result = $playlist_array['playlist'];
            }
        }
    
        return $result;
    }
}



