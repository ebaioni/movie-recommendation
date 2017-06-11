<?php
date_default_timezone_set('Australia/Sydney');
require_once __DIR__ . '/MovieRecommendation.php';
require_once __DIR__ . '/HttpClientWrapper.php';

const LOOK_AHEAD_TIME = '1800 seconds'; // 30minutes
const TIME_24HR_REGEX = '/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/';
const TIME_12HR_REGEX = '/^(((0?[1-9])|(1[0-2])):([0-5])(0|5)\s?(A|P|a|p)(M|m))$/';


if (count($argv) < 3) {
	echo 'Usage: php script GENRE TIME';
	exit(1);
}
$genre = $argv[1];
$time = $argv[2];

if (empty($genre)) {
	echo 'Error: No genre';
	exit(1);
}

if (!preg_match(TIME_24HR_REGEX, $time) && !preg_match(TIME_12HR_REGEX, $time)) {
  	echo 'Error: Time should be expressed in either 12 or 24hr format with or without leading 0';
	exit(1);
}

$time = new DateTime($time);
$time = $time->add(DateInterval::createFromDateString(LOOK_AHEAD_TIME));

$movieRecommendation = new MovieRecommendation(new HttpClientWrapper());
$recommendations = $movieRecommendation->getRecommendation($genre, $time);
if (empty($recommendations)) {
	echo "no movie recommendations";
} else {
	foreach ($recommendations as $recommendation) {
		echo $recommendation->getName() . ', showing at ' . $recommendation->firstAfter($time)->format('ga') . PHP_EOL;
	}
}
exit(0);


