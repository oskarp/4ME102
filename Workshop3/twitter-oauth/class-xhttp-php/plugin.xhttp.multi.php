<?php

# Arvin Castro, arvin@sudocode.net
# 24 May 2011
# http://sudocode.net/sources/includes/class-xhttp-php/plugin-xhttp-multi-php/

class xhttp_multi {

	const curl_multi_select_timeout = 30;
	private static $multi_request;
	private static $paused;

	public static function load() {
		xhttp::addHook('before-curl-execution', array(__CLASS__, 'add_request'), 9);
		self::$paused = true;
		return true;
	}

	public static function add_request(&$ch, &$requestData) {
		if(self::$paused) {

		} elseif(self::$multi_request) {

			self::$multi_request->add_request($ch, $requestData);
			return true;

		} else {
			trigger_error('xhttp multi is not started yet.', E_USER_ERROR);
		}
	}

	public static function start() {
		self::$multi_request = new xhttp_multi_request;
		self::$paused = false;
	}

	public static function stop() {
		self::$multi_request = null;
		self::$paused = true;
	}

	public static function pause() {
		self::$paused = true;
	}

	public static function resume() {
		self::$paused = false;
	}

	public static function exec() {
		return self::$multi_request->exec();
	}
}

class xhttp_multi_request {

	private $handle;
	private $requests;

	function __construct() {
		$this->handle  = curl_multi_init();
		$this->requests= array();
		$this->count   = 0;
		$this->complete= false;
	}

	function __destruct() {
		foreach($this->requests as $request) {
			curl_multi_remove_handle($this->handle, $request['handle']);
		}
		curl_multi_close($this->handle);
		unset($this->requests);
	}

	function add_request(&$ch, &$requestData) {
		$this->requests[] = array('handle' => &$ch, 'data' => &$requestData);
		curl_multi_add_handle($this->handle, $ch);
	}

	function exec() {

		# http://www.php.net/manual/en/function.curl-multi-exec.php
		$active = null;
		do {
		    $mrc = curl_multi_exec($this->handle, $active);
		} while ($mrc == CURLM_CALL_MULTI_PERFORM);

		while ($active && $mrc == CURLM_OK) {
		    if (curl_multi_select($this->handle, xhttp_multi::curl_multi_select_timeout) != -1) {
		        do {
		            $mrc = curl_multi_exec($this->handle, $active);
		        } while ($mrc == CURLM_CALL_MULTI_PERFORM);
		    }
		}

		$responses = array();
		foreach($this->requests as $request) {
        	$response = curl_multi_getcontent($request['handle']);
        	$responses[] = xhttp::after_curl_execution($request['handle'], $response, $request['data']);
        }

		xhttp_multi::stop();
		return $responses;
	}
}

?>
