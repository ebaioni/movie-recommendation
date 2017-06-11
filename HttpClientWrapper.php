<?php

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Class HttpClientWrapper
 */
class HttpClientWrapper {
    /**
     * @param $uri
     * @return \Httpful\Response|null
     */
	public function get($uri) :?Httpful\Response  {
		if (empty($uri)) {
			return null;
		}
		try {
			return \Httpful\Request::get($uri)->send();
		} catch (Exception $e) {
			error_log($e);
			return null;
		}
	}
}