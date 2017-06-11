<?php
require_once __DIR__ . '/ShowFactory.php';

/**
 * Class MovieRecommendation
 */
class MovieRecommendation
{
    /**
     * Movie list endpoint
     */
	const MOVIE_ENDPOINT = "https://pastebin.com/raw/cVyp3McN";
    /**
     * @var HttpClientWrapper
     */
    protected $httpClient;

	public function __construct(HttpClientWrapper $httpClient) {
		$this->httpClient = $httpClient;
    }

    /**
     * @param $genre
     * @param $time
     * @return array
     */
    public function getRecommendation($genre, $time) :array {
    	if (empty($genre) || empty($time)) {
    		return [];
    	}
    	$response = $this->httpClient->get(self::MOVIE_ENDPOINT);
//        fwrite(STDERR, print_r($this->httpClient, TRUE));
    	if (empty($response) || empty($response->body)) {
    		return [];
    	}
    	$movies = json_decode($response->body);
    	//Get an array of Shows
    	$shows = ShowFactory::getShows($movies);
    	//filter shows by genre and show with no availability after the input time
    	$mov = array_filter($shows, function($el) use($genre, $time) {
    		return $el->isGenre($genre) && $el->firstAfter($time) !== null;
    	});

    	$mov = array_values($mov); //reset array keys mixed up by filter function

    	if (count($mov) > 1) {
    		//sort by rating
    		usort($mov, function($a, $b) {
    			return $a->getRating() < $b->getRating();
    		});
    	}
    	return $mov;
    }
}