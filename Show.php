<?php

/**
 * Class Show
 */
class Show {
    /**
     * @var array
     */
	protected $genres;
    /**
     * @var array
     */
	protected $showings;
    /**
     * @var string
     */
	protected $name;
    /**
     * @var int
     */
	protected $rating;

	public function __construct($data) {
		$this->genres = $data->genres ? array_map('strtolower', $data->genres) : [];
		$this->name = $data->name ? $data->name : '';
		$this->showings = $data->showings ? $data->showings : [];
		$this->rating = intval($data->rating);
    }

    /**
     * @return array
     */
    public function getGenres() :array {
    	return $this->genres;
    }

    /**
     * @return array
     */
    public function getShowings() :array {
    	return $this->showings;
    }

    /**
     * @return string
     */
    public function getName() :string {
    	return $this->name;
    }

    /**
     * @return int
     */
    public function getRating() :int {
    	return $this->rating;
    }

    /**
     * @param $genre
     * @return bool
     */
    public function isGenre($genre) :bool {
    	return in_array(strtolower($genre), $this->genres);
    }

    /**
     * Returns DateTime of the first show available after the given $time
     * @param $time
     * @return DateTime|null
     */
    public function firstAfter($time) :?DateTime {
    	foreach ($this->showings as $showTime) {
    		$showDateTime = new DateTime($showTime);
    		$diff = $showDateTime->getTimestamp() - $time->getTimestamp();
    		if ($diff >= 0) {
    			return $showDateTime;
    		} 
    	}
    	return null;
    }
}