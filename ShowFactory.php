<?php
require_once __DIR__ . '/Show.php';

/**
 * Class ShowFactory
 */
class ShowFactory {
	private function __construct() {
		/**
	     * Construct won't be called inside this class and is uncallable from
	     * the outside. This prevents instantiating this class.
	     */
	}
	static function getShows($showArray) {
		$shows = [];
		foreach ($showArray as $singleShow) {
			$shows[] = self::getShow($singleShow);
		}
		return $shows;
	}

	static function getShow($singleShow) {
		return new Show($singleShow);
	}
}